<?php	
	require_once("../classe_user.php");
	session_start();
	
	$output = array();
	
	/*
	if(isset($_GET["host"])) {
		if(!empty($_GET["host"])) {
			$host = $_GET["host"];
		} else $host = "localhost";
	} else $host = "localhost";
	
	if(isset($_G ET["dbname"])) {
		if(!empty($_GET["dbname"])) {
			$dbname = $_GET["dbname"];
		} else $dbname = "db_ap";
	} else $dbname = "db_ap";
	
	if(isset($_GET["dbid"])) {
		if(!empty($_GET["dbid"])) {
			$dbid = $_GET["dbid"];
		} else $dbid = "root";
	} else $dbid = "root";
	
	if(isset($_GET["dbpsw"])) {
		if(!empty($_GET["dbpsw"])) {
			$dbpsw = $_GET["dbpsw"];
		} else $dbpsw = "";
	}else $dbpsw = "";
	*/
	
	@$mail = $_GET["mail"];
	@$confmail = $_GET["confmail"];
	@$passwd = $_GET["passwd"];
	@$confpasswd = $_GET["confpasswd"];
	@$send = $_GET["send"];
	
	createUser($mail, $passwd, $confmail, $confpasswd, $send);	
	
	function createUser($mail, $passwd, $confmail, $confpasswd, $send) {
	
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";
		
		//On verifie que les parametres d'entrée ne sont pas vides
		// A sovoir : $mail, $passwd, $confm, $confp et $send
		if(!empty($mail) and !empty($passwd) and !empty($confmail) and !empty($confpasswd) and !empty($send)) {
			//On créé les params connus
			$params = array(":mail"=>$mail, ":passwd"=>$passwd);
			$user = new Users();
			
			//Connexion
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output["code"] = 5;
				$output["result"] = "Internal server error";
				$output["infos"] = array(
					"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
				);
				unset($pdo);
				return json_encode($output);
			}
			
			//Requete select pour verifier que l'utilisateur entrant est unique
			$state = $pdo->prepare("SELECT * FROM user WHERE mail = :mail AND password = :passwd");
			
			//Execution
			if($state and $state->execute($params)) {
				$rows = $state->fetchAll();
				if(count($rows) > 1 || count($rows) < 0) {
					$output = array(
						"code"=>2,
						"result"=>"Email already registered!"
					);
					return json_encode($output);
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
							$user->setId($row["id_user"]);
							$user->setMail($row["mail"]);
							$user->setPasswd(row["password"]);
							$user->setToken($row["token"]);
							
							$_SESSION["id"] = $user->getId();
							$_SESSION["mail"] = $user->getMail();
							$_SESSION["psw"] = $user->getPasswd();
							$_SESSION["token"] = $user->getToken();
							
							$ouput = array(
								"code"=>0,
								"result"=>"OK",
								"infos"=> array(
									"query"=>$insert,
									"id_user"=> $user->getId(),
									"mail"=>$user->getMail(),
									"password"=>$user->getPasswd(),
									"token"=>$user->getToken()
								)
							);
							
							unset($state);
							unset($pdo);
							
							return json_encode($output);
							
						} else {
							$output["code"] = 7;
							$output["result"] = "Nothing to select!";
							return json_encode($output);
						}								
					} else {
						$output["code"] = 5;
						$output["result"] = "Internal server error!";
						return json_encode($output);
					}		
				}else {
					$output["code"] = 8;
					$output["result"] = "Password failed check you credentials!";
					return json_encode($output);
				}
			} else {
				$output["code"] = 2;
				$output["result"] = "Email already registered or well-written!";
				return json_encode($output);
			}
		} else {
			$output["code"] = 1;
			$output["result"] = "Missing required parameter(s)!";
			return json_encode($output);
		}
	}
	
	function addToken($mail, $pdo) {
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
	
	function verifMail($mail, $confmail, $pdo) {
		$params = array(":mail"=>$mail);
		$state = $pdo->prepare("SELECT * FROM user WHERE mail = :mail");
		
		if($state and $state->execute($params)) {
			if(substr_count($mail, "@") == 1) {
				if(strlen($mail) < 256) {
					if($mail === $confmail) 
						return true;
					else return false;
				}else return false;
			} else return false;
		} else return false;
	}
	
	function verifPassword($passwd, $confpasswd) {
		if(strlen($passwd) > 3 and strlen($passwd) < 17) {
			if($confpasswd === $passwd) {
				return true;
			} else return false;
		} else return false;
	}
?>
  