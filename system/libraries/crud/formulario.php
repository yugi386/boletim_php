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

		$FW_tabela = "clientes";											//	NOME DA TABELA DO BANCO DE DADOS
		$FW_tipoform = "post";												//	METODO DE ENVIO POST OU GET

		// VETOR COM OS NOMES DAS COLUNAS DA TABELA E OS RESPECTIVOS CAMPOS
		global $start;
		include_once(FW_PATH_SERV . FW_RAIZ. FW_VIEWS . $start->_controller ."/blocks/cabCampo.php");	//	INCLUI O ARQUIVO COM CABEÇALHOS E CAMPOS

		// PARA EXCLUIR ALGUM CAMPO DA EDIÇÃO DO FORMULÁRIO
		$excluir = array();
		$excluir = array("id");	//	por padrao deve ser excluído
		$FW_campos = $start->ExcluirCampo($FW_campos, $excluir );
		
		// PARA INCLUIR ALGUM CAMPO USE:
		$incluir = array (	"OBS" => "obs"
					);
		
		// $FW_campos = $start->IncluirCampo($FW_campos, $incluir );
		
	//	ESPECIFICAÇÃO DOS ATRIBUTOS DE LEITURA DO CAMPO => PADRAO type="text" size="65" maxlength="60"
	// ATENÇÃO: o primeiro parametro a ser personalizado é o tipo (type) - NÃO USE ESPACOS ANTES DE TYPE!!!

		$FW_formato = array(	"text1" 			=> 'type="text" size="10" maxlength="5"',
								"carro" 			=> 'type="checkbox"',
								"sexo"				=> '<input type="radio" id="sexo" name="sexo" value="M"  checked> Masculino <br> 
														<input type="radio" id="sexo" name="sexo" value="F"> Feminino' ,
								"tipocar"			=> '<select name="tipocar" id="tipocar">
														<option value="volvo">Volvo
														<option value="saab" selected>Saab
														<option value="fiat">Fiat
														<option value="audi">Audi
														</select>',					
								"obs"				=> '<textarea rows="10" cols="50">
														</textarea>',
								"senha"				=> '<input type="password" id="pw" name="pw" size="25" maxlength="20">'		
							);

		$FW_formato = array();						
		
//	==================================================================================================================================================		
	include_once(FW_PATH_SERV . FW_SCAF_FORM . "scafForm.php");		//	CHAMA O SCAFFOLDING PARA FAZER O FORMULARIO.
?>