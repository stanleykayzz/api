<?php
/*
2. « Liker » un commentaire
Doit permettre d’aimer ou de ne plus aimer un commentaire
*/

class likeComment
{
	private $comment;
	private $like;
	private $user;

	public function __construct()
	{
		$this->comment = 0
		$this->user = 0;
	}

	function iLikeYourComment($id_commentaire, $id_utilisateur)
	{
		$this->comment = $id_commentaire;
		$this->user = $id_utilisateur;

		try
			{	
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        $query = "INSERT INTO liker_comment VALUES(:id_comms, :id_users)";    

	        $req = $pdo->prepare($query);
	        $req->execute(array(
	         	':id_comms' => $id_commentaire,
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

	function iDislikeYourComment($id_commentaire,$id_utilisateur)
	{
		try
		{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');

	        //on crée une requete sql
	        $deleteQuery = "DELETE FROM liker_comment WHERE id_comms=:id_comms AND id_users=:id_users";
		 	$req = $pdo->prepare($deleteQuery);
	        $req->execute(array(':id_comms' => $id_commentaire,':id_users' => $id_utilisateur));
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