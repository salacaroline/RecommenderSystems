<?php
require 'vendor/autoload.php';
session_start();
$host = ["http://search-sistemarecomendacao-n4nryark2nid6lbezhlvlm3imm.sa-east-1.es.amazonaws.com:80"];
$client = Elasticsearch\ClientBuilder::create()->setHosts($host)->build();
// (4)
$login = $_GET['email'];
$senha = $_GET['senha'];

if($login === null and $senha === null){
    $login = $_SESSION['login'];
    $senha = $_SESSION['senha'];
}

#"(IMML)^2 | computer | interaction"
$params = ['index' => 'usuarios_', 'body' => ["query" => ["simple_query_string" => ["query" => $login, "fields" => ["email"], "default_operator" => "or"

]]]];

$results = $client->search($params);

if (!empty($results['hits']['hits']))
{
    foreach ($results['hits']['hits'] as $hit)
    {
        if ($hit['_source']['senha'] == $senha)
        {

            $_SESSION['login'] = $login;
            $_SESSION['senha'] = $senha;
            header("Location:index.php");
        }
        else
        {
            echo "<script language='javascript' type='text/javascript'>
                  alert('Login e/ou senha incorretos!');window.location
                  .href='/login.php';</script>";
        }

    }
}
else
{

    echo "<script language='javascript' type='text/javascript'>
            alert('Login e/ou senha incorretos!');window.location
            .href='/login.php';</script>";
    die();
}

?>
