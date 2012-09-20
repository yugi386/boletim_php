<?php
	Class RedirectorLib {
		protected $parameters = array();
	
		protected function go ($data) {
			header("Location: ". FW_RAIZ . $data);
		}
		
		public function setUrlParameter($name, $value) {
			$this->parameters[$name] = $value;
			return $this;
		}
	
		public function getUrlParameters() {
			$parms = "";
		
			foreach ($this->parameters as $name => $value)
				$parms .= $name . '/' . $value . "/";
				
			return $parms;		
		}

		public function goToController($controller){
			$this->go($this->getCurrentPackage() . "/". $controller . "/index/" . $this->getUrlParameters() );
		}

		public function goToAction($action){
			$this->go($this->getCurrentPackage() . "/". $this->getCurrentController() . "/". $action . "/" . $this->getUrlParameters() );
			
		}
		
		public function goToControllerAction($controller, $action){
			$this->go($this->getCurrentPackage() . "/". $controller . "/" . $action . "/" . $this->getUrlParameters() );
		}
		
		public function goToPackageControllerAction($package, $controller, $action){
			$this->go($package . "/". $controller . "/" . $action . "/" . $this->getUrlParameters() );
		}
		
		public function goToPackageController($package, $controller){
			$this->go($package . "/". $controller . "/index/" . $this->getUrlParameters() );
		}
		
		public function goToIndex(){	//	vai pro pacote master
			$this->goToController($this->getCurrentPackage() . "/". 'master');
		}	
		
		public function goToUrl($url){
			header("Location: ".$url);
		}	
	
		public function getCurrentPackage() {
			global $start;
			return $start->_package; 
		}
		
		public function getCurrentController() {
			global $start;
			return $start->_controller; 
		}
		
		public function getCurrentAction() {
			global $start;
			return $start->_action; 
		}
	
	}

?>