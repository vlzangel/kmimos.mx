<?php
	
	/* 
	*	Recoger data 
	*/

		function get_producto($cuidador, $servicio){
			global $db;
			$sql = "SELECT ID, post_title AS titulo FROM wp_posts WHERE post_author = '{$cuidador}' AND post_type = 'product' AND post_name LIKE '%{$servicio}%' ";
			return $db->get_row($sql, "ID");
		}
		
		function get_variantes($servicio, $variante){
			$_tamanos = array(
				"pequenos" => " post_name LIKE '%pequenos%' OR post_name LIKE '%pequenas%' ",
				"medianos" => " post_name LIKE '%medianos%' OR post_name LIKE '%medianas%' ",
				"grandes"  => " post_name LIKE '%grandes%' ",
				"gigantes" => " post_name LIKE '%gigantes%' "
			);
			global $db;
			$sql = "SELECT * FROM wp_posts WHERE post_parent = '{$servicio}' AND post_type = 'bookable_person' AND ( {$_tamanos[$variante]} ) ";
			return $db->get_var($sql, "ID");
		}
		
		function get_tamanos($reserva){
			$_tamanos = array(
				"3" => "pequenos",
				"4" => "medianos",
				"5" => "grandes",
				"6" => "gigantes"
			);

			global $db;

			$sql = "SELECT * FROM booked_services WHERE booking_id = {$reserva}";
			$tamanos = array();
			$mascota = $db->get_var($sql, "pet_id");
			if( $mascota ){
				$tam = $db->get_var("SELECT * FROM pets WHERE id = {$mascota}", "size_id");
				$tamanos[ $_tamanos[$tam] ] += 1;
			}

			$sql = "SELECT * FROM booked_pets WHERE booking_id = {$reserva}";
			$mascotas = $db->get_results($sql);
			if( $mascotas ){
				foreach ($mascotas as $key => $value) {
					if( $mascota != $value->pet_id ){
						$tam = $db->get_var("SELECT * FROM pets WHERE id = {$value->pet_id}", "size_id");
						$tamanos[ $_tamanos[$tam] ] += 1;
					}
				}
			}

			return $tamanos;
		}
		
		function get_servicios($reserva){
			$servicion = array(
				"15" => "Guardería",
				"16" => "Adiestramiento de obediencia básico",
				"17" => "Adiestramiento de obediencia intermedio",
				"18" => "Adiestramiento de obediencia avanzado"
			);
			$slugs = array(
				"15" => "guarderia",
				"16" => "adiestramiento_basico",
				"17" => "adiestramiento_intermedio",
				"18" => "adiestramiento_avanzado"
			);
			$servicion_adicionales = array(
				"1"  => "Transportación sencilla",
				"2"  => "Transportación redonda",
				"5"  => "Visita al veterinario",
				"6"  => "Acupuntura",
				"10" => "Limpieza dental",
				"13" => "Baño",
				"14" => "Corte de pelo y uñas"
			);
			global $db;
			$sql = "SELECT * FROM booked_services WHERE booking_id = {$reserva}";
			$servicios = $db->get_results($sql);
			$respuesta = array(
				"tipo" => "Hospedaje",
				"slug" => "hospedaje",
				"servicios" => array()
			);
			if( $servicios ){
				foreach ($servicios as $key => $value) {
					if( isset($servicion_adicionales[ $value->service_id ]) ){
						if( !in_array($servicion_adicionales[ $value->service_id ], $respuesta)){
							$respuesta["servicios"][] = $servicion_adicionales[ $value->service_id ];
						}
					}else{
						if( !in_array($servicion[ $value->service_id ], $respuesta)){
							$respuesta["tipo"] = $servicion[ $value->service_id ];
							$respuesta["slug"] = $slugs[ $value->service_id ];
						}
					}
				}
			}

			return $respuesta;

		}

		function get_fecha($fecha, $formato){
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			switch ( $formato ) {
				case 'txt':
					$time = strtotime( $fecha );
					return date('d', $time)." ".$meses[date('n', $time)-1]. ", ".date('Y', $time);
				break;
				case 'wc':
					$time = strtotime( $fecha );
					return date('Ymd', $time);
				break;
				case 'wp':
					$time = strtotime( $fecha );
					return date('Y-m-d H:i:s', $time);
				break;
			}
		}

		function get_duracion($fecha_inicio, $fecha_fin){
			$xini = strtotime($fecha_inicio);
			$xfin = strtotime($fecha_fin);  
			return ceil(((($xfin - $xini)/60)/60)/24)." Días";
		}

	/* 
	*	Generar SQLs
	*/

		function crear_shop_order($param){
			$sql = "
		        INSERT INTO
		            wp_posts 
		        VALUES (
		            NULL, 
		            1, 
		            '{$param['hoy']}', 
		            '{$param['hoy']}', 
		            '', 
		            'Orden - {$param['token']}', 
		            '', 
		            'wc-on-hold', 
		            'closed', 
		            'closed', 
		            '', 
		            'orden-{$param['token']}', 
		            '', 
		            '', 
		            '{$param['hoy']}',
		            '{$param['hoy']}',
		            '', 
		            0,
		            'http://www.kmimos.com.mx/?post_type=shop_order',
		            0, 
		            'shop_order', 
		            '', 
		            0
		        );
		    ";
			global $db;
			$db->query($sql);
			return $db->insert_id();
		}

		function crear_metas_shop_order($param){
			$sql = "
		        INSERT INTO wp_postmeta VALUES
	            (NULL, '{$param['id_order']}', '_customer_user',                         '{$param['cliente']}'),
	            (NULL, '{$param['id_order']}', '_order_total',                           '{$param['total']}'),
	            (NULL, '{$param['id_order']}', '_order_key',                             'wc_order_{$param['token']}'),
	            (NULL, '{$param['id_order']}', '_order_stock_reduced',                   '1'),
	            (NULL, '{$param['id_order']}', '_cart_discount_tax',                     '0'),
	            (NULL, '{$param['id_order']}', '_cart_discount',                         '0'),
	            (NULL, '{$param['id_order']}', '_order_version',                         '2.5.5'),
	            (NULL, '{$param['id_order']}', '_payment_method',                        'Migrado'),
	            (NULL, '{$param['id_order']}', '_recorded_sales',                        'yes'),
	            (NULL, '{$param['id_order']}', '_download_permissions_granted',          '1'),
	            (NULL, '{$param['id_order']}', '_order_shipping_tax',                    '0'),
	            (NULL, '{$param['id_order']}', '_order_tax',                             '0'),
	            (NULL, '{$param['id_order']}', '_order_shipping',                        ''),
	            (NULL, '{$param['id_order']}', '_payment_method_title',                  'Migrado'),
	            (NULL, '{$param['id_order']}', '_created_via',                           'Migrado'),
	            (NULL, '{$param['id_order']}', '_customer_user_agent',                   ''),
	            (NULL, '{$param['id_order']}', '_customer_ip_address',                   '::1'),
	            (NULL, '{$param['id_order']}', '_prices_include_tax',                    'yes'),
	            (NULL, '{$param['id_order']}', '_order_currency',                        'MXN');
		    ";
			global $db;
			$db->query($sql);
		}

		function crear_reserva($param){
			$sql = "
				INSERT INTO
		            wp_posts 
		        VALUES (
		            NULL, 
		            {$param['cliente']}, 
		            '{$param['hoy']}', 
		            '{$param['hoy']}', 
		            '', 
		            'Reserva - {$param['token']}', 
		            '', 
		            'confirmed', 
		            'closed', 
		            'closed', 
		            '', 
		            'reserva-{$param['token']}', 
		            '', 
		            '', 
		            '{$param['hoy']}',
		            '{$param['hoy']}',
		            '', 
		            {$param['id_order']},
		            'http://www.kmimos.com.mx/?post_type=wc_booking',
		            0, 
		            'wc_booking', 
		            '', 
		            0
		        );
			";
			global $db;
			$db->query($sql);
			return $db->insert_id();
		}

		function crear_metas_reservas($param){
			$sql = "
		        INSERT INTO wp_postmeta VALUES
	            (NULL, '{$param['id_reserva']}', '_booking_type',     		 'Migrado'),
	            (NULL, '{$param['id_reserva']}', '_booking_customer_id',     '{$param['cliente']}'),
	            (NULL, '{$param['id_reserva']}', '_booking_all_day',         '1'),
	            (NULL, '{$param['id_reserva']}', '_booking_start',           '{$param['inicio']}'),
	            (NULL, '{$param['id_reserva']}', '_booking_end',             '{$param['fin']}'),
	            (NULL, '{$param['id_reserva']}', '_booking_cost',            '{$param['total']}'),
	            (NULL, '{$param['id_reserva']}', '_booking_persons',         '{$param['num_mascotas']}'),
	            (NULL, '{$param['id_reserva']}', '_booking_order_item_id',   '{$param['id_item']}'),
	            (NULL, '{$param['id_reserva']}', '_booking_product_id',      '{$param['servicio']}');
		    ";
			global $db;
			$db->query($sql);
		}

		function crear_item($param){
			$sql = "
		        INSERT INTO
		            wp_woocommerce_order_items
		        VALUES (
		            NULL, 
		            '{$param['titulo']}', 
		            'line_item', 
		            '{$param['id_order']}'
		        );
		    ";
			global $db;
			$db->query($sql);
			return $db->insert_id();
		}

		function crear_metas_item($param){
			$_tamanos = array(
				"pequenos" => "Mascotas Pequeños",
				"medianos" => "Mascotas Medianos",
				"grandes"  => "Mascotas Grandes",
				"gigantes" => "Mascotas Gigantes"
			);
			$tamanos = "";
			foreach ($param["tamanos"] as $key => $value) {
				$tamanos .= "(NULL, '{$param['id_item']}', '{$_tamanos[$key]}', '{$value}'),";
			}
			$sql = utf8_decode("
		        INSERT INTO wp_woocommerce_order_itemmeta VALUES
	            (NULL, '{$param['id_item']}', 'Reserva ID', '{$param['id_reserva']}'),
	            (NULL, '{$param['id_item']}', 'Duración', '{$param['duracion']}'),
	            {$tamanos}
	            (NULL, '{$param['id_item']}', '_line_total',    '{$param['total']}'),
	            (NULL, '{$param['id_item']}', '_line_subtotal', '{$param['total']}'),
	            (NULL, '{$param['id_item']}', 'Fecha de Reserva', '{$param['inicio']}'),
	            (NULL, '{$param['id_item']}', '_product_id', '{$param['servicio']}'),
	            (NULL, '{$param['id_item']}', 'Ofrecido por', 'Cuidador Kmimos'),
	            (NULL, '{$param['id_item']}', '_wc_deposit_meta', 'a:1:{s:6:\"enable\";s:2:\"no\";}'),
	            (NULL, '{$param['id_item']}', '_line_tax_data', 'a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}'),
	            (NULL, '{$param['id_item']}', '_line_tax', '0'),
	            (NULL, '{$param['id_item']}', '_line_subtotal_tax', '0'),
	            (NULL, '{$param['id_item']}', '_variation_id', '0'),
	            (NULL, '{$param['id_item']}', '_tax_class', ''),
	            (NULL, '{$param['id_item']}', '_qty', '1');
		    ");
			global $db;
			$db->query($sql);
		}

?>