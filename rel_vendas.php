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

	//valor total vendido neste periodo
	$sql = "select SUM(VALOR_PEDIDO) as VALOR_GERAL from pedido_vendedor 
	where COD_VENDEDOR = $cod_usuario
	and STATUS_PEDIDO = 'A'
	and DT_PEDIDO BETWEEN '$data_de 00:00:01' and '$data_ate 23:59:59'";
	$lista_total = mysqli_query($conexao,$sql);
	$total = mysqli_num_rows($lista_total);
	while ($array = mysqli_fetch_array($lista_total)){
		$total = $array['VALOR_GERAL'];
	}
}

//verifica se existe boleto pendende
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
	<title>Relatório de Vendas</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/personalizado.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
	</script>
<style type="text/css">
	#caixa{
		border-radius: 5px;
		background-color: #8290a9eb;
		box-shadow: 9px 7px 5px rgba(50, 50, 50, 0.77);
	}
	.caixa2{
		justify-content: center; 
		padding: 5%;
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
			<h4>Relatório de Vendas</h4>
			<hr>
			<div class="container" id="caixa">
				<div class="row caixa2">
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
				if($total >= 1){

			?>

				<hr>
				<div>
					<div>
						<h4>Total de vendas realizadas: <?php echo number_format($total,2,",",".")?></h4>
						<small>(Período de <?php echo date('d/m/Y',strtotime($data_de)) ;?> até <?php echo date('d/m/Y',strtotime($data_ate)) ;?>)</small>
					</div>
				</div>
				<br>
				<br>
				<div class="row">
					<div style="justify-content: center;">
						<div id="chart_div" style=" height: 500px;"></div>
					</div>
				</div>
				<div class="row">
					<div style="justify-content: center;">
						<div id="piechart" style=" height: 500px;"></div>
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
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart','bar']});
      google.charts.setOnLoadCallback(drawStuff);
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawStuff() {
      	var button = document.getElementById('change-chart');
        var chartDiv = document.getElementById('chart_div');
        var data = google.visualization.arrayToDataTable([
          ['Produtos', 'Total Vendido', 'Quantidade'],
          <?php
          $count_salgado_total = 0;
          $count_doce_total = 0;
          $count_bebida_total = 0;
          $sqlId = "select pr.id_produto from carrinho_compras cc 
		  	inner join produto pr on cc.COD_PRODUTO = pr.id_produto
			INNER join pedido_vendedor p on cc.ID_PEDIDO = p.ID_PEDIDO
			where p.COD_VENDEDOR= $cod_usuario
			and  p.COD_VENDEDOR = pr.cod_cliente
			and p.STATUS_PEDIDO = 'A'
			and p.DT_PEDIDO BETWEEN '$data_de 00:00:01' and '$data_ate 23:59:59'
			group by pr.id_produto";
	
			$lista_id = mysqli_query($conexao,$sqlId);
			while ($arrayId = mysqli_fetch_array($lista_id)){
				$id = $arrayId['id_produto'];

				//pega o nome,qtd,valor vendido desse produto
				//**fazendo dessa forma, pois a query estava retornando o cod(3) duas vezes

				$sqlProd = "select cc.NOME_PRODUTO, SUM(CC.PRECO_PRODUTO) as PRECO_PRODUTO, SUM(CC.QTD_PRODUTO) as QTD_PRODUTO,pr.categoria_produto FROM carrinho_compras cc
				inner join pedido_vendedor p on cc.ID_PEDIDO = p.ID_PEDIDO
				inner join produto pr on cc.COD_PRODUTO = pr.id_produto
				where p.COD_VENDEDOR = $cod_usuario
				and cc.COD_PRODUTO = $id
				and p.STATUS_PEDIDO = 'A'
				and p.DT_PEDIDO BETWEEN '$data_de 00:00:01' and '$data_ate 23:59:59'";
				$lista_Produto = mysqli_query($conexao,$sqlProd);
				$count_bebida = 0;
				$count_doce = 0;
				$count_salgado = 0;
				while ($arrayProduto = mysqli_fetch_array($lista_Produto)){
					$produto = $arrayProduto['NOME_PRODUTO'];
					$vendido = $arrayProduto['PRECO_PRODUTO'];
					$qtd = $arrayProduto['QTD_PRODUTO'];
					$categoria = $arrayProduto['categoria_produto'];
					if ($categoria == 'S') {
						$count_salgado = $count_salgado + $qtd;
					}if ($categoria == 'D') {
						$count_doce = $count_doce + $qtd;
					}if ($categoria == 'B'){
						$count_bebida = $count_bebida + $qtd;
					}

					?>
					['<?php echo $produto?>',<?php echo $vendido ?>, <?php echo $qtd ?>],
				<?php
				}
				$count_salgado_total = $count_salgado + $count_salgado_total;
				$count_doce_total = $count_doce + $count_doce_total;
				$count_bebida_total = $count_bebida + $count_bebida_total;
			}
          
          	?>
        ]);

        var materialOptions = {
          width: 1125,
          chart: {
            title: 'Gráfico de Vendas por produtos',
            subtitle: 'Comparativo de quantidade por valor recebido'
          },
          series: {
            0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            y: {
              distance: {label: 'Total Vendido (R$)'}, // Left y-axis.
              brightness: {side: 'right', label: 'Quantidade (unid)'} // Right y-axis.
            }
          }
        };

          var materialChart = new google.charts.Bar(chartDiv);
          materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));

    };
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Categoria', 'Quantidade'],
          ['Bebida', <?php echo $count_bebida_total;?>],
          ['Doce', <?php echo $count_doce_total;?>],
          ['Salgado', <?php echo $count_salgado_total;?>],
          
        ]);

        var options = {
          width: 1125,
          title: 'Gráfico de vendas por categoria'
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>	
</body>
