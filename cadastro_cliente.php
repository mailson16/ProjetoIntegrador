<!DOCTYPE html>
<html>
<head>
	<title>Formulário de Cadastro</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script type="text/javascript">
		function validaSenha(input){
			if (input.value != document.getElementById('txtSenha').value){
				input.setCustomValidity('Repita a senha corretamente');
			}else{
				input.setCustomValidity('');
			}
		}

		function ApenasLetras(e, t) {
			try {
				if (window.event) {
					var charCode = window.event.keyCode;
				} else if (e) {
					var charCode = e.which;
				} else {
					return true;
				}
				if (
					(charCode > 64 && charCode < 91) || 
					(charCode > 96 && charCode < 123) ||
            		(charCode > 191 && charCode <= 255) // letras com acentos
            	){
					return true;
				} else {
					return false;
				}
			} catch (err) {
				alert(err.Description);
			}
		}

		function verifica() {

			var nome = form.nome.value;
			var sobrenome = form.sobrenome.value;
			var email = form.email.value;
			var telefone = form.telefone.value;
			var login = form.login.value;
			var usuario = form.usuario.value;
			var senha = form.senha.value;
			var senha2 = form.senha2.value;

			if (nome == "" ) {
				alert('Por favor, informe o nome.'); $("input[name=nome]").focus();
				return false;
			}

			if (sobrenome == "" ) {
				alert('Por favor, informe o sobrenome.'); $("input[name=sobrenome]").focus();
				return false;
			}
			if (email == "" ) {
				alert('Por favor, informe o email.'); $("input[name=email]").focus();
				return false;
			}
			if (telefone == "" ) {
				alert('Por favor, informe o telefone.'); $("input[name=telefone]").focus();
				return false;
			}
			if (login == "" ) {
				alert('Por favor, informe o login.'); $("input[name=login]").focus();
				return false;
			}
			if (senha == "" ) {
				alert('Por favor, informe a senha.'); $("input[name=senha]").focus();
				return false;
			}
			if (senha2 == "" ) {
				alert('Por favor, repita a senha.'); $("input[name=senha2]").focus();
				return false;
			}

        }

	</script>
</head>
<body class="bg-dark">
	<div class="container" >
		<div class="card my-4">
			<div class="card-header bg-primary">
				<h4>Cadastro</h4>
			</div>
			<div class="container" style="background-color: #e9ecef">
				<form action="insert_cadastro.php" method="post" name="form">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputNome">Nome</label>
							<input type="text" class="form-control" name="nome" onkeypress="return ApenasLetras(event,this);">
						</div>
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputSobrenome">Sobrenome</label>
							<input type="text" class="form-control" name="sobrenome" onkeypress="return ApenasLetras(event,this);">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="font-weight-bold" for="inputEmail">Email</label>
							<input type="email" class="form-control" name="email">
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
						<input onclick=" return verifica()" type="submit" name="send" class="btn btn-dark" value="Registrar">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
