<?php
include 'script/conexao.php';
include 'script/sessao.php';

$cod_usuario = $_SESSION['cod_usuario'];

$sql ="select * from Produto where cod_cliente = $cod_usuario 
	   and STATUS_PRODUTO in('A','I')
	   ";
$buscar = mysqli_query($conexao,$sql);


$sql2 ="select p.nome_produto, p.imagem_produto, a.msg_negado, p.id_produto from Produto p
		inner join anuncio_negado a on p.id_produto = a.id_produto
 		where a.cod_cliente = $cod_usuario 
	    and status_produto = 'N'";
$negado = mysqli_query($conexao,$sql2);

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
	<title>Anúncios</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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

        function atualizar() {
  
        var status 		= form.status.value;
        var qtd 		= form.qtd.value;
        var preco 		= form.preco.value;
        var validade 	= form.validade.value;
        var id 			= form.id_produto.value;
        var descricao 	= form.descricao.value;
 
        $.ajax({
                url: 'script/funcao_aprovar.php',
				type: 'POST',
                data: {
					status,
					qtd,
					preco,
					validade,
					id,
					descricao,
					voption: '6'
				},
                cache: false,
                success: function(response) {
                    location.reload();
                    //$(".resultado").html(response); //para mostrar alguma mensagem na tela
                }
        });   
       
    }
	</script>
</head>
<body class="bg-dark" style="padding-left: 30px">
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
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
						
				<?php
								
					while ($array = mysqli_fetch_array($buscar)){
						$id = $array['id_produto'];
						$produto = $array['imagem_produto'];
						$quantidade = $array['quantidade_produto'];
						$validade = $array['vencimento_produto'];
						$preco = $array['valor_produto'];
						$nome = $array['nome_produto'];
						$detalhe = $array['descricao_produto'];
						$situacao = $array['STATUS_PRODUTO'];
						if ($situacao == 'A') {
							$sit = 'Ativo';
						}else{
							$sit = 'Inativo';
						}
						?>
						<tr>
									
							<td><img src='<?php echo $produto; ?>' style="width:120px"></td>
							<td><?php echo $quantidade; ?></td>
							<td><?php echo date('d/m/Y',strtotime($validade)); ?></td>
							<td>R$ <?php echo number_format($preco,2,",","."); ?></td>
							<td><?php echo $sit ?></td>
							<td>
							<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $id ?>" data-whateverqtd="<?php echo $quantidade ?>"data-whateverpreco="<?php echo $preco ?>"data-whateverval="<?php echo $validade ?>" data-whatevernome="<?php echo $nome ?>" data-whateverdetalhe="<?php echo $detalhe ?>" data-whateversit="<?php echo $situacao ?>">Editar</button></td>
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
		
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"></h5>
					</div>
					<div class="modal-body">
						<form name="form" action="" method="post">
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Situação do Anúncio:</label>
								<select class="form-control" name="status" id="teste">
									<option value="A" <?php ($situacao == 'A')?'selected':''?> >Ativo</option>
									<option value="I" <?php ($situacao == 'I')?'selected':''?> >Inativo</option>
								</select> 
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Quantidade:</label>
								<input type="number" class="form-control" name="qtd" id="qtd">
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Preço:</label>
								<input type="number" class="form-control" name="preco" id="preco">
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Validade:</label>
								<input type="date" class="form-control" name="validade" id="validade">
							</div>
							<div class="form-group">
								<label for="message-text" class="col-form-label">Descrição:</label>
								<textarea class="form-control" name="descricao" id="descricao"></textarea>
							</div>
							<input type="hidden" name="id_produto" id="id_produto">
							<div class="modal-footer">
								<button onclick=" return atualizar()" type="button" class="btn btn-primary">Atualizar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
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
	<script type="text/javascript">
		$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  var recipientnome = button.data('whatevernome') // Extract info from data-* attributes
  var recipientval = button.data('whateverval') // Extract info from data-* attributes
  var recipientpreco = button.data('whateverpreco') // Extract info from data-* attributes
  var recipientqtd = button.data('whateverqtd') // Extract info from data-* attributes
  var recipientdetalhe = button.data('whateverdetalhe') // Extract info from data-* attributes
  var recipientsituacao = button.data('whateversit') // Extract info from data-* attributes
  
  var modal = $(this)
  //modelo para usar com string
  //modal.find('.modal-title').text('New message to ' + recipientnome)
  modal.find('.modal-title').text(recipientnome)
  modal.find('.modal-body #id_produto').val(recipient)
  modal.find('.modal-body #qtd').val(recipientqtd)
  modal.find('.modal-body #preco').val(recipientpreco)
  modal.find('.modal-body #validade').val(recipientval)
  modal.find('.modal-body textarea').val(recipientdetalhe)
  modal.find('.modal-body select').val(recipientsituacao)


})
	</script>
</body>
</html>