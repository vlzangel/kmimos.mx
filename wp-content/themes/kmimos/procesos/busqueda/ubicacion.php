<?php
	include("../../../../../vlz_config.php");
	include("../funciones/db.php");

	$conn = new mysqli($host, $user, $pass, $db);
	$db = new db($conn);

	$estados_str = "";
    $estados = $db->get_results("SELECT * FROM states WHERE country_id = 1");
    foreach ($estados as $key => $value) {
    		
		$municipios = $db->get_results("SELECT * FROM locations WHERE state_id = ".$value->id);
		if( count($municipios) > 1 ){
    		foreach ($municipios as $key => $municipio) {
    			$estados_str .= ("<div value='".$value->id."=".$municipio->id."'>".$value->name.", ".$municipio->name."</div>");
    		}
		}

    }

    echo $estados_str;
?>