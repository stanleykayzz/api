<?php
<<<<<<< HEAD
class post
{
	private $user;
	private $idPost;
	private $text;//on passe un objet commentaire en parametre
=======

echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";

require_once("classe_comment.php");

class post 
{
	private $user;
	private $idPost;
	private $datePost;
	private $limit;
	private $offset;
	private $description;//on passe un objet commentaire en parametre

	//je crée un constructeur pour les publications
	public function __construct()
	{
		$this->user = 0;
		$this->description = "";
	}

	public function createPost($utilisateur,$texte,$date)
	{
		$this->description = $texte;
		$this->users = $utilisateur;
		$this->datePost = $date;
>>>>>>> 9d3e710e7e425ab73e5af594199eb9cd9a92f862

	public function createPost($texte) {
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";
		/*Création d’une publication à partir des informations fournies.
Un post contient une description qui est en fait un commentaire.
Donc lors de la création du post il doit être possible de créer un commentaire
- Il est possible d’associer (tagguer) des amis à une publication*/
<<<<<<< HEAD

		if(!empty($texte) and !empty($_SESSION["id_user"])) {
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

			//ON initialise les parametres de la requete
			$params = array(
				":texte"=>$texte,
				":id_users"=>$_SESSION["id_user"]
			);

	        //On fait un insert du texte dans la table publication
	        //on crée une requete sql
			$state = $pdo->prepare("INSERT INTO post VALUES(:texte,:id_users)");
			if($state and $state->execute($params)) {
				$output = array(
					"code"=>0,
					"result"=>"OK",
					"infos"=>array(
						"query"=>"INSERT INTO post VALUES(".$texte.", ".$_SESSION["id_user"].")",
						"message"=>"Data inserted"
					)
				);
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"INSERT INTO post VALUES(".$texte.", ".$_SESSION["id_user"].")",
						"message"=>"Date have not been inserted"
					)
				);
			}
			unset($state);
			unset($pdo);
			return $output;
		}		
=======
	
		try
			{	
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
			echo "xxxxxxx";
			 //On fait un insert du texte dans la table publication
	        //on crée une requete sql
	        $query = "INSERT INTO post VALUES(:id_posts, :texte, :datePost, :id_users)"; 
	        echo "on créé une publication";
			//on récupère le dernier id de post et on l'augmente à chaque post
	        //$this->idPost = $pdo->lastInsertId();

	        $lastIdpost = $pdo->lastInsertId();

	         $req = $pdo->prepare($query);
	         $req->execute(array(
	         	':id_posts' => $lastIdpost++,
	         	':texte' => $texte,
	         	':datePost' => $date,
	         	':id_users' => $utilisateur
	         ));

	        $statement = $pdo->query("SELECT * FROM `post`");
    		while($row =$statement->fetch(PDO::FETCH_ASSOC) ){
	        $Idpost=$row["id_posts"];}	        

	        //On fait un insert du commentaire dans la table commentaire
			//la description d'un post est un commentaire , on crée donc un commentaire
			//dont l'idPost est le post actuel et le texte celui du commentaire
			$theComment = new comment();	
			$theComment->createComment($Idpost, $texte, $utilisateur);

	        echo "ça passe, tu viens de rajouter un post dans ta bdd ";
		
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
>>>>>>> 9d3e710e7e425ab73e5af594199eb9cd9a92f862
	}

	public function alterPost($id_publication, $updatedTexte) {
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		/*2. Mettre à jour une publication
Modifie une publication existante à partir des informations fournies.*/

		if(!empty($id_publication) and !empty($updatedTexte) and !empty($_SESSION["id_user"])) {
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

		    //On fait un UPDATE du commentaire dans la table commentaire

		    //on met à jour le post 
		    $params = array(
		    	":texte"=>$updatedTexte,
		    	":id_posts"=>$id_publication,
		    	"id_user"=>$_SESSION["id_user"]
		    );

			$state = $pdo->prepare("UPDATE post SET texte = :texte WHERE id_posts =:id_posts");

			if($state and $state->execute($params)) {
				$output = array(
					"code"=>0,
					"result"=>"OK",
					"infos"=>array(
						"query"=>"UPDATE post SET texte = ".$updatedTexte." WHERE id_posts = ".$id_publication,
						"message"=>"Data modified"
					)
				);
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"UPDATE post SET texte = ".$updatedTexte." WHERE id_posts = ".$id_publication,
						"message"=>"Date have not been modified"
					)
				);
			}

