<?php
require 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();
// (4)
$login = $_GET['email'];
$senha = $_GET['senha'];

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

            setcookie("login", $login);
            header("Location:index.php");
        }
        else
        {
            echo "<script language='javascript' type='text/javascript'>
                  alert('Login e/ou senha incorretos!');window.location
                  .href='/tcc/login.php';</script>";
        }

    }
}
else
{

    echo "<script language='javascript' type='text/javascript'>
            alert('Login e/ou senha incorretos!');window.location
            .href='/tcc/login.php';</script>";
    die();
}

?>
