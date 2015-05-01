<?php
	require_once("classe_comment.php");
	
	$output = array();
	$params = array();
	
	$modifText = $_GET["modifText"];
	$text = $_GET["text"];
	$id_com = $_GET["id_com"];
	$post = $_GET["id_post"];
	
	$comment = new Comment();
	
	if(isset($_GET["host"])) {
		if(!empty($_GET["host"])) {
			$host = $_GET["host"];
		} else $host = "localhost";
	} else $host = "localhost";
	
	if(isset($_GET["dbname"])) {
		if(!empty($_GET["dbname"])) {
			$dbname = $_GET["dbname"];
		} else $dbname = "projetapi";
	} else $dbname = "projetapi";
	
	if(isset($_GET["dbid"])) {
		if(!empty($_GET["dbid"])) {
			$dbid = $_GET["dbid"];
		} else $dbid = "root";
	} else $dbid = "projetapi";
	
	if(isset($_GET["dbpsw"])) {
		if(!empty($_GET["dbpsw"])) {
			$dbpsw = $_GET["dbpsw"];
		} else $dbpsw = "";
	}else $dbpsw = "";
	
/*
1. Créer un commentaire
Créer un commentaire sur un post.
Il doit être possible :
- d’identifier des amis,
- d’intégrer des « hashtags » dans le contenu du commentaire.
Il faudra ensuite prévoir d’extraire les « hashtags » pour les associer au
commentaire et ainsi permettre une recherche par « hashtag »
*/

public function createComment($text)
{
	if(isset($text)) {
		if(!empty($text)) {
			try
			{		
				//ON établi une connexion avec la base de données
				if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw))) {
					$output["code"] = 5;
					$output["result"] = "Internal server error!";
					$output["infos"] = array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host=".$host,
						"error"=>"You should probably check out the DB id and psw. Else check out your hostname."
					);
					return json_encode($output);
				}
				
				//On fait un insert du commentaire dans la table commentaire
				
				//on crée une requete sql
				$query = "INSERT INTO comment VALUES(:texte, :id_posts)";
				
				$comment->setText(':text');
				$comment->setPost(':id_posts');
				
				$params[':text'] = $comment->getText();
				$params[':id_posts'] = $this->getPost();

				$state = $pdo->prepare($query);
				
				if($state and $state->execute($params)) {
					$output["code"] = 0;
					$output["result"] = "OK";
					$output["infos"] = array(
						"query"=>$query,
						"id_com"=>$comment->getId(),
						"text"=>$comment->getText(),
						"id_post"=>$comment->getPost()
					);
					return json_encode($output);
				} else {
					$output["code"] = 7;
					$output["result"] = "Nothing to insert!";
					$output["infos"] = array(
						"query"=>$query
					);
					return json_encode($output);
				}
			}
			catch (Exception $e)
			{
				$output["code"] = 6;
				$output["result"] = "Unauthorized action!";
				$output["infos"] = array(
					"query"=>$query,
					"error"=>$e->getMessage()
				);
				return json_encode($output);
			}
		} else {
			$output["code"] = 1;
			$output["result"] = "Missing required parameter(s)!";
			$output["infos"] = array(
				"query"=>$query
			);
			return json_encode($output);
		}
	} else {
		$output["code"] = 1;
		$output["result"] = "Missing required parameter(s)!";
		$output["infos"] = array(
			"query"=>$query
		);
		return json_encode($output);
	}
}

	/*
2. Modifier un commentaire
Modifie un commentaire existant à partir des informations fournies.
!7
*/

public function alterComment($id_com, $modifText) {
	if(isset($id_com) and isset($modifText)) {
		if(!empty($id_com) and !empty($modifText)) {
			try
			{		
				//ON établi une connexion avec la base de données
				if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw))) {
					$output["code"] = 5;
					$output["result"] = "Internal server error!";
					$output["infos"] = array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host=".$host,
						"error"=>"You should probably check out the DB id and psw. Else check out your hostname."
					);
					return json_encode($output);
				}
				
				$params[':text'] = $modifText;
				$params[':id_com'] = $id_com;

				//on met à jour 
				$updateQuery = "UPDATE comment SET texte = :texte WHERE id_comms =:id_com";
				
				$comment->setText($modifText);
				$comment->setPost($id_post);

				$state = $pdo->prepare($updateQuery);
				
				if($state and $state->execute($params)) {
					$output["code"] = 0;
					$output["result"] = "OK";
					$output["infos"] = array("id_com"=>$comment->getId(), "text"=>$comment->getText(), "post"=>$comment->getPost());
					return json_encode($output);
				} else {
					$output["code"] = 7;
					$output["result"] = "Nothing to update!";
					return json_encode($output);
				}
			}
			catch (Exception $e)
			{
				$output["code"] = 6;
				$output["result"] = "Unauthorized action!";
				return json_encode($output);
			}
		} else {
			$output["code"] = 1;
			$output["result"] = "Missing required parameter(s)!";
			return json_encode($output);
		}
	} else {
		$output["code"] = 1;
		$output["result"] = "Missing required parameter(s)";
		return json_encode($output);
	}
}

/*
3. Supprimer un commentaire
Supprime un commentaire à partir de son identifiant. Il faudra penser à
supprimer tous les éléments associés à ce commentaire.
*/

public function DeleteComment($id_com)
{
	if(isset($id_com)) {
		if(!empty($id_com)) {
			try
			{		
				//ON établi une connexion avec la base de données
				if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw))) {
					$output["code"] = 5;
					$output["result"] = "Internal server error!";
					$output["infos"] = array(
						"query"=>"SELECT DB = "$dbanme."WITH id = "$dbid." AND psw = ".$dbpsw." AND host = ".$dbhost,
						"error"=>"You should probably check out the DB id and psw. Else check out your hostname."
					);
					return json_encode($output);
				}
				
				//On fait un delete du commentaire dont l'id est passé en paramètre
				
				$params[":id_com"] = $id_com;

				//on crée une requete sql
				$deleteQuery = "DELETE FROM comment WHERE id_com = :id_com";
				$state = $pdo->prepare($deleteQuery);
				
				if($state and $state->execute($params)) {
					$output["code"] = 0;
					$output["result"] = "OK";
					$output["infos"] = "DELETE FROM comment WHERE id_com = ".$id_com;
					return json_encode($output);
				} else {
					$output["code"] = 7;
					$output["result"] = "Nothing to delete!";
					return json_encode($output);
				}
			}
			catch (Exception $e)
			{
				$output["code"] = 6;
				$output["result"] = "Unauthorized action!";
				return json_encode($output);
			}
		} else {
			$output["code"] = 1;
			$output["result"] = "Missing required parameter(s)!";
			return json_encode($output);
		}
	} else {
		$output["code"] = 1;
		$output["result"] = "Missing required parameter(s)!";
		return json_encode($output);
	}
}

?>
