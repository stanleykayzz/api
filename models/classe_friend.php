<?php

class Friend
{
	/* Permet a un utilisateur de faire une demande d'ami  :  int id , int id_friend */
	public function ask_friend_resquest($id,$id_friend)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($id) and !empty($id_friend)) {

			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				unset($pdo);
				return $output;
			}

			$params = array(":id" => $id, ":id_friend" => $id_friend);

			$statement = $pdo->prepare("INSERT INTO demande_amitie (id_users,id_users_User) VALUES (:id,:id_friend) ");

			if($statement and $statement->execute($params))
			{
				$output = array(
					"code"=>0,
					"result"=>"OK",
					"infos"=>array(
						"query"=>"INSERT INTO demande_amitie (id_users,id_users_User) VALUES (".$id.",".$id_friend.")",
						"message"=>"Datas inserted"
					)
				);
				unset($statement);
				unset($pdo);
				return $output;
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error",
					"infos"=>array(
						"query"=>"INSERT INTO demande_amitie (id_users,id_users_User) VALUES (".$id.",".$id_friend.")",
						"message"=>"Datas have not been inserted"
					)
				);
				unset($statement);
				unset($pdo);
				return $output;
			}
		} else {
			$$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			return $output;
		}
	}

	/*Reponder a une demande d'amitier : boolean answer , int id , int id_friend*/ 
	public function answer_friend_resquest($answer,$id,$id_friend)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($answer) and !empty($id) and !empty($id_friend)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				unset($pdo);
				return $output;
			}

			

			if($answer == true)
			{
				$params = array(":id" => $id, ":id_friend" => $id_friend);
				$params2 = array(":id2" => $id, ":id_friend2" => $id_friend);
				$statement = $pdo->prepare("INSERT INTO amitie_confirme (id_users,id_users_User) VALUES (:id,:id_friend); ");
				$statement2 = $pdo->prepare("DELETE FROM demande_amitie WHERE id_users = :id2 AND id_users_User = :id_friend2; ");

				if($statement and $statement->execute($params) and $statement2 and $statement2->execute($params2))
				{
					$output = array(
						"code"=>0,
						"result"=>"OK",
						"infos"=>array(
							"query1"=>"INSERT INTO amitie_confirme (id_users,id_users_User) VALUES (".$id.",".$id_friend.");",
							"query2"=>"DELETE FROM demande_amitie WHERE id_users = ".$id2." AND id_users_User = ".$id_friend2.";",
							"message"=>"Datas inserted"
						)
					);
					unset($pdo);
					unset($statement);
					unset($statement2);
					return $output;
				} else {
					$output = array(
						"code"=>5,
						"result"=>"Internal server error",
						"infos"=>array(
							"query1"=>"INSERT INTO amitie_confirme (id_users,id_users_User) VALUES (".$id.",".$id_friend.");",
							"query2"=>"DELETE FROM demande_amitie WHERE id_users = ".$id2." AND id_users_User = ".$id_friend2.";",
							"message"=>"Datas have not been inserted"
						)
					);
					unset($pdo);
					unset($statement);
					unset($statement2);
					return $output;
				}
			}
			else
			{
				$params = array(":id" => $id, ":id_friend" => $id_friend);
				$params2 = array(":id2" => $id, ":id_friend2" => $id_friend);
				$statement = $pdo->prepare("INSERT INTO annuler_refuser_amitie (id_users,id_users_User) VALUES (".$id.",".$id_friend.")");
				$statement2 = $pdo->prepare("DELETE FROM demande_amitie WHERE id_users = ".$id2." AND id_users_User = ".$id_friend2."; ");

				if($statement and $statement->execute($params) and $statement and $statement2->execute($params2))
				{
					$output = array(
						"code"=>0,
						"result"=>"OK",
						"infos"=>array(
							"query1"=>"INSERT INTO annuler_refuser_amitie (id_users,id_users_User) VALUES (".$id.",".$id_friend.")",
							"query2"=>"DELETE FROM demande_amitie WHERE id_users = ".$id2." AND id_users_User = ".$id_friend2.";",
							"message"=>"Datas has been inserted"
						)
					);
					unset($pdo);
					unset($statement);
					unset($statement2);
					return $output;
				} else {
					$output = array(
						"code"=>5,
						"result"=>"Internal server error",
						"infos"=>array(
							"query1"=>"INSERT INTO amitie_confirme (id_users,id_users_User) VALUES (".$id.",".$id_friend.");",
							"query2"=>"DELETE FROM demande_amitie WHERE id_users = ".$id2." AND id_users_User = ".$id_friend2.";",
							"message"=>"Datas have not been inserted"
						)
					);
					unset($pdo);
					unset($statement);
					unset($statement2);
					return $output;
				}
			}
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			return $output;
		}
	}

	/*Supprimer un ami  : id int , id_friend int */
	public function del_friend($id,$id_friend)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($id) and !empty($id_friend)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				unset($pdo);
				return $output;
			}

			$params = array(":id" => $id, ":id_friend" => $id_friend);

			$statement = $pdo->prepare("DELETE FROM amitie_confirme WHERE id_users = :id AND id_users_User = :id_friend ");

			if($statement && $statement->execute($params))
			{
				$output = array(
					"code"=>0,
					"result"=>"OK",
					"infos"=>array(
						"query"=>"DELETE FROM amitie_confirme WHERE id_users = ".$id." AND id_users_User = ".$id_friend,
						"message"=>"Datas deleted"
					)
				);
				unset($pdo);
				unset($statement);
				return $output;
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error",
					"infos"=>array(
						"query"=>"DELETE FROM amitie_confirme WHERE id_users = ".$id." AND id_users_User = ".$id_friend,
						"message"=>"Datas have not been deleted"
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

	/*Annuler une demande d'amitier :  : id int , id_friend int  */
	public function cancel_friend_request($id,$id_friend)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($id) and !empty($id_friend)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				unset($pdo);
				return $output;
			}

			$params = array(":id" => $id, ":id_friend" => $id_friend);
			$statement = $pdo->prepare("DELETE FROM demande_amitie WHERE id_users = :id AND id_users_User = :id_friend ");

			if($statement && $statement->execute($params))
			{
				$output = array(
					"code"=>5,
					"result"=>"OK",
					"infos"=>array(
						"query"=>"DELETE FROM demande_amitie WHERE id_users = ".$id." AND id_users_User = ".$id_friend,
						"message"=>"Datas deleted"
					)
				);
				unset($pdo);
				unset($statement);
				return $output;
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error",
					"infos"=>array(
						"query"=>"DELETE FROM demande_amitie WHERE id_users = ".$id." AND id_users_User = ".$id_friend,
						"message"=>"Datas have not been deleted"
					)
				);
				unset($pdo);
				unset($statement);
				return $output;
			}
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			return $output;
		}
	}

	/*Liste de mes amis : $offset int , $limit int*/ 	
	public function get_friend_list($offset=0,$limit=1,$id_user)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($offset) and !empty($limit) and !empty($id_user)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				unset($pdo);
				return $output;
			}

			$params = array(":id" => $id_user );

			$statement = $pdo->prepare("SELECT`id_users`, `mail`, `pseudo`, `lastname`, `firstname` FROM user where id_users IN (
										SELECT id_users FROM `amitie_confirme` WHERE `id_users_User` = :id
										UNION
										SELECT id_users_User FROM amitie_confirme WHERE  `id_users` = :id )");

			if($statement && $statement->execute($params))
			{
				//Etape 1 : Compter le nombre d'amis
				$count = $statement->rowCount();

				$i = 0;
				$user = array();
				$output["code"]=0;
				$output["result"]="OK";
				$output["infos"] = array();
				$output["infos"]["query"] = "SELECT`id_users`, `mail`, `pseudo`, `lastname`, `firstname` FROM user where id_users IN ( SELECT id_users FROM `amitie_confirme` WHERE `id_users_User` = ".$id_user." UNION SELECT id_users_User FROM amitie_confirme WHERE `id_users` = ".$id_user." )";

				while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				   $output["infos"]["user".++$i] = $row;
				}

				unset($pdo);
				unset($statement);
				return $output;
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error",
					"infos"=>array(
						"query"=>"SELECT`id_users`, `mail`, `pseudo`, `lastname`, `firstname` FROM user where id_users IN ( SELECT id_users FROM `amitie_confirme` WHERE `id_users_User` = ".$id_user." UNION SELECT id_users_User FROM amitie_confirme WHERE `id_users` = ".$id_user." )",
						"message"=>"Datas have not been found"
					)
				);
				unset($pdo);
				unset($statement);
				return $output;
			}
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			return $output;
		}
	}

	/*Permet de faire une recherche sur l’ensemble des utilisateurs. Il faut que l’on
	puisse distinguer parmi ces utilisateurs ceux qui sont déjà amis avec l’utilisateur
	connecté. Attention il ne faut renvoyer l’utilisateur connecté !*/ 
	public function search_friend($offset=0,$limit=1,$id_user,$name)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($offset) and !empty($limit) and !empty($id_user) and !empty($name)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				unset($pdo);
				return $output;
			}

			$params = array(":n" => $name , ":u" => $id_user);

			$statement = $pdo->prepare("SELECT`id_users`, `mail`, `lastname`, `firstname` FROM user where (firstname = :n OR  lastname = :n)
										AND id_users NOT IN (SELECT id_users FROM user WHERE id_users = :u)");

			if($statement && $statement->execute($params))
			{
				$i=0;
				$output["code"]=0;
				$output["result"]="OK";
				$output["infos"] = array();
				$output["infos"]["query"] = "SELECT`id_users`, `mail`, `lastname`, `firstname` FROM user where (firstname = ".$id_user." OR  lastname = ".$name.") AND id_users NOT IN (SELECT id_users FROM user WHERE id_users = ".$id_user.")";
				while($row = $statement->fetch(PDO::FETCH_ASSOC))
					$output["infos"]["user".++$i] = $row;

				unset($pdo);
				unset($statement);
				return $output;
			} else {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error",
					"infos"=>array(
						"query"=>$output["infos"]["query"] = "SELECT`id_users`, `mail`, `lastname`, `firstname` FROM user where (firstname = ".$id_user." OR  lastname = ".$name.") AND id_users NOT IN (SELECT id_users FROM user WHERE id_users = ".$id_user.")",
						"message"=>"Datas have not been found"
					)
				);
				unset($pdo);
				unset($statement);
				return $output;
			}
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			unset($pdo);
			unset($statement);
			return $output;
		}
	}

	/*Retourne la liste des utilisateurs comptabilisant le plus de publications dans l’ordre décroissant.
	output est un tableau de user dans user[1] est stoque l'user qui a le plus de publication
	puis dans user[0][id_users] : l'id et user[0][nb_post] le nombre de post */
	public function get_list_user_most_post($offset=0,$limit=1,$id_user)
	{
		$host = "localhost";
		$dbname = "projetapi";
		$dbid = "root";
		$dbpsw = "";

		if(!empty($offset) and !empty($limit) and !empty($id_user)) {
			if(!($pdo = new PDO("mysql:host=".$host.";dbname=".$dbname, $dbid, $dbpsw)) != NULL) {
				$output = array(
					"code"=>5,
					"result"=>"Internal server error!",
					"infos"=>array(
						"query"=>"SELECT DB = ".$dbname." WITH id = ".$dbid." AND psw = ".$dbpsw." AND host = ".$host
					)
				);
				unset($pdo);
				return $output;
			}

			$statement = $pdo->prepare("SELECT id_users, COUNT( id_posts ) AS nb_post FROM post WHERE id_users
										IN (SELECT id_users FROM post GROUP BY id_users) GROUP BY id_users
										ORDER BY COUNT( id_posts ) DESC");

			if($statement && $statement->execute())
			{
				$i=0;
				$output["code"]=0;
				$output["result"]="OK";
				$output["infos"]=array();
				$output["infos"]["query"] = "SELECT id_users, COUNT( id_posts ) AS nb_post FROM post WHERE id_users
										     IN (SELECT id_users FROM post GROUP BY id_users) GROUP BY id_users
										     ORDER BY COUNT( id_posts ) DESC";
				while($row = $statement->fetch(PDO::FETCH_ASSOC))
					$output["infos"]["user".$i++] = $row;

				unset($pdo);
				unset($statement);
				return $output;
			} else {
				$output = array(

				);
			}
		} else {
			$output = array(
				"code"=>1,
				"result"=>"Missing required parameter(s)"
			);
			unset($pdo);
			unset($statement);
			return $output;
		}
	}
}

?>
