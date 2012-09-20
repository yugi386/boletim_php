<?php
	/*
		BLOCK: TABLE DISPLAY 
		APRESENTA DADOS DE UMA TABELA DO BANDO DE DADOS DE FORMA A POSSIBILITAR CONSULTA, ALTERAÇÃO E EXCLUSÃO
		PARAMETROS:
		1 - FW_cab   = ARRAY COM OS CABECALHOS DAS COLUNAS
		2 - FW_regisatros = ARRAY COM OS DADOS DO BANCO (registros)
	*/
	
// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	if (!defined('FW_RAIZ'))
		die("ERRO DE REDIRECIONAMENTO");
	include_once($_SERVER["DOCUMENT_ROOT"]  . FW_RAIZ . "system/checkBlock.php");
	
	$FW_registros = $view_lista_registros;									//	DADOS VINDO DA TABELA DO BANCO (REGISTROS)
?>

	<TABLE id="tab" cellspacing="0" class="sortable" VALIGN=TOP>
		<thead>
			<tr>
				<?php 
					$FW_rotulo = array_keys($FW_cab);	// CABEÇALHOS DA TABELA
					$FW_campos = array_values($FW_cab);	// CAMPOS DA TABELA
					foreach ($FW_rotulo as $cab ) { 	// CABEÇALHO DAS COLUNAS	
						echo "<TH>".$cab."</TH>";	
					}
				?>					

				<?php if (!isset($FW_excluir)) { ?>
					<th class="sorttable_nosort">Consultar</th>
					<th class="sorttable_nosort">Alterar</th>
					<th class="sorttable_nosort">Excluir</th> 
				<?php } else { ?>
					<?php
						if ($FW_excluir["consultar"] != "") {
							echo '<th class="sorttable_nosort">'. $FW_excluir["consultar"] .'</th>';
						}
						if ($FW_excluir["alterar"] != "") {
							echo '<th class="sorttable_nosort">'. $FW_excluir["alterar"] .'</th>';
						}
						if ($FW_excluir["excluir"] != "") {
							echo '<th class="sorttable_nosort">'. $FW_excluir["excluir"] .'</th>';
						}
					?>
				<?php } ?>
				
			</tr>	
		</thead>	
		<?php foreach ($FW_registros as $reg) : ?>	
			<div class="post">
				<TR class="celula" onMouseover="this.className='celulahover'" onMouseout="this.className='celula'"  VALIGN=TOP> 
					<?php
						foreach ($FW_campos as $campo ) { 	// NOME DOS CAMPOS DA TABELA
							echo '<TD>';
							echo $reg[$campo]; 
							echo "</TD>";
						}	
					?>

					<?php if (!isset($FW_excluir))  { ?>
						<td align=center><a href="<?php echo FW_RAIZ  . $view_redir ;?>consultar/id/<?php echo $reg['id'] ?>"><img src="<?php echo FW_SCAF_IMAGE; ?>icone_consultar.gif" width=30 height=30 border=0></a></td>
						<td align=center><a href="<?php echo FW_RAIZ  . $view_redir ;?>alterar/id/<?php echo $reg['id'] ?>"><img src="<?php echo FW_SCAF_IMAGE; ?>icone_alterar.png" width=30 height=30 border=0></a></td>
						<td align=center><a href="<?php echo FW_RAIZ  . $view_redir ;?>excluir/id/<?php echo $reg['id'] ?>"><img src="<?php echo FW_SCAF_IMAGE; ?>icone_excluir.gif" width=30 height=30 border=0></a></td>
					<?php
					} else {
						if ($FW_excluir["consultar"] != "") { ?>
							<td align=center><a href="<?php echo FW_RAIZ  . $view_redir ;?>consultar/id/<?php echo $reg['id'] ?>"><img src="<?php echo FW_SCAF_IMAGE; ?>icone_consultar.gif" width=30 height=30 border=0></a></td>
						<?php } ?>
						<?php if ($FW_excluir["alterar"] != "") { ?>
							<td align=center><a href="<?php echo FW_RAIZ  . $view_redir ;?>alterar/id/<?php echo $reg['id'] ?>"><img src="<?php echo FW_SCAF_IMAGE; ?>icone_alterar.png" width=30 height=30 border=0></a></td>
						<?php } ?>
						<?php if ($FW_excluir["excluir"] != "") { ?>
							<td align=center><a href="<?php echo FW_RAIZ  . $view_redir ;?>excluir/id/<?php echo $reg['id'] ?>"><img src="<?php echo FW_SCAF_IMAGE; ?>icone_excluir.gif" width=30 height=30 border=0></a></td>
						<?php } 
					}
					?>	
				</TR>
			</div>
		<?php endforeach; ?>
	</TABLE>