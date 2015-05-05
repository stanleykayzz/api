<?php
/*
2. « Liker » un commentaire
Doit permettre d’aimer ou de ne plus aimer un commentaire
*/

class like
{

	function likeComment($id_commentaire, $id_utilisateur)
	{
		$params = array(
			":id_comms"=>$id_commentaire,
			":id_users"=>$id_utilisateur
		);

		try
			{	
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        $query = "INSERT INTO liker_comment VALUES(:id_comms, :id_users)";    

	        $req = $pdo->prepare($query);
	        $req->execute($params);
	         }
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}		

	}

	function dislikeComment($id_commentaire,$id_utilisateur)
	{
		try
		{		
			$params = array(
				":id_comms"=>$id_commentaire,
				":id_users"=>$id_utilisateur
			);
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');

	        //on crée une requete sql
	        $deleteQuery = "DELETE FROM liker_comment WHERE id_comms=:id_comms AND id_users=:id_users";
		 	$req = $pdo->prepare($deleteQuery);
	        $req->execute($params);
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}		
	}

	function likePost($id_publication, $id_utilisateur)
	{

		try
			{	
				$params = array(
					":id_comms"=>$id_commentaire,
					":id_users"=>$id_utilisateur
				);
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        $query = "INSERT INTO liker_post VALUES(:id_posts, :id_users)";    

	        $req = $pdo->prepare($query);
	        $req->execute(array(
	         	':id_comms' => $id_publication,
	         	':id_users' => $id_utilisateur
	         ));
	         }
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}		

		return $this->likepost = true;
	}

	function dislikePost($id_publication,$id_utilisateur)
	{
		try
		{		
			$params = array(
				":id_comms"=>$id_commentaire,
				":id_users"=>$id_utilisateur
			);
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');

	        //on crée une requete sql
	        $deleteQuery = "DELETE FROM liker_post WHERE id_comms=:id_comms AND id_users=:id_users";
		 	$req = $pdo->prepare($deleteQuery);
	        $req->execute(array(':id_posts' => $id_publication,':id_users' => $id_utilisateur));
	    }
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}	
	}


}

?>