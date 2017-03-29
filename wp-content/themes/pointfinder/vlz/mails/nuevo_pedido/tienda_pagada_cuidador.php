<?php

	$msg_id_reserva ='<p>Reserva #: <strong>'.$reserva->ID.'</strong> </p>';

	$aceptar_rechazar = '
		<center>
			<p><strong>¿ACEPTAS ESTA RESERVA? </strong></p>
			<table>
				<tr>
					<td>
						<a href="'.get_home_url().'/wp-content/plugins/kmimos/order.php?o='.$id.'&s=1&t=1" style="text-decoration: none; padding: 7px 0px; background: #00d2b7; color: #FFF; font-size: 16px; font-weight: 500; border-radius: 5px; width: 100px; display: inline-block; text-align: center;">Aceptar</a>
					</td>
					<td>
						<a href="'.get_home_url().'/wp-content/plugins/kmimos/order.php?o='.$id.'&s=0&t=1" style="text-decoration: none; padding: 7px 0px; background: #dc2222; color: #FFF; font-size: 16px; font-weight: 500; border-radius: 5px; width: 100px; display: inline-block; text-align: center;">Rechazar</a>
					</td>
				</tr>
			</table>
		</center>
	';

	$saludo = '
		<p>Hola <strong>'.$cuidador_post->post_title.'</strong>,</p>

		<p>El cliente <strong>'.$nombre.' '.$apellido.'</strong> te ha enviado una solicitud de Reserva.</p>

		'.$aceptar_rechazar.'

		<h2>Detalles de la solicitud:</h2>
	';

	$siguientes_pasos = '
		<br><p align="center"><strong><u>SIGUIENTES PASOS - Importante</u></strong></p>
		<ul>
			<li>
				 <p align="justify">Es necesario que en las 8 horas a partir de que recibiste esta solicitud confirmes si aceptas el servicio.  En caso de no llevarlo a cabo, el sistema cancelará esta solicitud y enviará automáticamente una recomendación al cliente sobre otros cuidadores sugeridos para atenderlo.</p>
			</li>
			<li>
				 <p align="justify">Si existe algún cambio en la reserva relacionada a horarios, precios o servicios adicionales por favor asegúrate que el cliente está enterado y que está de acuerdo con los cambios,  posteriormente contacta al Staff Kmimos a la brevedad para realizar los ajustes. </p>
			</li>
		</ul>
		<br>
		<p align="justify"><strong><u>Puntos a considerar para tu reservación</u></strong></p>
		<br>
		<ul>
			<li><p align="justify">Preséntate con el cliente de una manera cordial, formal y cuidando tu imagen. (Vestimenta casual).</p></li>
			<li><p align="justify">Coméntale la experiencia que tienes cuidando perros y cuál es la rutina que utilizas.</p></li>
			<li><p align="justify">Verifica que el perro del dueño tenga sus vacunas y te compartan su cartilla de vacunación. </p></li>
			<br>
			<li><p align="justify"><strong>IMPORTANTE: </strong>Sin cartilla de vacunación, no estarán amparados ni tú ni el perro ante los beneficios veterinarios de Kmimos.</p></li>
			<br>
			<li><p align="justify">En caso de no conocerse personalmente, asegúrate de que te envíen fotos del perro que llegará a tu casa para confirmar que el tamaño se adecúa a lo declarado por el cliente.</p></li>
		</ul>
		<br>
		<p align="justify">Recuerda que cada perro tiene un comportamiento diferente, por lo que deberás tener la mayor información posible sobre los mismos:</p>
		<ul>
			<li>
				<p>¿Cómo es su rutina diaria? </p>
				<ul>
					<li>
						<p>¿Sale a pasear?, ¿A qué hora come y hace del baño?, etc.</p>
					</li>
				</ul>
			</li>
			<li>
				<p>¿Cómo se comporta con otros seres vivos? </p>
				<ul>
					<li>
						<p>¿Cómo interactúa con otros perros y personas?, ¿Cómo reacciona con un extraño?, etc.</p>
					</li>
				</ul>
			</li>
			<li>
				<p>¿Cómo identifica su animó?  </p>
				<ul>
					<li>
						<p>¿Cómo se comporta cuando esta triste o estresado?, ¿Qué hace su dueño cuando esta triste o estresado?, etc.</p>
					</li>
				</ul>
			</li>
		</ul>
	';

	$dudas = '<br><p>Para cualquier duda y/o comentario puedes contactar al Staff Kmimos a los teléfonos +52 (55) 1791.4931/ +52 (55) 6631.9264, o al correo contactomex@kmimos.la</p>';

	$mensaje_cliente  	= 	$saludo.
							$msg_id_reserva.
					  		$detalles_cuidador.
					  		$detalles_cliente.
					  		$detalles_mascotas.
					  		$detalles_servicio.
					  		"<br>".$aceptar_rechazar.
					  		$siguientes_pasos.
					  		$dudas
	;

	$mensaje_cliente = kmimos_get_email_html('Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, $mensaje_cliente, 'Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, true, true);

	wp_mail( $cuidador->email, 'Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, $mensaje_cliente);

?>