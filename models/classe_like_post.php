<?php
/*
2. « Liker » un commentaire
Doit permettre d’aimer ou de ne plus aimer un commentaire
*/

class likePost
{
	private $post;
	private $like;
	private $user;

	public function __construct()
	{
		$this->post = 0
		$this->user = 0;
	}

	function iLikeYourPost($id_publication, $id_utilisateur)
	{
		$this->post = $id_publication;
		$this->user = $id_utilisateur;

		try
			{	
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        $query = "INSERT INTO liker_comment VALUES(:id_posts, :id_users)";    

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

		return $this->like = true;
	}

	function iDislikeYourPost($id_publication,$id_utilisateur)
	{
		try
		{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');

	        //on crée une requete sql
	        $deleteQuery = "DELETE FROM liker_comment WHERE id_comms=:id_comms AND id_users=:id_users";
		 	$req = $pdo->prepare($deleteQuery);
	        $req->execute(array(':id_posts' => $id_publication,':id_users' => $id_utilisateur));
	    }
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}	
		return $this->like = false;	
	}
}

?>