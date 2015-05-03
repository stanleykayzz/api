<?php
class Friend
{
	/* Permet a un utilisateur de faire une demande d'ami  :  int id , int id_friend */
	public function ask_friend_resquest($id,$id_friend)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
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
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");

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
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
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
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
		$params = array(":id" => $id, ":id_friend" => $id_friend);
		$statement = $pdo->prepare("DELETE FROM demande_amitie WHERE id_users = :id AND id_users_User = :id_friend ");
		if($statement && $statement->execute($params))
		{
			echo "insert ok <br>";
		}

		unset($statement);
		unset($params);
	}

	/*Liste de mes amis : $offset int , $limit int , id_user int
	output est un tableau dans lequel est ranger les users qui eux 
	meme on un tableau associatif qui contient leurs differentes infos*/ 	
	public function get_friend_list($offset=0,$limit=1,$id_user)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
		$params = array(":id" => $id_user );
		$statement = $pdo->prepare("SELECT`id_users`, `mail`, `lastname`, `firstname` FROM user where id_users IN (
									SELECT id_users FROM `amitie_confirme` WHERE `id_users_User` = :id
									UNION
									SELECT id_users_User FROM amitie_confirme WHERE  `id_users` = :id )");
		if($statement && $statement->execute($params))
		{
			//Etape 1 : Compter le nombre d'amis
			$count = $statement->rowCount();

		
			echo "select ok <br>";

			$i=0;
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{

					$user[$i] = $row;
					$i++;

				 /*  echo $row["id_users"]; echo "<br>";
				   echo $row["firstname"];  echo "<br>";
				   echo $row["lastname"];  echo "<br><br>";*/
			}
				
			for ($i=0; $i <$limit ; $i++)
			{ 
				$output[$i] = $user[$offset+$i];
			}

			return $output;
		}

		unset($user);
		unset($statement);
		unset($params);	
	}

	/*Permet de faire une recherche sur l’ensemble des utilisateurs. Il faut que l’on
	puisse distinguer parmi ces utilisateurs ceux qui sont déjà amis avec l’utilisateur
	connecté. Attention il ne faut renvoyer l’utilisateur connecté !*/ 
	public function search_friend($offset=0,$limit=1,$id_user,$name)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
		$params = array(":n" => $name , ":u" => $id_user);
		$statement = $pdo->prepare("SELECT`id_users`, `mail`, `lastname`, `firstname` FROM user where (firstname = :n OR  lastname = :n)
									AND id_users NOT IN (SELECT id_users FROM user WHERE id_users = :u)");
		if($statement && $statement->execute($params))
		{
			//Etape 1 : Compter le nombre d'amis
			$count = $statement->rowCount();

		
			echo "select ok <br>";

			$i=0;
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{

					$user[$i] = $row;
					$i++;

				echo "id : ".$row["id_users"]."<br>"; 
				echo "prenom :".$row["firstname"]."<br>";
				echo "nom :".$row["lastname"]."<br>"; 
			}
				
			for ($i=0; $i <$limit ; $i++)
			{ 
				$output[$i] = $user[$offset+$i];
			}

			return $output;
		}

	}

	/*Retourne la liste des utilisateurs comptabilisant le plus de publications dans l’ordre décroissant.
	output est un tableau de user dans user[1] est stoque l'user qui a le plus de publication
	puis dans user[0][id_users] : l'id et user[0][nb_post] le nombre de post */
	public function get_list_user_most_post($offset=0,$limit=1,$id_user)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
		$statement = $pdo->prepare("SELECT id_users, COUNT( id_posts ) AS nb_post FROM post WHERE id_users
									IN (SELECT id_users FROM post GROUP BY id_users) GROUP BY id_users
									ORDER BY COUNT( id_posts ) DESC");
		if($statement && $statement->execute())
		{
			$i=0;
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{

					$user[$i] = $row;
					$i++;

				/*  echo "id : ".$row["id_users"]."<br>"; 
				  echo "nb_post :".$row["nb_post"]."<br>"; */
			}
				
			for ($i=0; $i <$limit ; $i++)
			{ 
				$output[$i] = $user[$offset+$i];
			}

			return $output;
		}

		unset($user);
		unset($statement);
		unset($params);	
	}			
} 


?>
