<?php
	Class InfoBDLib{
	
		public function retorna_BD(){				//	retorna todos os bancos de dados do MYSQL ATIVO.
			$link = mysql_connect(FW_SERVIDOR, FW_USUARIO, FW_PASSWORD);	
			$db_list = mysql_list_dbs($link);

			$bancos = array();
			$ct = 0;	
			while ($row = mysql_fetch_object($db_list)) {
				$bancos[$ct] = $row->Database;
				$ct++;
			}

			mysql_close($link);	
			return $bancos;
		}
	// -------------------------------------------------------------------------------------------------
		public function retorna_TB($Banco){			//	retorna os nomes das tabelas de um determinado banco
			$link = mysql_connect(FW_SERVIDOR, FW_USUARIO, FW_PASSWORD);	
			$exec = mysql_query("Show tables in $Banco");

			$bancos = array();
			$ct = 0;	
			while($campos=mysql_fetch_array($exec)) {
				$bancos[$ct] = $campos[0];
				$ct++;
			} 

			mysql_close($link);	
			return $bancos;
		}
	// -------------------------------------------------------------------------------------------------
		public function retorna_num_TB($Banco){			//	retorna o numero de tabelas de dado banco
			return count( $this->retorna_TB($Banco) );
		}
	// -------------------------------------------------------------------------------------------------
		public function retorna_num_CP($Banco,$tabela){			//	retorna o numero de campos de uma determinada tabela
			$link = mysql_connect(FW_SERVIDOR, FW_USUARIO, FW_PASSWORD);	
			$fields = mysql_list_fields($Banco,$tabela,$link);
			$columns = mysql_num_fields($fields);
			mysql_close($link);	
			return $columns;
		}
	// -------------------------------------------------------------------------------------------------
		public function retorna_info_CP($Banco,$tabela){		//	retorna informacoes sobre os campos de uma tabela: nome, tipo e tamanho.
			$link = mysql_connect(FW_SERVIDOR, FW_USUARIO, FW_PASSWORD);	
			$fields = mysql_list_fields($Banco,$tabela,$link);
			$limit = mysql_num_fields($fields);

			// Listando dados dos campos: nome, tipo e tamanho.			
			$info = array(array(), array());
			for(  $i = 0; $i < $limit; $i++){
				$campo = mysql_fetch_field( $fields, $i);
				$result = mysql_query("SELECT $campo->name FROM $tabela LIMIT 1");
				$length = mysql_field_len($result, 0);
				 
				$info[$i][0] = $campo->name;
				$info[$i][1] = $campo->type;
				$info[$i][2] = $length;
			 }
			 mysql_close($link);	
			 return $info;
		}	 
	// -------------------------------------------------------------------------------------------------		
	}

?>