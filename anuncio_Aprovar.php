<?php
include 'script/conexao.php';
include 'script/sessao.php';

$cod_usuario = $_SESSION['cod_usuario'];

$sql ="select * from Produto where status_produto = 'P' ";
$buscar = mysqli_query($conexao,$sql);



?>
<!DOCTYPE html>
<html>
<head>
	<title>Anúncios</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script type="text/javascript" >
		
		function aprova(id) {

            r = confirm("tem certeza que deseja aprovar este anúncio? ");
            if (r == true) {
                document.getElementsByName.value = '1';
                $.ajax({
                    url: 'script/funcao_aprovar.php',
                    type: 'POST',
                    data: {
                        vid: id,
                        voption: '1'
                    },
                    cache: false,
                    success: function (dataResult) {
                    	var dataResult = JSON.parse(dataResult);
                    	if(dataResult.statusCode==200){
                    		$('#success').html('Data added successfully !'); 						
                    	}
                    	else if(dataResult.statusCode==201){
                    		alert("Error occured !");
                    	}
                    }

                });

            } else {
                alert(" Ação cancelada ! ");
                $('#loading').hide();
                return false;
            }
        }
	</script>
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
						<a class="nav-link" href="pedido.php">Pedidos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="produtos.php">Produtos</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="anuncio_Aprovar.php">Anúncio</a>
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
			<div class="card-header bg-primary">
				<h4>Anúncios Para Aprovação</h4>
			</div>
			<div style="padding: 10px">
				<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				</div>
				<form action="" method="post">
					<div id="resp" style="position:absolute;width:100%; z-index:9999999; "></div>
					<table class="table table-dark table-hover responsive">
						<thead>
							<tr>
								<th></th>
								<th>Produto</th>
								<th>Vendedor</th>
								<th>Quantidade</th>
								<th>Validade</th>
								<th>Preço</th>
								<th>Categoria</th>
								<th>Tipo</th>
								<th></th>
							</tr>
						</thead>
						

							
							<?php
								
								while ($array = mysqli_fetch_array($buscar)){

									$img_produto = $array['imagem_produto'];
									$quantidade = $array['quantidade_produto'];
									$validade = $array['vencimento_produto'];
									$preco = $array['valor_produto'];
									$vendedor = $array['cod_cliente'];
									$produto = $array['nome_produto'];
									$categoria = $array['categoria_produto'];
									$tipo = $array['tipo_produto'];
									$id = $array['id_produto'];
								?>
								<tr>
									
									<td><img src='<?php echo $img_produto; ?>' style="width:120px"></td>
									<td><?php echo $produto; ?></td>
									<td><?php echo $vendedor; ?></td>
									<td><?php echo $quantidade; ?></td>
									<td><?php echo $validade; ?></td>
									<td><?php echo $preco; ?></td>
									<td><?php echo $categoria; ?></td>
									<td><?php echo $tipo; ?></td>
									<td>
										<button onclick="aprova(<?php echo trim($id); ?>)" type="submit" class="btn btn-success" value="1">Aprovar</button>
										<a href="anuncio_Reprovar.php?id=<?php echo $id?>" class="btn btn-danger" role="button">Reprovar</a>
									</td>
      							
								</tr>
							<?php
								}
								?>	
								
					</table>
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