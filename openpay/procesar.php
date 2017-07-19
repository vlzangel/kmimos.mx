<?php
	switch ($status_transaccion) {

		case 'cancelled':
			
			$id_orden = $value->order_id;
			$id_reserva = $wpdb->get_var("SELECT ID FROM wp_posts WHERE post_parent = {$id_orden} AND post_type LIKE 'wc_booking'");

			$booking = new WC_Booking( $id_reserva );
	 		$order   = new WC_Order($id_orden );
		
			$order->update_status('wc-cancelled');
			$booking->update_status('cancelled');

		break;

		case 'completed':
			
			$id_orden = $value->order_id;
			$id_reserva = $wpdb->get_var("SELECT ID FROM wp_posts WHERE post_parent = {$id_orden} AND post_type LIKE 'wc_booking'");

			$id_item = $wpdb->get_var("SELECT meta_value FROM wp_postmeta WHERE post_id = {$id_reserva} AND meta_key = '_booking_order_item_id' ");

			$remanente = $wpdb->get_var("SELECT meta_value FROM wp_woocommerce_order_itemmeta WHERE order_item_id = {$id_item} AND meta_key = '_wc_deposit_meta' ");

			$booking = new WC_Booking( $id_reserva );
			$order   = new WC_Order($id_orden);

			$hora_actual = date("Y-m-d H:i:s");
			$wpdb->query("UPDATE wp_posts SET post_date = '{$hora_actual}', post_date_gmt = '{$hora_actual}', post_modified = '{$hora_actual}', post_modified_gmt = '{$hora_actual}' WHERE ID = {$id_reserva};");
			$wpdb->query("UPDATE wp_posts SET post_date = '{$hora_actual}', post_date_gmt = '{$hora_actual}', post_modified = '{$hora_actual}', post_modified_gmt = '{$hora_actual}' WHERE ID = {$id_orden};");

		 	if( $remanente != 'a:1:{s:6:"enable";s:2:"no";}' ){
				$booking->update_status('unpaid');
				$order->update_status('wc-partially-paid');
			}else{
				$booking->update_status('paid');
				$order->update_status('wc-completed');
			}

		    add_filter( 'wp_mail_from_name', function( $name ) {
		        $info = kmimos_get_info_syte();
		        return $info["titulo"];
		    });
		    add_filter( 'wp_mail_from', function( $email ) {
		        $info = kmimos_get_info_syte();
		        return $info["email"]; 
		    });

			$info = kmimos_get_info_syte();
		    $email_admin = $info["email"];

			$datos_generales = kmimos_datos_generales_desglose($id_orden, true, true);

			$detalles_cliente = $datos_generales["cliente"];
			$detalles_cuidador = $datos_generales["cuidador"];
			$detalles_mascotas = $datos_generales["mascotas"];

			$cliente_email  = $datos_generales["cliente_email"];
			$cuidador_email = $datos_generales["cuidador_email"];

		    $orden_id = $datos_generales["orden"];
		    $reserva_id = $datos_generales["booking"];

		    $nom_cliente  = $datos_generales["nombre_cliente"];
		    $nom_cuidador = $datos_generales["nombre_cuidador"];

		    $producto  = $datos_generales["producto_name"];
		    $tipo_servicio = $datos_generales["tipo_servicio"];

			/* Detalles del servicio */

			$detalles = kmimos_desglose_reserva($id_orden, true);

			$msg_id_reserva = $detalles["msg_id_reserva"];
			$aceptar_rechazar = $detalles["aceptar_rechazar"];
			$detalles_servicio = $detalles["detalles_servicio"];
			$detalles_servicio_cuidador = $detalles["detalles_servicio_cuidador"];

			$metodo_pago = $detalles["metodo_pago"];

			include("HTMLs.php");

			wp_mail( $cliente_email, 'Pago Recibido Exitosamente!', $mensaje_cliente);
			wp_mail( $cuidador_email, 'Nueva Reserva - '.$tipo_servicio.' por: '.$nom_cliente, $mensaje_cuidador);

			kmimos_mails_administradores_new("Solicitud de reserva #".$reserva_id, $mensaje_admin);

		break;
	
	}
?>