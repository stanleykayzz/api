<?php


class comment
{
	private $post;
	private $comment;
	private $id_com;
	private $id_user;

	public function __construct()
	{
		$this->comment = "";
		$this->post = 0;
		$this->id_user = 0;
	}

	//permet de créer un commentaire dans la bdd
	public function createComment($post, $text, $user)
	{

		$this->comment = $text;
		$this->post = $post;
		$this->id_user = $user;
		try
			{	
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
			echo "ca passe";

	        $query = "INSERT INTO comment VALUES(:id_comms,:texte, :id_posts, :id_users)";    

	        //On ajoute des variable à la suite
	         $this->id_com = $pdo->lastInsertId();

	         $req = $pdo->prepare($query);
	         $req->execute(array(
	         	':id_comms' => $this->id_com,
	         	':texte' => $text,
	         	':id_posts' => $post,
	         	':id_users' => $user
	         ));

	         unset($req);

	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}		

	}

	public function alterComment($idcom,$modifText) 
	{
		$this->comment = $modifText;
			try
			{		

				$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
				echo " alter";

				//on met à jour 
				$updateQuery = "UPDATE comment SET texte = :texte WHERE id_comms = :id_com";

				$req = $pdo->prepare($updateQuery);
	 	        $req->execute(array(':texte' => $modifText,':id_com' => $idcom ));

	 	    	unset($req);
	 	    }
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}	

	}

	//permet de supprimer les commentaires dont l'id est passé en paramètre
	public function deleteComment($idComm)
	{
		try
			{	

			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
			echo "ca passe";
  
	        $deleteQuery = "DELETE FROM comment WHERE id_comms = :id_comms";
				$state = $pdo->prepare($deleteQuery);

	         $req = $pdo->prepare($deleteQuery);
	         $req->execute(array(
	         	':id_comms' => $idComm
	         ));

	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}		

	}
}


$v = new comment();
//$v->createComment(1,"je commente la première publication de stanleyKayzz",2);
//$v->createComment(1,"c'est bien , continue comme ca alors :p",1);
//$v->createComment(1," blala",1);
//$v->alterComment(1,"je viens de modifier mon commentaire",1);

?>