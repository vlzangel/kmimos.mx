<?php
require_once('base_db.php');
require_once('GlobalFunction.php');

// ***************************************
// Cargar listados de Reservas
// ***************************************

function calculo_pago_cuidador( $id_reserva, $total, $pago, $remanente ){

	$saldo_cuidador = 0;
	
	$dif = $remanente + $pago;
	if( $dif != $total || ($remanente == 0 && $dif == $total) ){
	        $pago_cuidador_real = ($total / 1.2);
	        $pago_kmimos = $total - $pago_cuidador_real;
	        $saldo_cuidador = $pago_cuidador_real - $remanente;
	}

	return $saldo_cuidador;
}

function getReservas($desde="", $hasta=""){

	$filtro_adicional = "";

	if( !empty($desde) && !empty($hasta) ){
		$filtro_adicional = " 
			AND ( r.post_date >= '{$desde} 00:00:00' and  r.post_date <= '{$hasta} 23:59:59' )
		";
	}else{
		$filtro_adicional = " AND MONTH(r.post_date) = MONTH(NOW()) AND YEAR(r.post_date) = YEAR(NOW()) ";
	}

	global $wpdb;
	$sql = "
		SELECT 
			r.ID as 'nro_reserva',
 			DATE_FORMAT(r.post_date,'%d-%m-%Y') as 'fecha_solicitud',
 			r.post_status as 'estatus_reserva',
 			p.ID as 'nro_pedido',
 			p.post_status as 'estatus_pago', 			
			pr.post_title as 'producto_title',
			pr.post_name as 'producto_name',			
 			(du.meta_value -1) as  'nro_noches',
 			(IFNULL(mpe.meta_value,0) + IFNULL(mme.meta_value,0) + IFNULL(mgr.meta_value,0) + IFNULL(mgi.meta_value,0)) as nro_mascotas,
 			((du.meta_value -1) * ( IFNULL(mpe.meta_value,0) + IFNULL(mme.meta_value,0) + IFNULL(mgr.meta_value,0) + IFNULL(mgi.meta_value,0) )) as 'total_noches',

			pr.ID as producto_id,
			pr.post_name as post_name,
 			us.user_id as cuidador_id,
 			cl.ID as cliente_id

		from wp_posts as r
			LEFT JOIN wp_postmeta as rm ON rm.post_id = r.ID and rm.meta_key = '_booking_order_item_id' 
			LEFT JOIN wp_posts as p ON p.ID = r.post_parent

			LEFT JOIN wp_woocommerce_order_itemmeta as fe  ON (fe.order_item_id  = rm.meta_value and fe.meta_key  = 'Fecha de Reserva')
			LEFT JOIN wp_woocommerce_order_itemmeta as du  ON (du.order_item_id  = rm.meta_value and du.meta_key  = 'Duración')
			LEFT JOIN wp_woocommerce_order_itemmeta as mpe ON mpe.order_item_id = rm.meta_value and (mpe.meta_key = 'Mascotas Pequeños' or mpe.meta_key = 'Mascotas Pequeñas')
			LEFT JOIN wp_woocommerce_order_itemmeta as mme ON mme.order_item_id = rm.meta_value and (mme.meta_key = 'Mascotas Medianos' or mme.meta_key = 'Mascotas Medianas')
			LEFT JOIN wp_woocommerce_order_itemmeta as mgr ON (mgr.order_item_id = rm.meta_value and mgr.meta_key = 'Mascotas Grandes')
			LEFT JOIN wp_woocommerce_order_itemmeta as mgi ON (mgi.order_item_id = rm.meta_value and mgi.meta_key = 'Mascotas Gigantes')
			LEFT JOIN wp_woocommerce_order_itemmeta as pri ON (pri.order_item_id = rm.meta_value and pri.meta_key = '_product_id')
			LEFT JOIN wp_posts as pr ON pr.ID = pri.meta_value
			LEFT JOIN cuidadores as us ON us.user_id = pr.post_author
			LEFT JOIN wp_users as cl ON cl.ID = r.post_author
		WHERE r.post_type = 'wc_booking' 
			and not r.post_status like '%cart%' 
			and cl.ID > 0 
			and p.ID > 0
			and r.post_status = 'confirmed'
			{$filtro_adicional}
		ORDER BY
			p.ID DESC
		;";

	$reservas = $wpdb->get_results($sql);
	return $reservas;
}




