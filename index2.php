<html>
    <head>
        <meta charset="utf-8">
        <title>Recomendação</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="css/css.css">


    </head>

    <body>
      <script>
      //alert("Avaliação enviada com sucesso!");
      </script>

<?php
#caminho do arquivo no ubuntu: Computer/usr/share/nginx/html/tcc
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
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
        echo "<br>";

        echo "Caso deseje pesquisar outros artigos:";
        echo "<br>";
        echo "<br>";
        echo '<a href="pesquisa.php" class="btn btn-primary">Pesquisar</a> ';
        echo "<br>";

        // }else{
        //   echo"Bem-Vindo, convidado <br>";
        //   //echo"<h4>Artigos recomendados de acordo com seu perfil:</h4>;
        //   echo"<br><a href='login.php'>Faça Login</a> Para ler o conteúdo";
        //
        //
        //
        
    }

}
else
{
    echo "Bem-Vindo(a), convidado <br>";
    //echo"Essas informações <font color='red'>NÃO PODEM</font> ser acessadas por você";
    echo "<br><a href='login.php'>Faça Login</a> Para ler o conteúdo";
}

require 'vendor/autoload.php';
$client = Elasticsearch\ClientBuilder::create()->build();

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
        $perfil_relevante = $hit['_source']['perfil'];

    }
}
$perfil_relevante = explode(",", $perfil_relevante);
$peso = count($perfil_relevante);
for ($i = 0;$i < count($perfil_relevante);$i++)
{

    $perfil_relevante[$i] = "(" . $perfil_relevante[$i] . "^" . $peso . ") |";

    --$peso;
}
$perfil_relevante = implode(" ", $perfil_relevante);

$params2 = ['index' => 'artigos', 'size' => 100, 'body' => ["query" => ["simple_query_string" => ["query" => $perfil_relevante, "fields" => ["paper_title", "paper_abstract_EN", "keyword"], "default_operator" => "or"

]]]];
//
$results2 = $client->search($params2);

$filterResult = [];
$contador = 0;

// foreach ($results2['hits']['hits'] as $hit) {
//   if (!in_array($hit['_source']['paper_title'], $filterResult)) {
//     $filterResult[$hit['_source']['paper_title']] = $hit;
//   }
// }
echo '

     <input type="hidden" id="likeArray" value="" name="likeArray">
     <input type="hidden" id="notLikeArray" value="" name="notlikeArray">
     <HR WIDTH=100%>';
// if (!empty($filterResult)) {
//      foreach ($filterResult as $key => $value) {
//        if($count<10){
//          echo
//               '
//                 <div class="card-body">
//                 <br>
//
//                   <h4 class="card-title">'.$value['_source']['paper_title'].'</h4>
//                   <p class="card-text">Ano: '.$value['_source']['paper_year'].'</p>
//                   <h5></h5>
//
//                   <div class="col-md-8">
//
//                     <button type="button" id="like_'.$value['_source']['paper_id'].'" onclick="likeFunction(this)">Curtir</button>
//                     <button type="button" id="dislike_'.$value['_source']['paper_id'].'"onclick="dislikeFunction(this)">Descurtir</button>
//
//
//                   </div>
//                   <a href="#" class="btn btn-primary">Download</a>
//                 </div>
//
//                 <HR WIDTH=100%>
//
//                 <HR WIDTH=100%>
//               </div>';
//               ++$count;
//
//        }else{
//          break;
//        }
//
//
//     }
// }
//
$filterResult2 = [];

$titleArray = [];
$personArray = [];

$block = "";
if (!empty($like) || !empty($dislike))
{
    $block = "disabled";
}

foreach ($results2['hits']['hits'] as $hit)
{
    if (empty($titleArray[$hit['_source']['paper_title']]) || !in_array($hit['_source']['paper_title'], $titleArray[$hit['_source']['paper_title']]))
    {
        $titleArray[$hit['_source']['paper_title']] = $hit['_source'];
    }
}
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
echo '  <div class="col-md-7 control-label">
          <p class="help-block"><h11>*</h11> Não esqueça de enviar sua avaliação dos artigos no final da página! </p><br><br>
        </div>
        </br>
        </br>
        <br><br>';
foreach ($titleArray as $key => $value)
{
    if ($contador < 10)
    {
        echo '<div class="card-body">

              <h5 class="card-title">Título: ' . $value['paper_title'] . '</h5>
              <h5 class="card-text">Ano: ' . $value['paper_year'] . '</h5>
              <h5 class="card-title">Autores: </h5>
            </div>
          </div>';
        //if($count<10){
        for ($i = 0;$i < count($personArray[$value['paper_title']]);$i++)
        {
            echo '
                   <div class="card-body">
                     <p class="card-title">' . $personArray[$value['paper_title']][$i] . '</p>
                     </div>

                   </div>
                  ';
        }

        echo '
          <div class="col-md-8">

              <button type="button" ' . $block . ' id="like_' . $value['paper_id'] . '" onclick="likeFunction(this)">Gostei</button>
              <button type="button" ' . $block . ' id="dislike_' . $value['paper_id'] . '"onclick="dislikeFunction(this)">Não Gostei</button>


            </div><br>';
        if ($value['paper_year'] >= '2006')
        {
            echo '
              <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary">Acesso</a>';
        }
        echo '
            <HR WIDTH=100%>
          </div>
        ';
        ++$contador;
    }

}

?>


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

    </body>
</html>
