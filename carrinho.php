<?php
include 'script/conexao.php';
//include 'script/sessao.php';

session_start();

if(!isset($_SESSION['itens'])){

	$_SESSION['itens'] = array();
}


if(isset($_GET['add']) && $_GET['add'] =='carrinho'){
	/*adiciona ao carrinho*/
	$idProduto = $_GET['id'];
	if(!isset($_SESSION['itens'][$idProduto])){
		$_SESSION['itens'][$idProduto] = 1;
	}else{
		$_SESSION['itens'][$idProduto] += 1;
	}
}
/*Exibe o carrinho*/

/*if(count($_SESSION['itens']) == 0){
	echo 'Carrinho Vazio <br><a href="produtos.php">Adicionar itens</a>';
}else{
	$conexao = new PDO('mysql:host=localhost;dbname=producao',"root","");
	foreach ($_SESSION['itens'] as $idProduto => $quantidade) 
	{
		$select = $conexao->prepare("select * from Produto where id_produto = ?");
		$select->bindParam(1,$idProduto);
		$select->execute();
		$produtos = $select->fetchAll();
		$total = $quantidade * $produtos[0]["valor_produto"];
		echo
			'Nome: '.$produtos[0]["nome_produto"].'<br/>
			Preço: '.number_format($produtos[0]["valor_produto"],2,",",".").'
			Quantidade: '.$quantidade.' <br/>
			Total: '.number_format($total,2,",",".").'
			<a href="remover_carrinho.php?remover=carrinho&id='.$idProduto.'">Remover</a>
			<hr>


		';
	}
	echo '<a href="finaliza_pedido.php">Finalizar Pedido</a>';		 
}*/
$cod_usuario = $_SESSION['cod_usuario'];

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
<!DOCTYPE html>
<html>
<head>
	<title>Carrinho de Compras</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/personalizado.js"></script>
</head>
<style type="text/css">
	img {
  		border-radius: 10px;
}

</style>

<body class="bg-light">
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
						<a class="nav-link" href="menu.php">Home<span class="sr-only">(current)</span></a>
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
							<a class='nav-link' href='anuncio_Aprovar.php'>Anúncio</a>
						</li>";
						
						}
					?>
					<?php if ($_SESSION['tipo_usuario'] == 'A'){
						echo "<li class='nav-item'>
							<a class='nav-link' href='rel_geral.php'>Relatório</a>
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
									<a class='dropdown-item' href='rel_vendas.php'>Relatório de Vendas</a>
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
	</nav>
	<div style="padding: 10px">
		<form action="" method="POST">
				<?php
					if(count($_SESSION['itens']) == 0){
						echo 'Carrinho Vazio <br><a href="produtos.php">Adicionar itens</a>';
					}else{
						$_SESSION['dados'] = array();
						$totalGeral = 0;
						$conexao = new PDO('mysql:host=localhost;dbname=producao',"root","");
						?>
						<table class="table table-light table-hover responsive">
						<thead>
							<tr>
								<th style="width:120px">Produto</th>
								<th style="width:328px"></th>
								<th style="width:152px">Quant.</th>
								<th style="width:262px">Valor Unitário</th>
								<th style="width:213px">Valor Total</th>
								<th style="width:230px"></th>
							</tr>
						</thead>
						<?php
						foreach ($_SESSION['itens'] as $idProduto => $quantidade) 
						{	
						
						
						
							$select = $conexao->prepare("select * from Produto where id_produto = ?");
							$select->bindParam(1,$idProduto);
							$select->execute();
							$produtos = $select->fetchAll();
							$img_produto = $produtos[0]["imagem_produto"];
							$qtd = $produtos[0]["quantidade_produto"];
							$total = $quantidade * $produtos[0]["valor_produto"];
							$totalGeral = $total + $totalGeral;
							$totalPedido = number_format($totalGeral,2,",",".")
							?>
							<tr style="background-color: rgb(196, 235, 178);">
									
									<td><img src='<?php echo $img_produto; ?>' style="width:120px"></td>
									<td><?php echo $produtos[0]["nome_produto"]; ?></td>
									<?php if ($qtd > 0){?>
										<td><?php echo $quantidade; ?></td><?php
									}else{?>
										<td style="color: Red";>Produto Esgotado</td><?php
									}?>
									<td><?php echo number_format($produtos[0]["valor_produto"],2,",","."); ?></td>
									<td><?php echo number_format($total,2,",","."); ?></td>
									<td><a href="remover_carrinho.php?remover=carrinho&id=<?php echo $idProduto?>"class="btn btn-outline-danger">Remover</a></td>
								</tr>
							
							<?php
							array_push(
								$_SESSION['dados'], 
								array(
									'id_produto' => $idProduto,
									'nome_produto' =>$produtos[0]["nome_produto"],
									'quantidade' => $quantidade,
									'preco_total' =>number_format($total,2,",",".")

								)
							);//finaliza o array push

							
						}?>
						</table>
						<?php
						$_SESSION['totalGeral'] = number_format($totalGeral,2,",",".");
						$total_pedido = $_SESSION['totalGeral'];
					}
				?>

				<?php
					if(count($_SESSION['itens']) != 0){
					?>
						<hr>
						<div class="row">
						<div class="col-11" style="text-align: right;">
							<h5>Total da Compra: <?php echo $totalPedido?></h4>
						</div>
						</div>
						<hr>
						<br><br>
							<div class="row">
						<div class="col-3" style="padding-left: 30px">
							<a href="produtos.php" class="btn btn-outline-primary">Continuar Comprando</a>
						</div>
						<div class="col-8" style="text-align: right;">
							<a href="finaliza_pedido.php" class="btn btn-success">Finalizar Pedido</a>
						</div>
						</div>
						<?php
					}?>
		</form>
	</div>
</body>
</html>