function getRazaDescripcion($id, $razas){
	$nombre = "[{$id}]";
	if($id > 0){
		if( !empty($razas) ){
			if(array_key_exists($id, $razas)){
				$nombre = $razas[$id];
			}
		}
	}
	return $nombre;
}

/*function get_razas(){
	global $wpdb;
	$sql = "SELECT * FROM razas ";
	$result = $wpdb->get_results($sql);
	$razas = [];
	foreach ($result as $raza) {
		$razas[$raza->id] = $raza->nombre;
	}
	return $razas;
}*/

function getCountReservas( $author_id=0, $interval=12, $desde="", $hasta=""){

	$filtro_adicional = "";
	if( !empty($landing) ){
		$filtro_adicional = " source = '{$landing}'";
	}
	if( !empty($desde) && !empty($hasta) ){
		$filtro_adicional .= (!empty($filtro_adicional))? ' AND ' : '' ;
		$filtro_adicional .= " 
			DATE_FORMAT(post_date, '%m-%d-%Y') between DATE_FORMAT('{$desde}','%m-%d-%Y') and DATE_FORMAT('{$hasta}','%m-%d-%Y')
		";
	}else{
		$filtro_adicional .= (!empty($filtro_adicional))? ' AND ' : '' ;
		$filtro_adicional .= " MONTH(post_date) = MONTH(NOW()) AND YEAR(post_date) = YEAR(NOW()) ";
	}


	$filtro_adicional = ( !empty($filtro_adicional) )? " WHERE {$filtro_adicional}" : $filtro_adicional ;

	$result = [];
	$sql = "
		SELECT 
			count(ID) as cant
		FROM wp_posts
		WHERE post_type = 'wc_booking' 
			AND not post_status like '%cart%'
			AND post_status = 'confirmed' 
			AND post_author = {$author_id}
			AND post_date > DATE_SUB(CURDATE(), INTERVAL {$interval} MONTH)
	";

	$result = get_fetch_assoc($sql);
	return $result;
}

function get_status($sts_reserva, $sts_pedido, $forma_pago="", $id_reserva){
	
	// Cargar a totales
	$addTotal = 0;
	// Resultado
	$sts_corto = "---";
	$sts_largo = "Estatus Reserva: {$sts_reserva}  /  Estatus Pedido: {$sts_pedido}";
	//===============================================================
	// BEGIN PaymentMethod
	// Nota: Agregar la equivalencia de estatus de las pasarelas de pago
	//===============================================================
	$payment_method_cards = [ // pagos por TDC / TDD
		'openpay_cards'
	]; 
	$payment_method_store = [ // pagos por Tienda por conveniencia
		'openpay_stores'
	]; 
	//===============================================================
	// END PaymentMethod
	//===============================================================

	// Pedidos
	switch ($sts_reserva) {
		case 'unpaid':
			$sts_corto = "Pendiente";
			if( $sts_pedido == 'wc-on-hold'){
				if( in_array($forma_pago, $payment_method_cards) ){
					$sts_largo = "Pendiente por confirmar el cuidador"; // metodo de pago es por TDC / TDD ( parcial )
				}elseif( in_array($forma_pago, $payment_method_store) ){
					$sts_largo = "Pendiente de pago en tienda"; // Tienda por conv
				}else{
					$sts_largo = "Estatus Pedido: {$sts_pedido}"; 
				}
			}
			if( $sts_pedido == 'wc-pending'){
				$sts_largo = 'Pendiente de pago';
			}
		break;
		case 'confirmed':
			$sts_corto = 'Confirmado';
			$sts_largo = 'Confirmado';
			$addTotal  = 1;
		break;
		case 'paid':
			$sts_corto = 'Pagado';
			$sts_largo = 'Pagado';
		break;
		case 'cancelled':
			$sts_corto = 'Cancelado';
			$sts_largo = 'Cancelado';
		break;
		// Modificacion Ángel Veloz
		case 'modified':
			$por = get_post_meta( $id_reserva, 'reserva_modificada', true );
			$sts_corto = 'Modificado';
			$sts_largo = 'Modificado por la reserva: '.$por;
		break;
	}

	return 	$result = [ 
		"reserva"  => $sts_reserva, 
		"pedido"   => $sts_pedido,
		"sts_corto"=> $sts_corto,
		"sts_largo"=> $sts_largo,
		"addTotal" => $addTotal,
	];
}

