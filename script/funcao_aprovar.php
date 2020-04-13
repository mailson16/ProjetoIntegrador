<?php
include 'conexao.php';
include 'sessao.php';


$sOption = $_POST['voption'];
$sID     = $_POST['vid'];

switch ($sOption) {
	case "1":
		if ($sOption = "1" and $sID <> ""){

			$sql = " update produto set STATUS_PRODUTO = 'A' 
					 where id_produto = '$sID' ";
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
    case "2":
     	if ($sOption = "2" and $sID <> ""){

			$sql = " delete from produto 
					 where id_produto = $sID ";
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