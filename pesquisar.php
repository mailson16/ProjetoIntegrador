
<?php
include 'script/conexao.php';
include 'script/sessao.php';

$produto = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);


$result_user = "select * from Produto WHERE nome_produto LIKE '%$produto%' 
		   and status_produto in('A')";
$resultado_user = mysqli_query($conexao,$result_user);

if(($resultado_user) and ($resultado_user->num_rows != 0)){

		echo "	<div class='row'>";
	while ($array = mysqli_fetch_array($resultado_user) ) {
		echo "	<div class='col'>";
		echo "	<div class='thumbnail'>";
    	echo "		<img class='card-img-top' src=".$array['imagem_produto']." alt='Card image cap'>";
    	echo "		<div class='caption text-center'>";
      	echo "			<h5 class='card-title'>".$array['nome_produto']."</h5>";
      	echo "			<p class='card-text'>".$array['descricao_produto']."</p>";
      	echo "			<p class='card-text'><b>R$ ".number_format($array['valor_produto'],2,",",".")."</b></p>";
      	echo "			<a href='carrinho.php?add=carrinho&id=".$array['id_produto']." class='btn btn-warning' role='button'><i class='material-icons';'>shopping_cart</i> Adicionar ao Carrinho</a>";
      	echo "			</br>";
		echo "		</div>";
    	echo "	</div>";
    	echo "	</div>";


	}
	echo "	</div>";
}else{
	echo "Nenhum produto encontrado";
}


?>
