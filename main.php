﻿<?php
	session_start();
	
	include_once 'models/classe_user.php';
	include_once 'models/classe_friend.php';
	include_once 'models/classe_comment.php';
	include_once 'models/classe_hashtag.php';
	include_once 'models/classe_post.php';
	
	try {
		//Obtenir tous les parametres des requete POST OU GET
		$params = $_REQUEST;
		
		$controller = ucfirst(strtolower($params['controller']));
		
		if(isset($params["mail"]) and isset($params["psw"]) or isset($params["lastname"]) or isset($params["firstname"])) {
			
			$action = strtolower($params['action']).'User';
			
			if(file_exists("controllers/{$controller}.php")) {
				include_once "controllers/{$controller}.php";
			} else {
				throw new Exception('Controller : '.$controller.' is invalid');
			}
			
			$controller = new $controller($params);
			
			if(method_exists($controller, $action) === false) {
				throw new Exception('Action : '.$action.'is invalid');
			}
			
			$output['data'] = $controller->$action();
			$output['result'] = "OK";
		}
		else if(isset($params["id"]) and isset($params["id_friend"]) or isset($params["answer"]) or isset($params["offset"]) or isset($params["limit"])) {
			$action = strtolower($params['action']).'Friend';
			
			if(file_exists("controllers/{$controller}.php")) {
				include_once "controllers/{$controller}.php";
			} else {
				throw new Exception ('Controller : '.$controller.' is invalid');
			}
			
			$controller = new $controller($params);
			
			if(method_exists($controller, $action) === false) {
				throw new Exception('Action : '.$action.'is invalid');
			}
			
			$output['data'] = $controller->$action();
			$output['result'] = "OK";
		}
		else if(isset($params["id_comms"]) and isset($params["texte"])) {
			$action = strtolower($params['action']).'Comment';

			if(file_exists("controllers/{$controller}.php")) {
				include_once "controllers/{$controller}.php";
			} else {
				throw new Exception('Controller : '.$controller.' is invalid');
			}

			$output['data'] = $controller->$action();
			$output['result'] = "OK";
		}
		
		
	} catch(Exception $e) {
		$output = array("code"=>8, "result"=>$e->getMessage());
	}
	
	
	echo json_encode($output);
	exit();
?>
