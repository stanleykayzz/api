<?php

<<<<<<< HEAD

class comment {
=======
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
>>>>>>> 9d3e710e7e425ab73e5af594199eb9cd9a92f862

	//permet de créer un commentaire dans la bdd
	public function createComment($post, $text, $user)
	{
<<<<<<< HEAD
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($post) and !empty($text) and !empty($_SESSION["id_user"])) {
=======
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
>>>>>>> 9d3e710e7e425ab73e5af594199eb9cd9a92f862

			//ON établi une connexion avec la base de données
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				return $output;
			}  

	         $params = array(
	         	":text"=>$text,
	         	":id_posts"=>$post,
	         	":id_user"=>$_SESSION["id_user"]
	         );

	         $state = $pdo->prepare("INSERT INTO comment VALUES(:texte, :id_posts)");

	         if($state and $state->execute($params)) {
	         	$output = array(
	         		"code"=>0,
	         		"result"=>"OK",
	         		"infos"=>array(
	         			"query"=>"INSERT INTO comment VALUES(".$text.", ".$post.")",
	         			"message"=>"Datas Inserted"
	         		)
	         	);
	         } else {
	         	$output = array(
	         		"code"=>5,
	         		"result"=>"Internal server error",
	         		"infos"=>array(
	         			"query"=>"INSERT INTO comment VALUES(".$this->id_com.", ".$text.", ".$post.")",
	         			"message"=>"Datas have not been inserted"
	         		)
	         	);
	         }
	        unset($pdo);
	        unset($state);
	        return $output;
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			return $output;
		}
	}

	public function alterComment($idcom,$modifText) 
	{
<<<<<<< HEAD
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($idcom) and !empty($modifText)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				return $output;
			}

			$params = array(
				":id_com"=>$idcom,
				":texte"=>$modifText,
			);

			$state = $pdo->prepare("UPDATE comment SET texte = :texte WHERE id_comms = :id_com");

			if($state and $state->execute($params)) {
				$output = array(
					"code"=>0,
					"result"=>"OK",
					"infos"=>array(
						"query"=>"UPDATE comment SET texte = ".$modifText." WHERE id_comms = ".$idcom,
						"message"=>"Datas updated"
					)
				);
			} else {
				$output = array(
	         		"code"=>5,
	         		"result"=>"Internal server error",
	         		"infos"=>array(
	         			"query"=>"INSERT INTO comment VALUES(".$this->id_com.", ".$text.", ".$post.")",
	         			"message"=>"Datas have not been inserted"
	         		)
	         	);
			}
			unset($pdo);
		    unset($state);
		    return $output;
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			return $output;
		}
=======
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

>>>>>>> 9d3e710e7e425ab73e5af594199eb9cd9a92f862
	}

	//permet de supprimer les commentaires dont l'id est passé en paramètre
	public function deleteComment($idComm)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($idComm)) {
			//ON établi une connexion avec la base de données
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				return $output;
			}

			$params = array(":id_comms"=>$idComm);

			$state = $pdo->prepare("DELETE FROM comment WHERE id_comms = :id_comms");

			if($state and $state->execute($params)) {
				$output = array(
					"code"=>0,
					"result"=>"OK",
					"infos"=>array(
						"query"=>"DELETE FROM comment WHERE id_comms = ".$idComm,
						"message"=>"Datas deleted"
					)
				);
			} else {
				$output = array(
	         		"code"=>5,
	         		"result"=>"Internal server error",
	         		"infos"=>array(
	         			"query"=>"DELETE FROM comment WHERE id_comms = ".$idComm,
	         			"message"=>"Datas have not been inserted"
	         		)
	         	);
			}
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			return $output;
		}		
	}
}


$v = new comment();
//$v->createComment(1,"je commente la première publication de stanleyKayzz",2);
//$v->createComment(1,"c'est bien , continue comme ca alors :p",1);

?>