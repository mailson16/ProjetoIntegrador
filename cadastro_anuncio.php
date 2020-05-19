<?php
include 'script/conexao.php';
include 'script/sessao.php';

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
	<title>Novo Anúncio</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!--<script src="https://kit.fontawesome.com/yourcode.js"></script>-->
	
	<script type="text/javascript">
		$(function(){
			$('#upload').change(function(){
				const file = $(this)[0].files[0]
				const fileReader = new FileReader()
				fileReader.onloadend = function(){
					$('#imgProduto').attr('src',fileReader.result)
				}
				fileReader.readAsDataURL(file)
			})
		})

		function verifica() {

			var produto = form.produto.value;
			var categoria = form.categoria.value;
			var tipo = form.tipo.value;
			var quantidade = form.quantidade.value;
			var preco = form.preco.value;
			var validade = form.validade.value;
			var descricao = form.descricao.value;
			var arquivo = form.arquivo.value;

			if (validade == "" ) {
				alert('Por favor, informe a data de vencimento.'); $("input[name=validade]").focus();
				return false;
			}

			if (produto == "" ) {
				alert('Por favor, informe o nome do produto.'); $("input[name=produto]").focus();
				return false;
			}
			if (categoria == "" ) {
				alert('Por favor, informe a categoria.'); $("input[name=categoria]").focus();
				return false;
			}
			if (tipo == "" ) {
				alert('Por favor, informe o tipo.'); $("input[name=tipo]").focus();
				return false;
			}
			if (quantidade == "" ) {
				alert('Por favor, informe a quantidade.'); $("input[name=quantidade]").focus();
				return false;
			}
			if (preco == "" ) {
				alert('Por favor, informe o preço.'); $("input[name=preco]").focus();
				return false;
			}
			if (descricao == "" ) {
				alert('Por favor, informe a descricao.'); $("input[name=descricao]").focus();
				return false;
			}
			if (arquivo == "" ) {
				alert('É necessário colocar uma imagem.'); $("input[name=arquivo]").focus();
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
					<li class="nav-item">
						<a class="nav-link" href="anuncio.php">Anúncio</a>
					</li>
					<?php if ($_SESSION['tipo_usuario'] == 'C'){
						echo "<li class='nav-item active'>
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
		
	</nav>
	
		<div class="card my-1">
			<div class="card-header bg-primary">
				<h4>+ Novo Anúncio</h4>
			</div>
			<div class="container" style="padding: 20px;">
				<form name="form" action="insert_anuncio.php" method="post" enctype="multipart/form-data">
					<div class="row no-gutters">
						<div class="form-row col-md-9">
							<div class="form-group col-md-5">
								<label class="font-weight-bold" for="inputNome">Produto</label>
								<input type="text" class="form-control" name="produto" maxlength="50">
							</div>
							<div class="form-group col-md-3">
								<label class="font-weight-bold">Categoria</label>
								<select name="categoria" class="form-control">
									<option value="">Selecionar...</option>
									<option value="D">Doce</option>
									<option value="S">Salgado</option>
									<option value="B">Bebida</option>
								</select>
							</div>
							<div class="form-group col-md-3">
								<label class="font-weight-bold">Tipo</label>
								<select name="tipo" class="form-control">
									<option value="">Selecionar...</option>
									<option value="P">Perecível</option>
									<option value="N">Não-Perecível</option>
								</select>
							</div>
							<div class="form-group col-md-2">
								<label class="font-weight-bold" for="inputEmail">Quantidade</label>
								<input type="number" class="form-control" name="quantidade" min="0">
							</div>
							<div class="form-group col-md-2">
								<label class="font-weight-bold">Valor Unit</label>
								<input type="text" class="form-control" name="preco" id="preco" maxlength="5">
							</div>
							<div class="form-group col-md-3">
								<label class="font-weight-bold">validade</label>
								<input type="date" class="form-control" name="validade">
							</div>
							<div class="form-group col-md-4">
								<label class="font-weight-bold">Imagem</label>
								<input type="file" class="form-control-file" name="arquivo" id="upload">
							</div>
							
							<div class="form-group col-md-11">
								<label class="font-weight-bold">Descrição</label>
								<textarea class="form-control" rows="5" name="descricao" maxlength="500"></textarea>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
								<label class="font-weight-bold">Pré-Visualização</label>
								<img id="imgProduto" style="width: 385px"/>
							</div>
						</div>
					</div>
					
					
					<div class="my-4" style="text-align: center">
						<!--<button type="submit" class="btn btn-outline-primary">Registrar</button>-->
						<input onclick=" return verifica()" type="submit" name="send" value="Registrar">
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
