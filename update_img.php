<?php
	include("vlz_config.php");
	include("db.php");
	$conn = new mysqli($host, $user, $pass, $db);
	$db = new db($conn);

	$r = $db->get_results("
		SELECT 
			post.post_title AS servicio,
			meta.meta_id AS id_meta,
			meta.meta_value AS id_img 
		FROM 
			wp_posts AS post
		INNER JOIN wp_postmeta AS meta ON ( post.ID = meta.post_id)
		WHERE 
			post.post_type =	'product' 		AND 
			post.post_name LIKE '%paseos%' 		AND
			meta.meta_key  = 	'_thumbnail_id'
	");

	if( $r ){
		echo "<pre>";
			foreach ($r as $key => $value) {
				print_r($value);
				$db->query("UPDATE wp_postmeta SET meta_value = '55480' WHERE meta_id = {$value->id_meta};");
			}
		echo "</pre>";
	}
?>