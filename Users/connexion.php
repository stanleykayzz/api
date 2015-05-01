<?php
	require_once("cls-u_1n_130.php");
	session_start();
	
	$user = new Users();
	
	$user->setMail($_SESSION["mail"]);
	$user->setPassword($_SESSION["passwd"]);
	$user->setPseudo($_SESSION["pseudo"]);
	$user->setDateOfBirth($_SESSION["date_birth"]);
	
	function connexion(String $pseudo, String $passwd) {
		$pdo = new PDO("mysql:host=localhost;dbname=db_ap", "root", "");
		
		$params = array(":id"=>$_SESSION["id"], ":psw"=>$user->getPassword());
		
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
