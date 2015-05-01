<?php	
	$array = array();
	
	$input = array();
	$input["code"] = 0;
	$input["result"] = "OK";
	
	$input["infos"] = array(
		"query"=>"query"
	);
	
	print_r($input);
	
	echo var_dump($input["infos"]);
	echo var_dump($array);
	
	if(var_dump($input["infos"]) === var_dump($array)) echo "<br/>is array";
	else echo "<br/>is not array";
	
	$xml = xml_encode($input, $array);
	
	print_r($xml);
	
	
	function xml_encode($input, $isArray) {
	
		$xml_input = "<?xml version=\"1.0\"?>";
		
		if(var_dump($input) === var_dump($isArray)) {
		
			foreach($input as $key => $value) {
			
				$xml_input = strcat($xml_input, "<".$key.">");
				
				if(var_dump($input["".$key.""]) === var_dump($isArray)) {
				
					foreach($input["".$key.""] as $key2=>$value2) {
					
						$xml_input = strcat($xml_input, "<".$key2.">".$value2."</".$key2.">");
					}
					
					$xml_input = strcat($xml_input, "</".$key.">");
					
				} else $xml_input = strcat($xml_input, $value."</".$key.">");
			}
		} else {
			foreach($input as $key => $value) {
				$xml_input = strcat($xml_input, "<".$key.">".$value."</".$key.">");
			}
		}
		
		return $xml_input;
	}
?>
