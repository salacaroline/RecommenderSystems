<html>
    <head>
        <meta charset="utf-8">
        <title>Recomendação</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="css/css.css">
    </head>
    <body>
        <script type="text/javascript">
            window.onload = function() {
            if (!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            }
}
        </script>
<?php
#caminho do arquivo no ubuntu: Computer/usr/share/nginx/html/tcc
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('Location: home.php');
}

//echo $login_cookie;
require 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

//pegar do banco sempre ao inves de trazer do checks

$login_cookie = $_SESSION['login'];
//echo $login_cookie;
if (!empty($_SESSION['login']))
{
    if (isset($login_cookie))
    {
        echo "Bem-Vindo(a), $login_cookie" . ' |     <a href="home.php" >Home</a>   |         <a href="logout.php" >Sair</a><br>';
        echo "<h3>Artigos recomendados de acordo com seu perfil:</h3>";
        echo "<br>";
    }
}
else
{
    echo "Bem-Vindo(a), convidado <br>";
    echo "<br><a href='login.php'>Faça Login</a> Para ler o conteúdo";
}

require 'vendor/autoload.php';
$host = ["http://search-sistemarecomendacao-n4nryark2nid6lbezhlvlm3imm.sa-east-1.es.amazonaws.com:80"];
$client = Elasticsearch\ClientBuilder::create()->setHosts($host)->build();

$like = "";
$dislike = "";
$params2 = ['index' => 'avaliar', 'body' => ["query" => ["simple_query_string" => ["query" => $login_cookie, "fields" => ["email"], "default_operator" => "or"

]]]];

$results2 = $client->search($params2);

if (!empty($_REQUEST['likes']))
{
    $like = urldecode($_REQUEST['likes']);
}
else
{
    if (!empty($results2['hits']['hits']))
    {
        foreach ($results2['hits']['hits'] as $hit)
        {
            if ($hit['_source']['email'] == $login_cookie)
            {
                $like = $hit['_source']['liked_id'];
            }
        }
    }
}

if (!empty($_REQUEST['dislikes']))
{
    $dislike = urldecode($_REQUEST['dislikes']);
}
else
{
    if (!empty($results2['hits']['hits']))
    {
        foreach ($results2['hits']['hits'] as $hit)
        {
            if ($hit['_source']['email'] == $login_cookie)
            {
                $dislike = $hit['_source']['disliked_id'];
            }
        }
    }

}

// echo $like;
// echo $dislike;
$params = ['index' => 'usuarios_', "size" => 5000, 'body' => ["query" => ["simple_query_string" => ["query" => $login_cookie,

"fields" => ["email"], "default_operator" => "or"

]]]];

$results = $client->search($params);
$count = 0;

//$resultado=json_encode($results);
//echo $resultado;
$perfil_relevante = array();
if (!empty($results['hits']['hits']))
{
    foreach ($results['hits']['hits'] as $hit)
    {
        if ($hit['_source']['email'] == $login_cookie)
        {
            $perfil_relevante = $hit['_source']['perfil'];
        }
    }
}

echo "Seu perfil: " . $perfil_relevante;
echo "<br>";
echo "<br>";
echo "Caso deseje pesquisar outros artigos:";
echo "<br>";
echo "<br>";
echo '<a href="pesquisa.php" class="btn btn-primary">Pesquisar</a> ';
echo "<br>";

$perfil_relevante = explode(",", $perfil_relevante);
$words = $perfil_relevante;

//monta a string com os termos do perfil e a prioridade
function stringPrioridade($perfil_relevante)
{
    $peso = count($perfil_relevante);
    for ($i = 0;$i < count($perfil_relevante);$i++)
    {

        $perfil_relevante[$i] = "(" . $perfil_relevante[$i] . "^" . $peso . ") |";

        --$peso;
    }
    $perfil_relevante = implode(" ", $perfil_relevante);

    return $perfil_relevante;
}

$perfil_relevante = stringPrioridade($perfil_relevante);

//parâmetros para o ES
$params2 = ['index' => 'artigos', 'size' => 150, 'body' => ["query" => ["query_string" => ["query" => $perfil_relevante, "fields" => ["paper_title", "paper_abstract_EN", "keyword"], "default_operator" => "or"]]]];

$results2 = $client->search($params2);

