<?php


class comment
{
	private $post;
	private $comment;
	private $id_com;

	public function __construct($publication,$commentaire)
	{
		$this->comment = $commentaire;
		$this->post = $publication;
	}

	//permet de créer un commentaire dans la bdd
	public function createComment($post, $text)
	{
		try
			{	
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
			echo "ca passe";

	        $query = "INSERT INTO comment VALUES(:id_comms,:texte, :id_posts)";    

	        //On ajoute des variable à la suite
	         $this->id_com = $pdo->lastInsertId();

	         $req = $pdo->prepare($query);
	         $req->execute(array(
	         	':id_comms' => $this->id_com,
	         	':texte' => $text,
	         	':id_posts' => $post
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

?>