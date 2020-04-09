<<<<<<< HEAD
<?php
include 'script/conexao.php';
include 'script/password.php';

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$nome_cliente = $nome. " ". $sobrenome;
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$usuario = $_POST['usuario'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$status = 'A';

$sql = " INSERT INTO cliente_fisico (NOME_CLIENTE, EMAIL_CLIENTE, TELEFONE_CLIENTE, SENHA_CLIENTE, TIPO_CLIENTE, LOGIN_CLIENTE, STATUS_CLIENTE) VALUES ('$nome_cliente','$email','$telefone',sha1('$senha'),'$usuario','$login','$status')";
//echo "$sql";
$inserir = mysqli_query($conexao, $sql);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user=scalable=no" />
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<style type="text/css">
		
	</style>
</head>
<body>
	<div class="container" style="width:400px;">
		<div style="padding: 10px;">
		<center>
			<h3>Adicionado com Sucesso</h3>
		</center>
		
  				<div style="margin-top: 20px;">
    				<a href="menu.php" class="btn btn-sm btn-warning" style="color:#fff">Voltar</a>
  				</div>
  				
		
		</div>
	</div>

	

</body>
=======
<?php
include 'script/conexao.php';
include 'script/password.php';

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$nome_cliente = $nome. " ". $sobrenome;
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$usuario = $_POST['usuario'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$status = 'A';

$sql = " INSERT INTO cliente_fisico (NOME_CLIENTE, EMAIL_CLIENTE, TELEFONE_CLIENTE, SENHA_CLIENTE, TIPO_CLIENTE, LOGIN_CLIENTE, STATUS_CLIENTE) VALUES ('$nome_cliente','$email','$telefone',sha1('$senha'),'$usuario','$login','$status')";
//echo "$sql";
$inserir = mysqli_query($conexao, $sql);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user=scalable=no" />
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<style type="text/css">
		
	</style>
</head>
<body>
	<div class="container" style="width:400px;">
		<div style="padding: 10px;">
		<center>
			<h3>Adicionado com Sucesso</h3>
		</center>
		
  				<div style="margin-top: 20px;">
    				<a href="menu.php" class="btn btn-sm btn-warning" style="color:#fff">Voltar</a>
  				</div>
  				
		
		</div>
	</div>

	

</body>
>>>>>>> Primeiro Commit
</html>