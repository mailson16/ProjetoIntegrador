<?php
include 'script/conexao.php';
include 'script/sessao.php';

// Definir a zona geográfica padrão.
date_default_timezone_set("America/Sao_Paulo");

// Pegar o último dia.
$P_Dia = date("Y-m-01");
$U_Dia = date("Y-m-t");

$cod_usuario = $_SESSION['cod_usuario'];

$sql = "select EMAIL_CLIENTE, TELEFONE_CLIENTE, cod_cliente, tipo_cliente from cliente_fisico where login_cliente = '$usuario'";
$buscar = mysqli_query($conexao,$sql);
while ($array = mysqli_fetch_array($buscar)){
	$email = $array['EMAIL_CLIENTE'];
	$telefone = $array['TELEFONE_CLIENTE'];

}

//se for o vendedor vai aparecer a quantidade de pedidos a serem aprovados

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

$sqlBol = "select * from boleto
            where COD_CLIENTE  = $cod_usuario
            and status_boleto  = 'P' ";
$lista_Boleto = mysqli_query($conexao,$sqlBol);
$existe = mysqli_num_rows($lista_Boleto);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dados Cadastrais</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/personalizado.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript">
		function validaSenha(input){
			if (input.value != document.getElementById('txtSenha').value){
				input.setCustomValidity('Repita a senha corretamente');
			}else{
				input.setCustomValidity('');
			}
		}

		

		function verifica() {

			
			var email = form.email.value;
			var telefone = form.telefone.value;
			var senha = form.senha.value;
			var senha2 = form.senha2.value;

			
			if (email == "" ) {
				alert('Por favor, informe o email.'); $("input[name=email]").focus();
				return false;
			}
			if (telefone == "" ) {
				alert('Por favor, informe o telefone.'); $("input[name=telefone]").focus();
				return false;
			
			}
			if (senha == "" ) {
				alert('Por favor, informe a senha.'); $("input[name=senha]").focus();
				return false;
			}
			if (senha2 == "" ) {
				alert('Por favor, repita a senha.'); $("input[name=senha2]").focus();
				return false;
			}

        }

	</script>
</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 80px">
		
			<a class="navbar-brand mr-0 mr-md-2">
				<img src="imagens/logo3.png" style="height:200px">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse h5" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="menu.php">Home<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="pedido.php">Pedidos</a>
					</li>
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
	<div class="container" >
		<div class="card my-4">
			<div class="card-header" style="background: linear-gradient(to right, #ee6565 , #007bff);">
				<h4 style="color:white">Meu dados</h4>
			</div>
			<div class="container" style="background-color: #e9ecef">
				<form action="" method="post" name="form">
					<br>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputEmail">Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo $email ?>">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold">Telefone</label>
							<input type="text" class="form-control" name="telefone" value="<?php echo $telefone ?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Senha</label>
							<input type="password" class="form-control" id="txtSenha" name="senha">
						</div>

						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Confirmar a Senha</label>
							<input type="password" class="form-control" name="senha2" oninput="validaSenha(this)">
						</div>
					</div>
					
					<div class="my-4" style="text-align: center">
						<input onclick=" return verifica()" type="submit" name="btoption" class="btn btn-dark" value="Alterar">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
