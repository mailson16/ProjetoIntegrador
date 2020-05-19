<?php
include 'script/sessao.php';
include 'script/conexao.php';
	//echo "cod_usuario " . $_SESSION['cod_usuario'] . "<br>";
	//echo "tipo de usuario " . $_SESSION['tipo_usuario'] . "<br>";

?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user=scalable=no" />
	<title>Menu Principal</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<style type="text/css">
	</style>
</head>
<?php

//session_start();

$cod_usuario = $_SESSION['cod_usuario'];
$usuario = $_SESSION['usuario'];
if(!isset($_SESSION['usuario'])){
	header('location:index.php');
}

$sqlAnu ="select * from Produto where status_produto = 'P' ";
$buscarAnu = mysqli_query($conexao,$sqlAnu);
$existe2 = mysqli_num_rows($buscarAnu);

$sqlBol = "select * from boleto
            where COD_CLIENTE  = $cod_usuario
            and status_boleto  = 'P' ";
$lista_Boleto = mysqli_query($conexao,$sqlBol);
$existe = mysqli_num_rows($lista_Boleto);

//se for o vendedor vai aparecer a quantidade de pedidos a serem aprovados

// Pegar o último dia.
$P_Dia = date("Y-m-01");
$U_Dia = date("Y-m-t");

if ($_SESSION['tipo_usuario'] == 'V'){
	$sql3 = "select distinct PED.ID_PEDIDO_VENDEDOR, PED.COD_CLIENTE, PED.DT_PEDIDO, PED.VALOR_PEDIDO from carrinho_compras c
			inner join produto p on c.COD_PRODUTO = p.id_produto
			inner join pedido_vendedor ped on  c.ID_PEDIDO = ped.ID_PEDIDO
			where ped.COD_VENDEDOR  = $cod_usuario
			and ped.STATUS_PEDIDO='P'
			and ped.DT_PEDIDO BETWEEN '$P_Dia 00:00:01' and '$U_Dia 23:59:59'
			order by c.ID_PEDIDO";
	$lista_pedidos_vendedor = mysqli_query($conexao,$sql3);
	$numero_pedidos = mysqli_num_rows($lista_pedidos_vendedor);
}

