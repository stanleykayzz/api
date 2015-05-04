<?php


class comment {

	//permet de créer un commentaire dans la bdd
	public function createComment($post, $text)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($post) and !empty($text) and !empty($_SESSION["id_user"])) {

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

?>