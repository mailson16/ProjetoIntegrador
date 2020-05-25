<?php
include 'script/conexao.php';
include 'script/password.php';

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$nome_cliente = $nome. " ". $sobrenome;
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$usuario = $_POST['usuario'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$status = 'A';
$today = date("Y-m-d");  

$sql = " INSERT INTO cliente_fisico (NOME_CLIENTE, EMAIL_CLIENTE, TELEFONE_CLIENTE, SENHA_CLIENTE, TIPO_CLIENTE, LOGIN_CLIENTE, STATUS_CLIENTE, DATA_CADASTRO) VALUES ('$nome_cliente','$email','$telefone',sha1('$senha'),'$usuario','$login','$status','$today')";
//echo "$sql";
$inserir = mysqli_query($conexao, $sql);
echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=menu.php"/>';

?>