// echo "results2: <br>";
// print_r($results2);
// echo "<br><br><br><br>";

echo '

     <input type="hidden" id="likeArray" value="" name="likeArray">
     <input type="hidden" id="notLikeArray" value="" name="notlikeArray">
     <HR WIDTH=100%>';

$titleArray = [];
$personArray = [];
$idEsArray = []; // indexa titulo por id do ES
$scoreArray = []; // score indexado pelo título


$block = "";
if (!empty($like) || !empty($dislike))
{
    $block = "disabled";
}

//indexa resutados pelo título do arquivo
function getPerTitle($results2, &$titleArray, &$idEsArray, &$scoreArray )
{
    foreach ($results2['hits']['hits'] as $hit)
    {
        if (empty($titleArray[$hit['_source']['paper_title']]) || !in_array($hit['_source']['paper_title'], $titleArray[$hit['_source']['paper_title']]))
        {
            $titleArray[$hit['_source']['paper_title']] = $hit['_source'];
            $idEsArray[$hit['_source']['paper_title']] = $hit['_id']; //utilizado para fazer o explain
            $scoreArray[$hit['_source']['paper_title']] = $hit['_score']; //utilizado para análise posterior
        }
    }
}
getPerTitle($results2, $titleArray, $idEsArray, $scoreArray);

// echo "scoreArray: <br>'";
// print_r($scoreArray);
// echo "<br><br><br><br>";

/*obtem todos os autores do artigo em um outro array*/
function getPerson($results2, $titleArray, &$personArray)
{
    foreach ($results2['hits']['hits'] as $hit)
    {
        foreach ($titleArray as $key => $value)
        {
            if ($hit['_source']['paper_title'] == $value['paper_title'])
            {
                if (empty($personArray[$hit['_source']['paper_title']]))
                {
                    $personArray[$hit['_source']['paper_title']] = [];
                    array_push($personArray[$hit['_source']['paper_title']], $hit['_source']['person_name']);
                }
                else
                {
                    for ($i = 0;$i < count($personArray[$hit['_source']['paper_title']]);$i++)
                    {
                        if ($personArray[$hit['_source']['paper_title']][$i] != $hit['_source']['person_name'] && !in_array($hit['_source']['person_name'], $personArray[$hit['_source']['paper_title']]))
                        {
                            array_push($personArray[$hit['_source']['paper_title']], $hit['_source']['person_name']);
                            break;
                        }
                    }
                }
            }
        }
    }
}
getPerson($results2, $titleArray, $personArray);

/*
  PÓS-FILTRO
*/
// echo "Quantidade de artigos encontrados: ";
// print_r(sizeof($idEsArray));
// echo "<br><br>";
/*cria a matriz de resultadosxpalavras e artigosxpalavras*/
foreach ($idEsArray as $key => $value)
{
    for ($i = 0;$i < count($words);$i++)
    {
        $resultsPerWord[$words[$i]] = 0; //Quantas vezes as palavras aparecem no total
        $countCriticalWord[$words[$i]] = 0; //Indexa as palavras que aparecem só uma vez
        $articlePerWord[$key][$words[$i]] = 0; //Indexa quantas palavras por artigo no total
        
    }
}

$arrayAuxiliar = [];
$caracteres = array(
    "(",
    ")",
    ":"
);

/*Para cada artigo dos resultados fazer explain*/
$contador = 0;
foreach ($idEsArray as $key => $value)
{
    if($contador == 10){
        break;
    }
    $params3 = ['id' => $value, 'index' => 'artigos', 'body' => ["query" => ["query_string" => ["query" => $perfil_relevante, "fields" => ["paper_title", "paper_abstract_EN", "keyword"], "default_operator" => "or"]]]];

    $results3 = $client->explain($params3);
    foreach ($results3['explanation']['details'] as $word)
    {
        foreach ($word['details'] as $key2 => $value)
        {
            /*Trata os resultados para obter a informação desejada*/
            $aux = explode(" ", str_replace($caracteres, " ", strtoupper($value['description'])));
            $articlePerWord[$key][$aux[2]]++;
            $resultsPerWord[$aux[2]]++;
        }
    }
    $contador++;
}
// echo "titleArray: <br>";
// print_r($titleArray);
// echo "<br><br><br><br>";

