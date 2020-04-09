<<<<<<< HEAD
<!DOCTYPE html>
<html>
<head>
	<title>Formulário de Cadastro</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script>
		function validaSenha(input){
			if (input.value != document.getElementById('txtSenha').value){
				input.setCustomValidity('Repita a senha corretamente');
			}else{
				input.setCustomValidity('');
			}
		}

	</script>
	<style type="text/css">

	

	</style>
</head>
<body class="bg-dark">
	<div class="container" >
		<div class="card my-4">
			<div class="card-header bg-primary">
				<h4>Cadastro</h4>
			</div>
			<div class="container" style="background-color: #e9ecef">
				<form action="insert_cadastro.php" method="post">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputNome">Nome</label>
							<input type="text" class="form-control" name="nome">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputSobrenome">Sobrenome</label>
							<input type="text" class="form-control" name="sobrenome">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputEmail">Email</label>
							<input type="text" class="form-control" name="email">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold">Telefone</label>
							<input type="text" class="form-control" name="telefone">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Login</label>
							<input type="text" class="form-control" maxlength="20" name="login">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold">Tipo do Acesso</label>
							<select name="usuario" class="form-control">
								<option value="0">Selecionar...</option>
								<option value="C">Cliente</option>
								<option value="V">Vendedor</option>
								<option value="A">Admin</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Senha</label>
							<input type="password" class="form-control" id="txtSenha" name="senha">
						</div>

						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Confirmar a Senha</label>
							<input type="password" class="form-control" name="senha2" oninput="validaSenha(this)">
						</div>
					</div>
					
					<div class="my-4" style="text-align: center">
						<button type="submit" class="btn btn-outline-primary">Registrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
=======
<!DOCTYPE html>
<html>
<head>
	<title>Formulário de Cadastro</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script>
		function validaSenha(input){
			if (input.value != document.getElementById('txtSenha').value){
				input.setCustomValidity('Repita a senha corretamente');
			}else{
				input.setCustomValidity('');
			}
		}

	</script>
	<style type="text/css">

	

	</style>
</head>
<body class="bg-dark">
	<div class="container" >
		<div class="card my-4">
			<div class="card-header bg-primary">
				<h4>Cadastro</h4>
			</div>
			<div class="container" style="background-color: #e9ecef">
				<form action="insert_cadastro.php" method="post">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputNome">Nome</label>
							<input type="text" class="form-control" name="nome">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputSobrenome">Sobrenome</label>
							<input type="text" class="form-control" name="sobrenome">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputEmail">Email</label>
							<input type="text" class="form-control" name="email">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold">Telefone</label>
							<input type="text" class="form-control" name="telefone">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Login</label>
							<input type="text" class="form-control" maxlength="20" name="login">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold">Tipo do Acesso</label>
							<select name="usuario" class="form-control">
								<option value="0">Selecionar...</option>
								<option value="C">Cliente</option>
								<option value="V">Vendedor</option>
								<option value="A">Admin</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Senha</label>
							<input type="password" class="form-control" id="txtSenha" name="senha">
						</div>

						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputPassword4">Confirmar a Senha</label>
							<input type="password" class="form-control" name="senha2" oninput="validaSenha(this)">
						</div>
					</div>
					
					<div class="my-4" style="text-align: center">
						<button type="submit" class="btn btn-outline-primary">Registrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
>>>>>>> Primeiro Commit
</html>