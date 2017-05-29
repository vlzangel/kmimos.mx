<?php

	error_reporting(0);

	$conn = new mysqli("localhost", "root", "", 'kmimos.reservas');

    // Eliminando los POSTs
    	
	    $r = $conn->query(
	    	'SELECT 
				ID, post_type
			FROM 
				wp_posts 
			WHERE 
				wp_posts.post_type IN (
					"shop_order",
					"shop_order_vendor",
					"wc_booking"
				) AND 
				wp_posts.ID NOT IN (
					150685,
					150686,
					150684
				)');

	    while( $f = $r->fetch_assoc() ){
	    	$ids[] = $f['ID'];
	    }

	    $sql_1 = "DELETE FROM wp_posts WHERE ID IN (".implode(", ", $ids).")";
	    $sql_2 = "DELETE FROM wp_postmeta WHERE post_id IN (".implode(", ", $ids).")";

		$conn->query($sql_1);
		$conn->query($sql_2);

		// $r = $conn->query("SELECT order_item_id FROM wp_woocommerce_order_items WHERE order_item_name LIKE '%Hospedaje%'");

	 //    while( $f = $r->fetch_assoc() ){
	 //    	$item_ids[] = $f['order_item_id'];
	 //    }

	 //    $sql_1 = "DELETE FROM wp_woocommerce_order_items WHERE order_item_id IN (".implode(", ", $item_ids).")";
	 //    $sql_2 = "DELETE FROM wp_woocommerce_order_itemmeta WHERE order_item_id IN (".implode(", ", $item_ids).")";

		// $conn->query($sql_1);
		// $conn->query($sql_2);

	echo "Limpieza Completada!"; 
?>