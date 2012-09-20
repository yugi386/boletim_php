<?php 
// ==================================================================
// FORMULARIO DE PESQUISA GENÉRICO PARA TODOS OS CADASTROS
// ==================================================================	
	
// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	if (!defined('FW_RAIZ'))
		die("ERRO DE REDIRECIONAMENTO");
	include_once($_SERVER["DOCUMENT_ROOT"]  . FW_RAIZ . "system/checkBlock.php");
	
	// =====================================================
	
	$pesq = "";
	if( isset($_POST['fw_pesquisar']) ) {		// Aqui verificamos se houve algum filtro de pesquisa
		$pesq = $_POST['fw_pesquisar'];
	}	
	
	$relac = "1";
	if( isset($_POST['fw_relacional']) ) {		// Aqui verificamos se houve mudança na ligação relacional
		$relac = $_POST['fw_relacional'];
	}	
	
	$campo = "id";
	if( isset($_POST['fw_campo']) ) {		// Aqui verificamos o campo foco da pesquisa
		$campo = $_POST['fw_campo'];
	}	
	
	// GERENCIANDO O SELECT DO CAMPO DE BUSCA:
	$cab = array_keys($FW_scaf);
	$campos = array_values($FW_scaf);
	$limit = count($FW_scaf);
	
	$stringOpc = '<select name="fw_campo" id="fw_campo">';
	for ($i=0;$i<$limit;$i++){
		if ($campo == $campos[$i]) {
			$stringOpc = $stringOpc . '<option value="' . $campos[$i] . '" selected>' . $cab[$i] ."<br>";
		} else {
			$stringOpc = $stringOpc . '<option value="' . $campos[$i] . '">' . $cab[$i] ."<br>";		
		}
	}
	$stringOpc .= '</select>';
?>

<form method="post" action="<?php echo FW_RAIZ . $view_redir ;?>index" id="frm-filtro">
	<p>
		<label for="pesquisar">Pesquisar:</label>
		<input type="text" id="fw_pesquisar" name="fw_pesquisar" size="25" value="<?php echo $pesq; ?>" />		
		&nbsp;&nbsp;&nbsp;
		<select name="fw_relacional" id="fw_relacional">
			<?php if ($relac == "1") { ?>
				<option value="1" selected>CONTIDO EM 
			<?php } else { ?>
				<option value="1">CONTIDO EM 
			<?php } ?>		
				
			<?php if ($relac == "2") { ?>
				<option value="2" selected>AUSENTE EM
			<?php } else { ?>	
				<option value="2">AUSENTE EM
			<?php } ?>		
			
			<?php if ($relac == "3") { ?>
				<option value="3" selected>IGUAL A
			<?php } else { ?>	
				<option value="3">IGUAL A
			<?php } ?>		
			
			<?php if ($relac == "4") { ?>
				<option value="4" selected>DIFERENTE DE
			<?php } else { ?>	
				<option value="4">DIFERENTE DE
			<?php } ?>		
			
			<?php if ($relac == "5") { ?>
				<option value="5" selected>MAIOR QUE
			<?php } else { ?>	
				<option value="5">MAIOR QUE
			<?php } ?>		
				
			<?php if ($relac == "6") { ?>				
				<option value="6" selected>MENOR QUE
			<?php } else { ?>				
				<option value="6">MENOR QUE
			<?php } ?>		
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo $stringOpc; ?>
	</p>
</form>