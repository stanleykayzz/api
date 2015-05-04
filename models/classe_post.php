<?php

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

		/*Création d’une publication à partir des informations fournies.
Un post contient une description qui est en fait un commentaire.
Donc lors de la création du post il doit être possible de créer un commentaire
- Il est possible d’associer (tagguer) des amis à une publication*/
	
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
	}


	}

	public function alterPost($id_publication, $updatedTexte)
	{
		/*2. Mettre à jour une publication
Modifie une publication existante à partir des informations fournies.*/

	try
	{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');

	        //On fait un UPDATE du commentaire dans la table commentaire

	        //on met à jour le post 
	        $updateQuery = "UPDATE post SET texte = :texte WHERE id_posts =:id_posts";

	         $req = $pdo->prepare($updateQuery);
	         $req->execute(array(':texte' => $updatedTexte,':id_posts' => $id_publication));

	        //on met à jour le comment 
	        $updateComm = "UPDATE comment SET texte = :texte WHERE id_posts =:id_posts";

	         $r = $pdo->prepare($updateComm);
	         $r->execute(array(':texte' => $updatedTexte,':id_posts' => $id_publication));

	        echo "ça passe, tu viens de modifier un commentaire dans ta bdd ";
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}

	}

	public function deletePost($id_post)
	{
		/*
3. Supprimer un publication
Supprime une publication à partir de son identifiant. Il faudra penser à
supprimer tous les éléments associés à cette publication.*/

		try
	{		
			//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        echo "ça passe, tu es connecté à la bdd <br/>";

	        //on crée une requete sql
	        $deleteQuery = "DELETE FROM post WHERE id_posts=:id_posts";
		 	$req = $pdo->prepare($deleteQuery);
	        $req->execute(array(':id_posts' => $id_post));


	        //lorsqu'on supprime la publication, on supprime aussi le commentaire associé
	        $deleteComm = "DELETE FROM comment WHERE id_posts=:id_posts";
		 	$r = $pdo->prepare($deleteComm);
	        $r->execute(array(':id_posts' => $id_post));

	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
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