<?php
  session_start();
  $likes =  urldecode($_REQUEST['like']);
  $dislikes =  urldecode($_REQUEST['dislike']);
  // //4067;1,4068;2,
  // $liked=[];
  // $disliked=[];
  //echo $likes;

  $array_like = explode(';', $likes);
  $array_like1= implode("|", $array_like);


  $array_dislike = explode(';', $dislikes);
  $array_dislike1= implode("|", $array_dislike);
  $insere_like=[];
  $insere_dislike=[];

  //echo
$email=$_SESSION['login'];
//echo $likes;


  //

  // foreach ($array_like as $key => $value) {
  //
  //   echo $value;
  //   echo"<br>";
  //
  //  }

  require 'vendor/autoload.php';

$host = ["http://search-sistemarecomendacao-n4nryark2nid6lbezhlvlm3imm.sa-east-1.es.amazonaws.com:80"];
$client = Elasticsearch\ClientBuilder::create()->setHosts($host)->build();
   // (4)
   //likes no vetor

      $params = [
          'index' => 'artigos',
          "size"=>5000,
          'body' => [
              "query"=> [
                  "simple_query_string" =>[
                    "query" => $array_like1,

                    "fields" => ["paper_id"],
                    "default_operator"=> "or"

                  ]
              ]
          ]
      ];
  //
    $results = $client->search($params);
    $filterResult = [];

     foreach ($results['hits']['hits'] as $hit) {
       if (!in_array($hit['_source']['paper_id'], $filterResult)) {
         $filterResult[$hit['_source']['paper_id']] = $hit;
       }
     }
    foreach ($filterResult as $key => $value) {
      // code...
      array_push($insere_like,$value['_source']['paper_title']);
    }

    //dislikes no vetor


          $params2 = [
              'index' => 'artigos',
              "size"=>5000,
              'body' => [
                  "query"=> [
                      "simple_query_string" =>[
                        "query" => $array_dislike1,

                        "fields" => ["paper_id"],
                        "default_operator"=> "or"

                      ]
                  ]
              ]
          ];
      //
        $results2 = $client->search($params2);
        $filterResult2 = [];

         foreach ($results2['hits']['hits'] as $hit) {
           if (!in_array($hit['_source']['paper_id'], $filterResult2)) {
             $filterResult2[$hit['_source']['paper_id']] = $hit;
           }
         }
        foreach ($filterResult2 as $key => $value) {
          // code...
          array_push($insere_dislike,$value['_source']['paper_title']);
        }

        //indexar no elastic

        //pegar login do cookie e indexar em novo index: o de avaliaçoes







          $indexed = $client->index([
              'index' => 'avaliar',
              'type' => '_doc',
              'body' => [
                   'email' => $email,
                  'liked_name' => $insere_like,
                  'liked_id'=> $likes,
                  'disliked_name' => $insere_dislike,
                  'disliked_id' => $dislikes,

               ],
            ]);



      //echo "Deu bom!";

  echo "
  <html>
  <head>
  </head>
  <body>
    <form id='Form1' action=''>
    <input id='likes' type='hidden' value='".urlencode($likes)."'>

    <script>

      window.location.href = 'index.php?likes=".urlencode($likes)."&dislikes=".urlencode($dislikes)."';

    </script>
  </body>
  </html>
  ";

?>
