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
		return 'contactomex@kmimos.la'; 
	});

	// Modificacion Ángel Veloz
	if( !isset($_SESSION) ){ session_start(); }
	global $current_user;
	$user_id = md5($current_user->ID);

	if( isset( $_SESSION["MR_".$user_id] ) ){
		$data = $_SESSION["MR_".$user_id];
		$modificando = $data["reserva"];
		global $wpdb;
		$id_reserva_modificada = $wpdb->get_var("SELECT post_parent FROM wp_posts WHERE ID = '{$modificando}'");
		$modificacion = '<p align="justify">Esta es una modificación de la reserva #: '.$id_reserva_modificada.'</p>';
	}else{
		$modificacion = "";
	}

	include("vlz_data_orden.php");

	$email_admin = "contactomex@kmimos.la";

	$aceptar_rechazar = '
		<center>
			<p><strong>¿ACEPTAS ESTA RESERVA?</strong></p>
			<table> <tr> <td>
				<a href="'.get_home_url().'/wp-content/plugins/kmimos/order.php?o='.$id.'&s=1&t=1" style="text-decoration: none; padding: 7px 0px; background: #00d2b7; color: #FFF; font-size: 16px; font-weight: 500; border-radius: 5px; width: 100px; display: inline-block; text-align: center;">
					Aceptar
				</a> </td> <td>
				 <a href="'.get_home_url().'/wp-content/plugins/kmimos/order.php?o='.$id.'&s=0&t=1" style="text-decoration: none; padding: 7px 0px; background: #dc2222; color: #FFF; font-size: 16px; font-weight: 500; border-radius: 5px; width: 100px; display: inline-block; text-align: center;">
				 	Rechazar
				 </a> </td> </tr>
			</table>
		</center>
	';

	$dudas = '<p align="justify">Para cualquier duda y/o comentario puedes contactar al Staff Kmimos a los teléfonos +52 (55) 1791.4931, o al correo contactomex@kmimos.la</p>';

	if( $metas_orden["_payment_method"][0] == "openpay_cards" ){
		include("tarjeta.php");
	}else{
		if( $metas_orden["_payment_method"][0] == "openpay_stores" ){
			include("tienda.php");
		}else{
			include("otro.php");
		}
	}

	
?>