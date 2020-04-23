<?php
include 'script/conexao.php';
include 'script/sessao.php';
$conexaos = new PDO('mysql:host=localhost;dbname=producao',"root","");

$cod_usuario = $_SESSION['cod_usuario'];
$total_pedido = $_SESSION['totalGeral'];
$status_pedido = 'P';
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");
//adiciono um  numero de pedido na tabela pedido
$insert = $conexaos->prepare("
	insert into pedido () values (null,?,?,?,?)");
$insert->bindParam(1,$cod_usuario);
$insert->bindParam(2,$total_pedido);
$insert->bindParam(3,$status_pedido);
$insert->bindParam(4,$data);
$insert->execute();

//resgato o numero de pedido gerado

$sql ="select * from pedido where status_pedido in('P')  
	   order by id_pedido desc limit 1 ";
$buscar = mysqli_query($conexao,$sql);

while ($array = mysqli_fetch_array($buscar)){

	$id_pedido = $array['ID_PEDIDO'];
}	



foreach ($_SESSION['dados'] as $produtos) {
	//$conexao = new PDO('mysql:host=localhost;dbname=producao',"root","");
	$insert = $conexaos->prepare("
		insert into carrinho_compras () values (?,?,?,?,?)");
		$insert->bindParam(1,$id_pedido);
		$insert->bindParam(2,$produtos['id_produto']);
		$insert->bindParam(3,$produtos['nome_produto']);
		$insert->bindParam(4,$produtos['quantidade']);
		$insert->bindParam(5,$produtos['preco_total']);
		$insert->execute();
		


}




?>