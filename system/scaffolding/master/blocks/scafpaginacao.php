<?php
	/*
		SCAFPAGINACAO:
		FAZ A PAGINACAO DE NA TELA INICIAL DO CADASTRO
	*/
	
// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	if (!defined('FW_RAIZ'))
		die("ERRO DE REDIRECIONAMENTO");
	include_once($_SERVER["DOCUMENT_ROOT"]  . FW_RAIZ . "system/checkBlock.php");
?>

<?php

		$path = FW_RAIZ . $view_redir . "index/pag/";
		$pag = $view_pag;	//	Página corrente.
		if ($view_totreg > $view_numreg) {
			$tot = ceil($view_totreg / $view_numreg);
		} else {	
			$tot = 1;
		}

		echo "<br>";
		echo "<b>Total de Registros: ".$view_totreg."</b>";
		echo "<br><br>";

		// Vai para a página inicial:
        echo "<a href=".$path."1 class=pg><img src=" . FW_SCAF_IMAGE . "nav_inicio.png width=100 height=40 border=0></a>";

		// Vai para a próxima página:
		$pg2 = $pag+1;
		if ($pg2 > $tot ) {
			$pg2 = $tot;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_proxima.png width=100 height=40 border=0></a>";

		// Avança 10 páginas:
		$pg2 = $pag+10;
		if ($pg2 > $tot ) {
			$pg2 = $tot;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_mais10.png width=100 height=40 border=0></a>";

		// Volta 10 páginas:
		$pg2 = $pag-10;
		if ($pg2 < 1 ) {
			$pg2 = 1;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_menos10.png width=100 height=40 border=0></a>";
        
		// Vai para a página anterior:
		$pg2 = $pag-1;
		if ($pg2 < 1 ) {
			$pg2 = 1;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_anterior.png width=100 height=40 border=0></a>";
		
		// Vai para a final:
		echo "<a href=".$path."$tot class=pg><img src=" . FW_SCAF_IMAGE . "nav_fim.png width=100 height=40 border=0></a>";
		echo "<br>";
?>