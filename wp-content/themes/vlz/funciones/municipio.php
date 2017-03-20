<?php
	include("../../../../vlz_config.php");
	extract($_POST);
	$conn_my = new mysqli($host, $user, $pass, $db);
	$sql = "SELECT * FROM locations WHERE state_id = '$estado' ORDER BY name";
	$result = $conn_my->query($sql);
		echo ( "<option value=''>Seleccione una Delegaci&oacute;n</option>" );
	while ($municipio = $result->fetch_assoc()){
		echo ( "<option value='{$municipio['id']}'>{$municipio['name']}</option>" );
	}
?>