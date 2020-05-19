<?php

include 'script/conexao.php';
include 'lib/WideImage.php'; //Inclui classe WideImage à página
include 'script/sessao.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Carrinho de Compras</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="script/personalizado.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#myModal').modal('show');

    });
</script>
</head>
<body>
	<div class="container theme-showcase" role="main">
<?php
$sendCadImg=filter_input(INPUT_POST,'send',FILTER_SANITIZE_STRING);
if($sendCadImg){
	$produto=filter_input(INPUT_POST,'produto',FILTER_SANITIZE_STRING);
	$categoria=filter_input(INPUT_POST,'categoria',FILTER_SANITIZE_STRING);
	$tipo=filter_input(INPUT_POST,'tipo',FILTER_SANITIZE_STRING);
	$quantidade=filter_input(INPUT_POST,'quantidade',FILTER_SANITIZE_STRING);
	$validade=filter_input(INPUT_POST,'validade',FILTER_SANITIZE_STRING);
	$preco=filter_input(INPUT_POST,'preco',FILTER_SANITIZE_STRING);
	$descricao=filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING);
	$imagem=$_FILES['arquivo']['name'];
	$cod_usuario = $_SESSION['cod_usuario'];
	//var_dump($_FILES['arquivo']);  respondo todas as informações da imagem
	$extensao = strtolower(substr($_FILES['arquivo']['name'], -4));//pega a extensão ok
	$nome_nome = md5(time()).$extensao; //vou criptografar o nome da imagem para nunca bater igual
	$caminho = "imagens/produtos/"; // crio o caminho onde quero q a imagem seja salva
	$imgtemp=$_FILES['arquivo']['tmp_name']; //pego o caminho temporario onde ela é salva
		//lib para redimensionar a imagem
	$image = WideImage::load($imgtemp);
	$image = $image->resize(300, 168, 'outside');
	$image = $image->crop('center', 'center', 300, 168); //Corta a imagem do centro, forçando sua altura e largura
	$image->saveToFile($caminho.$nome_nome); //Salva a imagem no caminho escolhido
	$diretorio = 'imagens/produtos/'.$nome_nome;

		//move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretoria.$nome_nome); //salva o arquivo nesse caminho
	$preco = str_replace(",", ".", $preco);
	$sql = " INSERT INTO produto (cod_cliente, nome_produto, categoria_produto, tipo_produto, quantidade_produto, valor_produto, vencimento_produto, imagem_produto, descricao_produto, status_produto) VALUES 
		('$cod_usuario','$produto','$categoria','$tipo',$quantidade,$preco,'$validade','$diretorio','$descricao','P')";
	//echo "$sql";
		//$inserir = mysqli_query($conexao, $sql);*/
	if($inserir = mysqli_query($conexao, $sql)){?>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header alert-success">
						<h4 class="modal-title" id="exampleModalLabel">&nbsp;&nbsp;Anúncio cadastrado</h5>
						</div>
						<div class="modal-body">
							<h6>Seu cadastro foi enviado para aprovação</h6>
						</div>
					</div>
				</div>
			</div><?php
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="3; URL=anuncio.php"/>';

	}else{
		$_SESSION['msg'] = '<p>';
	}

}else{
	header("location:cadastro_anuncio.php");
}

?>
  </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>