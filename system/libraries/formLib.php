<?php
/*
|===========================================================================|
|	CLASSE DOS FORMULARIOS   												|
|===========================================================================|
|																			|
|	VERSÃO:								1.0.0								|
|	DATA DA CRIAÇÃO:		 			29/03/2012 							|
|	DATA DA ÚLTIMA ATUALIZAÇÃO: 		29/03/2012							|
|	 																		|	
|===========================================================================|

ESTA CLASSE DEVE CONTER MÉTODOS PARA FACILITAR A CRIAÇÃO E GERENCIAMENTO DE FORMULÁRIOS
*/

Class formLib {
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 001: [ PRIVATE FUNCTION RETORNA_CAMPOS ]
	# RETORNA TODOS OS CAMPOS DA TABELA INDICADA COM NOME, TIPO, TAMANHO
	# 	PARAMETRO: NOME DA TABELA
	# ---------------------------------------------------------------------------------------------------------------------------------		
	
		public function Retorna_Campos($tabela){
			$bd = new InfoBDLib();													//	BIBLIOTECA COM FUNCOES QUE RETORNAM INFORMACOES SOBRE O BANCO, TABELAS E CAMPOS.
			$campos = array();	
			$campos = $bd->retorna_info_CP(FW_BANCO,$tabela);						//	RETORNA INFORMACOES SOBRE OS CAMPOS
			return $campos;
		}
		
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 002: [ PUBLIC FUNCTION GERA_TABFORM ]
	# GERA UMA TABELA COM AS ENTRADAS DO FORMULARIO
	# 	PARAMETROS: NOME DA TABELA, CABECALHO (VETOR COM CABECALHO e NOME DO CAMPO RESPECTIVO ), FORMATOS (VETOR COM INFORMACOES PERSONALIZADAS)
	# ---------------------------------------------------------------------------------------------------------------------------------		
		
		public function GeraTabForm($tabela,$cabecalho,$formato){
			$campos = array();
			$campos = $this->Retorna_Campos($tabela);
			
			$CabCampo = array_keys($cabecalho);
			$NomeCampo = array_values($cabecalho);
			$limit = count($CabCampo);	
			
			$formatoCab  = array_keys($formato);
			$formatotipo = array_values($formato);
			
			$stringForm = "<TABLE>";
			
			for ($ct=0;$ct<$limit;$ct++) {
					$campoTabela = false;	//	Permite identificar se o campo do formulario tem correspondencia com o campo da tabela
					// Identificando o Campo do Banco de dados pelo campo do formulário:
					for ($i=0;$i<count($campos);$i++) {
						if ($campos[$i][0] == $NomeCampo[$ct]) {
							$campoTabela = true;
							break;
						}	
					}
			
				$stringForm .= "<TR VALIGN=TOP>";
					$stringForm .= "<TD><B>" .  $CabCampo[$ct] . "</B></TD>";		//	CABECALHO DO CAMPO
					$stringForm .= "<TD>";
					
						if ($campoTabela) {
							if (!isset($formato[$NomeCampo[$ct]])) {	//	Se não tem personalizacao...
								$stringForm .= '<input type="text" name="' . $NomeCampo[$ct];
								$stringForm .= '" id="' . $NomeCampo[$ct];
								$stringForm .= '" size="' . (string)min(($campos[$i][2] + 5),65) . '" maxlength="';		
								$tmp = '$V'. $NomeCampo[$ct];
								$stringForm .= $campos[$i][2] . '" value="' . $tmp . '" >';					
							} else {
								$stringForm .= $this->DefinirCampo($NomeCampo[$ct],$formato[$NomeCampo[$ct]]);	
							}	
						} else {	
							if (!isset($formato[$NomeCampo[$ct]])) {	//	Se não tem personalizacao...
								$stringForm .= '<input type="text" name="' . $NomeCampo[$ct];
								$stringForm .= '" id="' . $NomeCampo[$ct];
								$stringForm .= '" size="65" maxlength="60"' . ' >';	//	Tamanho padrao para campos que nao tem correspondencia com a tabela
							} else {
								$stringForm .= $this->DefinirCampo($NomeCampo[$ct],$formato[$NomeCampo[$ct]]);	
							}		
						}
					
					$stringForm .= "</TD></TR>";
			}

			$stringForm .= "</TABLE>";
			return $stringForm;
		}	
		
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 003: [ PUBLIC FUNCTION RETORNAVAR ]
	# RETORNA UM ARRAY COM NOMES DE VARIAVEIS PRA PREENCHER O FORMULARIO EM CASO DE ALTERACAO DE DADOS
	# 	PARAMETROS: CABECALHO (VETOR COM CABECALHO e NOME DO CAMPO RESPECTIVO )
	#						EX: ARRAY("NOME DO CLIENTE" => "nome");	
	# ---------------------------------------------------------------------------------------------------------------------------------		
		
		public function RetornaVar($cabecalho){	
			$variaveis = array_values($cabecalho);			//	gerando vetor acima dinamicamente....
			for ($ct=0;$ct<count($cabecalho);$ct++) {
				$variaveis[$ct] = "V" . $variaveis[$ct];
			}
			return $variaveis;
		}
		
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 004: [ PRIVATE FUNCTION DEFINIRCAMPO ]
	# PERMITE PERSONALIZAR OS DADOS DE ENTRADA PARA UM CAMPO DO FORMULARIO
	# 	PARAMETROS: INFO (STRING COM DADOS RELATIVOS AO CAMPO)
	# ---------------------------------------------------------------------------------------------------------------------------------		
		
		private function DefinirCampo($Campo,$info){	
			$tipo = substr($info,0,4);		//	CODIGO DE ENTRADA DE CAMPO FACILITADO
			if ($tipo == 'type') {
				$stringForm = "<input ";
				$stringForm .= $info . ' name="' . $Campo . '" id="' . $Campo . '">';
				return $stringForm;
			} else {
				return $info;
			}
		}		
}	//	FIM DA CLASSE ---------------------------------------------------------------------------------------

?>