?>
<body style="background-color: rgba(231, 29, 29, 0.68);">
	
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 80px">
		<div class="container">
			<a class="navbar-brand mr-0 mr-md-2">
				<img src="imagens/logo.png" style="height:150px">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse h5" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="menu.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<?php if ($_SESSION['tipo_usuario'] =='V'){
						echo "<li class='nav-item'>
							<a class='nav-link' href='pedido.php'>Pedidos <span class='badge badge-light' style='font-size: 12px'>$numero_pedidos</span></a>
						</li>";
						
						}else{
							echo "<li class='nav-item'>
									<a class='nav-link' href='pedido.php'>Pedidos</a>
								</li>";
						}
					?>
					<li class="nav-item">
						<a class="nav-link" href="produtos.php">Produtos</a>
					</li>
					<?php if ($_SESSION['tipo_usuario'] =='V'){
						echo "<li class='nav-item'>
							<a class='nav-link' href='anuncio.php'>Anúncio</a>
						</li>";
						
						}
					?>
					<?php if ($_SESSION['tipo_usuario'] == 'A'){
						echo "<li class='nav-item'>
							<a class='nav-link' href='anuncio_Aprovar.php'>Anúncio <span class='badge badge-light' style='font-size: 12px'>$existe2</span></a>
						</li>";
						
						}
					?>
					<?php if ($_SESSION['tipo_usuario'] == 'C'){
						echo "<li class='nav-item'>
							<a class='nav-link' href='rel_usuario.php'>Relatório</a>
						</li>";
						
						}
					?>
					<?php if ($_SESSION['tipo_usuario'] == 'V'){
						echo "<li class='nav-item dropdown'>
								<a class='nav-link' data-toggle='dropdown' href='#' >Relatório</a>

								<div class='dropdown-menu'>
									<a class='dropdown-item' href='rel_usuario.php'>Relatório de Pedidos</a>
									<div class='dropdown-divider'></div>
									<a class='dropdown-item' href='rel_boleto.php'>Relatório de Boleto</a>
									<div class='dropdown-divider'></div>
									<a class='dropdown-item' href='rel_estoque.php'>Acompanhamento do Estoque</a>
    							</div>
							 </li>";
						
						}
					?>

					<li class="nav-item">
						<a class="nav-link" href="conta.php">Minha Conta</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<?php 

						if($existe == ''){
						?>
							<a class="nav-link" href="boleto_pendente.php"><i class="material-icons" style="font-size: 30px">email</i></a>
						<?php
						}else{?>
							<a class="nav-link" href="boleto_pendente.php"><i class="material-icons" style="font-size: 30px">email</i><span class="badge badge-light" style="font-size: 12px"><?php echo $existe;?></span></a><?php
							
						}?>
					</li>
					<li class="nav-item">
						<?php 

						if(!isset($_SESSION['itens'])){
						?>
							<a class="nav-link" href="carrinho.php"><i class="material-icons" style="font-size: 30px">shopping_cart</i></a>
						<?php
						}else{?>
							<a class="nav-link" href="carrinho.php"><i class="material-icons" style="font-size: 30px">shopping_cart</i><span class="badge badge-light" style="font-size: 12px"><?php echo count($_SESSION['itens']);?></span></a><?php
							
						}?>
					</li>
					<li class="nav-item">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Sair</a>
					</li>
					
				</ul>
			</div>
		</div>
	</nav>
	
	<div id="carouselSite" class="carousel slide" data-ride="carousel" style="opacity: 0.8">
		<ol class="carousel-indicators">
			<li data-target="#carouselSite" data-slide-to="0" class="active"></li>
			<li data-target="#carouselSite" data-slide-to="1"></li>
		</ol>
		<div class="carousel-inner">

			<div class="carousel-item active">

				<img src="imagens/tamanho.jpg" class="img-fluid d-block">
				<div class="carousel-caption d-none d-md-block text-light">
					<h1>Texto 1</h1>
					<p class="lead">abhxbhbhhbdhbhchdvhcbdh</p>
				</div>

			</div>
			<div class="carousel-item">
				<img src="imagens/tamanho2.jpg" class="img-fluid d-block">
				<div class="carousel-caption d-none d-md-block text-light">
					<h1>Texto 3</h1>
					<p class="lead">diferente do  primeiro cd c dh chd hc d</p>
				</div>
			</div>
		</div>
		<!--<a class="carousel-control-prev" href="#carouselSite" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
		</a>
		<a class="carousel-control-next" href="#carouselSite" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Próximo</span>
		</a>-->
	</div>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center my-3">
				<h4 class="display-3">Nossos Produtos</h4>
				<p>Confira abaixo nossas delicias que separamos para você</p>
			</div>

		</div>

	<div class="row mb-3">	
			<div class="col-md-4">
				<div class="card-header text-center h4 text-light">
					Doces
				</div>
				<div class="card">
					<a href="categoria_doce.php">
					<img class="card-img-top" src="imagens/brigadeiro.jpg" alt="...">
					</a>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card-header text-center h4 text-light">
					Salgados
				</div>
				<div class="card">
					<a href="categoria_salgado.php">
					<img class="card-img-top" src="imagens/atum.jpg" alt="...">
					</a>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card-header text-center h4 text-light">
					Bebidas
				</div>
				<div class="card">
					<a href="categoria_bebida.php">
					<img class="card-img-top" src="imagens/suco2.png" alt="...">
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center my-3">
				<h3 class="display-4">Mais que uma delícia. Um mundo de Sabores</h3>
			</div>

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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>