// echo "articlePerWord: <br>";
// print_r($articlePerWord);
// echo "<br><br><br><br>";

// echo "resultsPerWord: <br>";
// print_r($resultsPerWord);
// echo "<br><br>";

/*Lógica para criar perfil invertido*/
$missWord = false;
$inverseWords = [];
for ($i = count($words) - 1;$i >= 0;$i--)
{
    if ($resultsPerWord[$words[$i]] === 0)
    {
        $missWord = true;
    }
    array_push($inverseWords, $words[$i]);
}

/*Lógica pra verificar se alguma palavra apareceu em somente um artigo */
$j = 0;
foreach ($idEsArray as $key => $value)
{
    if ($j === 10)
    {
        break;
    }
    for ($i = 0;$i < count($words);$i++)
    {
        if ($articlePerWord[$key][$words[$i]] > 0)
        {
            //reveer lógica
            if ($countCriticalWord[$words[$i]] == 0)
            {
                $countCriticalWord[$words[$i]] = 1;
                $criticalArticle[$words[$i]] = $key; 
            }
            else if ($countCriticalWord[$words[$i]] > 0)
            {
                $countCriticalWord[$words[$i]] = 2;
                unset($criticalArticle[$words[$i]]);
            }
        }
    }
    $j++;
}

// echo "countCriticalWord: <br>";
// print_r($countCriticalWord);//Se 1 essa palavra só existe nesse arquivo
// echo "<br><br>";

// echo "criticalArticle: <br>";
// print_r($criticalArticle); //Armazena a palavra e o artigo (título)
// echo "<br><br>";

$titleArray2 = [];
$personArray2 = [];
$idEsArray2 = [];
$scoreArray2 = [];
$scoreRetired = [];

// echo "missWord: <br>";
// echo ($missWord ? "true" : "false");
// echo "<br><br>";

if ($missWord)
{
    $inverseWords = stringPrioridade($inverseWords);

    $params2 = ['index' => 'artigos', 'size' => 10, 'body' => ["query" => ["query_string" => ["query" => $inverseWords, "fields" => ["paper_title", "paper_abstract_EN", "keyword"], "default_operator" => "or"]]]];

    $results2 = $client->search($params2);
    getPerTitle($results2, $titleArray2, $idEsArray2, $scoreArray2);
    getPerson($results2, $titleArray2, $personArray2);
    // echo "scoreArray2: <br>";
    // print_r($scoreArray2);
    // echo "<br><br>";

}

echo '  <div class="col-md-7 control-label">
          <p class="help-block"><h11>*</h11> Não esqueça de enviar sua avaliação dos artigos no final da página! </p><br><br>
        </div>
        </br>
        </br>
        <br><br>';
