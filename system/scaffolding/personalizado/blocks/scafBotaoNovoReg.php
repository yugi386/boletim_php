<?php
/*
	BLOCK: BOTAO NOVO REG
	APRESENTA UMA BOTAO PARA INCLUIR UM NOVO REGISTRO
*/

// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	if (!defined('FW_RAIZ'))
		die("ERRO DE REDIRECIONAMENTO");
	include_once($_SERVER["DOCUMENT_ROOT"]  . FW_RAIZ . "system/checkBlock.php");
?>

<br><a href="<?php echo FW_RAIZ . $view_redir ;?>incluir"><img src="<?php echo FW_SCAF_IMAGE; ?>novo.png" width=180 height=64 border=0></a>