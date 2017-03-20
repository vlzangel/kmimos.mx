<?php

/**

 * Admin new order email

 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	add_filter( 'wp_mail_from_name', function( $name ) {
		return 'Kmimos México';
	});
	add_filter( 'wp_mail_from', function( $email ) {
		return 'kmimos@kmimos.la';
	});

	include("vlz_data_orden.php");

	$dudas = '<p align="justify">Para cualquier duda y/o comentario puedes contactar al Staff Kmimos a los teléfonos +52 (55) 1791.4931, o al correo atencion@kmimos.com.mx</p>';

	if( $metas_orden["_payment_method"][0] == "openpay_cards" ){

		/*
			Administrador
		*/
			
			$saludo = "<p>Hola <strong>Administrador</strong>,</p>";
			$msg_id_reserva ='<p>Se ha confirmado y pagado la Reserva <strong># '.$reserva->ID.'</strong> </p>';
			
			$mensaje_admin 	= $saludo.
							  $msg_id_reserva.
							  $detalles_cliente.
							  $detalles_cuidador.
							  $detalles_mascotas.
							  $detalles_servicio
			;

			$mensaje_admin = kmimos_get_email_html('Nueva Reserva - '.$producto->post_title, $mensaje_admin, 'Nueva Reserva - '.$producto->post_title, true, true);

			wp_mail( "contactomex@kmimos.la", "Solicitud de reserva #".$reserva->ID, $mensaje_admin, kmimos_mails_administradores());

		/*
			Correo Cliente
		*/

			$msg_id_reserva ='<p>Solicitud de reserva de servicio <strong>(N° '.$reserva->ID.')</strong> </p>';

			$saludo = '
				<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>

				<p>Recibimos tu solicitud de reserva de <strong>'.$tipo_servicio.'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>

				<p align="justify">
					Dentro de las próximas 12 horas el cuidador confirmará la disponibilidad para tu solicitud. 
					Posterior a que el cuidador confirme, te llegará un correo indicando que está <u>confirmada</u> tu reserva (el período de 12 horas es referencial, 
					normalmente los cuidadores contactan al clientes con mucha anterioridad).
				</p>

				<p align="justify">
					Si no puedes o decides no esperar las 12 horas no te preocupes, puedes contactar directamente al cuidador a través del teléfono o correo mostrados más abajo.
				</p>

				<p align="justify">
					En caso de que el cuidador no esté disponible, recibirás un correo de notificación con instrucciones para que puedas solicitar el reembolso del importe realizado.
				</p>

				<h2>Detalles de tu reservación pendiente a confirmar:</h2>
			';

			$mensaje_cliente = 	
				$msg_id_reserva.
				$saludo.
		  		$dudas.
				$detalles_cuidador.
				$detalles_mascotas.
				$detalles_servicio
			;

			$mensaje_cliente = kmimos_get_email_html('Solicitud de reserva', $mensaje_cliente, 'Solicitud de reserva', true, true);

			wp_mail( $user->data->user_email, "Solicitud de reserva", $mensaje_cliente);

		/*
			Correo Cuidador
		*/

			$msg_id_reserva ='<p>Reserva #: <strong>'.$reserva->ID.'</strong> </p>';

			$aceptar_rechazar = '
				<center>
					<p><strong>¿ACEPTAS ESTA RESERVA?</strong></p>
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
						 <p align="justify">Si existe algún cambio en la reserva relacionada a horarios, precios o servicios adicionales por favor asegúrate que el cliente está enterado y que está de acuerdo con los cambios,  posteriormente contacta al Staff Kmimos a la brevedad para realizar los ajustes.</p>
					</li>
				</ul>
				<br>
				<p align="justify"><strong><u>Puntos a considerar para tu reservación</u></strong></p>
				<br>
				<ul>
					<li><p align="justify">Preséntate con el cliente de una manera cordial, formal y cuidando tu imagen. (Vestimenta casual).</p></li>
					<li><p align="justify">Coméntale la experiencia que tienes cuidando perros y cuál es la rutina que utilizas.</p></li>
					<li><p align="justify">Verifica que el perro del dueño tenga sus vacunas y te compartan su cartilla de vacunación.</p></li>
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

			$mensaje_cuidador  	= 	$saludo.
									$msg_id_reserva.
							  		$detalles_cuidador.
							  		$detalles_cliente.
							  		$detalles_mascotas.
							  		$detalles_servicio.
							  		"<br>".$aceptar_rechazar.
							  		$siguientes_pasos.
							  		$dudas
			;

			$mensaje_cuidador = kmimos_get_email_html('Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, $mensaje_cuidador, 'Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, true, true);

			wp_mail( $cuidador->email, 'Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, $mensaje_cuidador);

	}else{

			if( $metas_orden["_payment_method"][0] == "openpay_stores" ){

				/*
					Cliente
				*/

				$msg_id_reserva ='<p>Solicitud de reserva de servicio <strong>(N° '.$reserva->ID.')</strong> </p>';

				if( $metas_orden["_payment_method"][0] == "openpay_cards" ){
					$saludo = '
						<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>

						<p>Recibimos tu solicitud de reserva de <strong>'.$tipo_servicio.'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>

						<p align="justify">
							Dentro de las próximas 12 horas el cuidador confirmará la disponibilidad para tu solicitud. 
							Posterior a que el cuidador confirme, te llegará un correo indicando que está <u>confirmada</u> tu reserva (el período de 12 horas es referencial, 
							normalmente los cuidadores contactan al clientes con mucha anterioridad).
						</p>

						<p align="justify">
							Si no puedes o decides no esperar las 12 horas no te preocupes, puedes contactar directamente al cuidador a través del teléfono o correo mostrados más abajo.
						</p>

						<p align="justify">
							En caso de que el cuidador no esté disponible, recibirás un correo de notificación con instrucciones para que puedas solicitar el reembolso del importe realizado.
						</p>

						<h2>Detalles de tu reservación pendiente a confirmar:</h2>
					';
				}

				$pdf = $metas_orden['_openpay_pdf'][0];

				$saludo = $sql.'
					<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>

					<p>Recibimos tu solicitud de reserva de <strong>'.trim($tipo_servicio).'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>

					<p align="justify">
						Has seleccionado como método de pago: <strong>Pago en efectivo en tiendas de conveniencia</strong>, a continuación encontrarás los pasos a seguir para 
						poder completar tu reservación.
					</p>

					<p align="justify">
						Una vez completes el pago, recibirás un correo de notificación de recepción del mismo.
					</p>

					<p align="justify">
						<a href="'.$pdf.'" style="
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
						">
							Ver Instrucciones para Pago en<br>
							Tiendas por Conveniencia</a>
					</p>
				';

				$mensaje_cliente = 	
					$msg_id_reserva.
					$saludo.
			  		$dudas
				;

				$mensaje_cliente = kmimos_get_email_html('Solicitud de Reserva Recibida Exitosamente!', $mensaje_cliente, 'Solicitud de Reserva Recibida Exitosamente!', true, true);

				wp_mail( $cliente_email, "Solicitud de Reserva Recibida Exitosamente!", $mensaje_cliente);

				/*
					Administrador
				*/

				$saludo = "<p>Hola <strong>Administrador</strong>,</p>";
				$msg_id_reserva ='
					<p>Se ha realizado una solicitud de reserva con el ID: <strong># '.$reserva->ID.'</strong>. </p>
				';
				
				$mensaje_admin 	= $saludo.
								  $msg_id_reserva.
								  '
								  	<p align="justify">
										<a href="'.$pdf.'" style="
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
										">
											Ver Instrucciones para Pago en<br>
											Tiendas por Conveniencia</a>
									</p>'.
								  $detalles_cliente.
								  $detalles_cuidador.
								  $detalles_mascotas.
								  $detalles_servicio
				;

				$mensaje_admin = kmimos_get_email_html('Nueva Reserva - '.$producto->post_title, $mensaje_admin, 'Nueva Reserva - '.$producto->post_title, true, true);

				wp_mail( "contactomex@kmimos.la", "Solicitud de reserva #".$reserva->ID, $mensaje_admin, kmimos_mails_administradores());

		}else{

			/*
				Administrador
			*/
				
				$saludo = "<p>Hola <strong>Administrador</strong>,</p>";
				$msg_id_reserva ='<p>Se ha confirmado y pagado la Reserva <strong># '.$reserva->ID.'</strong> </p>';
				
				$mensaje_admin 	= $saludo.
								  $msg_id_reserva.
								  $detalles_cliente.
								  $detalles_cuidador.
								  $detalles_mascotas.
								  $detalles_servicio
				;

				$mensaje_admin = kmimos_get_email_html('Nueva Reserva - '.$producto->post_title, $mensaje_admin, 'Nueva Reserva - '.$producto->post_title, true, true);

				wp_mail( "contactomex@kmimos.la", "Solicitud de reserva #".$reserva->ID, $mensaje_admin, kmimos_mails_administradores());

			/*
				Correo Cliente
			*/

				$msg_id_reserva ='<p>Solicitud de reserva de servicio <strong>(N° '.$reserva->ID.')</strong> </p>';

				$saludo = '
					<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>

					<p>Recibimos tu solicitud de reserva de <strong>'.$tipo_servicio.'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>

					<p align="justify">
						Dentro de las próximas 12 horas el cuidador confirmará la disponibilidad para tu solicitud. 
						Posterior a que el cuidador confirme, te llegará un correo indicando que está <u>confirmada</u> tu reserva (el período de 12 horas es referencial, 
						normalmente los cuidadores contactan al clientes con mucha anterioridad).
					</p>

					<p align="justify">
						Si no puedes o decides no esperar las 12 horas no te preocupes, puedes contactar directamente al cuidador a través del teléfono o correo mostrados más abajo.
					</p>

					<p align="justify">
						En caso de que el cuidador no esté disponible, recibirás un correo de notificación con instrucciones para que puedas solicitar el reembolso del importe realizado.
					</p>

					<h2>Detalles de tu reservación pendiente a confirmar:</h2>
				';

				$mensaje_cliente = 	
					$msg_id_reserva.
					$saludo.
			  		$dudas.
					$detalles_cuidador.
					$detalles_mascotas.
					$detalles_servicio
				;

				$mensaje_cliente = kmimos_get_email_html('Solicitud de reserva', $mensaje_cliente, 'Solicitud de reserva', true, true);

				wp_mail( $user->data->user_email, "Solicitud de reserva", $mensaje_cliente);

			/*
				Correo Cuidador
			*/

				$msg_id_reserva ='<p>Reserva #: <strong>'.$reserva->ID.'</strong> </p>';

				$aceptar_rechazar = '
					<center>
						<p><strong>¿ACEPTAS ESTA RESERVA?</strong></p>
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
							 <p align="justify">Si existe algún cambio en la reserva relacionada a horarios, precios o servicios adicionales por favor asegúrate que el cliente está enterado y que está de acuerdo con los cambios,  posteriormente contacta al Staff Kmimos a la brevedad para realizar los ajustes.</p>
						</li>
					</ul>
					<br>
					<p align="justify"><strong><u>Puntos a considerar para tu reservación</u></strong></p>
					<br>
					<ul>
						<li><p align="justify">Preséntate con el cliente de una manera cordial, formal y cuidando tu imagen. (Vestimenta casual).</p></li>
						<li><p align="justify">Coméntale la experiencia que tienes cuidando perros y cuál es la rutina que utilizas.</p></li>
						<li><p align="justify">Verifica que el perro del dueño tenga sus vacunas y te compartan su cartilla de vacunación.</p></li>
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
				
		}

	}

	
?>