<?php
	/*
		BLOCK: TABLE REG SHOW
		APRESENTA DADOS DE UM REGISTRO EM UMA TABELA
		PARAMETROS:
		1 - FW_cab   = ARRAY COM OS CABECALHOS DAS COLUNAS
		2 - FW_registro = ARRAY CONTENDO O REGISTRO DA TABELA...
	*/
	
// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	if (!defined('FW_RAIZ'))
		die("ERRO DE REDIRECIONAMENTO");
	include_once($_SERVER["DOCUMENT_ROOT"]  . FW_RAIZ . "system/checkBlock.php");
	
	$FW_registro = $view_show_registro ;							//	DADOS VINDO DA TABELA DO BANCO (REGISTRO DO CLIENTE)	
?>
	<?php 
		$FW_rotulo = array_keys($FW_cab);	// CABEÇALHOS DA TABELA
		$FW_campo = array_values($FW_cab);	// CAMPOS DA TABELA
		$cor1 = "#F5F5F5";
		$cor2 = "#FFFFFF";
		
		$form = new formLib();								//	classe de formularios
		$campos = $form->Retorna_Campos($FW_tabela);		//	retona campo da tabela, tipo e tamanho
	?>

	<TABLE cellspacing="0">
		<?php for($ct=0;$ct<count($FW_cab);$ct++) { ?>	
			<?php
				if ($ct % 2 == 0) {
					$cor = $cor1;
				} else {
					$cor = $cor2;
				}	
			?>	
			<div class="post">
				<TR bgcolor="<?php echo $cor;?>"  VALIGN=TOP> 
					<td width="50%"> <h3><b> <?php echo $FW_rotulo[$ct].": "; ?> </b></h3> </td> 
					<TD><h3 class="title"> <?php // echo $FW_registro[0][$FW_campo[$ct]]; ?> </h3></TD>
					<TD><h3 class="title"> <?php echo $this->textTransform2($FW_campo[$ct], $FW_registro[0][$FW_campo[$ct]], $campos); ?> </h3></TD>
				</TR>
			</div>
		<?php } ?>
	</TABLE>