<?php

	error_reporting(0);

	include("../vlz_config.php");

	$c = new mysqli($host, $user, $pass, $db);
	include("./db.php");
	$db = new db($c);
	include("./funciones.php");

	$sql = "
		SELECT 

			reserva.id 		AS id_reserva,

			reserva.created_at 		AS creada,
			reserva.start_date 		AS inicio,
			reserva.end_date 		AS fin,
			reserva.total 			AS total,
			reserva.token 			AS token,
			wp_cliente.ID 			AS cliente_ID,
			wp_cuidador.ID 			AS cuidador_ID,

			reserva.provider_id 	AS cuidador,
			reserva.user_id 		AS cliente,
			cliente.email 			AS cliente_email,
			cuidador.email 			AS cuidador_email

		FROM 

			bookings AS reserva

		LEFT JOIN users AS cliente ON ( cliente.id = reserva.user_id )
		LEFT JOIN providers AS cuidador ON ( cuidador.id = reserva.provider_id )
		LEFT JOIN wp_users AS wp_cliente ON ( wp_cliente.user_email = cliente.email )
		LEFT JOIN wp_users AS wp_cuidador ON ( wp_cuidador.user_email = cuidador.email )

		WHERE

			wp_cliente.user_email  != '' AND 
			wp_cuidador.user_email != '' AND
			reserva.total > 0

		ORDER BY reserva.id ASC
	";

	$reservas = $c->query($sql);
	if( $reservas->num_rows > 0 ){
		while ( $f = $reservas->fetch_assoc() ) {
			$servicios = get_servicios($f['id_reserva']);
			$tam = get_tamanos($f['id_reserva']);
			$producto = get_producto( $f['cuidador_ID'], $servicios['slug'] );

			$tam_2 = array();
			foreach ($tam as $key => $value) {
				$tam_2[ get_variantes($producto->ID, $key) ] = $value;
			}

			$creada = get_fecha( $f["inicio"], "wp" );

			$id_order = crear_shop_order(array(
				"hoy"   => $creada,
				"token" => $f['token']
			));

			crear_metas_shop_order(array(
				"id_order" => $id_order,
				"token"    => $f['token'],
				"cliente"  => $f["cliente_ID"],
				"total"    => $f["total"]
			));

			$id_reserva = crear_reserva(array(
				"hoy"      => $creada,
				"token"    => $f['token'],
				"cliente"  => $f["cliente_ID"],
				"id_order" => $id_order
			));

			$id_item = crear_item(array(
				"titulo"   => $producto->titulo,
				"id_order" => $id_order
			));

			crear_metas_item(array(
				"id_item"     => $id_item,
				"id_reserva"  => $f['id_reserva'],
				"duracion"    => get_duracion($f['inicio'], $f['fin']),
				"total"       => $f["total"],
				"inicio"      => get_fecha( $f["inicio"], "txt"),
				"tamanos"     => $tam,
				"servicio"    => $producto->ID
			));

			crear_metas_reservas(array(
				"id_reserva"   => $id_reserva,
				"cliente"      => $f['cliente_ID'],
				"inicio"       => get_fecha( $f["inicio"], "wc" ),
				"fin"          => get_fecha( $f["fin"], "wc" ),
				"total"        => $f["total"],
				"num_mascotas" => serialize($tam_2),
				"id_item"      => $id_item,
				"servicio"     => $producto->ID
			));
		}
	}

?>