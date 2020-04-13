<?php
include 'script/conexao.php';
include 'script/sessao.php';

$cod_usuario = $_SESSION['cod_usuario'];

$sql ="select * from Produto where cod_cliente = $cod_usuario 
	   and status_produto in('A')";
$buscar = mysqli_query($conexao,$sql);


$sql2 ="select p.nome_produto, p.imagem_produto, a.msg_negado, p.id_produto from Produto p
		inner join anuncio_negado a on p.id_produto = a.id_produto
 		where a.cod_cliente = $cod_usuario 
	    and status_produto = 'N'";
$negado = mysqli_query($conexao,$sql2);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Anúncios</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" >
		
		function excluir(id) {

            r = confirm("tem certeza que deseja excluir este anúncio? ");
            if (r == true) {
                document.getElementsByName.value = '1';
                $.ajax({
                    url: 'script/funcao_aprovar.php',
                    type: 'POST',
                    data: {
                        vid: id,
                        voption: '2'
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
						<a class="nav-link" href="#">Pedidos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Produtos</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="anuncio.php">Anúncio</a>
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
		<div class="card-header bg-primary">
			<h4>Anúncios Cadastrados</h4>
		</div>
		<div style="padding: 10px">
			<div class="my-4">
				<a class="btn btn-outline-primary" href="cadastro_anuncio.php" role="button">Novo Anúncio</a>
			</div>
			<table class="table table-dark table-hover responsive">
				<thead>
					<tr>
						<th>Produto</th>
						<th>Quantidade</th>
						<th>Validade</th>
						<th>Preço</th>
					</tr>
				</thead>
						
				<?php
								
					while ($array = mysqli_fetch_array($buscar)){

						$produto = $array['imagem_produto'];
						$quantidade = $array['quantidade_produto'];
						$validade = $array['vencimento_produto'];
						$preco = $array['valor_produto'];
						?>
						<tr>
									
							<td><img src='<?php echo $produto; ?>' style="width:120px"></td>
							<td><?php echo $quantidade; ?></td>
							<td><?php echo $validade; ?></td>
							<td><?php echo $preco; ?></td>
						</tr>
						<?php
					}
					?>	
			</table>
		</div>
	</div>
	<br>
	<div class="card my-1">
		<div class="card-header bg-danger">
			<h4>Anúncios Não Aprovados</h4>
		</div>
		<div style="padding: 10px">
			<table class="table table-dark table-hover responsive">
				<thead>
					<tr>
						<th></th>
						<th>Produto</th>
						<th>Motivo</th>
						<th></th>
					</tr>
				</thead>
						
				<?php
								
					while ($array = mysqli_fetch_array($negado)){

						$produto = $array['imagem_produto'];
						$nome_produto = $array['nome_produto'];
						$motivo = $array['msg_negado'];
						$id = $array['id_produto'];
						?>
						<tr>
									
							<td><img src='<?php echo $produto; ?>' style="width:120px"></td>
							<td><?php echo $nome_produto; ?></td>
							<td><?php echo $motivo; ?></td>
							<td>
								<a href="anuncio_Reprovado_editar.php?id=<?php echo $id?>" class="btn btn-info" role="button">Corrigir</a>
								<button onclick="excluir(<?php echo trim($id); ?>)" class="btn btn-danger" value="1">Excluir</button>
							</td>

						</tr>
						<?php
					}
					?>	
			</table>
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