<?php
	class Hashtag {
		public function createHashtag($mot) {
			$host = "localhost";
			$dbname = "projetapi";
			$dbid = "root";
			$dbpsw = "";

			if(!empty($mot)) {
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

				$params = array(":mot"=>$mot);

				$state = $pdo->prepare("INSERT INTO hashtag (mot) VALUES(:mot)");

				if($state and $state->execute($params)) {
					$output = array(
						"code"=>0,
						"result"=>"OK",
						"infos"=>array(
							"query"=>"INSERT INTO hashtag (mot) VALUES(".$mot.")",
							"message"=>"Datas has been inserted"
						)
					);
					unset($pdo);
					unset($state);
					return $output;
				} else {
					$output = array(
						"code"=>5,
						"result"=>"Internal server error",
						"infos"=>array(
							"query"=>"INSERT INTO hashtag (mot) VALUES(".$mot.")",
							"message"=>"Datas have not been inserted"
						)
					);
					unset($pdo);
					unset($state);
					return $output;
				}
			}
		}
	}
?>