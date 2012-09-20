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

<style type="text/css">
   .tip{
      background-color: #FFF5EE;
      padding: 5px;
      display: none;
      position: absolute;
   }
</style>

<script>
$(document).ready(function(){
   $("#elemento1").mouseenter(function(e){
      $("#tip1").css("left", e.pageX + 5);
      $("#tip1").css("top", e.pageY + 5);
      $("#tip1").css("display", "block");
   });
   $("#elemento1").mouseleave(function(e){
      $("#tip1").css("display", "none");
   });
   
   $("#elemento2").mouseenter(function(e){
      $("#tip2").css("left", e.pageX + 5);
      $("#tip2").css("top", e.pageY + 5);
      $("#tip2").css("display", "block");
   });
   $("#elemento2").mouseleave(function(e){
      $("#tip2").css("display", "none");
   });
   
    $("#elemento3").mouseenter(function(e){
      $("#tip3").css("left", e.pageX + 5);
      $("#tip3").css("top", e.pageY + 5);
      $("#tip3").css("display", "block");
   });
   $("#elemento3").mouseleave(function(e){
      $("#tip3").css("display", "none");
   });
   
    $("#elemento4").mouseenter(function(e){
      $("#tip4").css("left", e.pageX + 5);
      $("#tip4").css("top", e.pageY + 5);
      $("#tip4").css("display", "block");
   });
   $("#elemento4").mouseleave(function(e){
      $("#tip4").css("display", "none");
   });
   
    $("#elemento5").mouseenter(function(e){
      $("#tip5").css("left", e.pageX + 5);
      $("#tip5").css("top", e.pageY + 5);
      $("#tip5").css("display", "block");
   });
   $("#elemento5").mouseleave(function(e){
      $("#tip5").css("display", "none");
   });
   
    $("#elemento6").mouseenter(function(e){
      $("#tip6").css("left", e.pageX + 5);
      $("#tip6").css("top", e.pageY + 5);
      $("#tip6").css("display", "block");
   });
   $("#elemento6").mouseleave(function(e){
      $("#tip6").css("display", "none");
   });
})
</script>

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
		echo "<center><br><br>";

		// Mensagens dos botoes de navegação:
		echo '<div class="tip" id="tip1">Pagina inicial</div>';
		echo '<div class="tip" id="tip2">Proxima Pagina</div>';		
		echo '<div class="tip" id="tip3">+ 10 Paginas</div>';		
		echo '<div class="tip" id="tip4">- 10 Paginas</div>';				
		echo '<div class="tip" id="tip5">Pagina anterior</div>';		
		echo '<div class="tip" id="tip6">Ultima Pagina</div>';		
		
		// Vai para a página inicial:
		
        echo "<a href=".$path."1 class=pg><img src=" . FW_SCAF_IMAGE . "nav_inicio.png width=70 height=70 border=0 id=elemento1></a>";
		echo "&nbsp&nbsp";
		
		// Vai para a próxima página:
		$pg2 = $pag+1;
		if ($pg2 > $tot ) {
			$pg2 = $tot;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_proxima.png width=70 height=70 border=0 id=elemento2></a>";
		echo "&nbsp&nbsp";
		
		// Avança 10 páginas:
		$pg2 = $pag+10;
		if ($pg2 > $tot ) {
			$pg2 = $tot;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_mais10.png width=70 height=70 border=0 id=elemento3></a>";
		echo "&nbsp&nbsp";
		
		// Volta 10 páginas:
		$pg2 = $pag-10;
		if ($pg2 < 1 ) {
			$pg2 = 1;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_menos10.png width=70 height=70 border=0 id=elemento4></a>";
		echo "&nbsp&nbsp";        

		// Vai para a página anterior:
		$pg2 = $pag-1;
		if ($pg2 < 1 ) {
			$pg2 = 1;
		}
		echo "<a href=".$path."$pg2 class=pg><img src=" . FW_SCAF_IMAGE . "nav_anterior.png width=70 height=70 border=0 id=elemento5></a>";
		echo "&nbsp&nbsp";		
		
		// Vai para a final:
		echo "<a href=".$path."$tot class=pg><img src=" . FW_SCAF_IMAGE . "nav_fim.png width=70 height=70 border=0 id=elemento6> </a>";
		echo "<br></center>";
?>