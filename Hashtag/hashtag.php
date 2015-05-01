<?php
	require_once("classe_hashtag.php");
	
	$keyword = $_GET["keyword"];
	$params = array();
	
	$hashtag = new Hashtag();
	
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
	

	public function createHashtag($keyword) {
		if(isset($keyword)) {
			if(!empty($keyword)) {
				//on crée des hashtag dans la bdd
				try
				{
					//ON établi une connexion avec la base de données
					if(!($pdo = new PDO("mysql:host=localhost;dbname=projetapi", 'root',''))) {
						$output["code"] = 5;
						$output["result"] = "Internal server error!";
						return json_encode($output);
					}
					
					$params[":keyword"] = $keyword;
					
					$insertHashtag = "INSERT INTO hashtag VALUES(:keyword)";
					
					$state = $pdo->prepare($insertHashtag);
					
					$hashtag->setKeyword($keyword);
					
					if($state and $state->execute($params)) {
						$output["code"] = 0;
						$output["result"] = "OK";
						
						$query = "SELECT * FROM hashtag WHERE keyword = :keyword";
						
						$state = $pdo->prepare($query);
						
						if($state and $state->execute($params)) {
						
							$row = $state->fetch(PDO::FETCH_ASSOC);
							
							$hashtag->setHashtag($$row["id_hashtag"]);
							
							$output["infos"] = array(
								"query"=>$insertHashtag,
								"id_hashtag"=>$hashtag->getHashtag(),
								"keyword"=>$hashtag->getKeyword()
							);
							
							return json_encode($ouput);
						}
						else {
							$output["code"] = 7;
							$output["result"] = "Nothing to select!";
							return json_encode($output);
						}
						
					} else {
						$output["code"] = 6;
						$output["result"] = "Unauthorized action!";
						return json_encode($output);
					}				
				}
				catch (Exception $e){
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
