<?php
include 'script/conexao.php';
include 'script/sessao.php';
include 'script/funcao_usuario.php';

$cod_usuario = $_SESSION['cod_usuario'];

$data_de=filter_input(INPUT_POST,'data_de',FILTER_SANITIZE_STRING);
$data_ate=filter_input(INPUT_POST,'data_ate',FILTER_SANITIZE_STRING);
$btn=filter_input(INPUT_POST,'pesquisa',FILTER_SANITIZE_STRING);
$total = "";

if ($btn =='1') {
	$sql = "select COD_VENDEDOR, SUM(VALOR_PEDIDO) as TOTAL_VENDA from pedido_vendedor
	where COD_CLIENTE = $cod_usuario
	and STATUS_PEDIDO = 'A'
	and DT_PEDIDO BETWEEN '$data_de 00:00:01' and '$data_ate 23:59:59'
	GROUP BY COD_VENDEDOR";
	$lista_Pedido = mysqli_query($conexao,$sql);
	$total = mysqli_num_rows($lista_Pedido);

	$sqlTotal = "select SUM(VALOR_PEDIDO) as TOTAL_VENDA from pedido_vendedor
	where COD_CLIENTE = $cod_usuario
	and STATUS_PEDIDO = 'A'
	and DT_PEDIDO BETWEEN '$data_de 00:00:01' and '$data_ate 23:59:59' ";
	$bruto = mysqli_query($conexao,$sqlTotal);
	while ($arrayBruto = mysqli_fetch_array($bruto)){
		$valorBruto = $arrayBruto['TOTAL_VENDA'];


	}

}
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
	<title>Relatório de Pedidos</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/personalizado.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<script type="text/javascript" >

		function verifica() {

			var data_de = form.data_de.value;
			var data_ate = form.data_ate.value;

			if (data_de == "" ) {
				alert('Por favor, informe a data de inicio da busca.'); $("input[name=data_de]").focus();
				return false;
			}

			if (data_ate == "" ) {
				alert('Por favor, informe a data final da busca.'); $("input[name=data_ate]").focus();
				return false;
			}
        }
		
		function aprova(id) {
			
			document.getElementsByName.value = '1';
			$("#siteModal").modal();
			$.ajax({
				url: 'script/funcao_aprovar.php',
				type: 'POST',
				data: {
					vid: id,
					voption: '4'
				},
				success: function (result) {
					$("#siteModal").modal();
					$("#cliente").html(result); 						
				}

			});

		}

        
	</script>
<style type="text/css">
	#caixa{
		border-radius: 5px;
		background-color: #5aa3cea6;
		box-shadow: 9px 7px 5px rgba(50, 50, 50, 0.77);
	}
	#caixa2{
		justify-content: center; 
		padding: 5%;
	}
	#caixa3{
		border-radius: 5px;
		border: 1px solid grey;
		box-shadow: 9px 7px 5px rgba(50, 50, 50, 0.77);

	}

	body{
		 background: url("imagens/fundo4.png");
		 background-size:cover;
		 background-color: rgba(0, 123, 245, 0.4);
	}