function photo_exists($path=""){
	$photo = (file_exists('../'.$path) && !empty($path))? 
		get_option('siteurl').'/'.$path : 
		get_option('siteurl')."/wp-content/themes/pointfinder/images/noimg.png";
	return $photo;
}

/*function getEdad($fecha){
	$fecha = str_replace("/","-",$fecha);
	$hoy = date('Y/m/d');

	$diff = abs(strtotime($hoy) - strtotime($fecha) );
	$years = floor($diff / (365*60*60*24)); 
	$desc = " Años";
	$edad = $years;
	if($edad==0){
		$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
		$edad = $months;
		$desc = ($edad > 1) ? " Meses" : " Mes";
	}
	if($edad==0){
		$days  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$edad = $days;
		$desc = " Días";
	}

	return $edad . $desc;
}*/

function getMascotas($user_id){
	if(!$user_id>0){ return []; }
	$result = [];
	$list = kmimos_get_my_pets($user_id);
	$pets = explode(",",$list['list']);

	foreach ($pets as $row) {
		$result[$row] = kmimos_get_pet_info($row);
	}
	return $result;
}

function getProduct( $num_reserva = 0 ){
	$services = [];

	global $wpdb;
	$sql = "	
		SELECT 
			i.meta_key as 'servicio',
			i.meta_value as 'descripcion'
		FROM wp_woocommerce_order_itemmeta as i
			-- Order_item_id
			LEFT JOIN wp_woocommerce_order_itemmeta as o ON ( o.meta_key = 'Reserva ID' and o.meta_value = $num_reserva )
			-- Reserva
			LEFT JOIN wp_posts as re ON re.ID = i.meta_value -- No. Reserva
		WHERE	
			i.meta_key like 'Servicios Adicionales%'
			and i.order_item_id = o.order_item_id
	";
	$services = $wpdb->get_results($sql);

	return $services;	
}

function getServices( $num_reserva = 0 ){
	$services = [];

	global $wpdb;
	$sql = "	
		SELECT 
			i.meta_key as 'servicio',
			i.meta_value as 'descripcion'
		FROM wp_woocommerce_order_itemmeta as i
			-- Order_item_id
			LEFT JOIN wp_woocommerce_order_itemmeta as o ON ( o.meta_key = 'Reserva ID' and o.meta_value = $num_reserva )
			-- Reserva
			LEFT JOIN wp_posts as re ON re.ID = i.meta_value -- No. Reserva
		WHERE	
			i.meta_key like 'Servicios Adicionales%'
			and i.order_item_id = o.order_item_id
	";
	$services = $wpdb->get_results($sql);

	return $services;
}

function getMetaCliente( $user_id ){
	$condicion = " AND m.meta_key IN ('first_name', 'last_name', 'user_referred')";
	$result = get_metaUser($user_id, $condicion);
	$data = [
		'first_name' =>'', 
		'last_name' =>'', 
		'user_referred' =>'', 
	];
	if( !empty($result) ){
		foreach ($result['rows'] as $row) {
			$data[$row['meta_key']] = utf8_encode( $row['meta_value'] );
			//$data['cliente_nombre'] = utf8_encode( $row['meta_value'] );
		}
	}
	$data = merge_phone($data);
	return $data;
}

function getMetaCuidador( $user_id ){
	$condicion = " AND m.meta_key IN ('first_name', 'last_name', 'user_referred')";
	$result = get_metaUser($user_id, $condicion);
	$data = [
		'first_name' =>'', 
		'last_name' =>'', 
		'user_referred' =>'', 
	];
	if( !empty($result) ){
		foreach ($result['rows'] as $row) {
			$data[$row['meta_key']] = utf8_encode( $row['meta_value'] );
		}
	}
	$data = merge_phone($data);
	return $data;
}

function getMetaReserva( $post_id ){
	$condicion = " AND meta_key IN ( '_booking_start', '_booking_end', '_booking_cost', 'modificacion_de' )";
	$result = get_metaPost($post_id, $condicion);

	$data = [
		'_booking_start' =>'', 
		'_booking_end' =>'', 
		'_booking_cost' =>'', 
	];
	if( !empty($result) ){
		foreach ($result['rows'] as $row) {
			$data[$row['meta_key']] = utf8_encode( $row['meta_value'] );
		}
	}
	return $data;	
}

