<?php

include 'script/conexao.php';
include 'lib/WideImage.php'; //Inclui classe WideImage à página
include 'script/sessao.php';


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

	$sql = " INSERT INTO produto (cod_cliente, nome_produto, categoria_produto, tipo_produto, quantidade_produto, valor_produto, vencimento_produto, imagem_produto, descricao_produto, status_produto) VALUES 
		('$cod_usuario','$produto','$categoria','$tipo',$quantidade,$preco,'$validade','$diretorio','$descricao','P')";
	//echo "$sql";
		//$inserir = mysqli_query($conexao, $sql);*/
	if($inserir = mysqli_query($conexao, $sql)){
		header("location:anuncio.php");
	}else{
		$_SESSION['msg'] = '<p>';
	}

}else{
	header("location:cadastro_anuncio.php");
}

?>