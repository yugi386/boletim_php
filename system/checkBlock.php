<?php
	// =====================================================================	
	// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	global $start;			
	if ($start->Noblocks() == false) {
		die("ERRO DE REDIRECIONAMENTO!");
	}
	// =====================================================================
?>
