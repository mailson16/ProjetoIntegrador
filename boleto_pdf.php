<?php	
	include 'script/sessao.php';
	include_once ("script/funcao_usuario.php");
	include_once("script/conexao.php");

	$id_boleto = $_GET['id'];
	$cod_usuario = $_GET['usu'];
	$periodo_de ="";
	$periodo_final ="";
	$ano = date('Y');
	

	$sqlBol = "select * from boleto b
			  inner join cliente_fisico c on b.COD_VENDEDOR = c.COD_CLIENTE 
			  where b.id_boleto = $id_boleto ";
	$lista_Boleto = mysqli_query($conexao,$sqlBol);
	while ($array = mysqli_fetch_array($lista_Boleto)){
		$valorTotal= $array['VALOR_BOLETO'];
		$mesReferente= $array['PERIODO_BOLETO'];
		$cod_vendedor= $array['COD_VENDEDOR'];
		$nome_vendedor= $array['NOME_CLIENTE'];
	}
	switch ($mesReferente) {
		case "01":    
		$periodo_de = $ano.'-01-01';
		$periodo_final = $ano.'-01-31';

		break;
		case "02":    
		$periodo_de = $ano.'-02-01';
		$periodo_final = $ano.'-02-28'; 
		break;
		case "03":    
		$periodo_de = $ano.'-03-01';
		$periodo_final = $ano.'-03-31';       
		break;
		case "04":    
		$periodo_de = $ano.'-04-01';
		$periodo_final = $ano.'-04-30';        
		break;
		case "05":    
		$periodo_de = $ano.'-05-01';
		$periodo_final = $ano.'-05-31';        
		break;
		case "06":    
		$periodo_de = $ano.'-06-01';
		$periodo_final = $ano.'-06-30';   
		break;
		case "07":    
		$periodo_de = $ano.'-07-01';
		$periodo_final = $ano.'-07-31';      
		break;
		case "08":    
		$periodo_de = $ano.'-08-01';
		$periodo_final = $ano.'-08-31';   
		break;
		case "09":    
		$periodo_de = $ano.'-09-01';
		$periodo_final = $ano.'-09-30';    
		break;
		case "10":    
		$periodo_de = $ano.'-10-01';
		$periodo_final = $ano.'-10-31';    
		break;
		case "11":    
		$periodo_de = $ano.'-11-01';
		$periodo_final = $ano.'-11-30';    
		break;
		case "12":    
		$periodo_de = $ano.'-12-01';
		$periodo_final = $ano.'-12-31';   
		break;
	}

	$html = '<table style="width:100%"';	
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<th style="text-align:left">Nº pedido</th>';
	$html .= '<th style="text-align:left">Valor Total</th>';
	$html .= '<th style="text-align:left">Data</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	
	
	$result_transacoes = "select distinct(p.ID_PEDIDO_VENDEDOR), p.VALOR_PEDIDO, p.DT_PEDIDO from pedido_vendedor p 
	where p.COD_VENDEDOR = $cod_vendedor
	and p.cod_cliente = $cod_usuario
	and p.STATUS_PEDIDO = 'A'
	and p.DT_PEDIDO BETWEEN '$periodo_de 00:00:01' and '$periodo_final 23:59:59'";
	$resultado_trasacoes = mysqli_query($conexao, $result_transacoes);
	while($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)){
		$html .= '<tr><td>'.$row_transacoes['ID_PEDIDO_VENDEDOR'] . "</td>";
		$html .= '<td>'.number_format($row_transacoes['VALOR_PEDIDO'],2,",",".") . "</td>";
		$html .= '<td>'.date('d/m/Y',strtotime($row_transacoes['DT_PEDIDO'])) . "</td></tr>";		
	}
	$html .= '</tbody>';
	$html .= '</table';
	$html .= '<br>';
	$html .= '<hr>';
		$html .= '<div style="border:1px solid black; width:200px;padding:-13px">';
	$html .= '<h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor Total: R$ '.number_format($valorTotal,2,",",".").' </h4>';
	$html .= '</div>';

		//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Carrega seu HTML
	$dompdf->load_html('
			
			<h2 style="text-align: center;">Detalhamento do boleto</h2>
			<hr>
			<h6 style="text-align: center;">( Período do boleto: 01/05/2020 até 31/05/2020 )</h6>
			<h4>Vendedor: '.$nome_vendedor.'</h4>
			'.$html.'
	');

	ob_clean();
	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"boleto", 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>