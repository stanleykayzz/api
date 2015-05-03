<?php

session_start();

//$id = $_SESSION['id'];

class Friend
{
	/* Permet a un utilisateur de faire une demande d'ami  :  int id , int id_friend */
	public function ask_friend_resquest($id,$id_friend)
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
	public function answer_friend_resquest($answer,$id,$id_friend)
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
	public function del_friend($id,$id_friend)
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
	public function cancel_friend_request($id,$id_friend)
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
	public function get_friend_list($offset,$limit=1,$id_user)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projet_api","root","");
		$params = array(":id" => $id_user );
		$statement = $pdo->prepare("SELECT`id_users`, `mail`, `pseudo`, `lastname`, `firstname` FROM user where id_users IN (
									SELECT id_users FROM `amitie_confirme` WHERE `id_users_User` = :id
									UNION
									SELECT id_users_User FROM amitie_confirme WHERE  `id_users` = :id )");
		if($statement && $statement->execute($params))
		{
			//Etape 1 : Compter le nombre d'amis
			$count = $statement->rowCount();

			//Etape 2 : Deduire le nombre de page
			$nb_page = $count/$limit;

			//Etape 3 : nb d'amis de la derniere page
			$last_page = $count%$limit;


			echo "select ok <br>";
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				   echo $row["id_users"]; echo "<br>";
				   echo $row["firstname"];  echo "<br>";
				   echo $row["lastname"];  echo "<br><br>";
				}
		}

		/*$result[];

		


		//Etape 2 : Deduire le nombre de page

		for(i=0;i<nb_page;i++)
		{
			$result[i] = info_page_i;
		} */
		

		unset($statement);
		unset($params);	
	}
} 


?>
