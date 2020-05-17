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
    case "3":
		if ($sOption = "1" and $sID <> ""){

			$sql = " update pedido_vendedor set STATUS_PEDIDO = 'A' 
					 where ID_PEDIDO_VENDEDOR = '$sID' ";
			if (mysqli_query($conexao, $sql)) {
				$response = array("success" => true);
    			echo json_encode($response);
			} 
			else {
				echo json_encode(array("statusCode"=>201));
			}
		}
		mysqli_close($conexao);	
		//$inserir = mysqli_query($conexao, $sql);
     	break;
     case "4":
		if ($sOption = "4" and $sID <> ""){

			$sql = " select pr.imagem_produto, pr.nome_produto, cc.QTD_PRODUTO, cc.PRECO_PRODUTO from pedido_vendedor p
				inner join carrinho_compras cc on p.id_pedido = cc.ID_PEDIDO
				inner join produto pr on cc.COD_PRODUTO = pr.id_produto
				where ID_PEDIDO_VENDEDOR = '$sID' 
				and p.COD_VENDEDOR = pr.cod_cliente
				";
			$resultado_user = mysqli_query($conexao,$sql);

			if(($resultado_user) and ($resultado_user->num_rows != 0)){

				echo "	<tr>";
				while ($array = mysqli_fetch_array($resultado_user) ) {
					echo "		<td><img src=".$array['imagem_produto']." style='width:120px'></td>";
					echo "		<td>".$array['nome_produto']."</td>";
					echo "		<td>".$array['QTD_PRODUTO']."</td>";
					echo "		<td>R$ ".number_format($array['PRECO_PRODUTO'],2,",",".")."</td>";
					echo "	</tr>";


				}
				
			}else{
				echo "Nenhum produto encontrado";
			}
			
		}
		mysqli_close($conexao);	
		//$inserir = mysqli_query($conexao, $sql);
     	break;

    default:
        echo "Your favorite color is neither red, blue, nor green!";
}

?>