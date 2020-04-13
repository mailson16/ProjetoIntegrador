<?php

include 'script/conexao.php';
include 'script/password.php';

$usuario  = $_POST['usuario'];
$senhausuario = $_POST['senha'];

$sql = "select login_cliente, senha_cliente, cod_cliente, tipo_cliente from cliente_fisico where login_cliente = '$usuario'";
$buscar = mysqli_query($conexao,$sql);

$total = mysqli_num_rows($buscar); //vai buscar a qtd de linhas dentro da tabela, se for 0 nao existe usuario

if ($total == 1){
while ($array = mysqli_fetch_array($buscar)){

	$senha = $array['senha_cliente'];
	$_SESSION['cod_usuario'] = $array['cod_cliente'];
	$_SESSION['tipo_usuario'] = $array['tipo_cliente'];

	$senhacodificada = sha1($senhausuario);

	
	#conferir senha
		if ($senhacodificada == $senha){
			session_start();
			$_SESSION['usuario'] = $usuario;
			header('location: menu.php');
		}else{
			header('location: erro.php');
		}
		


}
}else{
	header('location: erro.php');
}
echo "aqui";
?>
