<?php
	$path = dirname(dirname(__DIR__));

	include( $path."/app/config.php");
	include( $path."/app/db.php");
	include( $path."/app/servicios/reservar.php");

	$num_mascotas = array(
        150449 => 1,          
        150450 => 2
    );

    $num_mascotas = serialize($num_mascotas);

    $hoy = date("Y-m-d H:i:s");

	$data_reserva = array(
		"servicio" 				=> "150448",
		"titulo_servicio" 		=> 'Hospedaje - Pedro P.',
		"cliente" 				=> '367',
		"cuidador" 				=> 'Pedro P.',
		"hoy" 					=> $hoy,
		"fecha_formato" 		=> '11 marzo, 2017',
		"token" 				=> time(),
		"inicio" 				=> '20170219',
		"fin" 					=> '20170221',
		"monto" 				=> "128.4",
		"num_mascotas" 			=> $num_mascotas,
		"metodo_pago" 			=> 'Migrado',
		"metodo_pago_titulo" 	=> 'Migrado',
		"moneda" 				=> 'MXN',
		"duracion_formato" 		=> '9 Dias',
		"mascotas" 				=> "(NULL, '{$id_item}', 'Mascotas Medianos', '1'), (NULL, '{$id_item}', 'Mascotas Pequeños', '1'),",
		"deposito" 				=> 'a:1:{s:6:\"enable\";s:2:\"no\";}',
		"status_reserva" 		=> 'paid',
		"status_orden" 			=> 'wc-completed'
	);

	$reservar = new Reservas($db, $data_reserva);

	$id_orden = $reservar->new_reserva();
?>