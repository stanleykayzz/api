<html>
	<body>
		<form action="connexion.php" mehtod="GET">
			mail : <input type="text" name="mail"/><br/>
			passord : <input type="password" name="passwd"/><br/>
			<input type="submit" name="send"/>
		</form>
	</body>	
</html>

<?php
	require_once("../classe_user.php");
	
	$json = connexion($_GET["mail"], $_GET["passwd"], $_GET["send"]);
	
	function connexion($mail, $passwd, $send) {
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";
		$user = new Users();
		
		//On verifie que les parametres d'entrée ne sont pas vides
		// A sovoir : $mail, $passwd, $confm, $confp et $send
		if(!empty($mail) and !empty($passwd) and !empty($send)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw))) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				echo json_encode($output);
				return json_encode($ouput);
			}
			
			if($_SESSION["mail"] == $mail and $_SESSION["psw"] == $passwd) {
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
					
					if(($_SESSION["mail"] == $mail) and ($_SESSION["psw"] == $passwd)) {
						if($user->getMail() != $_SESSION["mail"]) {$user->setMail($_SESSION["mail"]);}
						if($user->getPasswd() != $_SESSION["psw"]) {$user->setPasswd($_SESSION["psw"]);}
						if($user->getToken() != $_SESSION["token"]) {$user->setToken($_SESSION["token"]);}
						if($user->getId() != $_SESSION["id"]) {$user->setId($_SESSION["id"]);}
					} else {
						$_SESSION["mail"] = $row["mail"];
						$_SESSION["psw"] = $row["password"];
						$_SESSION["token"] = $row["token"];
						$_SESSION["id"] = $row["id_user"];
					}
					unset($state);
					unset($pdo);
					return json_encode($output);
				} else {
					$output = array(
						"code"=>-1,
						"Result"=>"Not referenced in database",
						"infos"=>array(
							"query"=>$select,
							"connexion"=>"DENIED"
						)
					);
					return json_encode($output);
				}
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!"
				);
				return json_encode($output);
			}
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)!"
			);
			return json_encode($output);
		}
	}
?>
