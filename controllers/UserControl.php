<?php
	class UserControl {
		//request POST or GET
		private $params_;
		
		public function __construct($params) {
			$this->params_ = $params;
		}
		
		public function createUser() {
			$user = new Users();
			return json_encode($user->createUser($this->params_["mail"], $this->params_["psw"]));
		}
		
		public function connexionUser() {
			$user = new Users();
			return json_encode($user->connexionUser($this->params_["mail"], $this->params_["psw"]));
		}
		
		public function editUser() {
			$user = new User();
			return json_encode($user->editUser($this->params_["mail"], $this->params_["psw"], $this->params_["lastname"], $this->params_["firstname"]));
		}
	}
?>