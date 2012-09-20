<?php
/*
|===========================================================================|
|	CONTROLADOR DO CADASTRO ALUNOS												|
|===========================================================================|
|																			|
|	VERSГO:								1.0.0								|
|	 																		|	
|===========================================================================|
*/
Class alunos extends Controller {
	
	private $alunos;			//	ATRIBUTO PARA INSTANCIAR O MODELO DE DADOS
	private $notas;			//	ATRIBUTO PARA INSTANCIAR O MODELO DE DADOS
	private $datas;				//  VETOR COM PARAMETRO PARA AS VIEWS
	// private $emprestimos;
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 001: [ PUBLIC FUNCTION INIT ]
	# ESTE METODO Й RESPONSБVEL POR INSTANCIAR O MODELO DE DADOS
	# ---------------------------------------------------------------------------------------------------------------------------------
		public function init() {					
			$this->alunos = new alunosModel();	
			$this->notas = new notasModel();	//	para relacionamento
			$this->datas['redir'] = $this->redirecionaPath();		//	RETORNA PACOTE E CONTROLADOR			
		}	
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 002: [ PUBLIC FUNCTION INDEX_ACTION ]
	# ESTA ACAO CHAMA UM METODO DA CLASSE MODEL PARA LISTAR TODOS OS REGISTROS
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function index_action() {	//	LISTAGEM DE TODOS OS REGISTROS OU DE ACORDO COM O FILTRO DE PESQUISA
		global $start;
		
		$this->LimpaFormulario("alunos");	//	limpa o formulario e sessao de erros...

		$numreg = 20;	//	numero de registros por pбgina

		// Lendo o parametro de paginacao	
		$pag = $this->getParam('pag');
		if ($pag == null) {
			$pag = 1;
		}
		
		if ( isset($_POST['fw_pesquisar']) and !empty($_POST['fw_pesquisar']) ) {

			 $vetor = $this->verificaPesquisa();	//	Verifica o tipo de pesquisa
			 $campo = $vetor[0];
			 $op = $vetor[1];

			$this->datas['lista_registros'] = $this->alunos->listaalunos(" `{$campo}` " . $op);	
			$totreg = count($this->datas['lista_registros']);	//	Total de registros com filtro

			$this->datas['lista_registros'] = $this->alunos->listaalunos(" `{$campo}` " . $op,$numreg,($pag-1)*$numreg);	//	Pesquisa com condiзгo
		} else {
			$this->datas['lista_registros'] = $this->alunos->listaalunos();
			$totreg = count($this->datas['lista_registros']); // total de registros 
		
			$this->datas['lista_registros'] = $this->alunos->listaalunos(null,$numreg,($pag-1)*$numreg);						//	Passa o resultado para o vetor $datas
		}
		
		$this->datas['numreg'] = $numreg;	//	nъmero de registros por pбgina
		$this->datas['pag'] = $pag;			//	nъmero da pбgina corrente
		$this->datas['totreg'] = $totreg;	//	total de pбginas com registros.
		
		$this->view('index', $this->datas);						//	Chama a View...
	}

	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 003: [ PUBLIC FUNCTION CONSULTAR ]
	# ESTA ACAO CHAMA UM METODO DA CLASSE MODEL PARA LISTAR UM ЪNICO REGISTRO.
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function consultar() {			//	CONSULTANDO UM REGISTRO!!!
		$id = $this->getParam('id');		//	Pega parametro na classe System
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->alunos->alunosShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
		$this->datas['tipo'] = '1';								// TIPO 1 = CONSULTA
		
		$this->view('consultar_excluir', $this->datas);
	}
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 004: [ PUBLIC FUNCTION EXCLUIR ]
	# ESTA ACAO PERMITE EXCLUIR UM REGISTRO
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function excluir() {						//	EXCLUINDO REGISTRO!!!
		$id = $this->getParam('id');				//	Pega parametro na classe System
		$confirma = $this->getParam('confirma');	//	Pega parametro na classe System
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->alunos->alunosShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
		$this->datas['tipo'] = '2';					// TIPO 2 = EXCLUSГO
		
		// nao deixa excluir aluno jб tem notas castradas...
		if (count($this->notas->notasShow("aluno_id = ".$id)) != 0) {
			$this->view('aviso_excluir', $this->datas);
			return;
		}
		
		if ($confirma == "sim") {
			$this->alunos->delete('id ='.$id);
			$this->redirecionar_pagina_inicial();	
		} else {
			$this->view('consultar_excluir', $this->datas);
		}	
	}

	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 005: [ PUBLIC FUNCTION INCLUIR ]
	# ESTA ACAO PERMITE INCLUIR UM REGISTRO
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function incluir() {						//	INCLUINDO UM REGISTRO!!!
		global $start;
		$confirma = $this->getParam('confirma');	//	Pega parametro na classe System
		
		$this->datas['tipo'] = '1';					// Inclusao

		// Aqui temos a confirmaзгo de exclusao
		if ($confirma == "sim") {
			$form = array();
			$form = $this->retorna_formulario($this->alunos->_tabela);	//	Lendo dados do formulario

			// validacao de dados	
			include_once(FW_PATH_SERV . FW_RAIZ. FW_VIEWS . $start->_controller ."/blocks/cabCampo.php");	//	INCLUI O ARQUIVO COM CABEЗALHOS E CAMPOS
			$campos = array_values($FW_campos);
			$this->datas['erros'] =  $this->alunos->ValidaDados($form,$campos);	//	validacao de dados...	
			
			if (count($this->datas['erros']) == 0) {		//	 se existem erros volta para o formulario
				$this->LimpaFormulario("alunos");	//	limpa o formulario e sessao de erros...					
				
				$this->alunos->insert($form);	//	grava dados
				$this->redirecionar_pagina_inicial();	//	 redireciona para pagina inicial do cadastro
			}else{
				$redireciona = new RedirectorLib();		
			    $redireciona->goToControllerAction($redireciona->GetCurrentController(), $redireciona->GetCurrentAction());		//	RETORNA PACOTE E CONTROLADOR			
			}		
		} else {
			$this->view('incluir_alterar', $this->datas);
		}	
	}

	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 006: [ PUBLIC FUNCTION ALTERAR ]
	# ESTA ACAO PERMITE ALTERAR UM REGISTRO
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function alterar() {		
	//	ALTERANDO REGISTRO!!!
		global $start;
	
		$id = $this->getParam('id');				//	Pega parametro na classe System
		$confirma = $this->getParam('confirma');	//	Pega parametro na classe System
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->alunos->alunosShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
		$this->datas['tipo'] = '2';						// Alteraзгo		
		
		// Confirmacao de alteracao
		if ($confirma == "sim") {
			$form = $this->retorna_formulario($this->alunos->_tabela);	//	Lendo dados do formulario
			
			include_once(FW_PATH_SERV . FW_RAIZ. FW_VIEWS . $start->_controller ."/blocks/cabCampo.php");	//	INCLUI O ARQUIVO COM CABEЗALHOS E CAMPOS
			$campos = array_values($FW_campos);
			$this->datas['erros'] =  $this->alunos->ValidaDados($form,$campos);	//	validacao de dados...	
			
			if (count($this->datas['erros']) == 0) {		//	 se existem erros volta para o formulario
				$this->LimpaFormulario("alunos");		//	limpa o formulario e sessao de erros...		
				$this->alunos->update( $form, "id=".$id) ;	//	 altera dados
				$this->redirecionar_pagina_inicial();		//	 redireciona para pagina inicial do cadastro
			}else{
				$redireciona = new RedirectorLib();		
				header("Location: ". FW_RAIZ . $redireciona->GetCurrentPackage() . "/" . $redireciona->GetCurrentController() . "/" . 
						$redireciona->GetCurrentAction() . "/id/" . $id );
			}
		} else {
			$this->view('incluir_alterar', $this->datas);
		}	
	}

} // FIM DA CLASSE -----------------------------------------------------------------------------------------------------------------------	
?>