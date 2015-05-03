<?php
	session_start();
	
	class Users {
		private $id_user_;
		private $mail_;
		private $passwd_;
		private $dateOfBirth_;
		private $lastName_;
		private $firstName_;
		private $token_;
		
		//Return array $output
		/*
		*	@Input_params : 
		*		$mail : Email du client
		*		$passwd : Password du client
		*/
		public function createUser($mail, $passwd) {
			$host = "localhost";
			$dbname = "projetapi";
			$dbid = "root";
			$dbpsw = "";
			
			//On verifie que les parametres d'entrée ne sont pas vides
			// A sovoir : $mail, $passwd, $confm, $confp et $send
			if(!empty($mail) and !empty($psw)) {
			
				//On créé les params connus
				$params = array(":mail"=>$mail, ":passwd"=>$passwd);
				
				//Connexion
				if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
					$output["code"] = 5;
					$output["result"] = "Internal server error";
					$output["infos"] = array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					);
					unset($pdo);
					return $output;
				}
				
				//Requête select pour verifier que l'utilisateur entrant est unique
				$state = $pdo->prepare("SELECT * FROM user WHERE mail = :mail AND password = :passwd");
				
				//Execution
				if($state and $state->execute($params)) {
					$rows = $state->fetchAll();
					if(count($rows) > 1 || count($rows) < 0) {
						$output = array(
							"code"=>2,
							"result"=>"Email already registered!"
						);
						return $output;
					}
				}
				
				$params[":token"] = addToken($mail, $pdo);
				
				//Préparation de la requete d'insertion
				$insert = "INSERT INTO user (mail, password, token) VALUES (:mail, :passwd, :token)";
				$state = $pdo->prepare($insert);
				
				//Vérification du mail entrant
				if(verifMail($mail, $confmail, $pdo)) {
					
					//Verification du password entrant
					if(verifPassword($passwd, $confpasswd)) {
						
						//Execution de l'insertion
						if($state and $state->execute($params)) {
							
							$state2 = $pdo->prepare("SELECT * FROM user WHERE mail = :mail AND password = :passwd");
							
							if($state2 and $state2->execute($params)) {
								$row = $state2->fetch(PDO::FETCH_ASSOC);
								$this->setId($row["id_user"]);
								$this->setMail($row["mail"]);
								$this->setPasswd($row["password"]);
								$this->setToken($row["token"]);
								
								$_SESSION["id"] = $this->getId();
								$_SESSION["mail"] = $this->getMail();
								$_SESSION["psw"] = $this->getPasswd();
								$_SESSION["token"] = $this->getToken();
								
								$ouput = array(
									"code"=>0,
									"result"=>"OK",
									"infos"=> array(
										"query"=>$insert,
										"id_user"=> $this->getId(),
										"mail"=>$this->getMail(),
										"password"=>$this->getPasswd(),
										"token"=>$this->getToken()
									)
								);
								
								unset($state);
								unset($pdo);
								return $output;
								
							} else {
								$output["code"] = 7;
								$output["result"] = "Nothing to select!";
								return $output;
							}								
						} else {
							$output["code"] = 5;
							$output["result"] = "Internal server error!";
							return $output;
						}		
					}else {
						$output["code"] = 8;
						$output["result"] = "Password failed check you credentials!";
						return $output;
					}
				} else {
					$output["code"] = 2;
					$output["result"] = "Email already registered or well-written!";
					return $output;
				}
			} else {
				$output["code"] = 1;
				$output["result"] = "Missing required parameter(s)!";
				return $output;
			}
		}
		
		//Return json_encode($output)
		/*
		*	@Input_params : 
		*		$mail : Email du client
		*		$passwd : Password du client
		*		$send : Valeur de retout du bouton submit
		*/
		public function connexionUser($mail, $passwd) {
			$host = "localhost";
			$dbname = "projetapi";
			$dbid = "root";
			$dbpsw = "";
			
			if(!empty($mail) and !empty($passwd)) {
				if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw))) {
					$output = array(
						"code"=>5,
						"result"=>"Internal server error!",
						"infos"=>array(
							"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
						)
					);
					return $output;
				}
				
				if(@$_SESSION["mail"] == $mail and $_SESSION["psw"] == $passwd) {
					$params = array(
						":mail"=>$_SESSION["mail"],
						":psw"=>$_SESSION["psw"]
					);
				} else {
					$params = array(
						":mail"=>$mail,
						":psw"=>$passwd
					);
				}
				
				$select = "SELECT * FROM user WHERE mail = :mail AND password = :psw";
				$state = $pdo->prepare("SELECT * FROM user WHERE mail = :mail AND password = :psw");
				
				if($state and $state->execute($params)) {
					$rows = $state->fetchAll();
					$row = $state->fetch(PDO::FETCH_ASSOC);
					$select = "SELECT * FROM user WHERE mail = ".$mail." AND password = ".$passwd;
					if(count($rows) == 1) {
						$output = array(
							"code"=>0,
							"result"=>"OK",
							"infos"=>array(
								"query"=>$select,
								"connexion"=>"OK"
							)
						);
						
						if((@$_SESSION["mail"] == $mail) and ($_SESSION["psw"] == $passwd)) {
							if($this->getMail() != $_SESSION["mail"]) {$this->setMail($_SESSION["mail"]);}
							if($this->getPasswd() != $_SESSION["psw"]) {$this->setPasswd($_SESSION["psw"]);}
							if($this->getToken() != $_SESSION["token"]) {$this->setToken($_SESSION["token"]);}
							if($this->getId() != $_SESSION["id"]) {$this->setId($_SESSION["id"]);}
						} else {
							$_SESSION["mail"] = $row["mail"];
							$_SESSION["psw"] = $row["password"];
							$_SESSION["token"] = $row["token"];
							$_SESSION["id"] = $row["id_user"];
						}
						unset($state);
						unset($pdo);
						return $output;
					} else {
						$output = array(
							"code"=>-1,
							"Result"=>"Not referenced in database",
							"infos"=>array(
								"query"=>$select,
								"connexion"=>"DENIED"
							)
						);
						return $output;
					}
				} else {
					$output = array(
						"code"=>5,
						"result"=>"Internal server error!"
					);
					return $output;
				}
			} else {
				$output = array(
					"code"=>1,
					"result"=>"Missing required parameter(s)!"
				);
				return $output;
			}
		}
		
		public function editUser($mail, $psw, $lastname, $firstname) {
			$host = "localhost";
			$dbname = "projetapi";
			$dbid = "root";
			$dbpsw = "";
			
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw))) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				return $ouput;
			}
			
			if(!empty($mail)) {
				$params = array(":mail"=>$mail);
				
				$state = $pdo->prepare("UPDATE user SET mail = :mail");
				if($state and $state->execute($params)) {
					$query = "UPDATE user SET password = ".$mail;
					$output = array(
						"code"=>0,
						"result"=>"OK",
						"infos"=>array(
							"query"=>$query,
							"mail"=>$mail." inserted with success!"
						)
					);
				} else {
					$output = array(
						"code"=>7,
						"result"=>"Nothing to update",
						"infos"=>array(
							"query"=>$query
						)
					);
				}
				
				if(!empty($psw)) {
					$params = array(":psw"=>$psw);
					
					$state = $pdo->prepare("UPDATE user SET password = :psw");
					
					if($state and $state->execute($params)) {
						$query = "UPDATE user SET password = ".$psw;
						$output = array(
							"code"=>0,
							"resutl"=>"OK",
							"infos"=>array(
								"query"=>$query,
								"password"=>$psw." inserted with success!"
							)
						);
					} else {
						$output = array(
							"code"=>7,
							"result"=>"Nothing to update",
							"infos"=>array(
								"query"=>$query
							)
						);
					}
				}
				
				if(!empty($lastname)) {
					$params = array(":ln"=>$lastname);
					
					$state = $pdo->prepare("UPDATE user SET lastname = :ln");
					
					if($state and $state->execute($params)) {
						$query = "UPDATE user SET password = ".$lastname;
						$output = array(
							"code"=>0,
							"result"=>"OK",
							"infos"=>array(
								"query"=>$query,
								"lastname"=>$lastname." inserted with success!"
							)
						);
					} else {
						$output = array(
							"code"=>7,
							"result"=>"Nothing to update",
							"infos"=>array(
								"query"=>$query
							)
						);
					}
				}
				
				if(!empty($firstname)) {
					$params = array(":fn"=>$firstname);
					
					$state = $pdo->prepare("UPDATE user SET firstname = :fn");
					
					if($state and $state->execute($params)) {
						$query = "UPDATE user SET password = ".$firstname;
						$output = array(
							"code"=>0,
							"result"=>"OK",
							"infos"=>array(
								"query"=>$query,
								"firstname"=>$firstname." inserted with success!"
							)
						);
					} else {
						$output = array(
							"code"=>7,
							"result"=>"Nothing to update",
							"infos"=>array(
								"query"=>$query
							)
						);
					}
				}
				unset($state);
				unset($pdo);
				return $ouput;
			}
		}
		
		public function addToken($mail, $pdo) {
			$params = array (":mail"=>$mail);
			
			$state = $pdo->prepare("SELECT * FROM user WHERE mail = :mail");
			
			if($state and $state->execute($params))
			{
				$row = $state->fetch(PDO::FETCH_ASSOC);
				if(($token = rand(00000000000, 99999999999)) == (int)$row["token"])
					$token = addToken($mail, $pdo);
				else return $token;
			}
		}
		
		public function verifMail($mail, $pdo) {
			$params = array(":mail"=>$mail);
			$state = $pdo->prepare("SELECT * FROM user WHERE mail = :mail");
			
			if($state and $state->execute($params))
				if(substr_count($mail, "@") == 1)
					if(strlen($mail) < 256)
						return true;
					else return false;
				else return false;
			else return false;
		}
		
		public function verifPassword($passwd) {
			if(strlen($passwd) > 3 and strlen($passwd) < 17) {
					return true;
			} else return false;
		}
		
		public function setId($id) {
			$this->id_user_ = $id;
		}
		
		public function getId() {
			return $this->id_user_;
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
