<?php
session_start();

 // limpe tudo que for necessário na saída.
 // Eu geralmente não destruo a seção, mas invalido os dados da mesma
 // para evitar algum "necromancer" recuperar dados. Mas simplifiquemos:
 session_destroy();
 header("location: home.php");
 exit();

?>
