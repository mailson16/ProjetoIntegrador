<?php
include 'script/conexao.php';
include 'script/sessao.php';



$cod_usuario = $_SESSION['cod_usuario'];
$motivo=filter_input(INPUT_POST,'pesquisar',FILTER_SANITIZE_STRING);


$sql = "select * from Produto where categoria_produto = categoria_produto
	   and status_produto in('A')";
$buscar = mysqli_query($conexao,$sql);


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
<style type="text/css">
	#gallerycontent{
    float: left;
    max-width: 1500px;
    text-align: justify;


}

#gallerycontent .galleryitem{
    width: 436px;
    height: 250px;
    background:url('../images/screen.png');
    background-repeat: no-repeat;
    padding: 5px 5px 5px 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    clear: both; display:inline-block;
    text-align: left;

}
#gallerycontent img{
    float: left;
    width: 75%;
    height: 75%;
    margin: 2.5%;

}
#gallerycontent ul{
    padding-left: 50px;
    list-style-type:square;
}
</style>

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
	
	<div class="card my-1">
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse h5" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="produtos.php">Todos<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="categoria_doce.php">Doces<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="categoria_salgado.php">Salgados<span class="sr-only">(current)</span></a>
					</li>					
					
					<li class="nav-item">
						<a class="nav-link" href="categoria_bebida.php">Bebidas<span class="sr-only">(current)</span></a>
					</li>				
				</ul> 
				<form class="form-inline my-2 my-lg-0" action="" method="POST"	  >
      				<input class="form-control mr-sm-2" type="text" name="pesquisar" id="pesquisar" placeholder="Search" aria-label="Search">
      				<button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
    			</form>
				
			
	</nav>

			<div style="padding: 10px">
				<form action="" method="POST">
					<div id="gallerycontent">	
						<?php

						while ($array = mysqli_fetch_array($buscar)){

							$produto = $array['imagem_produto'];
							$descricao = $array['descricao_produto'];
							$quantidade = $array['quantidade_produto'];
							$validade = $array['vencimento_produto'];
							$preco = $array['valor_produto'];
							$id = $array['id_produto'];

							?>

							<div class="galleryitem">
								<img src='<?php echo $produto; ?>' style="width:120px">
								<b>Descrição:</b> <?php echo $descricao; ?>
								<br/><br/>
								<b>Quantidade:</b> <?php echo $quantidade; ?>
								<br/><br/>
								<b>Validade:</b> <?php echo $validade; ?>
								<br/><br/>
								<b>Preço Unit:</b> <?php echo number_format($preco,2,",","."); ?>
								<a href="teste_carrinho.php?add=carrinho&id=<?php echo $id?>" class="btn btn-warning" role="button">Adicionar</a>
							</div>			


							<?php
						}
						?>	
					</div>			
					<div class="resultado">	
						
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