<?php
	
	$msg_id_reserva ='<p>Solicitud de reserva de servicio <strong>(N° '.$reserva->ID.')</strong> </p>';

	if( $metas_orden["_payment_method"][0] == "openpay_cards" ){
		$saludo = '
			<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>

			<p>Recibimos tu solicitud de reserva de <strong>'.$tipo_servicio.'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>

			<p align="justify">
				Dentro de las próximas 24 horas el cuidador confirmará la disponibilidad para tu solicitud. 
				Posterior a que el cuidador confirme, te llegará un correo indicando que esta <u>confirmada</u> tu reserva (el período de 24 horas es referencial, 
				normalmente los cuidadores contactan al clientes con mucha anterioridad).
			</p>

			<p align="justify">
				Si no puedes o decides no esperar las 24 horas no te preocupes, puedes contactar directamente al cuidador a través del teléfono o correo mostrados más abajo.
			</p>

			<p align="justify">
				En caso de que el cuidador no este disponible, recibiras un correo de notificación con intrucciones para que puedas:
				<ol>
					<li>Reservar con otro cuidador a través de un cupon.</li>
					<li>Solicitar el reembolso del importe realizado.</li>
				</ol> 
			</p>

			<h2>Detalles de tu reservación pendiente a confirmar:</h2>
		';
	}

	$dudas = '<p align="justify">Para cualquier duda y/o comentario puedes contactar al Staff Kmimos a los teléfonos +52 (55) 1791.4931/ +52 (55) 6631.9264, o al correo contactomex@kmimos.la</p>';

	if( $metas_orden["_payment_method"][0] == "openpay_stores" ){

		echo "SELECT session_value FROM wp_woocommerce_sessions WHERE session_key = '".$cliente."'";
		$session = $wpdb->get_var("SELECT session_value FROM wp_woocommerce_sessions WHERE session_key = '".$cliente."'");
		$session = unserialize($session);

		$saludo = '
			<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>

			<p>Recibimos tu solicitud de reserva de <strong>'.$tipo_servicio.'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>

			<p align="justify">
				Has seleccionado como método de pago: <strong>Pago en efectivo en tiendas de conveniencia</strong>, a continuación encontrarás los pasos a seguir para 
				poder completar tu reservación.
			</p>

			<p align="justify">
				Una vez completes el pago, recibirás un correo de notificación de recepción del mismo.
			</p>

			<p align="justify">
				<a href="'.$session['pdf_url'].'" style="
					padding: 10px;
				    background: #59c9a8;
				    color: #fff;
				    font-weight: 400;
				    font-size: 17px;
				    font-family: Roboto;
				    border-radius: 3px;
				    border: solid 1px #1f906e;
				    display: block;
				    width: 250px;
				    margin: 0px auto;
				    text-align: center;
				    text-decoration: none;
				">Ver Instrucciones para el Pago</a>
			</p>
		';

		$mensaje_cliente = 	
			$msg_id_reserva.
			$saludo.
	  		$dudas
		;

		$mensaje_cliente = kmimos_get_email_html('Solicitud de Reserva Recibida Exitosamente!', $mensaje_cliente, 'Solicitud de Reserva Recibida Exitosamente!', true, true);

		wp_mail( $user->data->user_email, "Solicitud de Reserva Recibida Exitosamente!", $mensaje_cliente);

	}

	if( $metas_orden["_payment_method"][0] == "openpay_cards" ){

		$mensaje_cliente = 	
			$msg_id_reserva.
			$saludo.
	  		$dudas.
			$detalles_cuidador.
			$detalles_mascotas.
			$detalles_servicio
		;

		$mensaje_cliente = kmimos_get_email_html('Solicitud de reserva pendiente de pago', $mensaje_cliente, 'Solicitud de reserva pendiente de pago', true, true);

		wp_mail( $user->data->user_email, "Solicitud de reserva pendiente de pago", $mensaje_cliente);

	}

?>