function getMetaPedido( $post_id ){
	$condicion = " AND meta_key IN ( '_payment_method','_payment_method_title','_order_total','_wc_deposits_remaining' )";
	$result = get_metaPost($post_id, $condicion);
	$data = [
		'_payment_method' => '',
		'_payment_method_title' => '',
		'_order_total' => '',
		'_wc_deposits_remaining' => '',
	];
	if( !empty($result) ){
		foreach ($result['rows'] as $row) {
			$data[$row['meta_key']] = utf8_encode( $row['meta_value'] );
		}
	}
	return $data;	
}

function get_ubicacion_cuidador( $user_id ){
	global $wpdb;
	$sql = "
		SELECT ub.*
		from  ubicaciones as ub
			inner join cuidadores as u ON u.id = ub.cuidador  
 	 	WHERE u.user_id = $user_id
 	";
	$ubi = $wpdb->get_results($sql);
	$ubicacion=$ubi;

	$data = [
		"estado" => '',
		"municipio" => '',
		"sql" => $sql,
	];
	if(count($ubi)>0){
		$ubicacion = $ubi[0];

		$estado = explode('=', $ubicacion->estado);
		$munici = explode('=', $ubicacion->municipios);

		$est = $wpdb->get_results("select * from states as est where est.id = ".$estado[1]);
		if(count($est)>0){ 
			$est = $est[0];
			$data['estado'] = $est->name; 
		}

		$mun = $wpdb->get_results("select * from locations as mun where mun.id = ".$munici[1]);
		if(count($mun)>0){ 
			$mun = $mun[0];
			$data['municipio'] = $mun->name; 
		}

	}

	return $data;
}


function Get_CouponCode($order_id,$coupon_code) {
	global $wpdb;
	$return = array();

	$query = "SELECT DISTINCT
        wc_items.order_item_name AS coupon_name,
        wc_itemmeta.meta_value AS coupon_discount_amount,
        postmeta.*

        FROM
        {$wpdb->prefix}woocommerce_order_items AS wc_items
		LEFT JOIN
        {$wpdb->prefix}woocommerce_order_itemmeta AS wc_itemmeta ON wc_items.order_item_id = wc_itemmeta.order_item_id
        LEFT JOIN
        {$wpdb->prefix}posts AS post ON post.post_title = wc_items.order_item_name
        LEFT JOIN
        {$wpdb->prefix}postmeta AS postmeta ON post.ID = postmeta.post_id

        WHERE
        wc_items.order_id = '{$order_id}' AND
        wc_items.order_item_type = 'coupon' AND
        wc_items.order_item_name LIKE '%{$coupon_code}%' AND
		wc_itemmeta.meta_key = 'discount_amount' ";
/*

	*/
	$coupons = $wpdb->get_results($query);

	if (!empty($coupons)) {
		foreach ($coupons as $key => $coupon) {
			//var_dump($coupon);
			$coupon_name = $coupon->coupon_name;

			if($coupon->meta_key=='coupon_amount'){
				if(!array_key_exists($coupon_name,$return)){
					$return[$coupon_name]=array();
				}
				$return[$coupon_name]['coupon_name'] = $coupon_name;
				$return[$coupon_name]['coupon_amount'] = $coupon->meta_value;
				//$return[$coupon_name]['coupon_amount'] = $coupon->meta_value;

			}else if($coupon->meta_key=='discount_type'){
				if(!array_key_exists($coupon_name,$return)){
					$return[$coupon_name]=array();
				}

				$return[$coupon_name]['discount_type'] = $coupon->meta_value;
			}

			//AMOUNT DISCOUNT
			$return[$coupon_name]['coupon_amount'] = $coupon->coupon_discount_amount;
		}
	}

	//var_dump($return);
	return $return;
}


function Get_SumCouponCode($order_id,$coupon_code,$total=0) {
	$coupons = Get_CouponCode($order_id,$coupon_code);
	$amount = 0;

	if(count($coupons)){
		foreach($coupons as $coupon){
			if($coupon['discount_type'] != 'percent'){
				$coupon_amount = $coupon['coupon_amount'];

			}else{
				$coupon_amount = $total*($coupon['coupon_amount']/100);
			}

			$coupon_amount = $coupon['coupon_amount'];
			$amount = $amount+$coupon_amount;
		}
	}
	return $amount;
}


function Get_NameCouponCode($order_id,$coupon_code) {
	$coupons = Get_CouponCode($order_id,$coupon_code);
	$name = array();

	if(count($coupons)){
		foreach($coupons as $coupon){
			$name[] = $coupon['coupon_name'];
		}
	}

	return implode(',',$name);
}

