<?php
	
	//permet de créer un commentaire dans la bdd
	function createComment($post, $text)
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

	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}		

	}

?>