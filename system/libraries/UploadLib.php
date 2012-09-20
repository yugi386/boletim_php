<?php
/*
	CLASSE PARA FAZER UPLOAD DE ARQUIVO 10/05/2012
*/

	Class UploadLib {
	
		protected $path;
		
		protected function GetPath(){
			$this->path = str_replace("//","/",FW_PATH_SERV . FW_RAIZ . "uploads/");
		}
		
		public function setPath($path){
			$this->path = $path;
			return $this;
		}	

	// =======================================================================================================	
	// METODO PARA GERAR NOME ALEATORIO DE ARQUIVO EM UM DADO DIRETORIO:
	// GERA ARQUIVOS COM NOMES DE 64 DÍGITOS CONTENDO 36 CARACTERES DIFERENTES...
	// =======================================================================================================		
	
	public function GeraNome($caminho, $ext){
		$vet = "abcdefghjiklmnopqrstuvwxyz0123456789";
		$tam = strlen($vet) - 1;
		
		// Gerenciando destino do Upload - criando a estrutura de diretorios:	
	
		while (true) {
			$nome = "";
			for ($ct=0;$ct<64;$ct++){
				$nome = $nome .substr($vet,rand(0, $tam),1);
			}
			
			$diretorio = $caminho .  $nome  . "." . $ext;		
			if(!file_exists($diretorio)) {
				break;
			}
		}	
		return $nome  . "." . $ext;
		
	}	
		
	// ===================================================================================================
	// METODO PARA FAZER O UPLOAD DE ARQUIVO: 
	// ===================================================================================================		 
	public function upload($campo, $caminho, $NovoNome) {
		$this->GetPath();

		// Gerenciando destino do Upload - criando a estrutura de diretorios:	
		$ext = explode('.',$NovoNome);	//	extensão do arquivo de origem
		
		$cam = explode('/',$caminho);
		$caminho = "";
		for ($ct=0;$ct<count($cam);$ct++){
			$caminho .= $cam[$ct] . "/";
			$diretorio = $this->path . $caminho;
			if(!file_exists($diretorio)) {
				mkdir($diretorio, 0777, true);
			}
		}

		// Gerando nome único e aleatório para o arquivo:
		$NovoNome = $this->GeraNome($diretorio, $ext[count($ext)-1]);	//	GERANDO NOME ALEATORIO E UNICO PARA O ARQUIVO UPLOAD
		echo $NovoNome;
		// die();
		
		ini_set('post_max_size', '8M');
		
		if (copy( $_FILES[$campo]['tmp_name'] , $this->path . $caminho . $NovoNome)){
			$ret = "";		//	Arquivo carregado com sucesso...
		} else {
			$ret = "ERRO AO CARREGAR ARQUIVO: " . $_FILES["arquivo_demo"]['name'];		//	Erro ao carregar arquivo...
		}
		return $ret;
	}

		
}	//	fim da classe

?>