</style>
<body>
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
					<?php if ($_SESSION['tipo_usuario'] == 'A' or $_SESSION['tipo_usuario'] =='V'){
						echo "<li class='nav-item'>
								<a class='nav-link' href='anuncio.php'>Anúncio</a>
							  </li>";
						
						}
					?>
					<?php if ($_SESSION['tipo_usuario'] == 'C'){
						echo "<li class='nav-item active'>
							<a class='nav-link' href='rel_usuario.php'>Relatório</a>
						</li>";
						
						}
					?>
					<?php if ($_SESSION['tipo_usuario'] == 'V'){
						echo "<li class='nav-item dropdown'>
								<a class='nav-link active' data-toggle='dropdown' href='#' >Relatório</a>

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
	<div class="container" style="padding: 20px;">
		<form name="form" action="" method="post">
			<h4>Relatório de Pedidos</h4>
			<hr>
			<div class="container" id="caixa">
				<div class="row" id="caixa2" >
					<div class="form-group col-md-3">
						<label class="font-weight-bold">Período de:</label>
						<input type="date" class="form-control" name="data_de">
					</div>
					<div class="form-group col-md-3">
						<label class="font-weight-bold">Até:</label>
						<input type="date" class="form-control" name="data_ate">
					</div>
				</div>
				<div class="row" style="justify-content: center;">
					<div class="form-group col-md-1">
						<button onclick=" return verifica()" class="btn btn-dark btn-md " name="pesquisa" value="1">&nbsp;&nbsp;Buscar&nbsp;&nbsp;</button>
					</div>
				</div>
			</div>
			<br>
			<br>
			<?php
			if ($btn == 1) {
			
			
			if($total >= 1){?>
				<div class="col-md-3 text-center" id="caixa3">
					<h4><b>Valor Total Gasto</b>:</h4>
					<h5><?php echo number_format($valorBruto,2,",","."); ?></h5>
				</div>

				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<div>
						<br />
						<?php
						while ($arrayPedido = mysqli_fetch_array($lista_Pedido)){
							$valor_pedido = $arrayPedido['TOTAL_VENDA'];
							$vendedor = $arrayPedido['COD_VENDEDOR'];

							$sql2 ="select distinct(p.ID_PEDIDO_VENDEDOR), p.VALOR_PEDIDO, p.DT_PEDIDO from pedido_vendedor p 
							where p.COD_VENDEDOR = $vendedor
							and p.cod_cliente = $cod_usuario
							and p.STATUS_PEDIDO = 'A'
							and p.DT_PEDIDO BETWEEN '$data_de 00:00:01' and '$data_ate 23:59:59'
							";
							$pedido = mysqli_query($conexao,$sql2);

							?>
							<div class="show_hide" style="background-color: #5aa3cea6;">
								<div class="row">
									<div class="col-md-4 text-left">
										<h5><b>Vendedor</b> : <?php echo RetornaNome($vendedor); ?></h5>
									</div>
									<div class="col-md-3 text-left">
										<h5><b>Valor Total</b> : R$<?php echo number_format($valor_pedido,2,",",".");?></h5>
									</div>
								</div>
							</div>

							<div class="slidingDiv">
								<table class="table table-light table-hover responsive" >
									<thead>
										<tr>
											<th style="width:120px">Nº Pedido</th>
											<th style="width:152px">Valor</th>
											<th style="width:213px">Data</th>
											<th style="width:213px"></th>
										</tr>
									</thead>
									<?php
									while ($array = mysqli_fetch_array($pedido)){
										$id_pedido = $array['ID_PEDIDO_VENDEDOR'];
										$valor = $array['VALOR_PEDIDO'];
										$data = $array['DT_PEDIDO'];

										?>

										<tr>
											<td><?php echo $id_pedido; ?></td>
											<td> R$ <?php echo number_format($valor,2,",","."); ?></td>
											<td><?php echo date('d/m/Y H:i:s',strtotime($data)); ?></td>
											<td><button onclick="aprova(<?php echo trim($id_pedido); ?>)" type="button" class="btn btn-outline-warning"><i class="material-icons" style="font-size: 20px">add_box</i> Mais detalhes</button></td>
										</tr>
										<?php	
									}?>
								</table>
							</div>
						<?php
						}?>
					</div>
				</div>
			<?php
			}else{?>
				<div class="alert alert-danger" role="alert" style="text-align: center;">
					Não existe nenhum pedido de compra neste período
				</div>
				<?php
			}
		}?>
		</form>
	</div>
	<!--modal-->
	<div class="modal fade" id="siteModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body bg-light">
					<div style="padding: 10px;">
						<table class="table table-striped listaFichas">
							<thead>
								<tr>
									<th style="width:120px">Produto</th>
									<th style="width:328px"></th>
									<th style="width:152px">Quant.</th>
									<th style="width:213px">Valor Total</th>
								</tr>
							</thead>
							<tbody id="cliente"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
		
</body>
