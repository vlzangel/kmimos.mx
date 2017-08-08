<?php
	$path = dirname(dirname(__DIR__));

	include( $path."/app/db.php");
	include( $path."/app/funciones.php");

	extract($_POST);

	$sql = "
		SELECT 
			acepta,
			cupos,
			fecha,
			full,
			no_disponible
		FROM 
			cupos WHERE servicio = '{$servicio}'";

	$data  = array();

	$data = $db->get_results( $sql );
	
	echo json_encode( $data );

?>