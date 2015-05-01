<?php
	interface IUsers {
		public function askFriendship();
		public function denyFriendship();
		public function cancelFriendship();
		
		public function createPost();
		public function editPost();
		public function supprPost();
		
		public function setMail($mail);
		public function getMail();
		
		public function setPassword($passwd);
		public function getPassword();
		
		public function setPseudo($pseudo);
		public function getPseudo();
		
		public function setDOB ($dob);
		public function getDOB();
		
		public function setLastName($lastName);
		public function getLastName();
		
		public function setFirstName($firstName);
		public function getFirstName();
		
		public function setToken($token);
		public function getToken();
	}
?>
