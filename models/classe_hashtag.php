<?php
	class hashtag {

		private $hashtag;
		private $motCle;

		public function __construct()
		{
			$this->hashtag= 0;
			$this->motCle= "";
		}

		public function createHashtag($mot)
		{
		$this->motCle = $mot;
			try
			{	
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        $query = "INSERT INTO hashtag VALUES(:id_hashtag, :mot)";    

	        //On recupere la derniere valeur de la table hashtag
	         $this->this->hashtag = $pdo->lastInsertId();

	        $req = $pdo->prepare($query);
	        $req->execute(array(
	         	':id_hashtag' => $this->hashtag,
	         	':mot' => $mot
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