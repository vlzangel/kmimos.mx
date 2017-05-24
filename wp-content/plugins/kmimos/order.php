<?php

    define('WP_USE_THEMES', false);
    require('../../../wp-blog-header.php');

    add_filter( 'wp_mail_from_name', function( $name ) {
		return 'Kmimos México';
	});
	add_filter( 'wp_mail_from', function( $email ) {
		return 'kmimos@kmimos.la';
	});

	include("vlz_data_orden.php");
	include("vlz_order_funciones.php");

	//CLASS BOOKING
	$_kmimos_booking->Booking_Details($orden_id);

	echo "
		<style>
    		html, body{ margin: 0px; min-height: 100%; padding: 0px; font-size: 12px; }
    		.body{ margin: 0px; min-height: 100%; padding: 0px; }
    		body * { font-size: 12px; }
    	</style>
	";
	$styles = "
		<style>
			.undoreset div p {
			    margin: 1em 0px;
			}
		</style>
	"; 

	$status = $booking->get_status();

	if( $status == "confirmed" || $status == "cancelled" ){
		$estado = array(
			"confirmed" => "Confirmada",
			"cancelled" => "Cancelada"
		);
		$msg = $styles.'
				<p>Hola <strong>'.$cuidador_post->post_title.'</strong></p>
				<p align="justify">Te notificamos que la reserva N° <strong>'.$reserva_id.'</strong> ya ha sido '.$estado[$status].' anteriormente.</p>
				<p align="justify">Por tal motivo ya no es posible realizar cambios en el estatus de la misma.</p>
		';
   		echo kmimos_get_email_html("La reserva ya fue ".$estado[$status]." anteriormente.", $msg, "", false, true);
	}else{

		if($s == "0"){
			$order->update_status('wc-cancelled');
			$booking->update_status('cancelled');

			$msg = $styles.'
		    	<p><strong>Cancelación de Reserva (N°. '.$reserva_id.')</strong></p>
				<p>Hola <strong>'.$cuidador_post->post_title.'</strong></p>
				<p align="justify">Te notificamos que la reserva N° <strong>'.$reserva_id.'</strong> ha sido cancelada exitosamente de acuerdo a tu petición.</p>
				<p align="justify">Si tienes alguna duda o comentario de la cancelación con todo gusto puedes contactarnos.</p>'
				.$_kmimos_tables->Create_Table_Client($_kmimos_booking->user_client,$_kmimos_booking->user_meta_client)
				//.$_kmimos_tables->Create_Table_Caregiver($_kmimos_booking->user_caregiver,$_kmimos_booking->user_meta_caregiver)
				.$_kmimos_tables->Create_Table_Pets($_kmimos_booking->user_client)
				//.$_kmimos_tables->Create_Table_Service($orden_id)
				.$detalles_servicio.'
				<p style="text-align: center;">
		            <a 
		            	href="'.get_home_url().'/"
		            	style="
		            		padding: 10px;
						    background: #59c9a8;
						    color: #fff;
						    font-weight: 400;
						    font-size: 17px;
						    font-family: Roboto;
						    border-radius: 3px;
						    border: solid 1px #1f906e;
						    display: block;
						    width: 200px;
						    margin: 0px auto;
						    text-align: center;
						    text-decoration: none;
		            	"
		            >Ir a Kmimos</a>
		        </p>
		    ';
		    
	   		echo $msg_cuidador = kmimos_get_email_html("Reserva Cancelada Exitosamente!", $msg, "", true, true);
	   		wp_mail( $email_cuidador, "Cancelación de Reserva", $msg_cuidador);

			$msg = $styles.'
		    	<p><strong>Cancelación de Reserva (N°. '.$reserva_id.')</strong></p>
				<p>Hola <strong>Administrador</strong>,</p>
				<p align="justify">Te notificamos que el cuidador <strong>'.$cuidador_post->post_title.'</strong> ha cancelado la reserva N° <strong>'.$reserva_id.'</strong>.</p>'
				.$_kmimos_tables->Create_Table_Client($_kmimos_booking->user_client,$_kmimos_booking->user_meta_client)
				.$_kmimos_tables->Create_Table_Caregiver($_kmimos_booking->user_caregiver,$_kmimos_booking->user_meta_caregiver)
				.$_kmimos_tables->Create_Table_Pets($_kmimos_booking->user_client)
				//.$_kmimos_tables->Create_Table_Service($orden_id)
				.$detalles_servicio
				.'
					<p align="justify">
						Esta son las sugerencias que se le enviaron al cliente:
					</p>
				'
				.$lista_cercanos;
		    
	   		$msg_admin = kmimos_get_email_html("Reserva Cancelada por Cuidador - ".$cuidador_post->post_title, $msg, "", true, true);
	   		wp_mail( $email_admin, "Cancelación de Reserva", $msg_admin, kmimos_mails_administradores());

	   		$msg = $styles.'
	   			<div>
			    	<p><strong>Cancelación de Reserva (N°. '.$reserva_id.')</strong></p>
					<p>Hola <strong>'.$nom.'</strong>,</p>
					<p align="justify">Te notificamos que el cuidador <strong>'.$cuidador_post->post_title.'</strong> ha cancelado la reserva N° <strong>'.$reserva_id.'</strong>.</p>
					<p align="justify">
						Sin embargo, sabemos lo importante que es para ti encontrar el lugar adecuado para que cuiden a tu peludo, 
						por lo que te compartimos estas opciones con características similares a tu búsqueda original. Solo debes seguir los siguientes pasos:
					</p>
					'.$lista_cercanos.'
					<p align="justify">Si tienes alguna duda o comentario de la cancelación con todo gusto puedes contactarnos.</p>
				</div>
		    ';
		    
	   		$msg_cliente = kmimos_get_email_html("Cancelación de Reserva", $msg, "", true, true);
	   		wp_mail( $user->data->user_email, "Cancelación de Reserva", $msg_cliente, kmimos_mails_administradores());

	    } else {
			$order->update_status('wc-on-hold');
			$booking->update_status('confirmed');

			$msg = $styles.'
		    	<p><strong>Confirmación de Reserva (N°. '.$reserva_id.')</strong></p>
				<p>Hola <strong>'.$cuidador_post->post_title.'</strong></p>
				<p align="justify">Siguiendo tu solicitud hacia el Staff Kmimos, la reserva del cliente <strong>'.$nom.'</strong> ha sido confirmada para dar el servicio.</p>'
				.$_kmimos_tables->Create_Table_Client($_kmimos_booking->user_client,$_kmimos_booking->user_meta_client)
				//.$_kmimos_tables->Create_Table_Caregiver($_kmimos_booking->user_caregiver,$_kmimos_booking->user_meta_caregiver)
				.$_kmimos_tables->Create_Table_Pets($_kmimos_booking->user_client)
				//.$_kmimos_tables->Create_Table_Service($orden_id)
				.$detalles_servicio.'
				<p style="text-align: center;">
		            <a 
		            	href="'.get_home_url().'/"
		            	style="
		            		padding: 10px;
						    background: #59c9a8;
						    color: #fff;
						    font-weight: 400;
						    font-size: 17px;
						    font-family: Roboto;
						    border-radius: 3px;
						    border: solid 1px #1f906e;
						    display: block;
						    width: 200px;
						    margin: 0px auto;
						    text-align: center;
						    text-decoration: none;
		            	"
		            >Ir a Kmimos</a>
		        </p>
		    ';

	   		echo $msg_cuidador = kmimos_get_email_html("Confirmación de Reserva", $msg, "", true, true);
	   		wp_mail( $email_cuidador, "Confirmación de Reserva", $msg_cuidador);

			$msg_admin = $styles.'
		    	<p><strong>Confirmación de Reserva (N°. '.$reserva_id.')</strong></p>
				<p>Hola <strong>Administrador</strong>,</p>
				<p align="justify">Te notificamos que el cuidador <strong>'.$cuidador_post->post_title.'</strong> ha <strong>Confirmado</strong> la reserva N° <strong>'.$reserva_id.'</strong>.</p>'
				.$_kmimos_tables->Create_Table_Client($_kmimos_booking->user_client,$_kmimos_booking->user_meta_client)
				.$_kmimos_tables->Create_Table_Caregiver($_kmimos_booking->user_caregiver,$_kmimos_booking->user_meta_caregiver)
				.$_kmimos_tables->Create_Table_Pets($_kmimos_booking->user_client)
				//.$_kmimos_tables->Create_Table_Service($orden_id)
				.$detalles_servicio;

	   		$msg_admin = kmimos_get_email_html("Confirmación de Reserva", $msg_admin, "", true, true);
	   		wp_mail( $email_admin, "Confirmación de Reserva", $msg_admin, kmimos_mails_administradores());

	   		$nota_importante = $styles.'
	   			<p align="justify"><strong>Importante:</strong></p>
	   			<p align="justify">Si necesitaras cancelar el servicio te pedimos que notifiques al cuidador y al Staff Kmimos con 48 horas de anticipación a la fecha de inicio de la reserva, de lo contrario se cobrará un monto del 20% sobre el total de la reserva por concepto de cancelación tardía.</p>
	   			
	   		';

			$msg_cliente = $styles.'
				<p align="center">¡Todo está listo <strong>'.$nom.'</strong>!</p>
				<p align="justify">Tu reserva (N°. '.$reserva_id.') ha sido confirmada por el cuidador <strong>'.$cuidador_post->post_title.'</strong>.</p>
		    	<p>Detalles de la reserva:</p>'
				//.$_kmimos_tables->Create_Table_Client($_kmimos_booking->user_client,$_kmimos_booking->user_meta_client)
				.$_kmimos_tables->Create_Table_Caregiver($_kmimos_booking->user_caregiver,$_kmimos_booking->user_meta_caregiver)
				.$_kmimos_tables->Create_Table_Pets($_kmimos_booking->user_client)
				//.$_kmimos_tables->Create_Table_Service($orden_id)
				.$detalles_servicio
				.$nota_importante;

			$msg_cliente = kmimos_get_email_html("Confirmación de Reserva", $msg_cliente, "", true, true);
	   		wp_mail( $email_cliente, "Confirmación de Reserva", $msg_cliente);


	   		// ********************************************************************
	   		// BEGIN Notificacion para usuario referidos - Landing WOM /Referidos
	   		// ********************************************************************
	   		$user_info = get_user_by( 'email', $email_cliente );
	   		if(isset($user_info->ID)){	
	   			global $wpdb;
				$count_reservas = $wpdb->get_results( 
					"SELECT  
						count(ID) as cant
					FROM wp_posts
					WHERE post_type = 'wc_booking' 
						AND not post_status like '%cart%' AND post_status = 'confirmed' 
						AND post_author = {$user_info->ID}
						AND DATE_FORMAT(post_date, '%m-%d-%Y') between DATE_FORMAT('2017-05-12','%m-%d-%Y') and DATE_FORMAT(now(),'%m-%d-%Y')"
				);

		   		$user_referido = get_user_meta($user_info->ID, 'landing-referencia', true);


		   		if(!empty($user_referido)){
					$username = $nom;
					require_once('../../../landing/email_template/notificacion_registro_referido.php');
					$user_participante = $wpdb->get_results( "
						select ID, user_email 
						from wp_users 
						where md5(user_email) = '{$user_referido}'" 
					);
					$user_participante = (count($user_participante)>0)? $user_participante[0] : [];


					if(isset($user_participante->user_email)){
						$message_participante = kmimos_get_email_html(
							"Club de las patitas felices",
							$mensaje_mail_partitipante,
							'', true, true);
						wp_mail( $user_participante->user_email, 
								"¡Felicidades, has hecho a la manada más grande!", 
								$message_participante );
					}
				} 
			}
	   		// ********************************************************************
	   		// END Notificacion para usuario referidos - Landing WOM /Referidos
	   		// ********************************************************************

	    }

	}

?>