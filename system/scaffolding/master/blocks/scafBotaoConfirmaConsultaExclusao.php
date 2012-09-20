<?php
/*
	BLOCK: BOTAO CONFIRMA CONSULTA EXCLUSAO
	CONTROLANDO ACOES DE CONSULTA OU EXCLUSAO DE DADOS
*/
	// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	if (!defined('FW_RAIZ'))
		die("ERRO DE REDIRECIONAMENTO");
	include_once($_SERVER["DOCUMENT_ROOT"]  . FW_RAIZ . "system/checkBlock.php");
?>

	<?php if ($view_tipo == '1' ) { ?>
		<br><a href="<?php echo FW_RAIZ . $view_redir ;?>index"><img src="<?php echo FW_SCAF_IMAGE; ?>voltar.png" width=128 height=64 border=0></a>
	<?php } else if ($view_tipo == '2') { ?>
		<br><b><h2> Deseja excluir este registro? </h2></b><br>
			<a href="<?php echo FW_RAIZ  . $view_redir ;?>excluir/confirma/sim/id/<?php echo $FW_registro[0]['id']; ?>"><img src="<?php echo FW_SCAF_IMAGE;?>sim.png" width=128 height=64 border=0></a>
			<a href="<?php echo FW_RAIZ  . $view_redir ;?>index"><img src="<?php echo FW_SCAF_IMAGE; ?>nao.png" width=128 height=64 border=0></a>
	<?php } ?>