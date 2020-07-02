<?php
session_start();

unset($_SESSION['login']);
unset($_SESSION['senha']);
        

 // limpe tudo que for necessário na saída.
 // Eu geralmente não destruo a seção, mas invalido os dados da mesma
 // para evitar algum "necromancer" recuperar dados. Mas simplifiquemos:
 session_destroy();
 header("Location: home.php");
 exit();

?>
