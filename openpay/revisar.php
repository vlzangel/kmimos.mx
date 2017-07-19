<?php
	include("../wp-load.php");

	global $wpdb;

    date_default_timezone_set('America/Mexico_City');

    $limite = date("Y-m-d", strtotime("-4 day"));

	echo "<style> *{ font-size: 12px; } </style>";

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
		INNER JOIN wp_posts 						AS reserva 		ON ( p.ID 					= reserva.post_parent ) 
		INNER JOIN wp_postmeta 						AS mts 	 		ON ( p.ID 					= mts.post_id ) 
		INNER JOIN wp_postmeta 						AS mts_reserva 	ON ( reserva.ID 			= mts_reserva.post_id 		AND mts_reserva.meta_key 	= '_booking_order_item_id' ) 
		INNER JOIN wp_woocommerce_order_itemmeta 	AS remanente 	ON ( mts_reserva.meta_value = remanente.order_item_id 	AND remanente.meta_key 		= '_wc_deposit_meta' ) 
		WHERE 
			mts.meta_key = '_payment_method' AND mts.meta_value = 'openpay_stores'
			AND p.post_type = 'shop_order' AND p.post_status = 'wc-on-hold' AND p.post_date >= '{$limite}'
			AND reserva.post_status = 'unpaid'
	");

	if( count($ordenes_pendientes) > 0){

		$ordenes = array();
		foreach ($ordenes_pendientes as $f) {
			$ordenes[] = $f->orden;
		}

		// Modo Producción
		$openpay = Openpay::getInstance('mbagfbv0xahlop5kxrui', 'sk_b485a174f8d34df3b52e05c7a9d8cb22');
		Openpay::setProductionMode(true);

		// Modo Pruebas
		// $openpay = Openpay::getInstance('mej4n9f1fsisxcpiyfsz', 'sk_684a7f8598784911a42ce52fb9df936f');

		$findDataRequest = array(
		    'creation[gte]' => $limite,
		    'offset' => 0,
		    'limit' => 10000
	    );

		$chargeList = $openpay->charges->getList($findDataRequest);

		foreach ($chargeList as $key => $value) {

			if( in_array($value->order_id, $ordenes) ){

				if( $value->due_date != "" ){

					if( $value->status == "completed" ){
						$status_transaccion = "completed";
					}else{
						$fec = strtotime($value->due_date);
						if( $fec < $hoy ){
							$status_transaccion = "cancelled";
						}else{
							$status_transaccion = "pending";
						}
					}

					include("procesar.php");
				}
				
			}
		}

	}

?>