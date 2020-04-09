<?php

include 'conexao.php';
//03-04-2020
//com essa conexão não preciso mais ficar iniciando sessão, nem fazendo a validação se o usuario está logando.
//basta chamar esse include que está tudo feito.
	session_start();

	$usuario = $_SESSION['usuario'];
	if(!isset($_SESSION['usuario'])){
		header('location:index.php');
	}
	$sql = "select cod_cliente, tipo_cliente from cliente_fisico where login_cliente = '$usuario'";
	$buscar = mysqli_query($conexao,$sql);

	$total = mysqli_num_rows($buscar); //vai buscar a qtd de linhas dentro da tabela, se for 0 nao existe usuario

if ($total == 1){
	while ($array = mysqli_fetch_array($buscar)){

		$_SESSION['cod_usuario'] = $array['cod_cliente']; //atribuí essas variaveis como sessao, quem vem do BD
		$_SESSION['tipo_usuario'] = $array['tipo_cliente'];

	}
}
?>
