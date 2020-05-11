<?php
include 'script/conexao.php';
include 'script/sessao.php';
include 'script/funcao_usuario.php';

// Definir a zona geográfica padrão.
date_default_timezone_set("America/Sao_Paulo");

// Pegar o último dia.
$P_Dia = date("Y-m-01");
$U_Dia = date("Y-m-t");

$cod_usuario = $_SESSION['cod_usuario'];

//lista os que estão aguardando aprovação(colocar pelo dia inicio e dia fim de mes)
$sql2 = "select * from pedido_vendedor
         where COD_CLIENTE = $cod_usuario
         and STATUS_PEDIDO = 'P'
         and DT_PEDIDO BETWEEN '$P_Dia 00:00:01' and '$U_Dia 23:59:59'
         order by DT_PEDIDO desc";
$lista_Pedido = mysqli_query($conexao,$sql2);

//lista os pedidos finalizados(colocar pelo dia inicio e dia fim de mes)
$sql4 = "select * from pedido_vendedor
         where COD_CLIENTE = $cod_usuario
         and STATUS_PEDIDO = 'A'
         and DT_PEDIDO BETWEEN '$P_Dia 00:00:01' and '$U_Dia 23:59:59'
         order by DT_PEDIDO desc";
$lista_Pedido_Finalizados = mysqli_query($conexao,$sql4);


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


