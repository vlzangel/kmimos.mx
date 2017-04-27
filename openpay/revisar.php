<?php
	include("../wp-config.php");

	//include("openpay/Openpay.php");

	global $wpdb;

    date_default_timezone_set('America/Mexico_City');

    $limite = date("Y-m-d", strtotime("-4 day"));

    $ordenes_pasadas = $wpdb->get_results("
		SELECT 
			p.ID AS orden,
			p.post_date AS fecha,
			p.post_status AS status_orden,
			reserva.ID AS reserva,
			reserva.post_status AS status_reserva,
			remanente.meta_value AS remanente
		FROM 
			wp_posts AS p
		INNER JOIN wp_posts 						AS reserva 		ON ( p.ID 					= reserva.post_parent																										) 
		INNER JOIN wp_postmeta 						AS mts 	 		ON ( p.ID 					= mts.post_id 					) 
		INNER JOIN wp_postmeta 						AS mts_reserva 	ON ( reserva.ID 			= mts_reserva.post_id 		AND mts_reserva.meta_key 	= '_booking_order_item_id'											) 
		INNER JOIN wp_woocommerce_order_itemmeta 	AS remanente 	ON ( mts_reserva.meta_value = remanente.order_item_id 	AND remanente.meta_key 		= '_wc_deposit_meta'												) 
		WHERE 
			1=1 
			AND mts.meta_key = '_payment_method' AND mts.meta_value = 'openpay_stores'
			AND p.post_type = 'shop_order' AND p.post_status = 'wc-on-hold' AND p.post_date < '{$limite}'
			AND reserva.post_status = 'unpaid'
		GROUP BY 
			p.ID DESC
	");

	echo "
		<style>
			*{
				font-size: 12px;
			}
		</style>
	";


	foreach ($ordenes_pasadas as $key => $value) {
		$booking = new WC_Booking( $value->reserva );
 	 	$order   = new WC_Order($value->orden );
	
		$order->update_status('wc-cancelled');
		$booking->update_status('cancelled');

		// TODO: hay que enviar un correo cuando el plazo para pagar haya terminado.?
	}

	$ordenes_pendientes = $wpdb->get_results("
		SELECT 
			p.ID AS orden,
			p.post_date AS fecha,
			p.post_status AS status_orden,
			reserva.ID AS reserva,
			reserva.post_status AS status_reserva,
			remanente.meta_value AS remanente
		FROM 
			wp_posts AS p
		INNER JOIN wp_posts 						AS reserva 		ON ( p.ID 					= reserva.post_parent																										) 
		INNER JOIN wp_postmeta 						AS mts 	 		ON ( p.ID 					= mts.post_id 					) 
		INNER JOIN wp_postmeta 						AS mts_reserva 	ON ( reserva.ID 			= mts_reserva.post_id 		AND mts_reserva.meta_key 	= '_booking_order_item_id'											) 
		INNER JOIN wp_woocommerce_order_itemmeta 	AS remanente 	ON ( mts_reserva.meta_value = remanente.order_item_id 	AND remanente.meta_key 		= '_wc_deposit_meta'												) 
		WHERE 
			1=1 
			AND mts.meta_key = '_payment_method' AND mts.meta_value = 'openpay_stores'
			AND p.post_type = 'shop_order' AND p.post_status = 'wc-on-hold' AND p.post_date >= '{$limite}'
			AND reserva.post_status = 'unpaid'
		GROUP BY 
			p.ID DESC
	");

	if( count($ordenes_pendientes) > 0){

		$ordenes = array();
		foreach ($ordenes_pendientes as $f) {
			$ordenes[] = $f->orden;
		}

		$openpay = Openpay::getInstance('mbagfbv0xahlop5kxrui', 'sk_b485a174f8d34df3b52e05c7a9d8cb22');
		Openpay::setProductionMode(true);

		$findDataRequest = array(
		    // 'creation[gte]' => $limite,
		    'creation[gte]' => $limite,
		    'offset' => 0,
		    'limit' => 10000
	    );

		$chargeList = $openpay->charges->getList($findDataRequest);

		foreach ($chargeList as $key => $value) {

			if( in_array($value->order_id, $ordenes) ){

				switch ($value->status) {

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

						$email_admin = "contactomx@kmimos.la";

						$metas_orden 	= get_post_meta($id_orden);
						$metas_reserva  = get_post_meta( $id_reserva );

						/* Datos del Producto */

						$producto = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = '{$metas_reserva['_booking_product_id'][0]}'");
						$tipo_servicio  = explode("-", $producto->post_title);
						$tipo_servicio  = $tipo_servicio[0];
						$metas_producto = get_post_meta( $producto->ID );

						/* Datos del cuidador */

						$cuidador_post  = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = '{$producto->post_parent}'");
						$cuidador 		= $wpdb->get_row("SELECT * FROM cuidadores WHERE user_id = '{$producto->post_author}'");

						$detalles_cuidador = '
							<p style="color:#557da1;font-size: 16px;font-weight: 600;">Datos del Cuidador</p>
							<table cellspacing=0 cellpadding=0>
								<tr>
									<td style="width: 70px;"> <strong>Nombre:</strong> </td>
									<td>'.$cuidador_post->post_title.'</td>
								</tr>
								<tr>
									<td> <strong>Teléfono:</strong> </td>
									<td>'.$cuidador->telefono.'</td>
								</tr>
								<tr>
									<td> <strong>Correo:</strong> </td>
									<td>'.$cuidador->email.'</td>
								</tr>
							</table>
						';

						/* Datos del cliente */

						$cliente = $metas_orden["_customer_user"][0];
						$metas_cliente = get_user_meta($cliente);

						$nombre = $metas_cliente["first_name"][0];
						$apellido = $metas_cliente["last_name"][0];
						$dir = $metas_cliente["user_address"][0];

						$telf = $metas_cliente["user_phone"][0];
						if( $metas_cliente["user_mobile"][0] != "" ){ $telf .= ", ".$metas_cliente["user_mobile"][0]; }
						if( $telf == "" ){ $telf = "No registrado"; }
						if( $dir == "" ){ $dir = "No registrada"; }

						$user = get_user_by( 'id', $cliente );

						$cliente_email = $user->data->user_email;

						$detalles_cliente = '
							<p align="justify" style="color:#557da1;font-size: 16px;font-weight: 600;">Datos del Cliente</p>
							<table cellspacing=0 cellpadding=0>
								<tr>
									<td style="width: 70px;"> <strong>Nombre:</strong> </td>
									<td>'.$nombre.' '.$apellido.'</td>
								</tr>
								<tr>
									<td> <strong>Teléfono:</strong> </td>
									<td>'.$telf.'</td>
								</tr>
								<tr>
									<td> <strong>Correo:</strong> </td>
									<td>'.$user->data->user_email.'</td>
								</tr>
							</table>
						';

						/* Mascotas */

						$mascotas = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_author = '{$cliente}' AND post_type='pets'");
						
						$detalles_mascotas = "";
						$detalles_mascotas .= '
							<h2 style="color: #557da1; font-size: 16px;">Detalles de las mascotas: </h2>
							<table style="width:100%" cellspacing=0 cellpadding=0>
								<tr>
									<th style="padding: 3px; background: #00d2b7;"> <strong>Nombre</strong> </th>
									<th style="padding: 3px; background: #00d2b7;"> <strong>Raza</strong> </th>
									<th style="padding: 3px; background: #00d2b7;"> <strong>Edad</strong> </th>
									<th style="padding: 3px; background: #00d2b7;"> <strong>Tamaño</strong> </th>
									<th style="padding: 3px; background: #00d2b7;"> <strong>Comportamiento</strong> </th> 
								</tr>';

						$comportamientos_array = array(
							"pet_sociable" 			 => "Sociables",
							"pet_sociable2" 		 => "No sociables",
							"aggressive_with_pets"   => "Agresivos con perros",
							"aggressive_with_humans" => "Agresivos con humanos",
						);
						$tamanos_array = array(
							"Pequeño",
							"Mediano",
							"Grande",
							"Gigante"
						);
						if( count($mascotas) > 0 ){
							foreach ($mascotas as $key => $mascota) {
								$data_mascota = get_post_meta($mascota->ID);

								$temp = array();
								foreach ($data_mascota as $key => $value) {

									switch ($key) {
										case 'pet_sociable':
											if( $value[0] == 1 ){
												$temp[] = "Sociable";
											}else{
												$temp[] = "No sociable";
											}
										break;
										case 'aggressive_with_pets':
											if( $value[0] == 1 ){
												$temp[] = "Agresivo con perros";
											}
										break;
										case 'aggressive_with_humans':
											if( $value[0] == 1 ){
												$temp[] = "Agresivo con humanos";
											}
										break;
									}

								}

								$anio = explode("-", $data_mascota['birthdate_pet'][0]);
								$edad = date("Y") - $anio[0];

								$raza = $wpdb->get_var("SELECT nombre FROM razas WHERE id=".$data_mascota['breed_pet'][0]);

								$detalles_mascotas .= '
									<tr>
										<td style="border-bottom: solid 1px #00d2b7; padding: 3px;" valign="top"> '.$data_mascota['name_pet'][0].'</td>
										<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" valign="top"> '.$raza.'</td>
										<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" valign="top"> '.$edad.' año(s)</td>
										<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" valign="top"> '.$tamanos_array[ $data_mascota['size_pet'][0] ].'</td>
										<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" valign="top"> '.implode("<br>", $temp).'</td>
									</tr>
								';
							}
						}else{
							$detalles_mascotas .= '
								<tr>
									<td colspan="5">No tiene mascotas registradas.</td>
								</tr>
							';
						}
						$detalles_mascotas .= '</table>';

						/* Detalles del servicio */

						$inicio = $metas_reserva['_booking_start'][0];
						$fin    = $metas_reserva['_booking_end'][0];

						$xini = strtotime( substr($inicio, 0, 4)."-".substr($inicio, 4, 2)."-".substr($inicio, 6, 2) );
						$xfin = strtotime( substr($fin, 0, 4)."-".substr($fin, 4, 2)."-".substr($fin, 6, 2) );

						$inicio = substr($inicio, 6, 2)	."/".substr($inicio, 4, 2)."/".substr($inicio, 0, 4);
						$fin    = substr($fin, 6, 2)	."/".substr($fin, 4, 2)	  ."/".substr($fin, 0, 4);

						$id_orden_item = $metas_reserva['_booking_order_item_id'][0];

						$orden_item = $wpdb->get_results("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = '".$id_orden_item."'");

						$adicionales_array = array();
						$transporte  = array();
						foreach ($orden_item as $key => $value) {

							switch ($value->meta_value) {

								case 'Transp. Sencillo - Rutas Cortas':

									$data = explode(" ", $value->meta_key);
									$data[6] = str_replace("(", "", $data[6]);
									$data[6] = str_replace(")", "", $data[6]);
									$data[6] = substr($data[6], 5);
									$transporte[] = array(
										$value->meta_value,
										$data[6]+0
									);

				                break;

				                case 'Transp. Sencillo - Rutas Medias':

									$data = explode(" ", $value->meta_key);
									$data[6] = str_replace("(", "", $data[6]);
									$data[6] = str_replace(")", "", $data[6]);
									$data[6] = substr($data[6], 5);
									$transporte[] = array(
										$value->meta_value,
										$data[6]+0
									);

				                break;

				                case 'Transp. Sencillo - Rutas Largas':

									$data = explode(" ", $value->meta_key);
									$data[6] = str_replace("(", "", $data[6]);
									$data[6] = str_replace(")", "", $data[6]);
									$data[6] = substr($data[6], 5);
									$transporte[] = array(
										$value->meta_value,
										$data[6]+0
									);

				                break;

				                case 'Transp. Redondo - Rutas Cortas':

									$data = explode(" ", $value->meta_key);
									$data[6] = str_replace("(", "", $data[6]);
									$data[6] = str_replace(")", "", $data[6]);
									$data[6] = substr($data[6], 5);
									$transporte[] = array(
										$value->meta_value,
										$data[6]+0
									);

				                break;

				                case 'Transp. Redondo - Rutas Medias':

									$data = explode(" ", $value->meta_key);
									$data[6] = str_replace("(", "", $data[6]);
									$data[6] = str_replace(")", "", $data[6]);
									$data[6] = substr($data[6], 5);
									$transporte[] = array(
										$value->meta_value,
										$data[6]+0
									);

				                break;

				                case 'Transp. Redondo - Rutas Largas':

									$data = explode(" ", $value->meta_key);
									$data[6] = str_replace("(", "", $data[6]);
									$data[6] = str_replace(")", "", $data[6]);
									$data[6] = substr($data[6], 5);
									$transporte[] = array(
										$value->meta_value,
										$data[6]+0
									);

				                break;

								case 'Baño (precio por mascota)':
									$data = explode(" ", $value->meta_key);
									$data[5] = str_replace("(", "", $data[5]);
									$data[5] = str_replace(")", "", $data[5]);
									$data[5] = substr($data[5], 5);
									$adicionales_array[] = array(
										'Baño',
										$data[5]+0
									);
								break;

								case 'Ba&ntilde;o (precio por mascota)':
									$data = explode(" ", $value->meta_key);
									$data[5] = str_replace("(", "", $data[5]);
									$data[5] = str_replace(")", "", $data[5]);
									$data[5] = substr($data[5], 5);
									$adicionales_array[] = array(
										'Baño',
										$data[5]+0
									);
								break;
								
								case 'Corte de Pelo y U&ntilde;as (precio por mascota)':
									$data = explode(" ", $value->meta_key);
									$data[5] = str_replace("(", "", $data[5]);
									$data[5] = str_replace(")", "", $data[5]);
									$data[5] = substr($data[5], 5);
									$adicionales_array[] = array(
										'Corte de Pelo y Uñas',
										$data[5]+0
									);
								break;
								
								case 'Corte de Pelo y Uñas (precio por mascota)':
									$data = explode(" ", $value->meta_key);
									$data[5] = str_replace("(", "", $data[5]);
									$data[5] = str_replace(")", "", $data[5]);
									$data[5] = substr($data[5], 5);
									$adicionales_array[] = array(
										'Corte de Pelo y Uñas',
										$data[5]+0
									);
								break;
								
								case 'Visita al Veterinario (precio por mascota)':
									$data = explode(" ", $value->meta_key);
									$data[5] = str_replace("(", "", $data[5]);
									$data[5] = str_replace(")", "", $data[5]);
									$data[5] = substr($data[5], 5);
									$adicionales_array[] = array(
										'Visita al Veterinario',
										$data[5]+0
									);
								break;
								
								case 'Limpieza Dental (precio por mascota)':
									$data = explode(" ", $value->meta_key);
									$data[5] = str_replace("(", "", $data[5]);
									$data[5] = str_replace(")", "", $data[5]);
									$data[5] = substr($data[5], 5);
									$adicionales_array[] = array(
										'Limpieza Dental',
										$data[5]+0
									);
								break;
								
								case 'Acupuntura (precio por mascota)':
									$data = explode(" ", $value->meta_key);
									$data[5] = str_replace("(", "", $data[5]);
									$data[5] = str_replace(")", "", $data[5]);
									$data[5] = substr($data[5], 5);
									$adicionales_array[] = array(
										'Acupuntura',
										$data[5]+0
									);
								break;

							}
						}

						$detalles_reserva = array();
						foreach ($orden_item as $key => $value) {
							$detalles_reserva[$value->meta_key] = $value->meta_value;
						}

						$variaciones_array = array(
							"pequenos" => "Mascotas Pequeños", 
							"medianos" => "Mascotas Medianos", 
							"grandes"  => "Mascotas Grandes", 
							"gigantes" => "Mascotas Gigantes",
							"pequenos" => "Mascotas Pequeñas", 
							"medianos" => "Mascotas Medianas"
						);

						$txts = array(
							"pequenos" => "Mascotas Pequeñas", 
							"medianos" => "Mascotas Medianas", 
							"grandes"  => "Mascotas Grandes", 
							"gigantes" => "Mascotas Gigantes"
						);

						$dias = ceil(((($xfin - $xini)/60)/60)/24);

						$dias_noches = "Noche";
						if( trim($tipo_servicio) != "Hospedaje" ){
							$dias_noches = "Día";
							$dias++;
						}

						if( $dias > 1 ){
							$dias_noches .= "s";
						}

						$variaciones = ''; $grupo = 0;
						foreach ($variaciones_array as $key => $value) {
							if( isset( $detalles_reserva[$value] ) ){

								$variacion_ID = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent={$producto->ID} AND post_title='{$value}' ");
								$metas_variacion = get_post_meta($variacion_ID);

								$unitario = $metas_producto['_price'][0]+$metas_variacion['block_cost'][0];

								$variaciones .= '
								<tr>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-left: solid 1px #00d2b7;"> '.$txts[$key].' </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" align="center"> '.$detalles_reserva[$value].' </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" align="center"> '.$dias.' '.$dias_noches.' </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" align="right"> '.number_format( $unitario, 2, ',', '.').'$ </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right"> '.number_format( ($unitario*$detalles_reserva[$value]*$dias), 2, ',', '.').'$ </td>
								</tr>';

								$grupo += $detalles_reserva[$value];

							}
						}

						if( count($adicionales_array) > 0 ){

							$adicionales = '<tr> <td style="padding: 3px; background: #00d2b7; border-left: solid 1px #00d2b7; font-weight: 800;" colspan=5> Servicios Adicionales </td> </tr>';
							foreach ($adicionales_array as $key => $value) {
								$servicio = $value[0];
								$costo = ($value[1]);
								$adicionales .= '
								<tr>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-left: solid 1px #00d2b7;" colspan=2> '.$servicio.' </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" align="left"> '.$grupo.' Mascota(s) </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" align="right"> '.number_format( $costo, 2, ',', '.').'$ </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right"> '.number_format( ($costo*$grupo), 2, ',', '.').'$ </td>
								</tr>';
							}

						}

						if( count($transporte) > 0 ){
							
							$transporte_str = '<tr> <td style="padding: 3px; background: #00d2b7; border-left: solid 1px #00d2b7; font-weight: 800;" colspan=5> Servicio de Transporte </td> </tr>';
							foreach ($transporte as $key => $value) {
								$servicio = $value[0];
								$costo = ($value[1]);
								$transporte_str .= '
								<tr>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-left: solid 1px #00d2b7;" colspan=2> '.$servicio.' </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" align="center"> Precio por Grupo </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7;" align="right"> '.number_format( $costo, 2, ',', '.').'$ </td>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right"> '.number_format( $costo, 2, ',', '.').'$ </td>
								</tr>';
							}

						}

						$pago = ($detalles_reserva['_line_total']);
						$remanente = unserialize($detalles_reserva['_wc_deposit_meta']);

						if( $remanente['enable'] == "no" ){
							$remanente['deposit'] = $pago;
						}

						if( $metas_orden["_payment_method"][0] == "openpay_stores" ){
							$totales = '
								<tr>
									<td></td>
									<td></td>
									<th colspan=2 style="padding: 3px; border-bottom: solid 1px #00d2b7; border-left: solid 1px #00d2b7;">Total</th>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right">'.number_format( $pago, 2, ',', '.').'$</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<th colspan=2 style="padding: 3px; border-bottom: solid 1px #00d2b7; border-left: solid 1px #00d2b7;">Pago en Tienda</th>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right">'.number_format( $remanente['deposit'], 2, ',', '.').'$</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<th colspan=2 style="padding: 3px; border-bottom: solid 1px #cccccc;  text-align: left;">Cliente debe pagar al Cuidador:<div style="color: red;">en efectivo, al llevar a la mascota</div></th>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right">'.number_format( $remanente['remaining'], 2, ',', '.').'$</td>
								</tr>
							';
						}else{

							$totales = '
								<tr>
									<td></td>
									<td></td>
									<th colspan=2 style="padding: 3px; border-bottom: solid 1px #00d2b7; border-left: solid 1px #00d2b7; text-align: left;">Total</th>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right">'.number_format( $pago, 2, ',', '.').'$</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<th colspan=2 style="padding: 3px; border-bottom: solid 1px #00d2b7; border-left: solid 1px #00d2b7; text-align: left;">Pagado</th>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right">'.number_format( $remanente['deposit'], 2, ',', '.').'$</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<th colspan=2 style="padding: 3px; border-bottom: solid 1px #cccccc;  text-align: left;">Cliente debe pagar al Cuidador:<div style="color: red;">en efectivo, al llevar a la mascota</div></th>
									<td style="padding: 3px; border-bottom: solid 1px #00d2b7; border-right: solid 1px #00d2b7;" align="right">'.number_format( $remanente['remaining'], 2, ',', '.').'$</td>
								</tr>
							';

						}

						$detalles_servicio_admin = '
							<br>
							<p align="justify" style="color:#557da1;font-size: 16px;font-weight: 600;">Detalles del Servicio Reservado</p>
							<table>
								<tr> <td> <strong>Servicio:</strong> </td> <td> '.$tipo_servicio.' </td> </tr>
								<tr> <td> <strong>Desde:</strong> </td> <td> '.$inicio.' </td> </tr>
								<tr> <td> <strong>Hasta:</strong> </td> <td> '.$fin.' </td> </tr>
								<tr> <td> <strong>Duración:</strong> </td> <td> '.$dias.' '.$dias_noches.' </td> </tr>
								<tr> <td> <strong>Método de Pago:</strong> </td> <td> '.$metas_orden['_payment_method_title'][0].' </td> </tr>
							</table>
							<br>
							<table style="width:100%" cellspacing=0 cellpadding=0>
								<tr>
									<th style="padding: 3px; background: #00d2b7; border-left: solid 1px #00d2b7;"> Tamaño </th>
									<th style="padding: 3px; background: #00d2b7;"> Num. Mascotas </th>
									<th style="padding: 3px; background: #00d2b7;"> Tiempo </th>
									<th style="padding: 3px; background: #00d2b7; width: 150px;"> Precio Unitario </th>
									<th style="padding: 3px; background: #00d2b7; border-right: solid 1px #00d2b7;"> Precio Total </th>
								</tr>
								'.$variaciones.'
								'.$transporte_str.'
								'.$adicionales.'
								'.$totales.'
							</table>
						';

						$detalles_servicio = '
							<br>
							<p><h2 style="color: #557da1;">Detalles del Servicio Reservado</h2></p>
							<table>
								<tr> <td> <strong>Servicio:</strong> </td> <td> '.$tipo_servicio.' </td> </tr>
								<tr> <td> <strong>Desde:</strong> </td> <td> '.$inicio.' </td> </tr>
								<tr> <td> <strong>Hasta:</strong> </td> <td> '.$fin.' </td> </tr>
								<tr> <td> <strong>Duración:</strong> </td> <td> '.$dias.' '.$dias_noches.' </td> </tr>
							</table>
							<br>
							<table style="width:100%" cellspacing=0 cellpadding=0>
								<tr>
									<th style="padding: 3px; background: #00d2b7; border-left: solid 1px #00d2b7;"> Tamaño </th>
									<th style="padding: 3px; background: #00d2b7;"> Num. Mascotas </th>
									<th style="padding: 3px; background: #00d2b7;"> Tiempo </th>
									<th style="padding: 3px; background: #00d2b7; width: 150px;"> Precio Unitario </th>
									<th style="padding: 3px; background: #00d2b7; border-right: solid 1px #00d2b7;"> Precio Total </th>
								</tr>
								'.$variaciones.'
								'.$transporte_str.'
								'.$adicionales.'
								'.$totales.'
							</table>
						';

						$dudas = '<p align="justify">Para cualquier duda y/o comentario puedes contactar al Staff Kmimos a los teléfonos +52 (55) 1791.4931, o al correo atencion@kmimos.com.mx</p>';
					
						/* Cliente */

						$msg_id_reserva ='<p>Solicitud de reserva de servicio <strong>(N° '.$id_reserva.')</strong> </p>';
						$saludo = '
							<center style="font-size: 16px; font-weight: 600;">¡Gracias '.$nombre.' '.$apellido.'!</center>
							<p>Recibimos tu solicitud de reserva de <strong>'.trim($tipo_servicio).'</strong>, para que <strong>'.$cuidador_post->post_title.'</strong> atienda a tu(s) peludo(s).</p>
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

						$mensaje_cliente = kmimos_get_email_html('Pago Recibido Exitosamente!', $mensaje_cliente, 'Pago Recibido Exitosamente!', true, true);

						/* Administrador */

						$aceptar_rechazar = '
							<center>
								<p><strong>¿ACEPTAS ESTA RESERVA? </strong></p>
								<table>
									<tr>
										<td>
											<a href="'.get_home_url().'/wp-content/plugins/kmimos/order.php?o='.$id_orden.'&s=1&t=1" style="text-decoration: none; padding: 7px 0px; background: #00d2b7; color: #FFF; font-size: 16px; font-weight: 500; border-radius: 5px; width: 100px; display: inline-block; text-align: center;">Aceptar</a>
										</td>
										<td>
											<a href="'.get_home_url().'/wp-content/plugins/kmimos/order.php?o='.$id_orden.'&s=0&t=1" style="text-decoration: none; padding: 7px 0px; background: #dc2222; color: #FFF; font-size: 16px; font-weight: 500; border-radius: 5px; width: 100px; display: inline-block; text-align: center;">Rechazar</a>
										</td>
									</tr>
								</table>
							</center>
						';

						$saludo = "<p>Hola <strong>Administrador</strong>,</p>";
						$msg_id_reserva ='<p>Se ha pagado la Reserva <strong># '.$id_reserva.'</strong> a través de <strong>Pago en efectivo en tiendas de conveniencia</strong></p>';
						$mensaje_admin 	= 
							$saludo.
						  	$msg_id_reserva.
					  		"<br>".$aceptar_rechazar.
						  	$detalles_cliente.
						  	$detalles_cuidador.
						  	$detalles_mascotas.
						  	$detalles_servicio_admin.
					  		"<br>".$aceptar_rechazar
						;
						
						$mensaje_admin = kmimos_get_email_html('Nueva Reserva - '.$producto->post_title, $mensaje_admin, 'Nueva Reserva - '.$producto->post_title, true, true);

						/* Cuidador */

						$msg_id_reserva ='<p>Reserva #: <strong>'.$id_reserva.'</strong> </p>';
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
									<ul> <li>
										<p>¿Sale a pasear?, ¿A qué hora come y hace del baño?, etc.</p>
									</li> </ul>
								</li>
								<li>
									<p>¿Cómo se comporta con otros seres vivos? </p>
									<ul> <li>
										<p>¿Cómo interactúa con otros perros y personas?, ¿Cómo reacciona con un extraño?, etc.</p>
									</li> </ul>
								</li>
								<li>
									<p>¿Cómo identifica su animó?  </p>
									<ul> <li>
										<p>¿Cómo se comporta cuando esta triste o estresado?, ¿Qué hace su dueño cuando esta triste o estresado?, etc.</p>
									</li> </ul>
								</li>
							</ul>
						';

						$mensaje_cuidador  	= 	
							$saludo.
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

						wp_mail( $cliente_email, 	'Pago Recibido Exitosamente!', $mensaje_cliente);
						wp_mail( $email_admin, 		'Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, $mensaje_admin,    kmimos_mails_administradores());
						wp_mail( $cuidador->email, 	'Nueva Reserva - '.$tipo_servicio.' por: '.$nombre.' '.$apellido, $mensaje_cuidador, kmimos_mails_administradores());

					break;
				
				}
				
			}
		}

	}

?>