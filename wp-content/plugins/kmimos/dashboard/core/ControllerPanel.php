<?php
// ***************************************
// Cargar listados de Reservas
// ***************************************
function getReservas(){
	global $wpdb;
	$sql = "
		SELECT
			cl.ID as 'Cliente ID',
			CONCAT(cln.meta_value,' ',cll.meta_value) as 'Cliente Nombre',
			-- cli.meta_value as 'Cliente Photo',
			cu.meta_value as 'Cuidador Nombre',
			i.meta_value as 'Nro. Reserva',
			re.post_parent as 'Nro. del Pedido',
			-- es.meta_value as 'Estado',
			-- es.meta_value as 'Municipio',
			re.post_date as 'Fecha de la solicitud',
			DATE_FORMAT(fd.meta_value,'%d-%m-%Y') as  'Estadía Desde',
			DATE_FORMAT(fh.meta_value,'%d-%m-%Y') as 'Estadía Hasta',
			(du.meta_value -1) as  'Nro. Noches',
			(IFNULL(mpe.meta_value,0) + IFNULL(mme.meta_value,0) + IFNULL(mgr.meta_value,0) + IFNULL(mgi.meta_value,0)) as 'Numero de mascotas',
			((du.meta_value -1) * ( IFNULL(mpe.meta_value,0) + IFNULL(mme.meta_value,0) + IFNULL(mgr.meta_value,0) + IFNULL(mgi.meta_value,0) )) as 'Nro de noches totales',
			fp.meta_value as 'Forma de pago',
			re.post_status as 'Estatus de la reserva',
			re.ping_status as 'Estatus del pago',
			IFNULL(bc.meta_value,0) as 'Total a Pagar',
			IFNULL(ot.meta_value,0) as 'Monto pagado',
			IFNULL(rm.meta_value,0) as 'Pago pendiente al cuidador'
		FROM wp_woocommerce_order_itemmeta as i
			-- Reserva
			LEFT JOIN wp_posts as re ON re.ID = i.meta_value -- No. Reserva
			LEFT JOIN wp_postmeta as fd ON ( fd.post_id = re.ID and fd.meta_key = '_booking_start' ) -- Desde
			LEFT JOIN wp_postmeta as fh ON ( fh.post_id = re.ID and fh.meta_key = '_booking_end' ) -- Hasta
			LEFT JOIN wp_postmeta as bc ON ( bc.post_id = re.ID and bc.meta_key = '_booking_cost' ) -- Total a pagar
			-- Pedido
			LEFT JOIN wp_posts as pe ON pe.ID = re.post_parent -- No. Pedido
			LEFT JOIN wp_postmeta as es ON ( es.post_id = pe.ID and es.meta_key = '_shipping_state') -- Estado 
			LEFT JOIN wp_postmeta as cy ON ( cy.post_id = pe.ID and cy.meta_key = '_shipping_city') -- Ciudad
			LEFT JOIN wp_postmeta as fp ON ( fp.post_id = pe.ID and fp.meta_key = '_payment_method_title') -- Forma de Pago
			LEFT JOIN wp_postmeta as ot ON ( ot.post_id = pe.ID and ot.meta_key = '_order_total') -- Total Orden
			LEFT JOIN wp_postmeta as rm ON ( rm.post_id = pe.ID and rm.meta_key = '_wc_deposits_remaining') -- Remanente
			-- Woocommerce
			LEFT JOIN wp_woocommerce_order_itemmeta as fe  ON (fe.order_item_id = i.order_item_id and fe.meta_key = 'Fecha de Reserva')
			LEFT JOIN wp_woocommerce_order_itemmeta as du  ON (du.order_item_id = i.order_item_id and du.meta_key = 'Duración')
			LEFT JOIN wp_woocommerce_order_itemmeta as mpe ON (mpe.order_item_id = i.order_item_id and mpe.meta_key = 'Mascotas Pequeños')
			LEFT JOIN wp_woocommerce_order_itemmeta as mme ON (mme.order_item_id = i.order_item_id and mme.meta_key = 'Mascotas Medianos')
			LEFT JOIN wp_woocommerce_order_itemmeta as mgr ON (mgr.order_item_id = i.order_item_id and mgr.meta_key = 'Mascotas Grandes')
			LEFT JOIN wp_woocommerce_order_itemmeta as mgi ON (mgi.order_item_id = i.order_item_id and mgi.meta_key = 'Mascotas Gigantes')
			-- Datos Cuidador
			LEFT JOIN wp_woocommerce_order_itemmeta as cu  ON (cu.order_item_id = i.order_item_id and cu.meta_key = 'Ofrecido por') -- Nombre del cuidador
			-- Datos Cliente
			LEFT JOIN wp_users as cl ON cl.ID = re.post_author 
			LEFT JOIN wp_usermeta as cln ON ( cln.user_id = cl.ID  and cln.meta_key = 'first_name' )
			LEFT JOIN wp_usermeta as cll ON ( cll.user_id = cl.ID  and cll.meta_key = 'last_name' )
			LEFT JOIN wp_usermeta as cli ON ( cli.user_id = cl.ID  and cli.meta_key = 'name_photo' )
		WHERE i.meta_key = 'Reserva ID'
		ORDER BY i.meta_id DESC
	";

	$reservas = $wpdb->get_results($sql, ARRAY_N);
	return $reservas;
}

