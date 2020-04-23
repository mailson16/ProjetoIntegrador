
<?php
include 'script/conexao.php';
include 'script/sessao.php';

$produto = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);


$result_user = "select * from Produto WHERE nome_produto LIKE '%$produto%' 
		   and status_produto in('A')";
$resultado_user = mysqli_query($conexao,$result_user);

if(($resultado_user) and ($resultado_user->num_rows != 0)){

	while ($array = mysqli_fetch_array($resultado_user) ) {
		echo "<b>Produto:</b>".$array['nome_produto']."</b>";
		echo "<br><br>";
		echo "<b>Descrição:</b>".$array['descricao_produto']."</b>";
		echo "<br><br>";
		//echo "<b>Descrição:</b>".$array['quantidade']."</b>";
		//echo "<br><br>";
		//echo "<b>Validade:</b>".$array['validade']."</b>";
		//echo "<br><br>";
		//echo "<b>Preço Unit:</b>".$array['preco']."</b>";

	}

}else{
	echo "Nenhum produto encontrado";
}


?>
