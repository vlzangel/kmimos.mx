<?php
	$id_reserva = $wpdb->get_var("SELECT ID FROM wp_posts WHERE post_parent = {$value->order_id} AND post_type LIKE 'wc_booking'");

	$cliente_id = get_post_meta($id_reserva, "_booking_customer_id", true);
	$user = get_user_by( 'id', $cliente_id );
	$email_cliente = $user->data->user_email;

	$mensaje_cliente  = "<p style='text-align: justify'>Estimado cliente,</p>";
	$mensaje_cliente .= "<p style='text-align: justify'>Kmimos le recuerda que tiene hasta 48 hrs para realizar el pago en la tienda de conveniencia, luego de vencido el tiempo no podrá efectuar el pago correspondiente.</p>";

	$mensaje_cliente = kmimos_get_email_html("Recordatorio de Pago en Tienda!", $mensaje_cliente, '', true, true);

	wp_mail( $cliente_email, 'Recordatorio de Pago en Tienda!', $mensaje_cliente);

	update_post_meta( $value->order_id, "notificacion", "Si" );
?>