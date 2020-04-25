<?php
include 'script/conexao.php';
include 'script/sessao.php';
$conexaos = new PDO('mysql:host=localhost;dbname=producao',"root","");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Carrinho de Compras</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/personalizado.js"></script>
</head>
<body>
	<div class="container theme-showcase" role="main">


<?php
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
if(mysqli_affected_rows($conexao) > 0){

?>
	<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header alert-success">
        <h5 class="modal-title" id="exampleModalLabel">&nbsp;&nbsp;Pedido Efetuado com Sucesso!</h5>
      </div>
      <div class="modal-body">
        <h6>Seu pedido foi enviado para o vendedor</h6>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function () {
		$('#myModal').modal('show');

	});
</script>

<?php
}else{?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php
}


unset($_SESSION['itens']);  //após finalizar a compra, limpa o carrinho de compras
echo '<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=carrinho.php"/>';
?>


</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>




