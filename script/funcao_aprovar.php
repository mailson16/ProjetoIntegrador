<?php
include 'conexao.php';
include 'sessao.php';


$sOption = $_POST['voption'];
$sID     = $_POST['vid'];

if ($sOption = "1" and $sID <> ""){

	$sql = " update produto set STATUS_PRODUTO = 'A' 
			 where id_produto = '$sID' ";
	if (mysqli_query($conexao, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conexao);	
	//$inserir = mysqli_query($conexao, $sql);
     
}



?>