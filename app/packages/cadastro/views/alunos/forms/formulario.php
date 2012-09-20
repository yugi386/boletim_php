<?php /*	
==========================================================================	
|	GERADOR DE FORMULARIO PARA O CADASTRO
==========================================================================	
*/
// CODIGO PARA EVITAR EXECUCAO DE BLOCOS SEM PASSAR PELA PAGINA INICIAL
	if (!defined('FW_RAIZ'))
		die("ERRO DE REDIRECIONAMENTO");
	include_once($_SERVER["DOCUMENT_ROOT"]  . FW_RAIZ . "system/checkBlock.php");
	
//	==================================================================================================================================================

		$FW_tabela = "alunos";	//	NOME DA TABELA DO BANCO DE DADOS
		$FW_tipoform = "post";	//	METODO DE ENVIO POST OU GET

		// VETOR COM OS NOMES DAS COLUNAS DA TABELA E OS RESPECTIVOS CAMPOS
		global $start;
		include_once(FW_PATH_SERV . FW_RAIZ. FW_VIEWS . $start->_controller ."/blocks/cabCampo.php");	//	INCLUI O ARQUIVO COM CABEÇALHOS E CAMPOS

		// PARA EXCLUIR ALGUM CAMPO DA EDIÇÃO DO FORMULÁRIO
		$excluir = array();
		$excluir = array("id","mediaGeral");	//	por padrao deve ser excluído
		$FW_campos = $start->ExcluirCampo($FW_campos, $excluir );
		
		// PARA INCLUIR ALGUM CAMPO USE:
		$incluir = array (	"OBS" => "obs");
		
		// $FW_campos = $start->IncluirCampo($FW_campos, $incluir );
		
	//	ESPECIFICAÇÃO DOS ATRIBUTOS DE LEITURA DO CAMPO => PADRAO type="text" size="65" maxlength="60"
		$FW_formato = array(	
			"sexo"				=> '<select name="sexo" id="sexo">
									<option value="M" selected>Masculino
									<option value="F" >Feminino
									</select>',
			"estado" => '<select name="estado" id = "estado">
						<option value="AC" selected>Acre
						<option value="AL">Alagoas
						<option value="AP">Amapa
						<option value="AM">Amazonas
						<option value="BA">Bahia
						<option value="CE">Ceara
						<option value="DF">Distrito Federal
						<option value="ES">Espirito Santo
						<option value="GO">Goias
						<option value="MA">Maranhao
						<option value="MS">Mato Grosso do Sul
						<option value="MG">Minas Gerais
						<option value="PA">Para
						<option value="PB">Paraiba
						<option value="PR">Parana
						<option value="PE">Pernanbuco
						<option value="PI">Piaui
						<option value="RJ">Rio de Janeiro
						<option value="RN">Rio Grande do Norte
						<option value="RS">Rio Grande do Sul
						<option value="RO">Rondonia
						<option value="RR">Roraima
						<option value="SC">Santa Catarina
						<option value="SP">Sao Paulo
						<option value="SE">Sergipe
						<option value="TO">Tocantins
						</select>',
		);
		// $FW_formato = array();						
		
//	==================================================================================================================================================		
	include_once(FW_PATH_SERV . FW_SCAF_FORM . "scafForm.php");		//	CHAMA O SCAFFOLDING PARA FAZER O FORMULARIO.
?>