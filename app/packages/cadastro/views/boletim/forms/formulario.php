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

		$FW_tabela = "boletim";	//	NOME DA TABELA DO BANCO DE DADOS
		$FW_tipoform = "post";	//	METODO DE ENVIO POST OU GET

		// VETOR COM OS NOMES DAS COLUNAS DA TABELA E OS RESPECTIVOS CAMPOS
		global $start;
		include_once(FW_PATH_SERV . FW_RAIZ. FW_VIEWS . $start->_controller ."/blocks/cabCampo.php");	//	INCLUI O ARQUIVO COM CABEÇALHOS E CAMPOS

		// PARA EXCLUIR ALGUM CAMPO DA EDIÇÃO DO FORMULÁRIO
		$excluir = array();
		$excluir = array("id");	//	por padrao deve ser excluído
		$FW_campos = $start->ExcluirCampo($FW_campos, $excluir );
		
		// PARA INCLUIR ALGUM CAMPO USE:
		$incluir = array (	"OBS" => "obs");
		
		// $FW_campos = $start->IncluirCampo($FW_campos, $incluir );
		
	//	ESPECIFICAÇÃO DOS ATRIBUTOS DE LEITURA DO CAMPO => PADRAO type="text" size="65" maxlength="60"
	// RELACIONAMENTOS DO FORMULARIO:

		$alunos = new alunosModel();				//	para acessar o modelo de alunos
		// Alunos:
		$lista_alunos = $alunos->listaalunos(null, null, null, 'id ASC');
		$CampoAlunoId = $this->DevolveSelect("aluno_id", $lista_alunos, array("id","aluno"));

		//	alimenta o formulario com dados dos alunos...
		// média será preenchida automaticamente
		$FW_formato = array("aluno_id" => $CampoAlunoId,
							"mediaFinal" => '<input type="text" size="15" maxlength="10" readonly="yes">' . " - Média Preenchida Automaticamente");					
		
		// $FW_formato = array();						
		
//	==================================================================================================================================================		
	include_once(FW_PATH_SERV . FW_SCAF_FORM . "scafForm.php");		//	CHAMA O SCAFFOLDING PARA FAZER O FORMULARIO.
?>