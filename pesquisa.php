<html>
    <head>
        <meta charset="utf-8">
        <title>Search Elasticsearch</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="css/css.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body>



<?php

#caminho do arquivo no ubuntu: Computer/usr/share/nginx/html/tcc
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
/*
session_start();
if((!isset ($_SESSION['email']) == true) and (!isset ($_SESSION['senha']) == true))
{
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  header('location:index.php');
  }

$logado = $_SESSION['email'];

*/



require 'vendor/autoload.php';


$client = Elasticsearch\ClientBuilder::create()->build();
 // (4)

if(isset($_GET['q'])){
  $q = $_GET['q'];
  $params = [
      'index' => 'artigos',
      "size"=>5000,
      'body' => [
          "query"=> [
              "simple_query_string" =>[
                "query" => $q,

                "fields" => ["paper_title", "paper_abstract_EN", "keyword"],
                "default_operator"=> "or"

              ]
          ]
      ]
  ];

  $results = $client->search($params);


  // $resultado=json_encode($results);
  // echo $resultado;


  $filterResult = [];
  $filterResult2 = [];

  $titleArray = [];
  $personArray = [];

  foreach ($results['hits']['hits'] as $hit) {
    if (empty($titleArray[$hit['_source']['paper_title']]) || !in_array($hit['_source']['paper_title'], $titleArray[$hit['_source']['paper_title']])) {
      $titleArray[$hit['_source']['paper_title']] = $hit['_source'];
    }
  }

  foreach ($results['hits']['hits'] as $hit) {
    foreach ($titleArray as $key => $value) {
      if ($hit['_source']['paper_title'] == $value['paper_title']) {
        if (empty($personArray[$hit['_source']['paper_title']])) {
          $personArray[$hit['_source']['paper_title']] = [];
          array_push($personArray[$hit['_source']['paper_title']], $hit['_source']['person_name']);
        } else {
          for ($i=0; $i < count($personArray[$hit['_source']['paper_title']]); $i++) {
            if ($personArray[$hit['_source']['paper_title']][$i] != $hit['_source']['person_name'] && !in_array($hit['_source']['person_name'],$personArray[$hit['_source']['paper_title']])) {
              array_push($personArray[$hit['_source']['paper_title']], $hit['_source']['person_name']);
              break;
            }
          }
        }
      }
    }
  }
  echo"<h3>Artigo(s) relacionado(s) à sua pesquisa:</h3>";
  echo "<br>";

  echo " <a href='home.php' >Home</a> ";
  echo "<br>";

  echo "<HR WIDTH=100%>";

  foreach ($titleArray as $key => $value) {
    echo '<div class="card-body">
        <h5 class="card-title">'.$value['paper_title'].'</h5>
        <h5 class="card-text">Ano de publicação: '.$value['paper_year'].'</h5>
        <h5 class="card-title">Autores: </h5>
      </div>
    </div>';

    for ($i=0; $i < count($personArray[$value['paper_title']]); $i++) {
      echo
           '
             <div class="card-body">
               <p class="card-title">'.$personArray[$value['paper_title']][$i].'</p>
               </div>

             </div>
            ';
    }
    if($value['paper_year']>='2006'){

      echo '
      <div class="col-md-8">
      </div>
       <a href="https://dl.acm.org/event.cfm?id=RE449" class="btn btn-primary">Acesso</a>
      ';
    }
    echo "<HR WIDTH=100%>
     ";


  }


}


?>


    <br>  <br>  <br>  <br>
    <form class="form-horizontal">
        <fieldset>
        <div class="panel panel-primary">
          <div class="panel-heading">Pesquisar</div>

              <div class="panel-body">
                <div class="form-group">
      </form>

        <form action="pesquisa.php" method="get" autocomplete="off">

                <div class="col-md-2 control-label">
                  <input type="text" name="q">
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label" for="Cadastrar"></label>
                  <div class="col-md-8">
                    <button id="Cadastrar" name="Cadastrar" class="btn btn-success" type="Submit">Ir</button>

                  </div>
               </div>
        </form>


    </body>
</html>
