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

		$FW_tabela = "notas";											//	NOME DA TABELA DO BANCO DE DADOS
		$FW_tipoform = "post";												//	METODO DE ENVIO POST OU GET

		// VETOR COM OS NOMES DAS COLUNAS DA TABELA E OS RESPECTIVOS CAMPOS
		global $start;
		include_once(FW_PATH_SERV . FW_RAIZ. FW_VIEWS . $start->_controller ."/blocks/cabCampo.php");	//	INCLUI O ARQUIVO COM CABEÇALHOS E CAMPOS

		// PARA EXCLUIR ALGUM CAMPO DA EDIÇÃO DO FORMULÁRIO
		$excluir = array();
		$excluir = array("id","mediaDisciplina");	//	por padrao deve ser excluído
		$FW_campos = $start->ExcluirCampo($FW_campos, $excluir );
		
		// PARA INCLUIR ALGUM CAMPO USE:
		//  $incluir = array (	"OBS" => "obs");
		
		// $FW_campos = $start->IncluirCampo($FW_campos, $incluir );
		
	//	ESPECIFICAÇÃO DOS ATRIBUTOS DE LEITURA DO CAMPO => PADRAO type="text" size="65" maxlength="60"
	// ATENÇÃO: o primeiro parametro a ser personalizado é o tipo (type) - NÃO USE ESPACOS ANTES DE TYPE!!!
	
// RELACIONAMENTOS DO FORMULARIO:

		$alunos = new alunosModel();				//	para acessar o modelo de alunos
		$disciplinas = new disciplinasModel();	//	para acessar o modelo de disciplinas
		
		// Alunos:
		$lista_alunos = $alunos->listaalunos(null, null, null, 'id ASC');
		$CampoAlunoId = $this->DevolveSelect("aluno_id", $lista_alunos, array("id","aluno"));

		// Disciplinas:
		$lista_disciplinas = $disciplinas->listadisciplinas(null, null, null, 'id ASC');
		$CampoDisciplinaId = $this->DevolveSelect("disciplina_id", $lista_disciplinas, array("id","disciplina"));

	if ($view_tipo == '1') { // inclusao
		//	alimenta o formulario com dados das disciplinas e alunos.
		$FW_formato = array(
				"aluno_id" => $CampoAlunoId, 
				"disciplina_id" => $CampoDisciplinaId
		);					
	} else {	//	 alteracao
		// Na alteracao os campos nomes de alunos e disciplina não podem ser alterados...
		$CampoAluno = $this->alunos->alunosShow("id= ". $view_show_registro[0]['aluno_id']);
		$CampoDisciplina = $this->disciplinas->disciplinasShow("id= ". $view_show_registro[0]['disciplina_id']);
			$FW_formato = array(	
				"aluno_id" => '<input type="text" readonly="readonly" id="aluno_id" name="aluno_id" size="10" maxlength="10" value="'.$view_show_registro[0]['aluno_id'].'">'
								. " - " . $CampoAluno[0]['aluno'],
				"disciplina_id" => '<input type="text" readonly="readonly" id="disciplina_id" name="disciplina_id" size="10" maxlength="10" value="'.$view_show_registro[0]['disciplina_id'].'">'
								. " - " . $CampoDisciplina[0]['disciplina']
			);				
	}
		// $FW_formato = array();						
		
//	==================================================================================================================================================		
	include_once(FW_PATH_SERV . FW_SCAF_FORM . "scafForm.php");		//	CHAMA O SCAFFOLDING PARA FAZER O FORMULARIO.
?>