$contador = 0;
echo '<div class="row">';
echo '<div class="col-md-6">';
$nCriticalWord = 0;
/*Primeira coluna de resultados do algoritmo baseline*/
if (!$missWord)
{
foreach ($titleArray as $key => $value)
{
    if ($contador < 10)
    {
        echo '     
            <h5 class="card-title">Título: ' . $value['paper_title'] . '</h5>
            <h5 class="card-text">Ano: ' . $value['paper_year'] . '</h5>
            <h5 class="card-title">Autores: </h5>
            
        ';
        echo '
               <div class="card-body">
                 <p class="card-title">';
        for ($i = 0;$i < count($personArray[$value['paper_title']]);$i++)
        {
            
            if($i == count($personArray[$value['paper_title']]) - 1){
                echo ''.$personArray[$value['paper_title']][$i].' ';
            }else{
                echo ''.$personArray[$value['paper_title']][$i].', ';
            }
        }
        echo '</p>
           </div>';

        echo '
        <div class="row">
          <div class="col-md-8">
            <button type="button" ' . $block . ' class="btn btn-primary" id="like_' . $value['paper_id'] . '" onclick="likeFunction(this)">Gostei</button>
            <button type="button" ' . $block . ' class="btn btn-primary" id="dislike_' . $value['paper_id'] . '"onclick="dislikeFunction(this)">Não Gostei</button>
          </div>';
        if ($value['paper_year'] >= '2006')
        {
            echo '
            <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary">Acesso</a>

        </div>';
        }else{
          echo '
            <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary" disabled>Acesso</a>

        </div>';
        }
        echo '
          <HR WIDTH=100%>
        
      ';
        ++$contador;
    }

}
//echo '</div>';
}else{


$contador = 1;

    
    for ($i = 0;$i < count($words);$i++)
    {
        if ($countCriticalWord[$words[$i]] === 1)
        {
            ++$nCriticalWord;
        }
    }
    if($nCriticalWord > 0)
    {
        $titleArrayReversed = array_reverse($titleArray);
        
        foreach ($titleArrayReversed as $key => $value)
        {
            $flag = false; 
            foreach ($criticalArticle as $key2 => $value2) 
            {
                if($value['paper_title'] === $value2)
                {
                    $flag = true;
                }   
            }
            if(!$flag)
            {
                unset($titleArray[$key]);
                /*para análises*/
                $scoreRetired[$value['paper_title']] = $scoreArray[$value['paper_title']];
                break;
            }
        }    
    }

    //echo '<div class="col-md-6">';
    foreach ($titleArray as $key => $value)
    {

        if ($contador < 10)
        {
           
            echo '
          
         
          <h5 class="card-title">Título: ' . $value['paper_title'] . '</h5>
          <h5 class="card-text">Ano: ' . $value['paper_year'] . '</h5>
          <h5 class="card-title">Autores: </h5>
          
      ';
            echo '
               <div class="card-body">
                 <p class="card-title">';
            for ($i = 0;$i < count($personArray[$value['paper_title']]);$i++)
            {
                
                if($i == count($personArray[$value['paper_title']]) - 1){
                    echo ''.$personArray[$value['paper_title']][$i].' ';
                }else{
                    echo ''.$personArray[$value['paper_title']][$i].', ';
                }
            }
            echo '</p>
               </div>';

            echo '
          <div class="row">
          <div class="col-md-8">
          <button type="button" ' . $block . ' class="btn btn-primary" id="like_' . $value['paper_id'] . '" onclick="likeFunction(this)">Gostei</button>
          <button type="button" ' . $block . ' class="btn btn-primary" id="dislike_' . $value['paper_id'] . '"onclick="dislikeFunction(this)">Não Gostei</button>
          </div>';

            if ($value['paper_year'] >= '2006')
            {
                echo '
          <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary">Acesso</a>
          </div>';
            }else{
              echo '
                <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary" disabled>Acesso</a>

            </div>';
            }
            echo '
        <HR WIDTH=100%>
      
      ';    
        }else if($contador == 10 && empty($scoreRetired))
        {
            /*para analises*/
            $scoreRetired[$value['paper_title']] = $scoreArray[$value['paper_title']];
        }
        $contador++;
    }


    $contador2 = 0;
    foreach ($titleArray2 as $key => $value)
    {
        if ($contador2 === 1)
        {
            break;
        }
        echo '

              <h5 class="card-title">Título: ' . $value['paper_title'] . '</h5>
              <h5 class="card-text">Ano: ' . $value['paper_year'] . '</h5>
              <h5 class="card-title">Autores: </h5>
            
         ';
        
             echo '
               <div class="card-body">
                 <p class="card-title">';
            for ($i = 0;$i < count($personArray2[$value['paper_title']]);$i++)
            {
                
                if($i == count($personArray2[$value['paper_title']]) - 1){
                    echo ''.$personArray2[$value['paper_title']][$i].' ';
                }else{
                    echo ''.$personArray2[$value['paper_title']][$i].', ';
                }
            }
            echo '</p>
               </div>';

        

        echo '
          <div class="row">
          <div class="col-md-8">
              <button type="button" ' . $block . ' class="btn btn-primary" id="like_' . $value['paper_id'] . '" onclick="likeFunction(this)">Gostei</button>
              <button type="button" ' . $block . ' class="btn btn-primary" id="dislike_' . $value['paper_id'] . '"onclick="dislikeFunction(this)">Não Gostei</button>
          </div>';
        if ($value['paper_year'] >= '2006')
        {
            echo '
              <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary">Acesso</a>
          </div>';
        }else{
          echo '
            <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary" disabled>Acesso</a>

        </div>';
        }
        echo '
            <HR WIDTH=100%>
         
        ';
        $contador2++;
    }
    

    // echo "<br>nCriticalWord: <br>";
    // print_r($nCriticalWord);
    // echo "<br><br><br><br>";

    // echo "scoreRetired: <br>";
    // print_r($scoreRetired);
    // echo "<br><br>";
}
echo '</div>';
echo '</div>';

