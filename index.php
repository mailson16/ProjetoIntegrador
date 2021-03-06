<!DOCTYPE html>
<html lang="pt">
<head>
	<title>LeaderNet</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript" >

		function logar() {
  
        var usuario =  document.getElementsByName("usuario")[0].value
        var senha 	= document.getElementsByName("senha")[0].value
 
        $.ajax({
                url: 'index1.php',
				type: 'POST',
                data: {
					usuario2: usuario,
					senha2: senha,
					voption: '1'
				},
                cache: false,
                success: function(response) {
                	if(response == "true"){
                		window.location.href = "menu.php";
                	}else{
                		$(".resultado").html(response); //para mostrar alguma mensagem na tela
                	}
                    //
                    //
                }
        });   
       
    }
	</script>
</head>
<body style="background-color: rgba(231, 29, 29, 0.68);">
	
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 80px">
		<div class="container">
			<a class="navbar-brand mr-0 mr-md-2">
				<img src="imagens/logo3.png" style="height:200px">
			</a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse h5 mb-0" id="navbarTogglerDemo01">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Produtos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Contato</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Quem Somos</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="" data-toggle="modal" data-target="#siteModal">Login</a>
					</li>
					
				</ul>
			</div>
		</div>
	</nav>
	
	<div id="carouselSite" class="carousel slide" data-ride="carousel" style="opacity: 0.8">
		<ol class="carousel-indicators">
			<li data-target="#carouselSite" data-slide-to="0" class="active"></li>
			<li data-target="#carouselSite" data-slide-to="1"></li>
		</ol>
		<div class="carousel-inner">

			<div class="carousel-item active">

				<img src="imagens/menu.png" class="img-fluid d-block">
				<div class="carousel-caption d-none d-md-block text-light">
				</div>

			</div>
			<div class="carousel-item">
				<img src="imagens/menu4.png" class="img-fluid d-block">
				<div class="carousel-caption d-none d-md-block text-light">
				</div>
			</div>
		</div>
		<!--<a class="carousel-control-prev" href="#carouselSite" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
		</a>
		<a class="carousel-control-next" href="#carouselSite" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Próximo</span>
		</a>-->
	</div>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center my-3">
				<h4 class="display-3">Nossos Produtos</h4>
				<p>Confira abaixo nossas delicias que separamos para você</p>
			</div>

		</div>

		<div class="row mb-3">	
			<div class="col-md-4">
				<div class="card-header text-center h4 text-light">
					Doces
				</div>
				<div class="card">
					<a href="categoria_doce.php">
					<img class="card-img-top" src="imagens/brigadeiro.jpg" alt="...">
					</a>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card-header text-center h4 text-light">
					Salgados
				</div>
				<div class="card">
					<a href="categoria_salgado.php">
					<img class="card-img-top" src="imagens/atum.jpg" alt="...">
					</a>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="card-header text-center h4 text-light">
					Bebidas
				</div>
				<div class="card">
					<a href="categoria_bebida.php">
					<img class="card-img-top" src="imagens/bebidas.jpg" alt="...">
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 text-center my-3">
				<h3 class="display-4">Mais que uma delícia. Um mundo de Sabores</h3>
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
	<!--modal-->
	<div class="modal fade" id="siteModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body bg-dark">
					<div style="padding: 10px;">
						<center>
							<img src="imagens/logo3.png" style="height: 250px">
						</center>
							<div class="form-group text-light">
								<label>Usuário</label>
								<input type="text" class="form-control" name="usuario" placeholder="Usuário" autocomplete="off" required>
							</div>
							<div class="form-group text-light">
								<label>Senha</label>
								<input type="password" class="form-control" name="senha" placeholder="Senha" autocomplete="off" required>
							</div>
							<br>
							<div class="form-group" style="text-align: center;">
								<button onclick=" return logar()" type="button" class="btn btn-outline-success btn-md">&nbsp;&nbsp;Logar&nbsp;&nbsp;</button>
							</div>
							<div class="resultado" style="text-align: center;">

							</div>
							<center class="text-light">
								<small>Você não possui cadastro? Cique <a href="cadastro_cliente.php"> aqui</a></small>
							</center>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>