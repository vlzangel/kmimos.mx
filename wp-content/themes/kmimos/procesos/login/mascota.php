<?php  
	include(__DIR__."../../../../../../vlz_config.php");

	$conn = new mysqli($host, $user, $pass, $db);

	$errores = array();

	if ($conn->connect_error) {
        echo 'false';
	}else{
		$razas = $conn->query("SELECT * FROM razas ORDER BY nombre ASC");
		if ($razas->num_rows > 0) {
			$datos = $razas->fetch_assoc();

			foreach ($datos as $dato) 
			{
				echo $dato->id;
				echo $dato->nombre;
			}
		echo json_encode($datos);	
		}


	}
 	

?>