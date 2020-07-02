<?php
session_start();
if((isset ($_SESSION['login']) == true) and (isset ($_SESSION['senha']) == true))
{
  header('Location: index.php');
}


?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/css2.css">
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!--
    <div class="fadeIn first">
      <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" />
    </div>
    Icon IHC -->

    <form action="open.php" id="Form1" method="get" >
      <input type="text" id="nome" class="fadeIn second" name="email" placeholder="email@email.com">
      <input type="password" id="senha" class="fadeIn third" name="senha" placeholder="senha">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>



    <div id="formFooter">
      <a class="underlineHover" href="cadastro.php">Cadastre-se</a>
    </div>


  </div>
</div>
