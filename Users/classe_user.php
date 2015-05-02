<?php
	require_once("IUser_1n_1300.php");
	
	class Users {
		private $mail_;
		private $passwd_;
		private $pseudo_;
		private $dateOfBirth_;
		private $lastName_;
		private $firstName_;
		private $token_;
		
		public function __construct(String $mail=NULL, String $passwd=NULL, String $pseudo=NULL, String $dateOfBirth=NULL) {
			$this->mail_ = $mail;
			$this->passwd_ = $passwd;
			$this->pseudo_ = $pseudo;
			$this->dateOfBirth_ = $dateOfBirth;
		}
		
		public function getMail() {
			return $this->mail_;
		}
		
		public function setMail($mail) {
			$this->mail_ = $mail;
		}
		
		public function getPasswd() {
			return $this->passwd_;
		}
		
		public function setPasswd($passwd) {
			$this->passwd_ = $passwd;
		}
		
		public function getPseudo() {
			return $this->pseudo_;
		}
		
		public function setPseudo($pseudo) {
			$this->pseudo_ = $pseudo;
		}
		
		public function getDOB() {
			return $this->dateOfBirth_;
		}
		
		public function setDOB($dateOfBirth) {
			$this->dateOfBirth_ = $dateOfBirth;
		}
		
		public function setLastName($lastName) {
			$this->lastName_ = $lastName;
		}
		
		public function getLastName() {
			return $this->lastName_;
		}
		
		public function setFirstName($firstName) {
			$this->firstName_ = $firstName;
		}
		
		public function getFirstName() {
			return $this->firstName_;
		}
		
		public function getToken() {
			return $this->token_;
		}
		
		public function setToken($token) {
			$this->token_ = $token;
		}
	}
?>
