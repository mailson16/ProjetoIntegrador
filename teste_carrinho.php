<?php
//include 'script/conexao.php';
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

?>
<!DOCTYPE html>
<html>
<head>
	<title>Produtos</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/personalizado.js"></script>
</head>

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
					<li class="nav-item">
						<a class="nav-link" href="#">Pedidos</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="produtos.php">Produtos</a>
					</li>					
					<?php if ($_SESSION['tipo_usuario'] == 'A' or $_SESSION['tipo_usuario'] =='V'){
						echo "<li class='nav-item'>
								<a class='nav-link' href='anuncio.php'>Anúncio</a>
							  </li>";
						
						}
					?>
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
	<div style="padding: 10px">
		<form action="" method="POST">
			<div id="gallerycontent">	
				<?php
					if(count($_SESSION['itens']) == 0){
						echo 'Carrinho Vazio <br><a href="produtos.php">Adicionar itens</a>';
					}else{
						$_SESSION['dados'] = array();
						$totalGeral = 0;
						$conexao = new PDO('mysql:host=localhost;dbname=producao',"root","");
						foreach ($_SESSION['itens'] as $idProduto => $quantidade) 
						{

							$select = $conexao->prepare("select * from Produto where id_produto = ?");
							$select->bindParam(1,$idProduto);
							$select->execute();
							$produtos = $select->fetchAll();
							$total = $quantidade * $produtos[0]["valor_produto"];
							$totalGeral = $total + $totalGeral;
							echo
								'<div class="galleryitem">
								<b>Nome: </b>'.$produtos[0]["nome_produto"].'<br/>
								Preço: '.number_format($produtos[0]["valor_produto"],2,",",".").'
								Quantidade: '.$quantidade.' <br/>
								Total: '.number_format($total,2,",",".").'
								<a href="remover_carrinho.php?remover=carrinho&id='.$idProduto.'">Remover</a>
								<br>
							';
							array_push(
								$_SESSION['dados'], 
								array(
									'id_produto' => $idProduto,
									'nome_produto' =>$produtos[0]["nome_produto"],
									'quantidade' => $quantidade,
									'preco_total' =>number_format($total,2,",",".")

								)
							);//finaliza o array push

							
						}

						$_SESSION['totalGeral'] = number_format($totalGeral,2,",",".");
						$total_pedido = $_SESSION['totalGeral'];
						echo '<a href="finaliza_pedido.php">Finalizar Pedido</a>';		 
					}
				?>	
			</div>			
			<div class="resultado">	

			</div>
		</form>
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