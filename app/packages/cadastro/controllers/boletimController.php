<?php
/*
|===========================================================================|
|	CONTROLADOR DO CADASTRO BOLETIM												|
|===========================================================================|
|																			|
|	VERSÃO:								1.0.0								|
|	 																		|	
|===========================================================================|
*/
Class boletim extends Controller {
	
	private $boletim;		//	ATRIBUTO PARA INSTANCIAR O MODELO DE DADOS
	private $notas;			//	ATRIBUTO PARA INSTANCIAR O MODELO DE DADOS	
	private $alunos;		//	ATRIBUTO PARA INSTANCIAR O MODELO DE DADOS		
	private $datas;			//  VETOR COM PARAMETRO PARA AS VIEWS
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 001: [ PUBLIC FUNCTION INIT ]
	# ESTE METODO É RESPONSÁVEL POR INSTANCIAR O MODELO DE DADOS
	# ---------------------------------------------------------------------------------------------------------------------------------
		public function init() {					
			$this->boletim = new boletimModel();	
			$this->notas = new notasModel();	//	para relacionamento com notas
			$this->alunos = new alunosModel();	//	para relacionamento com alunos
			$this->datas['redir'] = $this->redirecionaPath();		//	RETORNA PACOTE E CONTROLADOR			
		}	
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 002: [ PUBLIC FUNCTION INDEX_ACTION ]
	# ESTA ACAO CHAMA UM METODO DA CLASSE MODEL PARA LISTAR TODOS OS REGISTROS
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function index_action() {	//	LISTAGEM DE TODOS OS REGISTROS OU DE ACORDO COM O FILTRO DE PESQUISA
		global $start;
		
		$this->LimpaFormulario("boletim");	//	limpa o formulario e sessao de erros...

		$numreg = 20;	//	numero de registros por página

		// Lendo o parametro de paginacao	
		$pag = $this->getParam('pag');
		if ($pag == null) {
			$pag = 1;
		}
		
		if ( isset($_POST['fw_pesquisar']) and !empty($_POST['fw_pesquisar']) ) {

			 $vetor = $this->verificaPesquisa();	//	Verifica o tipo de pesquisa
			 $campo = $vetor[0];
			 $op = $vetor[1];

			$this->datas['lista_registros'] = $this->boletim->listaboletim(" `{$campo}` " . $op);	
			$totreg = count($this->datas['lista_registros']);	//	Total de registros com filtro

			$this->datas['lista_registros'] = $this->boletim->listaboletim(" `{$campo}` " . $op,$numreg,($pag-1)*$numreg);	//	Pesquisa com condição
		} else {
			$this->datas['lista_registros'] = $this->boletim->listaboletim();
			$totreg = count($this->datas['lista_registros']); // total de registros 
		
			$this->datas['lista_registros'] = $this->boletim->listaboletim(null,$numreg,($pag-1)*$numreg);						//	Passa o resultado para o vetor $datas
		}
		
		$this->datas['numreg'] = $numreg;	//	número de registros por página
		$this->datas['pag'] = $pag;			//	número da página corrente
		$this->datas['totreg'] = $totreg;	//	total de páginas com registros.
		
		$this->view('index', $this->datas);						//	Chama a View...
	}

	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 003: [ PUBLIC FUNCTION CONSULTAR ]
	# ESTA ACAO CHAMA UM METODO DA CLASSE MODEL PARA LISTAR UM ÚNICO REGISTRO.
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function consultar() {			//	CONSULTANDO UM REGISTRO!!!
		$id = $this->getParam('id');		//	Pega parametro na classe System
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->boletim->boletimShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
		
		// Notas referentes ao aluno (por disciplinas)
		$this->datas['disciplinas'] = $this->notas->notasShow("aluno_id=".$this->datas['show_registro'][0]['aluno_id']);		
		
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
		
		$this->datas['show_registro'] = $this->verificaRegistro($id, $this->boletim->boletimShow("id=".$id));	//	VERIFICA SE O REGISTRO EXISTE!!!
		$this->datas['tipo'] = '2';					// TIPO 2 = EXCLUSÃO
		// Notas referentes ao aluno (por disciplinas)
		$this->datas['disciplinas'] = $this->notas->notasShow("aluno_id=".$this->datas['show_registro'][0]['aluno_id']);		
		
		if ($confirma == "sim") {
			$this->boletim->delete('id ='.$id);
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

		if ($confirma == "sim") {
			$form = array();
			$form = $this->retorna_formulario($this->boletim->_tabela);	//	Lendo dados do formulario
			
			include_once(FW_PATH_SERV . FW_RAIZ. FW_VIEWS . $start->_controller ."/blocks/cabCampo.php");	//	INCLUI O ARQUIVO COM CABEÇALHOS E CAMPOS
			$campos = array_values($FW_campos);
			$this->datas['erros'] =  $this->boletim->ValidaDados($form,$campos);	//	validacao de dados...	
			
			// verifica se o aluno esta incluido naquela disciplina:
			// em caso positivo nao deixa incluir
			$id = $this->boletim->listaboletim("aluno_id=".$form['aluno_id']);
			if (count($id) != 0) {			
				$this->LimpaFormulario("boletim");			//	limpa o formulario e sessao de erros...					
				$this->datas['show_registro'] = $this->verificaRegistro($id[0]["id"], $this->boletim->boletimShow("id=".$id[0]["id"]));
				$this->view('aviso_aluno_cadastrado', $this->datas);
				return;
			}
			
			if (count($this->datas['erros']) == 0) {		//	 se existem erros volta para o formulario
				$this->LimpaFormulario("boletim");			//	limpa o formulario e sessao de erros...					
				
				$this->boletim->insert($form);		//	GRAVA BOLETIM
				$reg = $this->boletim->ver_id("boletim");	//	id inserido na tabela boletim...
				$this->calculaMedia($form,$reg);	//	passa o formulario e o numero do registro para calcular a media...
				
				$this->redirecionar_pagina_inicial();	
			}else{
				$redireciona = new RedirectorLib();		
			    $redireciona->goToControllerAction($redireciona->GetCurrentController(), $redireciona->GetCurrentAction());		//	RETORNA PACOTE E CONTROLADOR			
			}		
		} else {
			$this->view('incluir_alterar', $this->datas);
		}	
	}

	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 006 [ PUBLIC FUNCTION calcularMedia ]
	# ESTA ACAO PERMITE Calcular a media final do aluno.
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function calculaMedia($form,$id) {	// recebe como parametro o formulario do registro.
		
		// Notas referentes ao aluno
		$lista_media = $this->notas->notasShow("aluno_id=".$form["aluno_id"]);
		
		// Calculando média final:
		$total = 0;

		// somando as medias das disciplinas	
		for ($ct=0;$ct<count($lista_media);$ct++){
			$total = $total + (float)$lista_media[$ct]["mediaDisciplina"];
		}
		$total = $total / count($lista_media);	//	 média final
		
		$form["mediaFinal"] = $total;	//	colocando media final no formulario
		$this->boletim->update($form, "id=".$id);	//	altera a media final

		return;	
	}
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 007 [ PUBLIC FUNCTION calcularMedia ]
	# ESTA ACAO PERMITE Recalcular as notas de todos os alunos
	# ---------------------------------------------------------------------------------------------------------------------------------
	public function recalcular() {	// recebe como parametro o formulario do registro.
		$boletim = $this->boletim->listaboletim();	//	lista de boletins...

		// varrendo todos os boletins
		$form = Array();

		for ($ct=0;$ct<count($boletim);$ct++){
			$form["id"] = $boletim[$ct]["id"];
			$form["aluno_id"] = $boletim[$ct]["aluno_id"];
			$form["mediaFinal"] = $boletim[$ct]["mediaFinal"];
			$this->calculaMedia($form,$form["id"]);	//	recalcula a media final para o registro corrente
		}

		$this->redirecionar_pagina_inicial();	
		return;
	}
	
} // FIM DA CLASSE -----------------------------------------------------------------------------------------------------------------------	
?>