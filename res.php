<?php
	include("vlz_config.php");
	include("db.php");

	$db = new db( new mysqli($host, $user, $pass, $db) );

	$posts = $db->get_results("SELECT ID, post_status FROM wp_posts_2 WHERE post_status != 'publish'");
	foreach ($posts as $key => $value) {
		$sql = "UPDATE wp_posts SET post_status = '{$value->post_status}' WHERE ID = {$value->ID};";
		$db->query($sql);
		// echo $sql."<br>";
	}

?>