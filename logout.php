<?php  
session_start();
unset($_SESSION['usuario']);
unset($_SESSION['itens']);  //após deslogar mata todas as compra do carrinho
?>

<script>location.href='index.php';</script>