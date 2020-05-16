<?php
include 'conexao.php';
include 'sessao.php';


$sOption = $_POST['voption'];
$valor = $_POST['valor'];
$vendedor = $_POST['vendedor'];
$cliente = $_POST['cliente'];
$mes = $_POST['mes'];
$sID     = $_POST['vid'];


switch ($sOption) {
	case "1":
		$sql = "INSERT INTO boleto (VALOR_BOLETO, COD_VENDEDOR, COD_CLIENTE, STATUS_BOLETO, PERIODO_BOLETO) VALUES ('$valor', '$vendedor', '$cliente', 'P', '$mes')";
		if (mysqli_query($conexao, $sql)) {
			$response = array("success" => true);
    		echo json_encode($response);
		}else {
			echo json_encode(array("statusCode"=>201));
		}
		mysqli_close($conexao);
		break;
	case "2":
		if ($sOption = "2" and $sID <> ""){

			$sql = " update boleto set STATUS_BOLETO = 'F' 
					 where ID_BOLETO = '$sID' ";
			if (mysqli_query($conexao, $sql)) {
				echo json_encode(array("statusCode"=>200));
			} 
			else {
				echo json_encode(array("statusCode"=>201));
			}
		}
		mysqli_close($conexao);	
		//$inserir = mysqli_query($conexao, $sql);
     	break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}

?>