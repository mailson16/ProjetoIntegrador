<?php


function RetornaNome(&$var) {
	$servername = "localhost"; //padrao - server local
	$database = "producao"; //alterar conforme o nome do seu banco de dados
	$username = "root"; // padrao - root
	$password = ""; // senha de conexao do bd
	$conexao = mysqli_connect($servername,$username,$password,$database);
	$sql = "select NOME_CLIENTE from cliente_fisico where COD_CLIENTE = '$var' ";
	$buscar = mysqli_query($conexao,$sql);

	while ($array = mysqli_fetch_array($buscar)){
		$nome = $array['NOME_CLIENTE'];
		echo "$nome";

	}
	
}

?>