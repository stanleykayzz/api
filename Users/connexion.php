<?php
	require_once("cls-u_1n_130.php");
	session_start();
	
	$mail = $_GET["mail"];
	$passwd = $_GET["passwd"];
	
	$user = new Users();
	
	function connexion(String $mail, String $passwd) {
		if(!empty($mail) and !empty($passwd) and !empty($_GET["send"])) {
			if(!($pdo = new PDO("mysql:host=localhost;dbname=db_ap", "root", "")) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				return json_encode($ouput);
			}
			
			$params = array(
				":id"=>$_SESSION["id"],
				":mail"=>$mail,
				":psw"=>$passwd
			);
			
			$select = "SELECT * FROM user WHERE mail = :mail AND password = :psw";
			$state = $pdo->prepare($select);
			
			if($state and $state->execute($params)) {
				$lignes = $state->fetchAll();
				if(count($lignes) > 1) {
				
				}
			} else {
				$ouput = array(
					"code"=>5,
					"result"=>"Internal server error!";
				);
				return json_encode($output);
			}
		} else {
			$output = array(
				"code"=>1
				"result"=>"Missing required parameter(s)!"
			);
			return json_encode($output);
		}
		
		$state = $pdo->query("SELECT * FROM users WHERE pseudo = :id AND password = :psw");
		
		$row = $state->fetch(PDO::FETCH_ASSOC);
		
		if(length($row) == 1) {
			echo "Connected!";
		}
		else echo "ID or password wrong!";
		
		unset($state);
		unset($pdo);
	}
?>
