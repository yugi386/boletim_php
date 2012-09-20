<?php
/*
|===========================================================================|
|	PÁGINA PRINCIPAL biblioteca PHP											|
|===========================================================================|
|																			|
|	VERSÃO:								1.0.0								|
|	DATA DE INÍCIO DO PROJETO: 			09/03/2012 							|
|	DATA DA ÚLTIMA ATUALIZAÇÃO: 		28/03/2012							|
|	 																		|	
|===========================================================================|
*/

	# INICIANDO O CONTROLADOR DE SESSÃO
		session_start();	
		
	# INCLUINDO ARQUIVO DE CONFIGURAÇÃO DO SISTEMA:
		require_once( "config.php");
		
	# DEFININDO A PASTA RAIZ DO SISTEMA	
	#	define("FW_RAIZ","/infinity/escola/");

	# DEFININDO A PASTA RAIZ DO SERVIDOR (NECESSARIO PARA ALGUNS INCLUDES)
		define("FW_PATH_SERV",str_replace("//","/",$_SERVER["DOCUMENT_ROOT"] . "/"));
		
	# DEFININDO A PASTA PARA ACESSAR O RECURSO DE SEGURANCA CHECKBLOCK
		define("FW_BLOCK",str_replace("//","/",$_SERVER["DOCUMENT_ROOT"].FW_RAIZ));
		
	# DEFININDO A PASTA DE LIBRARIES DO SISTEMA (BIBLIOTECAS)
		define("FW_LIBRARIES",   "system/libraries/");

	# DEFINE O LAYOUT DA APLICACAO		
		define("FW_LAYOUTS", "app/layouts/boldness/");	
     	// define("FW_LAYOUTS",	 "app/layouts/site/");	
		// $FW_LAYOUTS = "app/layouts/boldness/";	//	alterando layout para ser mudado dinamicamente...
		// $FW_LAYOUTS = "app/layouts/boldness/";	//	alterando layout para ser mudado dinamicamente...
	
	# DEFINE O CAMINHO COMPLETO DO LAYOUT DA APLICACAO PARA ACESSAR ARQUIVOS DE IMAGES E OUTROS
		define("FW_PATH_LAYOUT", FW_RAIZ . FW_LAYOUTS);
		// FW_PATH_LAYOUT = FW_RAIZ . $FW_LAYOUTS;

	# DEFINE A VARIAVEL DE SEGURANCA PARA A EXECUÇÃO DE BLOCOS
		$fw_blocks =  "qazwsxedc";	

	# DEFINE O CAMINHO DOS ELEMENTOS AUXILIARES DO SCAFFOLDING
		define("FW_SCAFFOLDING",  FW_RAIZ . "system/scaffolding/personalizado/");	//	DIRETORIO SCAFOOLDING PADRAO
		define("FW_SCAF_IMAGE",   FW_SCAFFOLDING . "images/");						//	IMAGENS AUXILIARES DO GRUPO MASTER
		define("FW_SCAF_SCRIPTS", FW_SCAFFOLDING . "scripts/");						//	SCRIPTS SCRIPTS (JQUERY E JAVASCRIPT)
		define("FW_SCAF_CSS",	  FW_SCAFFOLDING . "css/");							//	ARQUIVOS CSS (ARQUIVOS CSS)
		define("FW_SCAF_FORM",	  FW_SCAFFOLDING . "forms/");						//	ELEMENTOS AUXILIARES DE FORMULARIOS
		define("FW_SCAF_BLOCKS",  FW_SCAFFOLDING . "blocks/");						//	BLOCOS DE CÓDIGOS REUTILIZÁVEIS...
		define("FW_SCAF_JAVASCRIPT",  FW_RAIZ . "system/scaffolding/javascript/");	//	BIBLIOTECAS JAVASCRIPT: JQUERY E OUTRAS...
		
	# DADOS DE CONEXAO
	/*
		define("FW_BANCO","escola");				
		define("FW_SERVIDOR","localhost");
		define("FW_USUARIO","root");
		define("FW_PASSWORD","");
	*/
	
	# DIRETORIO DE UPLOAD
		define("FW_UPLOAD",FW_RAIZ . "upload/");				
		
	# INCLUINDO OS ARQUIVOS DE SISTEMA		
		require_once( "system/system.php");
		require_once( "system/controllers/controller.php");
		require_once( "system/models/model.php");
		
	# CARREGANDO O SISTEMA
		$start = new System();
		
	# DEFININDO AS PASTAS DO USUARIO	
	
		define("FW_CONTROLLERS", "app/packages/" . $start->_package . "/controllers/");
		define("FW_VIEWS", 	  	 "app/packages/" . $start->_package . "/views/");
		define("FW_MODELS",      "app/packages/" . $start->_package . "/models/");
		define("FW_HELPERS",     "app/packages/" . $start->_package . "/helpers/");		

		//echo $start->_package . "<br>";
		//echo FW_MODELS . "<br>";
		
	# INICIANDO OS ARQUIVOS DO USUARIO
		function __autoload($file) {
			//echo $file;
			// die();
			
			if ( file_exists(FW_MODELS .$file. ".php") ) {
				//echo "model";
				require_once(FW_MODELS .$file. ".php");
			} else if ( file_exists(FW_HELPERS .$file. ".php") ) { 
				require_once(FW_HELPERS .$file. ".php");
				//echo "helper";
			} else if ( file_exists(FW_LIBRARIES .$file. ".php") ) { 
				require_once(FW_LIBRARIES .$file. ".php");
				//echo "LIB";
			} else {
				//echo "teste";
				die("MODEL, HELPER OU LIBRARY NÃO FOI ENCONTRADO!");	
				
			}	
		}
		
	# INICIANDO O SISTEMA:		
		$start->run();
?>