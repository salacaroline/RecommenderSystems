<?php
$perfil = urldecode($_REQUEST['parametros']); // (5)

session_start();


require 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

if (!empty($_REQUEST))
{ // (4)
    if (isset($_REQUEST['nome'], $_REQUEST['senha'], $_REQUEST['email'], $_REQUEST['instituicao']) && !empty($perfil))
    {

        $nome = $_REQUEST['nome'];
        $senha = $_REQUEST['senha'];
        $email = $_REQUEST['email'];
        $instituicao = $_REQUEST['instituicao'];
        $_SESSION['login'] = $email;
        $_SESSION['senha'] = $senha;


        #$attributes = explode(',', $_REQUEST['attributes']); // (5)
        //echo $senha;
        // (6)
        $indexed = $client->index(['index' => 'usuarios_', 'type' => '_doc', 'body' => ['nome' => $nome, 'senha' => $senha, 'email' => $email, 'instituicao' => $instituicao, 'perfil' => $perfil,

        ], ]);
         //header("Location:open.php");
    }else{
      //header('Location: home.php');
    }
}

echo "
<html>
<head>
</head>
<body>
  <form id='Form1' action='index.php'>
  <script>
    document.getElementById('Form1').submit();
  </script>
</body>
</html>
";

?>
