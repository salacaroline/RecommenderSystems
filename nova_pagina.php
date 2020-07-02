<?php
$perfil = urldecode($_REQUEST['parametros']); // (5)
//$perfil= array();


//$perfil = explode(',', $perfil2);


// (6)
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

        #$attributes = explode(',', $_REQUEST['attributes']); // (5)
        //echo $senha;
        // (6)
        $indexed = $client->index(['index' => 'usuarios_', 'type' => '_doc', 'body' => ['nome' => $nome, 'senha' => $senha, 'email' => $email, 'instituicao' => $instituicao, 'perfil' => $perfil,

        ], ]);
    }
}

echo "
<html>
<head>
</head>
<body>
  <form id='Form1' action='login.php'>
  <script>
    document.getElementById('Form1').submit();
  </script>
</body>
</html>
";

?>
