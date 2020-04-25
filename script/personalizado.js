$(function(){
	$("#pesquisar").keyup(function(){

		var pesquisa = $(this).val();
		//Verifica se há algo digitado

		if(pesquisa != ''){

			var dados = {

				palavra : pesquisa
			}
			$.post('pesquisar.php', dados, function(retorna){

			//Mostra no html dentro de uma classe

				$(".resultado").html(retorna);

			});
		}else{
			window.location.href = "produtos.php";
		}


	});

});