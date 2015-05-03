<?php	
	define('DATA_PATH', realpath(dirname(__FILE__).'/data'));
	
	include_once 'models/classe_user.php';
	
	try {
		//Obtenir tous les parametres des requete POST OU GET
		$params = $_REQUEST;
		
		$controller = ucfirst(strtolower($params['controller']));
		
		$action = strtolower($params['action']).'User';
		
		if(file_exists("controllers/{$controller}.php")) {
			include_once "controllers/{$controller}.php";
		} else {
			throw new Exception('Controller : '.$controller.' is invalid');
		}
		
		$controller = new $controller($params);
		
		if(method_exists($controller, $action) === false) {
			throw new Exception('Action is invalid');
		}
		
		$output['data'] = $controller->$action();
		$output['result'] = "OK";
	} catch(Exception $e) {
		$output = array("code"=>8, "result"=>$e->getMessage());
	}
	
	echo json_encode($output);
	exit();
?>
