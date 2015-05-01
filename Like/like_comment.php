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

	public function __construct($idComment,$idUser)
	{
		$this->comment = $idComment;
		$this->like = false;
		$this->iLikeYourComment($idComment,$idUser);
	}


	function iLikeYourComment($id_commentaire, $id_utilisateur)
	{
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
	        $deleteQuery = "DELETE FROM liker_comment WHERE id_comms=:id_comms,id_users=:id_users";
		 	$req = $pdo->prepare($deleteQuery);
	        $req->execute(array(':id_comms' => $id_commentaire,':id_users' => $id_utilisateur));
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}		
	}
}

$iLikeMyCo = new likeComment(1,2);
$iLikeMyCo->iDislikeYourComment(30,1);
$iLikeMyCo->iDislikeYourComment(28,2);

?>
