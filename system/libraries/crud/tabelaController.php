<?php
/*
|===========================================================================|
|	CONTROLADOR DO CADASTRO 												|
|===========================================================================|
|																			|
|	VERSГO:								1.0.0								|
|	 																		|	
|===========================================================================|
*/
Class clientes extends Controller {
	
	private $clientes;			//	ATRIBUTO PARA INSTANCIAR O MODELO DE DADOS
	private $datas;				//  VETOR COM PARAMETRO PARA AS VIEWS
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 001: [ PUBLIC FUNCTION INIT ]
	# ESTE METODO Й RESPONSБVEL POR INSTANCIAR O MODELO DE DADOS
	# ---------------------------------------------------------------------------------------------------------------------------------
		public function init() {					
			$this->clientes = new clientesModel();	
			$this->datas['redir'] = $this->redirecionaPath();		//	RETORNA PACOTE E CONTROLADOR			
		}	
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 002: [ PUBLIC FUNCTION INDEX_ACTION ]
	# ESTA ACAO CHAMA UM METODO DA CLASSE MODEL PARA LISTAR TODOS OS REGISTROS
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function index_action() {	//	LISTAGEM DE TODOS OS REGISTROS OU DE ACORDO COM O FILTRO DE PESQUISA
		global $start;
		
		$numreg = 6;	//	numero de registros por pбgina

		// Lendo o parametro de paginacao	
		$pag = $this->getParam('pag');
		if ($pag == null) {
			$pag = 1;
		}
		
		if ( isset($_POST['fw_pesquisar']) and !empty($_POST['fw_pesquisar']) ) {

			 $vetor = $this->verificaPesquisa();	//	Verifica o tipo de pesquisa
			 $campo = $vetor[0];
			 $op = $vetor[1];

			$this->datas['lista_registros'] = $this->clientes->listaClientes(" `{$campo}` " . $op);	
			$totreg = count($this->datas['lista_registros']);	//	Total de registros com filtro

			$this->datas['lista_registros'] = $this->clientes->listaClientes(" `{$campo}` " . $op,$numreg,($pag-1)*$numreg);	//	Pesquisa com condiзгo
		} else {
			$this->datas['lista_registros'] = $this->clientes->listaClientes();
			$totreg = count($this->datas['lista_registros']); // total de registros 
		
			$this->datas['lista_registros'] = $this->clientes->listaClientes(null,$numreg,($pag-1)*$numreg);						//	Passa o resultado para o vetor $datas
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
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->clientes->ClienteShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
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
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->clientes->ClienteShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
		$this->datas['tipo'] = '2';					// TIPO 2 = EXCLUSГO
		
		if ($confirma == "sim") {
			$this->clientes->delete('id ='.$id);
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
		$confirma = $this->getParam('confirma');	//	Pega parametro na classe System
		
		$this->datas['tipo'] = '1';					// Inclusao

		if ($confirma == "sim") {
			$this->clientes->insert($this->retorna_formulario($this->clientes->_tabela));
			$this->redirecionar_pagina_inicial();	
		} else {
			$this->view('incluir_alterar', $this->datas);
		}	
	}

	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 006: [ PUBLIC FUNCTION ALTERAR ]
	# ESTA ACAO PERMITE ALTERAR UM REGISTRO
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function alterar() {						//	ALTERANDO REGISTRO!!!
		$id = $this->getParam('id');				//	Pega parametro na classe System
		$confirma = $this->getParam('confirma');	//	Pega parametro na classe System
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->clientes->ClienteShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
		$this->datas['tipo'] = '2';						// Alteraзгo		
		
		if ($confirma == "sim") {
			$this->clientes->update( $this->retorna_formulario($this->clientes->_tabela), "id=".$id) ;
			$this->redirecionar_pagina_inicial();	
		} else {
			$this->view('incluir_alterar', $this->datas);
		}	
	}

} // FIM DA CLASSE -----------------------------------------------------------------------------------------------------------------------	
?>