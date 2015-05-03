<?php

class Like
{
	/* Permet a un utilisateur de faire une demande d'ami  :  int id , int id_friend */
	public function like_publication($id_user,$id_post)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
		$params = array(":u" => $id_user, ":p" => $id_post);
		$statement = $pdo->prepare("INSERT INTO `liker_post`(`id_users`, `id_posts`) VALUES (:u,:p)");
		if($statement && $statement->execute($params))
		{
			echo "insert ok <br>";
		}

		unset($statement);
		unset($params);
	}

		public function like_comment($id_user,$id_com)
	{
		$pdo = new PDO("mysql:host=localhost;dbname=projetapi","root","");
		$params = array(":u" => $id_user, ":c" => $id_com);
		$statement = $pdo->prepare("INSERT INTO `liker_comment`(`id_comms`, `id_users`) VALUES (:c,:u)");
		if($statement && $statement->execute($params))
		{
			echo "insert ok <br>";
		}

		unset($statement);
		unset($params);
	}

} 


?>