<?php
$perfil = urldecode($_REQUEST['parametros']); // (5)

session_start();


require 'vendor/autoload.php';

$host = ["http://search-sistemarecomendacao-n4nryark2nid6lbezhlvlm3imm.sa-east-1.es.amazonaws.com:80"];
$client = Elasticsearch\ClientBuilder::create()->setHosts($host)->build();

if (!empty($_REQUEST))
{ // (4)
    if (isset($_REQUEST['nome'], $_REQUEST['senha'], $_REQUEST['email'], $_REQUEST['instituicao']) && !empty($perfil))
    {

        $nome = $_REQUEST['nome'];
        $senha = $_REQUEST['senha'];
        $email = $_REQUEST['email'];
        $instituicao = $_REQUEST['instituicao'];
        $conhecoIHC = $_REQUEST['conhecoIHC'];
        $_SESSION['login'] = $email;
        $_SESSION['senha'] = $senha;


        #$attributes = explode(',', $_REQUEST['attributes']); // (5)
        //echo $senha;
        // (6)
        $indexed = $client->index(['index' => 'usuarios_', 'type' => '_doc', 'body' => ['nome' => $nome, 'senha' => $senha, 'email' => $email, 'instituicao' => $instituicao, 'perfil' => $perfil, 'conhecoIHC'=> $conhecoIHC,

        ], ]);
         header("Location:login.php");
    }else{
      header('Location: login.php');
    }
}

echo "
<html>
<head>
</head>
<body>
  <form id='Form1' >
  <script>
    document.getElementById('Form1').submit();
  </script>
</body>
</html>
";

?>
