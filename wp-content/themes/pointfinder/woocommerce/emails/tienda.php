<?php
	
	/* Cliente */

		$msg_id_reserva ='<p>Solicitud de reserva de servicio <strong>(N° '.$reserva->ID.')</strong> </p>';

		$pdf = $metas_orden['_openpay_pdf'][0];

		$saludo = $sql.'
			<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>
			<p>Recibimos tu solicitud de reserva de <strong>'.trim($tipo_servicio).'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>
			<p align="justify">
				Has seleccionado como método de pago: <strong>Pago en efectivo en tiendas de conveniencia</strong>, a continuación encontrarás los pasos a seguir para poder completar tu reservación.
			</p>
			<p align="justify">
				Una vez completes el pago, recibirás un correo de notificación de recepción del mismo.
			</p>
			<p align="justify">
				<a href="'.$pdf.'" style="padding: 10px; background: #59c9a8; color: #fff; font-weight: 400; font-size: 17px; font-family: Roboto; border-radius: 3px; border: solid 1px #1f906e; display: block; width: 250px; margin: 0px auto; text-align: center; text-decoration: none;">
					Ver Instrucciones para Pago en<br> Tiendas por Conveniencia
				</a>
			</p>
		';

		$mensaje_cliente = 	
			$msg_id_reserva.
			$saludo.
	  		$dudas
		;

		$mensaje_cliente = kmimos_get_email_html('Solicitud de Reserva Recibida Exitosamente!', $mensaje_cliente, 'Solicitud de Reserva Recibida Exitosamente!', true, true);

		wp_mail( $cliente_email, "Solicitud de Reserva Recibida Exitosamente!", $mensaje_cliente, kmimos_mails_administradores());

	/* Administrador */

		$saludo = "<p>Hola <strong>Administrador</strong>,</p>";
		$msg_id_reserva ='<p> Se ha realizado una solicitud de reserva con el ID: <strong># '.$reserva->ID.'</strong>. </p>';
		
		$mensaje_admin 	= 
			$saludo.
			$msg_id_reserva.'
			<p align="justify">
				<a href="'.$pdf.'" style="padding: 10px; background: #59c9a8; color: #fff; font-weight: 400; font-size: 17px; font-family: Roboto; border-radius: 3px; border: solid 1px #1f906e; display: block; width: 250px; margin: 0px auto; text-align: center; text-decoration: none;">
					Ver Instrucciones para Pago en<br> Tiendas por Conveniencia
				</a>
			</p>'.
			$detalles_cliente.
			$detalles_cuidador.
			$detalles_mascotas.
			$detalles_servicio
		;
		$mensaje_admin = kmimos_get_email_html('Nueva Reserva - '.$producto->post_title, $mensaje_admin, 'Nueva Reserva - '.$producto->post_title, true, true);

		wp_mail( $email_admin, "Solicitud de reserva #".$reserva->ID, $mensaje_admin, kmimos_mails_administradores());

?>