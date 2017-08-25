<?php
	extract($_POST);

	$info = explode("===", $info);

	// print_r( $info );

	$parametros_label = array(
		"pagar",
		"tarjeta",
		"fechas",
		"cantidades",
		"transporte",
		"adicionales",
	);

	$parametros = array();

	foreach ($info as $key => $value) {
		$parametros[ $parametros_label[ $key ] ] = json_decode($value);
	}

	print_r( $parametros );
	
?>