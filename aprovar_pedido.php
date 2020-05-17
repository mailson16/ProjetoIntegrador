<?php
include 'script/conexao.php';
include 'script/sessao.php';
include 'script/funcao_usuario.php';


$cod_usuario = $_SESSION['cod_usuario'];


$sql2 = "select distinct PED.ID_PEDIDO_VENDEDOR, PED.COD_CLIENTE, PED.DT_PEDIDO, PED.VALOR_PEDIDO from carrinho_compras c
		inner join produto p on c.COD_PRODUTO = p.id_produto
		inner join pedido_vendedor ped on  c.ID_PEDIDO = ped.ID_PEDIDO
        where ped.COD_VENDEDOR  = $cod_usuario
        and ped.STATUS_PEDIDO='P'
        order by c.ID_PEDIDO";
$lista_Pedido = mysqli_query($conexao,$sql2);
$numero_pedidos = mysqli_num_rows($lista_Pedido);

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
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><h5>Aprovação<h5></li>
						<li class="breadcrumb-item active"><a href="pedido.php">Meus Pedidos</a></li>
					</ol>
				</nav>
				<hr class="linetittle" style="background-color: black" />
                 <div >
                    <button type="button" class="btn btn-success" onclick="toggleSlideAll()" style="color:white">abrir / fechar todos</button>
                    <br />
                    <br />
                    <br />
                 </div>
				<?php
				while ($arrayPedido = mysqli_fetch_array($lista_Pedido)){
					$id = $arrayPedido['ID_PEDIDO_VENDEDOR'];
					$data = $arrayPedido['DT_PEDIDO'];
					$valor_pedido = $arrayPedido['VALOR_PEDIDO'];
					$cliente = $arrayPedido['COD_CLIENTE'];
					

					$sql ="select * from pedido_vendedor p
					inner join carrinho_compras c on p.ID_PEDIDO = c.ID_PEDIDO
					INNER join produto pr on c.COD_PRODUTO = pr.id_produto
					where p.ID_PEDIDO_VENDEDOR = $id
					and pr.cod_cliente = $cod_usuario
					order by p.DT_PEDIDO desc"; 
					$pedido = mysqli_query($conexao,$sql);

				?>
				<div class="show_hide" style="background-color: rgba(92, 181, 95, 0.65);">
					<div class="row">
						<div class="col-md-2 text-left">
							<b>N° Pedido</b> : <?php echo "$id";?>
						</div>
						<div class="col-md-3 text-left">
							<b>Cliente</b> : <?php echo RetornaNome($cliente);?>
						</div>
						<div class="col-md-2 text-left">
							<b>R$</b> : <?php echo number_format($valor_pedido,2,",",".");?>
						</div>
						<div class="col-md-2 text-left">
							<b>Data</b> : <?php echo date('d/m/Y H:i:s',strtotime($data));?>
						</div>
						<div class="col-md-2 text-right">
							<button onclick="aprova(<?php echo trim($id); ?>)" type="submit" class="btn btn-success" value="1">Aprovar</button>
							<!--Habilitar esse botão só depois q gerar o boleto e não haja pagamento do mes
							<a href="anuncio_Reprovar.php?id=<?php echo $id?>" class="btn btn-danger" role="button">Reprovar</a>-->
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
					
		</form>
	</div>
</body>
</html>