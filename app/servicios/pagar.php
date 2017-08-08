<?php
	$path = dirname(dirname(__DIR__));

	include( $path."/app/db.php");
	include( $path."/app/funciones.php");

	extract($_POST);

	$data = explode("===", $_POST["carrito"]);
	$info = array();
	foreach ($data as $key => $value) {
		$info[] = json_decode($value);
	}

	echo json_encode( array(
		"info" => $_POST,
		"data" => $info
	) );

?>