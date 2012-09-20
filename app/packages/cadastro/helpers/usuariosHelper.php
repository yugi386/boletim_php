<?php
/*
|===========================================================================|
|	CONTROLADOR DO CADASTRO 												|
|===========================================================================|
|																			|
|	VERSÃO:								1.0.0								|
|	 																		|	
|===========================================================================|
*/
Class usuariosHelper extends Controller {
	
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 001: [ PUBLIC FUNCTION INIT ]
	# RETORNA MASCULINO FEMININO:
	# ---------------------------------------------------------------------------------------------------------------------------------
		public function genero($tipo) {					
			if (strtoupper($tipo) == 'M') {
				return "Masculino";
			} else if (strtoupper($tipo) == 'F') {	
				return "Feminino";
			}	
		}	

	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 002: [ PUBLIC FUNCTION INIT ]
	# RETORNA SIM NAO
	# ---------------------------------------------------------------------------------------------------------------------------------
		public function yesNo($tipo) {					
			if (strtoupper($tipo) == 'S') {
				return "Sim";
			} else if (strtoupper($tipo) == 'N') {	
				return "Nao";
			}	
		}	
		
	# ---------------------------------------------------------------------------------------------------------------------------------
	# METODO 003: [ PUBLIC FUNCTION INIT ]
	# RETORNA O NOME DOS ESTADOS A PARTIR DA SIGLA
	# ---------------------------------------------------------------------------------------------------------------------------------
		public function estados($tipo) {					
			if (strtoupper($tipo) == 'AC') {
				return "Acre";
			} else if (strtoupper($tipo) == 'AL') {	
				return "Alagoas";
			} else if (strtoupper($tipo) == 'AP') {	
				return "Amapá";	
			} else if (strtoupper($tipo) == 'BA') {	
				return "Bahia";		
			} else if (strtoupper($tipo) == 'CE') {	
				return "Ceara";			
			} else if (strtoupper($tipo) == 'DF') {	
				return "Distrito Federal";			
			} else if (strtoupper($tipo) == 'ES') {	
				return "Espirito Santo";			
			} else if (strtoupper($tipo) == 'GO') {	
				return "Goias";			
			} else if (strtoupper($tipo) == 'MA') {	
				return "Maranhao";			
			} else if (strtoupper($tipo) == 'MT') {	
				return "Mato Grosso";			
			} else if (strtoupper($tipo) == 'MS') {	
				return "Mato Grosso do Sul";			
			} else if (strtoupper($tipo) == 'MG') {	
				return "Minas Gerais";			
			} else if (strtoupper($tipo) == 'PA') {	
				return "Para";			
			} else if (strtoupper($tipo) == 'PB') {	
				return "Paraiba";			
			} else if (strtoupper($tipo) == 'PR') {	
				return "Parana";			
			} else if (strtoupper($tipo) == 'PE') {	
				return "Pernambuco";			
			} else if (strtoupper($tipo) == 'PI') {	
				return "Piaui";			
			} else if (strtoupper($tipo) == 'RJ') {	
				return "Rio de Janeiro";			
			} else if (strtoupper($tipo) == 'RN') {	
				return "Rio Grande do Norte";			
			} else if (strtoupper($tipo) == 'RS') {	
				return "Rio Grande do Sul";			
			} else if (strtoupper($tipo) == 'RO') {	
				return "Rondonia";			
			} else if (strtoupper($tipo) == 'RR') {	
				return "Roraima";			
			} else if (strtoupper($tipo) == 'SC') {	
				return "Santa Catarina";			
			} else if (strtoupper($tipo) == 'SP') {	
				return "Sao Paulo";			
			} else if (strtoupper($tipo) == 'SE') {	
				return "Sergipe";			
			} else if (strtoupper($tipo) == 'TO') {	
				return "Tocantins";			
			}	
		}	
		
} // FIM DA CLASSE -----------------------------------------------------------------------------------------------------------------------	
?>