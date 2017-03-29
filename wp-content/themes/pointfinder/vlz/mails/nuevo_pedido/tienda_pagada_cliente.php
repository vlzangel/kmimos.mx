<?php
	
	$msg_id_reserva ='<p>Solicitud de reserva de servicio <strong>(N° '.$reserva->ID.')</strong> </p>';

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

	$dudas = '<p align="justify">Para cualquier duda y/o comentario puedes contactar al Staff Kmimos a los teléfonos +52 (55) 1791.4931/ +52 (55) 6631.9264, o al correo contactomex@kmimos.la</p>';

	$mensaje_cliente = 	
		$msg_id_reserva.
		$saludo.
  		$dudas.
		$detalles_cuidador.
		$detalles_mascotas.
		$detalles_servicio
	;

	$mensaje_cliente = kmimos_get_email_html('Solicitud de Reserva Recibida Exitosamente!', $mensaje_cliente, 'Solicitud de Reserva Recibida Exitosamente!', true, true);

	wp_mail( $cliente_email, "Solicitud de Reserva Recibida Exitosamente!", $mensaje_cliente);


?>