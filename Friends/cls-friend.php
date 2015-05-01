<?php

session_start();

//$id = $_SESSION['id'];

class Friend
{
	/* Permet a un utilisateur de faire une demande d'ami  :  int id , int id_friend */
	static public function ask_friend_resquest($id,$id_friend)
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

	/*Reponder a une demande d'amitier : boolean answer , int id , int id_friend*/ 
	static public function answer_friend_resquest($answer,$id,$id_friend)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projet_api","root","");

		if($answer == true)
		{
			$params = array(":id" => $id, ":id_friend" => $id_friend);
			$params2 = array(":id2" => $id, ":id_friend2" => $id_friend);
			$statement = $pdo->prepare("INSERT INTO amitie_confirme (id_users,id_users_User) VALUES (:id,:id_friend); ");
			$statement2 = $pdo->prepare("DELETE FROM demande_amitie WHERE id_users = :id2 AND id_users_User = :id_friend2; ");
			if($statement && $statement->execute($params) && $statement2 && $statement2->execute($params2))
			{
				echo "insert ok <br>";
			}
		}
		else
		{
			$params = array(":id" => $id, ":id_friend" => $id_friend);
			$params2 = array(":id2" => $id, ":id_friend2" => $id_friend);
			$statement = $pdo->prepare("INSERT INTO annuler_refuser_amitie (id_users,id_users_User) VALUES (:id,:id_friend) ");
			$statement2 = $pdo->prepare("DELETE FROM demande_amitie WHERE id_users = :id2 AND id_users_User = :id_friend2; ");
			if($statement && $statement->execute($params))
			{
				echo "insert ok <br>";
			}
		}

		unset($statement);
		unset($params);
		unset($statement2);
		unset($params2);
	}

	/*Supprimer un ami  : id int , id_friend int */
	static public function del_friend($id,$id_friend)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projet_api","root","");
		$params = array(":id" => $id, ":id_friend" => $id_friend);
		$statement = $pdo->prepare("DELETE FROM amitie_confirme WHERE id_users = :id AND id_users_User = :id_friend ");
		if($statement && $statement->execute($params))
		{
			echo "insert ok <br>";
		}

		unset($statement);
		unset($params);
	}

	/*Annuler une demande d'amitier :  : id int , id_friend int  */
	static public function cancel_friend_request($id,$id_friend)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projet_api","root","");
		$params = array(":id" => $id, ":id_friend" => $id_friend);
		$statement = $pdo->prepare("DELETE FROM demande_amitie WHERE id_users = :id AND id_users_User = :id_friend ");
		if($statement && $statement->execute($params))
		{
			echo "insert ok <br>";
		}

		unset($statement);
		unset($params);
	}

	/*Liste de mes amis : $offset int , $limit int*/
	static public function get_friend_list($offset,$limit)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projet_api","root","");
		$statement = $pdo->prepare("SELECT * FROM `amitie_confirme` WHERE `id_users` =1");
		if($statement && $statement->execute($params))
		{
			echo "select ok <br>";
		}

		unset($statement);
		unset($params);	
	}
} 


?>
