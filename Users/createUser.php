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
	
	if(isset($_GET["dbname"])) {
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
	
	$host = "localhost";
	$dbname = "projetapi";
	$dbid = "root";
	$dbpsw = "";
	
	@$mail = $_GET["mail"];
	@$confmail = $_GET["confmail"];
	@$passwd = $_GET["passwd"];
	@$confpasswd = $_GET["confpasswd"];
	@$send = $_GET["send"];
	
	json = createUser($mail, $passwd, $confmail, $confpasswd, $send, $host, $dbname, $dbid, $dbpsw);	
	
	function createUser($mail, $passwd, $confmail, $confpasswd, $send, $host, $dbname, $dbid, $dbpsw) {
	
		if(!empty($mail) and !empty($passwd) and !empty($confmail) and !empty($confpasswd) and !empty($send)) {
			$params = array(":mail"=>$mail, ":passwd"=>$passwd);
			$user = new Users();
			
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output["code"] = 5;
				$output["result"] = "Internal server error";
				$output["infos"] = array(
					"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
				);
				echo json_encode($output);
				return json_encode($output);
			}
			
			$insert = "INSERT INTO user (mail, password) VALUES (:mail, :passwd)";
			$state = $pdo->prepare($insert);
			
			if(verifMail($mail, $confmail, $pdo, $state)) {
			
				if(verifPassword($passwd)) {
					if($state and $state->execute($params)) {
						$user->setMail($mail);
						$user->setPasswd($passwd);
						
						$state2 = $pdo->prepare("SELECT * FROM user WHERE mail = :mail AND password = :passwd");
						
						if($state2 and $state2->execute($params)) {
							$row = $state->fetch(PDO::FETCH_ASSOC);
							$_SESSION["id"] = $row["id_user"];
							$_SESSION["mail"] = $user->getMail();
							$_SESSION["passwd"] = $user->getPasswd();
							
							
							$output["code"] = 0;
							$output["result"] = "OK";
							$output["infos"] = array(
								"query"=>$insert,
								"id_user"=>$_SESSION["id"],
								"mail"=>$user->getMail(),
								"passwd"=>$user->getPasswd()
							);
							return json_encode($output);
							unset($state);
							unset($pdo);
							
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
				echo json_encode($output);
				return json_encode($output);
			}
		} else {
			$output["code"] = 1;
			$output["result"] = "Missing required parameter(s)!";
			return json_encode($output);
		}
	}
	
	function verifMail($mail, $confmail, $pdo, $state) {
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
	
	function verifPassword($passwd) {
		if(strlen($passwd) > 3 and strlen($passwd) < 17)
			return true;
		else
			return false;
	}
?>
  