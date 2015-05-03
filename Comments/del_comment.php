<?php

	//permet de supprimer les commentaires dont l'id est passé en paramètre
	function deleteComment($idComm)
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

?>