			unset($pdo);
			unset($state);
			return $output;
		}
	}

	public function deletePost($id_post) {
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		/*
3. Supprimer un publication
Supprime une publication à partir de son identifiant. Il faudra penser à
supprimer tous les éléments associés à cette publication.*/

		if(!empty($id_post) and !empty($_SESSION["id_user"])) {
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
				":id_posts"=>$id_post,
				":id_user"=>$id_user
			);

	        //lorsqu'on supprime la publication, on supprime aussi le commentaire associé
	        $state = $pdo->prepare("DELETE FROM comment WHERE id_posts=:id_posts AND id_users = :id_user");
		 	

		 	if($state and $state->execute($params)) {
		 		//On supprime le post
		 		$state2 = $pdo->prepare("DELETE FROM post WHERE id_posts=:id_posts AND id_users = :id_user");

		 		if($state2 and $state2->execute($params)) {
		 			$output = array(
		 				"code"=>0,
		 				"result"=>"OK",
		 				"infos"=>array(
		 					"query"=>"DELETE FROM comment WHERE id_posts=".$id_publication." AND id_users = :".$_SESSION["id_user"],
		 					"message"=>"comment(s) deleted"
		 				)
		 			);
		 			unset($state2);
		 			unset($state);
		 			unset($pdo);
		 			return $output;
		 		} else {
		 			$output = array(
		 				"code"=>5,
		 				"result"=>"Internal server error",
		 				"infos"=>array(
		 					"query"=>"DELETE FROM comment WHERE id_posts=".$id_publication." AND id_users = :".$_SESSION["id_user"],
		 					"message"=>"comment(s) has not been deleted"
		 				)
		 			);
		 			unset($state);
		 			unset($state2);
		 			unset($pdo);
		 			return $output;
		 		}
		 	}
		}
	}

	/*

	4. Liste des publications concernant l'utilisateur
	connecté et de ses amis (Timeline)
	Retourne la liste des publications des amis de l'utilisateur
	connecté ainsi que les siennes. Le tout doit être par date.

	NB : il faudra utiliser un système de pagination sur les résultats
	ce service prendra en paramètre:
	offset: la position du premier element à envoyer
	limit: Nombre d'éléments à renvoyer*/

	public function Timeline($connectedUser, $offset=0, $limit=5)
	{
		$this->limit = $limit;
		$this->offset = $offset;
		$nbrPublication=0;
		$l=$limit;

		try
		{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
			// on affiche seulement les status de l'utilisateur connecté
	        $statement = $pdo->query("SELECT * FROM post WHERE id_users = ".$connectedUser."order by datePost desc limit ".$offset.", ".$limit);
    		for($o=$offset;$line = $statement->fetch(PDO::FETCH_ASSOC);$o++){
    		$post = new post();
    		$post->createPost($line["id_posts"], $line["texte"],$line["datePost"], $line["id_users"]);
    		$postList[$o]= $post;
    		$nbrPublication++;
    	}
	}
	catch (Exception $e)
	{
	    die('Erreur : ' . $e->getMessage());
	    echo "ça passe pas";
	}

	for($i=$offset;$i<$l;$i++)
	{
		$resultList[$i] = $postList[$i];
		echo "<br/> ".$resultList[$i]." <br/>";
	}
		return $resultList;
	}
}

<<<<<<< HEAD
?>
=======
//$publicationDeMoi = new post(2,2,"Quand on fini est projet de php on est léger ;)");
//$publi = new post(1,10,"faut reconnaitre que le java est quand même plus long et plus chiant que le php -_-");
//$publi = new post(1," der des der ");
//$publi->Timeline(1,0,2);
//$publi->deletePost(19);
//$publi->alterPost(5,"Bon moi je vais me coucher, à plus");
$p = new post();
$p->Timeline(1,0,2);
//$p->createPost(1," me too ",'2013-06-27');
//$p->createPost(2," mewtwo ",'2014-06-27');

?>
>>>>>>> 9d3e710e7e425ab73e5af594199eb9cd9a92f862
