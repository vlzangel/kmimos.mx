<?php


	include("../vlz_config.php");

	$conn = new mysqli($host, $user, $pass, $db);

    // Eliminando los POSTs
    	
	    $r = $conn->query('
	    	SELECT 
				post.ID AS ID, item.meta_value AS item
			FROM 
				wp_posts AS post
			INNER JOIN  wp_postmeta AS metas ON ( metas.post_id = post.ID AND metas.meta_key = "_booking_type" )
			INNER JOIN  wp_postmeta AS item  ON ( item.post_id  = post.ID AND item.meta_key  = "_booking_order_item_id" )
			WHERE post.post_type = "wc_booking"
		');

	    if( $r->num_rows > 0 ){
		    while( $f = $r->fetch_assoc() ){
		    	$ids[] = $f['ID'];
		    	$items[] = $f['item'];
		    }
	    }

	    $r2 = $conn->query('
	    	SELECT 
				post.ID AS ID, metas.meta_value AS meta
			FROM 
				wp_posts AS post
			INNER JOIN  wp_postmeta AS metas ON ( metas.post_id = post.ID AND metas.meta_key = "_created_via" AND metas.meta_value = "Migrado" )
			WHERE post.post_type = "shop_order"
		');

	    if( $r2->num_rows > 0 ){
		    while( $f = $r2->fetch_assoc() ){
		    	$ids[] = $f['ID'];
		    }
	    }
/*
	    echo "<pre>";
	    	print_r($ids);

	    	echo "Items<br>";

	    	print_r($items);
	    echo "</pre>";*/

	    $sql_1 = "DELETE FROM wp_posts WHERE ID IN (".implode(", ", $ids).")";
	    $sql_2 = "DELETE FROM wp_postmeta WHERE post_id IN (".implode(", ", $ids).")";

		$conn->query($sql_1);
		$conn->query($sql_2);

	    $sql_1 = "DELETE FROM wp_woocommerce_order_items WHERE order_item_id IN (".implode(", ", $items).")";
	    $sql_2 = "DELETE FROM wp_woocommerce_order_itemmeta WHERE order_item_id IN (".implode(", ", $items).")";

		$conn->query($sql_1);
		$conn->query($sql_2);

	    // echo "<pre>";
	    // 	print_r($ids);

	    // 	echo "Items<br>";

	    // 	print_r($items);
	    // echo "</pre>";

	echo "Limpieza Completada!"; 
?>