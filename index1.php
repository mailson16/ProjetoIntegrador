<?php

include 'script/conexao.php';
include 'script/password.php';

$usuario  = $_POST['usuario2'];
$senhausuario = $_POST['senha2'];

$sql = "select login_cliente, senha_cliente, cod_cliente, tipo_cliente from cliente_fisico where login_cliente = '$usuario'";
$buscar = mysqli_query($conexao,$sql);

$total = mysqli_num_rows($buscar); //vai buscar a qtd de linhas dentro da tabela, se for 0 nao existe usuario
$tes = "";
if ($total == 1){
	while ($array = mysqli_fetch_array($buscar)){

		$senha = $array['senha_cliente'];
		$_SESSION['cod_usuario'] = $array['cod_cliente'];
		$_SESSION['tipo_usuario'] = $array['tipo_cliente'];

		$senhacodificada = sha1($senhausuario);


	#conferir senha
		if ($senhacodificada == $senha){
			session_start();
			$_SESSION['usuario'] = $usuario;
			$tes = "true";
			//header('location: menu.php');
			
		}else{
			echo "	<div class='alert alert-danger'>";
			echo "Usuário/senha incorreta";
			echo "	</div>";

		}
	}
}else{
	echo "	<div class='alert alert-danger'>";
	echo "Usuário não cadastrado";
	echo "	</div>";
}
echo "$tes";
?>
