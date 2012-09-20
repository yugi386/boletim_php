<?php

// CLASSE PARA GERAR O CRUD DE UM CADASTRO FACILITANDO O DESENVOLVIMENTO 

	Class crudLib {
	
		private $caminho;

		private function init() {	//	iniciando Path
			$this->caminho = FW_PATH_SERV . FW_RAIZ . FW_LIBRARIES . "crud/";
		}
	 
	
	// ==========================================================================================
	//	METODO PARA GERAR CRUD COMPLETO
	// ==========================================================================================	
		public function GerarCadastro($tabela,$pacote) {
			$this->createController($tabela,$pacote);
			$this->createModel($tabela,$pacote);
			$this->createFormulario($tabela,$pacote);
			$this->createCrud($tabela,$pacote);	
		}
	 
	// -------------------------------------------------------------------------------------------------------		
	// METODO PARA GERAR O CONTROLADOR BASEADO NO MODELO.
	// PARAMETROS: $NOME_DA_TABELA = nome da tabela no banco de dados..., $pacote = pacote da classe
	// -------------------------------------------------------------------------------------------------------			
		private function createController($nome_da_tabela,$pacote){
			$this->init();
			$arq = $this->LerArq($this->caminho . "tabelaController.php");
			
			$this->CriarEstrutura($pacote,$nome_da_tabela);
			
			for($i = 0; $i < count($arq); $i++) {
				$arq[$i] = str_replace("this->clientes", "this->".$nome_da_tabela, $arq[$i]);	
				$arq[$i] = str_replace("clientesModel", $nome_da_tabela."Model", $arq[$i]);	
				$arq[$i] = str_replace("listaClientes", "lista".$nome_da_tabela, $arq[$i]);					
				$arq[$i] = str_replace("ClienteShow", $nome_da_tabela."Show", $arq[$i]);	
				$arq[$i] = str_replace("clienteShow", $nome_da_tabela."Show", $arq[$i]);													
				$arq[$i] = str_replace("Class clientes", "Class ".$nome_da_tabela, $arq[$i]);									
				$arq[$i] = str_replace("clientes", $nome_da_tabela, $arq[$i]);
			}
			
			// Gerenciando o caminho do controlador:
			$path = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/controllers/";
			$name = $path . $nome_da_tabela . "Controller.php";
			$this->CriarArq($name,$arq);
		}	
	
	// -------------------------------------------------------------------------------------------------------		
	// METODO PARA GERAR O MODELO DE DADOS (MODEL)
	// PARAMETROS: $NOME_DA_TABELA = nome da tabela no banco de dados..., $pacote = pacote da classe
	// -------------------------------------------------------------------------------------------------------			
		private function createModel($nome_da_tabela,$pacote){
			$this->CriarEstrutura($pacote,$nome_da_tabela);
			$this->init();
			$arq = $this->LerArq($this->caminho . "tabelaModel.php");
			for($i = 0; $i < count($arq); $i++) {
				$arq[$i] = str_replace("clientesModel", $nome_da_tabela."Model", $arq[$i]);	
				$arq[$i] = str_replace("listaClientes", "lista".$nome_da_tabela, $arq[$i]);					
				$arq[$i] = str_replace("ClienteShow", $nome_da_tabela."Show", $arq[$i]);					
				$arq[$i] = str_replace("clienteShow", $nome_da_tabela."Show", $arq[$i]);									
				$arq[$i] = str_replace("clientes", $nome_da_tabela, $arq[$i]);
			}
			
			// Gerenciando o caminho do Modelo:
			$path = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/models/";
			$name = $path . $nome_da_tabela . "Model.php";
			$this->CriarArq($name,$arq);
		}	
	
	// -------------------------------------------------------------------------------------------------------		
	// METODO PARA GERAR FUNCOES DE INCLUSAO, CONSULTA ALTERACAO E EXCLUSAO DE DADOS
	// PARAMETROS: $NOME_DA_TABELA = nome da tabela no banco de dados..., $pacote = pacote da classe
	// -------------------------------------------------------------------------------------------------------			
		private function createCrud($nome_da_tabela,$pacote){
			$this->CriarEstrutura($pacote,$nome_da_tabela);
			$this->init();
			
			//  CONSULTA E EXCLUSAO:
			$arq = $this->LerArq($this->caminho . "consultar_excluir.phtml");
			for($i = 0; $i < count($arq); $i++) {
				$arq[$i] = str_replace("clientes", $nome_da_tabela, $arq[$i]);
			}
			$path = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/views/" ;
			$name = $path . $nome_da_tabela . "/consultar_excluir.phtml";
			$this->CriarArq($name,$arq);
			
			//  INCLUSAO E ALTERAÇÃO
			$arq = $this->LerArq($this->caminho . "incluir_alterar.phtml");
			$path = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/views/" ;
			$name = $path . $nome_da_tabela . "/incluir_alterar.phtml";
			$this->CriarArq($name,$arq);
			
			// CABCAMPO.PHP - CABEÇALHOS E CAMPOS DA TABELA
			$rf = new InfoBDLib(); 
			$campos = $rf->retorna_info_CP(FW_BANCO,$nome_da_tabela);	//	Retorna todos os campos da tabela
			
			$rotCamp = "$". "FW_campos = array(";
			for ($ct=0;$ct< count($campos); $ct++) {
				if (count($campos) != ($ct+1))  {
					$rotCamp = $rotCamp . '"' . strtoupper($campos[$ct][0]) . '"' . " => " . '"' . $campos[$ct][0] . '"' . "," . "\n";
				} else {
					$rotCamp = $rotCamp . '"' . strtoupper($campos[$ct][0]) . '"' . " => " . '"' . $campos[$ct][0] . '"'. "\n";
				}				
			}
				$rotCamp = $rotCamp . ");";
			
			$arq = $this->LerArq($this->caminho . "cabCampo.php");
			for($i = 0; $i < count($arq); $i++) {
				$arq[$i] = str_replace("$"."FW_campos = array();", $rotCamp, $arq[$i]);	
			}
			$path = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/views/" ;
			$name = $path . $nome_da_tabela . "/blocks/cabCampo.php";
			$this->CriarArq($name,$arq);
			
			// Deixando só os três primeiros campos de $rotCamp
			
			while (true) {
				if (count($campos) > 3) {
					array_pop($campos);
				}
				if (count($campos) <= 3) {
					break;
				}
			}

			$rotCamp = "$". "FW_campos = array(";
			for ($ct=0;$ct< count($campos); $ct++) {
				if (count($campos) != ($ct+1))  {
					$rotCamp = $rotCamp . '"' . strtoupper($campos[$ct][0]) . '"' . " => " . '"' . $campos[$ct][0] . '"' . "," . "\n";
				} else {
					$rotCamp = $rotCamp . '"' . strtoupper($campos[$ct][0]) . '"' . " => " . '"' . $campos[$ct][0] . '"'. "\n";
				}				
			}
				$rotCamp = $rotCamp . ");";
			$rotCamp = str_replace("FW_campos","FW_cab",$rotCamp);
			
			// index.phtml CRIANDO A PAGINA PRINCIPAL DO CADASTRO
			$arq = $this->LerArq($this->caminho . "index.phtml");
			for($i = 0; $i < count($arq); $i++) {
				$arq[$i] = str_replace("$"."FW_cab = array();", $rotCamp, $arq[$i]);	
				$arq[$i] = str_replace("FW_tabela = 'clientes';", "FW_tabela = '". $nome_da_tabela."';", $arq[$i]);
			}
			$path = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/views/" ;
			$name = $path . $nome_da_tabela . "/index.phtml";
			$this->CriarArq($name,$arq);
		
		}	
	
	// -------------------------------------------------------------------------------------------------------		
	// METODO PARA GERAR O FORMULARIO DE ENTRADA DE DADOS
	// PARAMETROS: $NOME_DA_TABELA = nome da tabela no banco de dados..., $pacote = pacote da classe
	// -------------------------------------------------------------------------------------------------------			
		private function createFormulario($nome_da_tabela,$pacote){
			$this->CriarEstrutura($pacote,$nome_da_tabela);
			$this->init();
			$arq = $this->LerArq($this->caminho . "formulario.php");
			
			for($i = 0; $i < count($arq); $i++) {
				$arq[$i] = str_replace('"clientes";', '"'.$nome_da_tabela.'";', $arq[$i]);
			}

			// criar o diretorio das views...	
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/views/" . $nome_da_tabela;	
			if(!file_exists($diretorio)) {
				$this->CriarDiretorio($diretorio);
			}

			if(!file_exists($diretorio . "/forms")) {
				$this->CriarDiretorio($diretorio . "/forms");
			}	
				
			// Gerenciando o caminho do formulario:
			$path = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/views/" . $nome_da_tabela . "/forms/";
			$name = $path . "formulario.php";
			$this->CriarArq($name,$arq);
		}	
	
	// -------------------------------------------------------------------------------------------------------
	// METODO PARA GERAR A ESTRUTURA DE DIRETORIOS DO CADASTRO
	// PARAMETROS: NOME DO PACOTE, nome da tabela
	// -------------------------------------------------------------------------------------------------------
		private function CriarEstrutura($pacote,$nome_da_tabela) {
			// Cria pacote, se ele não existe...
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote;
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);

			// Cria Diretorio de Controladores:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/controllers";
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
	
			// Cria Diretorio de helpers:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/helpers";
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
			
			// Cria Diretorio de models:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/models";
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
			
			// Cria Diretorio de views:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote . "/views";
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
			
			// Cria subdiretorio do pacote na pasta views:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote .  "/views/" . $nome_da_tabela;	
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
			
			// Cria subdiretorio do pacote na pasta views - blocks:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote .  "/views/" . $nome_da_tabela . "/blocks";	
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
			
			// Cria subdiretorio do pacote na pasta views - CSS:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote .  "/views/" . $nome_da_tabela . "/css";	
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
			
			// Cria subdiretorio do pacote na pasta views - forms:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote .  "/views/" . $nome_da_tabela . "/forms";
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);

			// Cria subdiretorio do pacote na pasta views - images:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote .  "/views/" . $nome_da_tabela . "/images";
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);

			// Cria subdiretorio do pacote na pasta views - scripts:
			$diretorio = FW_PATH_SERV . FW_RAIZ . "app/packages/" . $pacote .  "/views/" . $nome_da_tabela . "/scripts";
			$this->GeraDir($pacote,$nome_da_tabela,$diretorio);
			
		}
	
	// ------------------------------------------------------------------
	// METODOS AUXILIAR PARA CRIAR DIRETORIOS:
	// ------------------------------------------------------------------	
		private function GeraDir($pacote,$nome_da_tabela,$diretorio) {
			$this->init();
			$arq = $this->LerArq($this->caminho . "index.html");
			
			if(!file_exists($diretorio)) {
				$this->CriarDiretorio($diretorio);
			}
			// Criando arquivo index.html
			$name = $diretorio . "/index.html";
			$this->CriarArq($name,$arq);
		}
	
	// -------------------------------------------------------------------------------------------------------		
	// METODO PARA LER O ARQUIVO E RETORNAR UM ARRAY COM O CONTEUDO	
	// -------------------------------------------------------------------------------------------------------			
		private function LerArq($name) {
			$arquivo = file($name);
			return $arquivo;
		}

	// -------------------------------------------------------------------------------------------------------		
	// METODO PARA GRAVAR UM ARQUIVO COM DETERMINADO CONTEUDO
	// -------------------------------------------------------------------------------------------------------			
		private function CriarArq($name,$conteudo) {
			$f = fopen($name, "w");
			// Escreve no arquivo
			for($i = 0; $i < count($conteudo); $i++) {		
				fwrite($f, $conteudo[$i]);
			}	
			// Libera o arquivo
			fclose($f);
		}

	// -------------------------------------------------------------------------------------------------------		
	// METODO PARA CRIAR UM DIRETORIO
	// -------------------------------------------------------------------------------------------------------			
		private function CriarDiretorio($name) {
			mkdir ($name, 0766 ); 
		}		
	}

?>