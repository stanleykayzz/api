<?php
// Permet a un utilisateur de faire une demande d'ami 
session_start();

$id = $_SESSION['id']

function ask_friend_resquest($id,$id_friend)
{
	$pdo = new PDO("mysql:host=localhost;dbname=projet_api","root","");
	$params = array(":id" => $id, ":id_friend" => $id_friend);
	$statement = $pdo->prepare("INSERT INTO demande_amitie (id_users,id_users_User) VALUES (:id,:id_friend) ");
	if($statement && $statement->execute($params))
	{
		echo "insert ok <br>";
	}

	unset($statement);
	unset($params);
}

?>
