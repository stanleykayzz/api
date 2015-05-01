<?php

echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";


require_once("C:/wamp/www/Projet_API/Comments/comment.php");

class post
{
	private $user;
	private $idPost;
	private $description;

	//je crée un constructeur pour les publications
	public function __construct($id_user,$des)
	{
		$this->user = $id_user;
		$this->description = $des;		
		$this->createPost($id_user,$des);
	}

	public function createPost($utilisateur,$texte)
	{
		/*Création d’une publication à partir des informations fournies.
Un post contient une description qui est en fait un commentaire.
Donc lors de la création du post il doit être possible de créer un commentaire
- Il est possible d’associer (tagguer) des amis à une publication*/
	

		try
			{	

				//ON établi une connexion avec la base de données
			$pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root','');
	        echo "<br/> ça passe, tu es connecté à la bdd ";

	        //On fait un insert du commentaire dans la table commentaire
	        //on crée une requete sql
	        $query = "INSERT INTO post VALUES(:id_posts, :texte,:id_users)";

			//la description d'un post est un commentaire , on crée donc un commentaire
			$theComment = new comment( $this->idPost, $this->description);	     

			//on récupère le dernier id de post et on l'augmente à chaque post
	        $this->idPost = $pdo->lastInsertId();

	        echo " <br/><br/> <h3>la dernière valeur est ".$this->idPost."</h3>";

	         $req = $pdo->prepare($query);
	         $req->execute(array(
	         	':id_posts' => $this->idPost++,
	         	':texte' => $this->description,
	         	':id_users' => $this->user
	         ));

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

	        //on met à jour 
	        $updateQuery = "UPDATE post SET texte = :texte WHERE id_posts =:id_posts";

	         $req = $pdo->prepare($updateQuery);
	         $req->execute(array(':texte' => $updatedTexte,':id_posts' => $id_publication));

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
	        echo " <br/><br/> <h3>tu viens de supprimer un post </h3>";
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	        echo "ça passe pas";
	}
	}


}

//$publicationDeMoi = new post(2,2,"Quand on fini est projet de php on est léger ;)");
//$publi = new post(1,10,"faut reconnaitre que le java est quand même plus long et plus chiant que le php -_-");
$publi = new post(2,"hello les gens!!!! :)");
$publi->deletePost(8);
$publi->alterPost(5,"Bon moi je vais me coucher, à plus");



?>
