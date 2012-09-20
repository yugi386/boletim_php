<?php
// CLASSE PARA GERENCIAMENTO DE LOGIN NO SISTEMA...

	Class authLib {
		protected $sessionLib, $redirectorLib, $tablename, $userColumn,
				  $passColumn, $user, $pass, $loginController = 'artigos', $loginAction = 'index',
				  $logoutController = 'login',  $logoutAction = 'index',
				  $loginPackage = "cadastro", $logoutPackage="cadastro";
		
		public function __construct() {
			$this->sessionLib = new SessionLib();
			$this->redirectorLib = new RedirectorLib();
			return $this;
		}
		
		// seta tabela com os dados de login
		public function setTableName ($val) {
			$this->tableName = $val;
			return $this;
		}
		
		// seta coluna da tabela contendo login do usuario
		public function setUserColumn ($val) {
			$this->userColumn = $val;
			return $this;
		}
		
		// seta coluna da tabela contendo senha do usuario		
		public function setPassColumn ($val) {
			$this->passColumn = $val;
			return $this;
		}
		
		// seta o usuario atual
		public function setUser ($val) {
			$this->user = $val;
			return $this;
		}
		
		// seta a senha atual...
		public function setPass($val) {
			$this->pass = $val;
			return $this;
		}
		
		// direciona login
		public function setLoginControllerAction ($package,$controller, $action) {
			$this->loginPackage = $package;
			$this->loginController = $controller;
			$this->loginAction = $action;
			return $this;
		}
		
		// direciona logout
		public function setLogoutControllerAction ($package,$controller, $action) {
			$this->logoutPackage = $package;
			$this->logoutController = $controller;
			$this->logoutAction = $action;
			return $this;
		}
		
		// funcao para criar a sessao de login
		public function login() {
			$db = new Model();
			$db->_tabela = $this->tableName;
			$where = $this->userColumn."='".$this->user."' AND ".$this->passColumn."='".$this->pass."'";
			$sql = $db->read($where,'1');
			
			if (count($sql) > 0 ) :
				$this->sessionLib->createSession("userAuth",true)
								 ->createSession("userData",$sql[0]);
			else:
				// em caso de nao acertar a sneha volta para o login...
				$this->redirectorLib->goToPackageControllerAction($this->logoutPackage, $this->logoutController, $this->logoutAction);								
				// die("USUÁRIO NÃO EXISTE!!!");
			endif;	
			
			$this->redirectorLib->goToPackageControllerAction($this->loginPackage, $this->loginController, $this->loginAction);
			return $this;
		}
		
		// funcao para criar a sessao de logout		
		public function logout() {
			$this->sessionLib->deleteSession("userAuth")
							 ->deleteSession("userData");
			$this->redirectorLib->goToPackageControllerAction($this->logoutPackage, $this->logoutController, $this->logoutAction);								
			return $this;
		}
		
		public function checkLogin($action) {
			switch ($action) {
				case "boolean":
					if (!$this->sessionLib->checkSession("userAuth") )
						return false;
					else
						return true;
					break;
				case "redirect":
					if (!$this->sessionLib->checkSession("userAuth") )
						if (trim($this->redirectorLib->getCurrentController()) != trim($this->loginController) || trim($this->redirectorLib->getCurrentAction()) != trim($this->loginAction) )
							$this->redirectorLib->goToControllerAction($this->loginController, $this->loginAction);
				
					break;
				case "stop":
					if (!$this->sessionLib->checkSession("userAuth") )
						exit;
					break;
			}
		}

		public function userData ($key) {
			$s = $this->sessionLib->selectSession("userData");
			return $s[$key];
		}
		
	}

?>