/*Envia analises*/
$indexed = $client->index([
              'index' => 'analises',
              'type' => '_doc',
              'body' => [
                  'email' => $login_cookie,
                  'perfil' => $perfil_relevante,
                  'scoreArray'=> json_encode($scoreArray),
                  'nArticleFound' => sizeof($idEsArray),
                  'articlePerWord' => json_encode($articlePerWord),
                  'resultsPerWord' => json_encode($resultsPerWord),
                  'countCriticalWord' => json_encode($countCriticalWord),
                  'criticalArticle' => json_encode($criticalArticle),
                  'missWord' => $missWord ? "true" : "false",
                  'scoreArray2' => json_encode($scoreArray2),
                  'nCriticalWord' => json_encode($nCriticalWord),
                  'scoreRetired' => json_encode($scoreRetired),
               ],
            ]);

?>
<div class="row">
<div class="col-md-12">
<button type="button" onclick="enviaForm()"  class="btn btn-primary btn-lg btn-block">Enviar Avaliações

    <script>
    var like = "<?php echo $like; ?>";
    var dislike = "<?php echo $dislike; ?>";
    //alert(like);
    function loadArrays() {

      var likeArray = like.split(';');
      var notLikeArray = dislike.split(';');

      if (likeArray != "") {
        for (var i = likeArray.length - 1; i >= 0; i--) {
          if (likeArray[i] != "") {
            //alert(likeArray[i]);
            document.getElementById("like_"+likeArray[i]).style.background = 'green';
            document.getElementById("dislike_"+likeArray[i]).disabled = true;
          }
        }
      }

      if (notLikeArray != "") { //mudei de dislike para notLikeArray
        for (var i = notLikeArray.length - 1; i >= 0; i--) {
          if (notLikeArray[i] != "") {
            document.getElementById("dislike_"+notLikeArray[i]).style.background = 'red';
            document.getElementById("like_"+notLikeArray[i]).disabled = true;
          }
        }
      }
    }

    loadArrays();

    function likeFunction(el) {
      likeString = document.getElementById("likeArray").value;
      dislikedString = document.getElementById("notLikeArray").value;

      var liked = (el.id).replace("like_", "");

      if (dislikedString.includes(liked)) {
        document.getElementById("notLikeArray").value = dislikedString.replace(liked+";", "");
        document.getElementById("likeArray").value = likeString.replace(liked+";", "");
        document.getElementById("like_"+disliked).style.backgroundColor = '';
      }

      if (likeString.includes(liked)) {
        document.getElementById("likeArray").value = likeString.replace(liked+";", "");
        document.getElementById("like_"+liked).style.backgroundColor = '';
      } else {
        document.getElementById("likeArray").value = likeString+liked+";"
        document.getElementById("like_"+liked).style.backgroundColor = 'green';

      }
    }

    function dislikeFunction(el) {
      dislikedString = document.getElementById("notLikeArray").value;
      likeString = document.getElementById("likeArray").value;

      var disliked = (el.id).replace("dislike_", "");

      if (likeString.includes(disliked)) {
        document.getElementById("notLikeArray").value = dislikedString.replace(disliked+";", "");
        document.getElementById("likeArray").value = likeString.replace(disliked+";", "");
        document.getElementById("like_"+disliked).style.backgroundColor = '';
      }

      if (dislikedString.includes(disliked)) {
        document.getElementById("notLikeArray").value = dislikedString.replace(disliked+";", "");
        document.getElementById("dislike_"+disliked).style.backgroundColor = '';
      } else {
        document.getElementById("notLikeArray").value = dislikedString+disliked+";"
        document.getElementById("dislike_"+disliked).style.backgroundColor = 'red';
      }

    }


      function enviaForm() {

        dislikedString = document.getElementById("notLikeArray").value;
        likeString = document.getElementById("likeArray").value;
        //alert(chks1);

        // 1 == like 2 == dislike

        //var form = document.getElementById("Form1");
        var url = "checks.php?like="+encodeURIComponent(likeString)+"&dislike="+encodeURIComponent(dislikedString);
        window.location.href = url;
      }

    </script>
</button>
</div>
</div>
</body>
</html>
