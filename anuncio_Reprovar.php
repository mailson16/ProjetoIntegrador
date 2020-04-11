<?php
include 'script/conexao.php';
include 'script/sessao.php';

$id_produto = $_GET['id'];

$motivo=filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING);
$option=filter_input(INPUT_POST,'send',FILTER_SANITIZE_STRING);
$vendedor=filter_input(INPUT_POST,'vendedor',FILTER_SANITIZE_STRING);


if ($option == '1') {
	$sql = " INSERT INTO anuncio_negado (id_produto, cod_cliente, msg_negado) VALUES 
		('$id_produto','$vendedor','$motivo')";
		$inserir = mysqli_query($conexao, $sql);

	$sql2 = " update Produto set STATUS_PRODUTO = 'N' 
			  where id_produto = '$id_produto' ";
			$inserir2 = mysqli_query($conexao, $sql2);

	header("location:anuncio_Aprovar.php");
}

$sql ="select * from Produto where id_produto = '$id_produto' ";
$buscar = mysqli_query($conexao,$sql);

while ($array = mysqli_fetch_array($buscar)){

	$vendedor = $array['cod_cliente'];
	$produto = $array['nome_produto'];
	$categoria = $array['categoria_produto'];
	$tipo = $array['tipo_produto'];
	$id = $array['id_produto'];
}	


?>
<!DOCTYPE html>
<html>
<head>
	<title>Anúncios</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body class="bg-dark">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 80px">
		
			<a class="navbar-brand mr-0 mr-md-2">
				<img src="imagens/logo.png" style="height:150px">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse h5" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="menu.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Pedidos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Produtos</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="anuncio_Aprovar.php">Anúncio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Relatório</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Minha Conta</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Sair</a>
					</li>
					
				</ul>
			</div>
		
	</nav>
		
		<div class="card my-1">
			<div class="card-header bg-danger">
				<h4>Anúncio Reprovado</h4>
			</div>
			<div style="padding: 10px">
				<form action="" method="post">
					<div class="container" style="padding: 20px;">
						<div class="form-row col-md-10">
							<div class="form-group col-md-5">
								<label class="font-weight-bold" for="inputNome">Vendedor</label>
								<input type="text" class="form-control" name="vendedor" value="<?php echo $vendedor ?>">
							</div>
							
							<div class="form-group col-md-5">
								<label class="font-weight-bold" for="inputNome">Produto</label>
								<input type="text" class="form-control" name="produto" value="<?php echo $produto ?>">
							</div>
							
							<div class="form-group col-md-10">
								<label class="font-weight-bold">Motivo</label>
								<textarea class="form-control" rows="5" name="descricao"></textarea>
							</div>
						</div>
						<div class="form-row col-md-10">
							<div class="my-4" style="text-align: center">
								<button class="btn btn-success" name="send" value="1">Enviar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row bg-dark">
		<div class="container">
			<div class="row">
				<div class="col-md-3 my-3">
					<h3>LeaderNet</h3>
					<h5>Telefones</h5>
					<h6>(21)3309-8765</h6>
					<h6>(21)3309-8766</h6>
				</div>
				
				<div class="col-md-3 my-3">
					<h3>&nbsp;</h3>
					<h5>LeaderNet</h5>
					<h6>Fale Conosco</h6>
					<h6>Trabalhe Conosco</h6>
				</div>

				<div class="col-md-4 my-3">
					<h3>&nbsp;</h3>
					<h5>Endereço</h5>
					<h6>Rua Buenos Aires, 90 - 6° andar Centro - Rio de Janeiro</h6>
					<h5>&nbsp;</h5>
				</div>
				<div class="col-12 mb-0">
					<blockquote class="blockquote text-center text-light">
						<h6>@2020 LeaderNet. Todos os direitos reservados</h6>
					</blockquote>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>