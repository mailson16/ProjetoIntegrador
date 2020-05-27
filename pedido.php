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
$sql2 = "select DISTINCT  p.ID_PEDIDO, p.VALOR_PEDIDO, p.DT_PEDIDO from pedido p
		inner join pedido_vendedor pv on p.ID_PEDIDO = PV.ID_PEDIDO
         where pv.COD_CLIENTE = $cod_usuario
         and pv.STATUS_PEDIDO in ('P','A')
         and pv.DT_PEDIDO BETWEEN '$P_Dia 00:00:01' and '$U_Dia 23:59:59'
         order by pv.DT_PEDIDO desc";
$lista_Pedido = mysqli_query($conexao,$sql2);

//lista os pedidos finalizados(colocar pelo dia inicio e dia fim de mes)
$sqlF = "select * from pedido_vendedor
         where COD_CLIENTE = $cod_usuario
         and STATUS_PEDIDO = 'A'
         and DT_PEDIDO BETWEEN '$P_Dia 00:00:01' and '$U_Dia 23:59:59'
         order by DT_PEDIDO desc";
$lista_Pedido_Finalizados = mysqli_query($conexao,$sqlF);


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
	<title>Pedidos</title>
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
            //$(".slidingDiv").hide();
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
                success: function (response) {
                	location.reload();
                }

            });

        } else {
            alert(" Ação cancelada ! ");
            $('#loading').hide();
            return false;
        }
    }
    function reprovar(id) {
    	var vendedor = form2.vendedor.value;
        r = confirm("tem certeza que deseja reprovar este pedido? ");
        if (r == true) {
            document.getElementsByName.value = '2';
            $.ajax({
                url: 'script/funcao_aprovar.php',
                type: 'POST',
                data: {
                	vendedor,
                    vid: id,
                    voption: '5'

                },
                cache: false,
                success: function (response) {
                	location.reload();
                	//$(".resultado").html(response); para mostrar alguma mensagem na tela
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
	<div class="card my-0">
		<div class="card-header" style="background: linear-gradient(to right, #ee6565 , #007bff);">
			<h4 style="color: white">Meus Pedidos</h4>
		</div>
	</div>
	<div style="padding: 10px">
		<br>
		<br>
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pedidos</a>
			</li>
			<!--<li class="nav-item">
				<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Finalizados</a>
			</li>-->
			<?php 
			if ($_SESSION['tipo_usuario'] == 'V') {?>
				<li class="nav-item btn-warning">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false">
						Aprovar
					<?php 
						if ($numero_pedidos >= 1) {?>
							<span class="badge badge-light" style="font-size: 12px"><?php echo "$numero_pedidos";?></span>
					</a><?php
						}?>

				</li><?php
			}?>
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
						$id_pedido = $arrayPedido['ID_PEDIDO'];
						$data = $arrayPedido['DT_PEDIDO'];
						$valor_pedido = $arrayPedido['VALOR_PEDIDO'];

						//pego a quantidade de vendedores nesse pedido
						$sql2 ="select count(DISTINCT(pv.ID_PEDIDO_VENDEDOR)) as lista from pedido_vendedor pv
						inner join carrinho_compras cc on pv.ID_PEDIDO = cc.ID_PEDIDO
						where pv.ID_PEDIDO = $id_pedido";
						$qtdVend = mysqli_query($conexao,$sql2);
						while ($arrayQtdVend = mysqli_fetch_array($qtdVend)){
							$qtdVendedor = $arrayQtdVend['lista'];
						}
						?>
						<div class="show_hide" style="background-color: #5aa3cea6;">
							<div class="row">
								<div class="col-md-2 text-left">
									<b>N° Pedido</b> : <?php echo "$id_pedido";?>
								</div>
								<div class="col-md-4 text-center">
									<b>Valor do Pedido</b> : <?php echo number_format($valor_pedido,2,",",".");?>
								</div>
								<div class="col-md-5 text-right">
									<b>Data do Pedido</b> : <?php echo date('d/m/Y H:i:s',strtotime($data));?>
								</div>
							</div>
						</div>
						<div class="slidingDiv">
						<?php
								//pego o id de cada pedido vendedor

								$sql3 ="select DISTINCT(pv.ID_PEDIDO_VENDEDOR), pv.COD_VENDEDOR from pedido_vendedor pv
								inner join carrinho_compras cc on pv.ID_PEDIDO = cc.ID_PEDIDO
								where pv.ID_PEDIDO = $id_pedido";?>

								
									<table class="table table-light table-hover responsive" >
										<thead>
											<tr>
												<th></th>
												<th style="width:200px">Produto</th>
												<th>Quant.</th>
												<th>Valor Total</th>
												<th>Status Pedido</th>
												<th>Vendedor</th>
											</tr>
										</thead><?php
										$idPedidos = mysqli_query($conexao,$sql3);
										while ($arrayIdPedidos = mysqli_fetch_array($idPedidos)){
											$id = $arrayIdPedidos['ID_PEDIDO_VENDEDOR'];
											$vendedor = $arrayIdPedidos['COD_VENDEDOR'];

											//detallhe de cada pedido
											$sql4 ="select prod.imagem_produto, prod.nome_produto, cc.QTD_PRODUTO, prod.cod_cliente, cc.PRECO_PRODUTO, p.STATUS_PEDIDO, p.COD_VENDEDOR from pedido_vendedor p 
											inner join pedido pe on p.ID_PEDIDO = pe.ID_PEDIDO
											inner join carrinho_compras cc on pe.ID_PEDIDO = cc.ID_PEDIDO
											inner join produto prod on cc.COD_PRODUTO = prod.id_produto
											where p.ID_PEDIDO_VENDEDOR= $id
											and prod.cod_cliente = $vendedor";
											$pedido = mysqli_query($conexao,$sql4);

											while ($array = mysqli_fetch_array($pedido)){
												$produto = $array['imagem_produto'];
												$nome = $array['nome_produto'];
												$quantidade = $array['QTD_PRODUTO'];
												$vendedor = $array['cod_cliente'];
												$preco = $array['PRECO_PRODUTO'];
												$status = $array['STATUS_PEDIDO'];
												$nome_vend = $array['COD_VENDEDOR'];
												if ($status == 'A') {
													$vsatus =  "<td style='color:green'>Aprovado</td>";
												}else{
													$vsatus = "<td style='color:orange'>Pendente</td>";
												}
												?>

												<tr>
													<td><img src='<?php echo $produto; ?>' style="width:120px"></td>
													<td><?php echo $nome; ?></td>
													<td><?php echo $quantidade; ?></td>
													<td><?php echo number_format($preco,2,",","."); ?></td>
													<?php echo $vsatus;?>
													<td><?php echo retornaNome($nome_vend); ?></td>
												</tr>
												<?php	
											}
										}?>
									</table>
								</tr>
							</table>
						</div><?php							
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
						<form name ="form2" action="" method="post">
						<input TYPE="hidden" name="vendedor" value='<?php echo($cod_usuario)?>'>
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

							$sqlPend = "select * from boleto
							where COD_CLIENTE  = $cliente_ped_vend
							and COD_VENDEDOR = $cod_usuario
							and status_boleto  = 'P' ";
							$lista_Pend = mysqli_query($conexao,$sqlPend);
							$existe_Pend = mysqli_num_rows($lista_Pend)

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

									<div class="col-md-3 text-right">
										<button onclick="aprova(<?php echo trim($id_ped_vend); ?>)" type="button" class="btn btn-success" value="1">Aprovar</button>
										<!--Habilitar esse botão só depois q gerar o boleto e não haja pagamento do mes-->
										<?php
										if ($existe_Pend >=1) {?>

											<button onclick="reprovar(<?php echo trim($id_ped_vend); ?>)" type="button" class="btn btn-danger" value="2">Não Aprovar</button><?php
										}?>
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
						</form>
					</div>
				</div><?php
				}?>
		</div>	           	
	</div>
</body>
</html>