?>
<!DOCTYPE html>
<html>
<head>
	<title>Produtos</title>
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
<script type="text/javascript">
	$(document).ready(function () {
            $(".slidingDiv").hide();
            $(".show_hide").show();
            $(".show_hide").click(function () {
                $(this).next().slideToggle();
            });
        });
        function toggleSlideAll() {
            $(".slidingDiv").slideToggle("slow");
            $(".slidingDiv").toggleClass("clicked");
        }
	function aprova(id) {

        r = confirm("tem certeza que deseja aprovar este pedido? ");
        if (r == true) {
            document.getElementsByName.value = '1';
            $.ajax({
                url: 'script/funcao_aprovar.php',
                type: 'POST',
                data: {
                    vid: id,
                    voption: '3'
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
<style type="text/css">
	img {
  		border-radius: 10px;
	}
	.show_hide{
	border-bottom: 1px solid white;
    border-radius: 3px;
    color: black;
    padding: 10px;
    display: none;
    cursor: pointer;

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
					<li class="nav-item active">
						<a class="nav-link" href="pedido.php">Pedidos</a>
					</li>
					<li class="nav-item">
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
			<br>
			<h4 style="padding: 10px">Meus Pedidos</h4>
			<br>
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pendentes</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Finalizados</a>
				</li>
				<?php if ($_SESSION['tipo_usuario'] == 'V') {?>
					<li class="nav-item btn-warning">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false">
						Aprovação
						<?php if ($numero_pedidos >= 1) {?>
							<span class="badge badge-light" style="font-size: 12px"><?php echo "$numero_pedidos";?></span></a><?php
						}?>
						
					</li><?php
				}
				?>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<div>
						<br />
						<br />
						<br />
						<button type="button" class="btn btn-primary" onclick="toggleSlideAll()" style="color:white">abrir / fechar todos
						</button>
						<br />
						<br />
						<br />
						<?php
						while ($arrayPedido = mysqli_fetch_array($lista_Pedido)){
							$id = $arrayPedido['ID_PEDIDO_VENDEDOR'];
							$data = $arrayPedido['DT_PEDIDO'];
							$valor_pedido = $arrayPedido['VALOR_PEDIDO'];
							$vendedor = $arrayPedido['COD_VENDEDOR'];


							$sql ="select * from pedido_vendedor p 
							inner join pedido pe on p.ID_PEDIDO = pe.ID_PEDIDO
							inner join carrinho_compras cc on pe.ID_PEDIDO = cc.ID_PEDIDO
							inner join produto prod on cc.COD_PRODUTO = prod.id_produto
							where p.ID_PEDIDO_VENDEDOR= $id
							and prod.cod_cliente = $vendedor";
							$pedido = mysqli_query($conexao,$sql);

							?>
							<div class="show_hide" style="background-color: #5aa3cea6;">
								<div class="row">
									<div class="col-md-2 text-left">
										<b>N° Pedido</b> : <?php echo "$id";?>
									</div>
									<div class="col-md-2 text-left">
										<b>Valor do Pedido</b> : <?php echo number_format($valor_pedido,2,",",".");?>
									</div>
									<div class="col-md-4 text-left">
										<b>Vendedor</b> : <?php echo RetornaNome($vendedor); ?>
									</div>
									<div class="col-md-3 text-left">
										<b>Data do Pedido</b> : <?php echo date('d/m/Y H:i:s',strtotime($data));?>
									</div>
								</div>
							</div>

							<div class="slidingDiv">
								<table class="table table-light table-hover responsive" >
									<thead>
										<tr>
											<th style="width:120px">Produto</th>
											<th style="width:328px"></th>
											<th style="width:152px">Quant.</th>
											<th style="width:213px">Valor Total</th>
										</tr>
									</thead>
									<?php
									while ($array = mysqli_fetch_array($pedido)){
										$produto = $array['imagem_produto'];
										$nome = $array['nome_produto'];
										$quantidade = $array['QTD_PRODUTO'];
										$vendedor = $array['cod_cliente'];
										$preco = $array['PRECO_PRODUTO'];

										?>

										<tr>
											<td><img src='<?php echo $produto; ?>' style="width:120px"></td>
											<td><?php echo $nome; ?></td>
											<td><?php echo $quantidade; ?></td>
											<td><?php echo number_format($preco,2,",","."); ?></td>
										</tr>
										<?php	
									}?>
								</table>
							</div>
						<?php
						}?>
					</div>
				</div>
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div>
						<br />
						<br />
						<br />
						<button type="button" class="btn btn-success" onclick="toggleSlideAll()" style="color:white">abrir / fechar todos</button>
						<br />
						<br />
						<br />
						<?php
						while ($arrayPedidoFinalizado = mysqli_fetch_array($lista_Pedido_Finalizados)){
							$id = $arrayPedidoFinalizado['ID_PEDIDO_VENDEDOR'];
							$data = $arrayPedidoFinalizado['DT_PEDIDO'];
							$valor_pedido = $arrayPedidoFinalizado['VALOR_PEDIDO'];
							$vendedor = $arrayPedidoFinalizado['COD_VENDEDOR'];
							
		
							$sql5 ="select * from pedido_vendedor p 
							inner join pedido pe on p.ID_PEDIDO = pe.ID_PEDIDO
							inner join carrinho_compras cc on pe.ID_PEDIDO = cc.ID_PEDIDO
							inner join produto prod on cc.COD_PRODUTO = prod.id_produto
							where p.ID_PEDIDO_VENDEDOR= $id
							and prod.cod_cliente = $vendedor";
							$pedidoFinalizado = mysqli_query($conexao,$sql5);
		
						?>
							<div class="show_hide" style="background-color: #28a745;">
								<div class="row">
									<div class="col-md-2 text-left">
										<b>N° Pedido</b> : <?php echo "$id";?>
									</div>
									<div class="col-md-2 text-left">
										<b>Valor do Pedido</b> : <?php echo number_format($valor_pedido,2,",",".");?>
									</div>
									<div class="col-md-4 text-left">
										<b>Vendedor</b> : <?php echo RetornaNome($vendedor); ?>
									</div>
									<div class="col-md-3 text-left">
										<b>Data do Pedido</b> : <?php echo date('d/m/Y H:i:s',strtotime($data));?>
									</div>
								</div>
							</div>
				
							<div class="slidingDiv">
								<table class="table table-light table-hover responsive" >
									<thead>
										<tr>
											<th style="width:120px">Produto</th>
											<th style="width:328px"></th>
											<th style="width:152px">Quant.</th>
											<th style="width:213px">Valor Total</th>
										</tr>
									</thead>
									<?php
									while ($array2 = mysqli_fetch_array($pedidoFinalizado)){
										$produto = $array2['imagem_produto'];
										$nome = $array2['nome_produto'];
										$quantidade = $array2['QTD_PRODUTO'];
										$vendedor = $array2['cod_cliente'];
										$preco = $array2['PRECO_PRODUTO'];
			
										?>
			
										<tr>
											<td><img src='<?php echo $produto; ?>' style="width:120px"></td>
											<td><?php echo $nome; ?></td>
											<td><?php echo $quantidade; ?></td>
											<td><?php echo number_format($preco,2,",","."); ?></td>
										</tr>
										<?php	
									}?>
								</table>
							</div>
						<?php
						}?>		
					</div>
				</div>
				<?php if ($_SESSION['tipo_usuario'] == 'V') {?>
					<div class="tab-pane fade show" id="profile2" role="tabpanel" aria-labelledby="home-tab">
						<div>
							<br />
							<br />
							<br />
							<button type="button" class="btn btn-primary" onclick="toggleSlideAll()" style="color:white">abrir / fechar todos
							</button>
							<br />
							<br />
							<br />
							<?php
							while ($arrayPedido2 = mysqli_fetch_array($lista_pedidos_vendedor)){
								$id_ped_vend = $arrayPedido2['ID_PEDIDO_VENDEDOR'];
								$data_ped_vend = $arrayPedido2['DT_PEDIDO'];
								$valor_ped_vend = $arrayPedido2['VALOR_PEDIDO'];
								$cliente_ped_vend = $arrayPedido2['COD_CLIENTE'];
								
			
								$sql4 ="select * from pedido_vendedor p
								inner join carrinho_compras c on p.ID_PEDIDO = c.ID_PEDIDO
								INNER join produto pr on c.COD_PRODUTO = pr.id_produto
								where p.ID_PEDIDO_VENDEDOR = $id_ped_vend
								and pr.cod_cliente = $cod_usuario
								order by p.DT_PEDIDO desc"; 
								$pedido_vend = mysqli_query($conexao,$sql4);
	
							?>
								<div class="show_hide" style="background-color: rgba(92, 181, 95, 0.65);">
									<div class="row">
										<div class="col-md-2 text-left">
											<b>N° Pedido</b> : <?php echo "$id_ped_vend";?>
										</div>
										<div class="col-md-3 text-left">
											<b>Cliente</b> : <?php echo RetornaNome($cliente_ped_vend);?>
										</div>
										<div class="col-md-2 text-left">
											<b>R$</b> : <?php echo number_format($valor_ped_vend,2,",",".");?>
										</div>
										<div class="col-md-2 text-left">
											<b>Data</b> : <?php echo date('d/m/Y H:i:s',strtotime($data_ped_vend));?>
										</div>
										<div class="col-md-2 text-right">
											<button onclick="aprova(<?php echo trim($id_ped_vend); ?>)" type="submit" class="btn btn-success" value="1">Aprovar</button>
											<!--Habilitar esse botão só depois q gerar o boleto e não haja pagamento do mes
											<a href="anuncio_Reprovar.php?id=<?php echo $id_ped_vend?>" class="btn btn-danger" role="button">Reprovar</a>-->
										</div>
									</div>
								</div>
	
	
								<div class="slidingDiv">
									<table class="table table-light table-hover responsive" >
										<thead>
											<tr>
												<th style="width:120px">Produto</th>
												<th style="width:328px"></th>
												<th style="width:152px">Quant.</th>
												<th style="width:213px">Valor Total</th>
											</tr>
										</thead>
										<?php
										while ($array3 = mysqli_fetch_array($pedido_vend)){
											$produto3 = $array3['imagem_produto'];
											$nome3 = $array3['nome_produto'];
											$quantidade3 = $array3['QTD_PRODUTO'];
											$vendedor3 = $array3['cod_cliente'];
											$preco3 = $array3['PRECO_PRODUTO'];
	
											?>
	
											<tr>
												<td><img src='<?php echo $produto3; ?>' style="width:120px"></td>
												<td><?php echo $nome3; ?></td>
												<td><?php echo $quantidade3; ?></td>
												<td><?php echo number_format($preco3,2,",","."); ?></td>
											</tr>
											<?php	
										}?>
									</table>
								</div>
							<?php
							}?>
						</div>
					</div><?php
				}
				?>
			</div>	           	
		</form>
	</div>
</body>
</html>