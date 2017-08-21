<?php 
    require('../../../vlz_config.php');
    require('../../../db.php');

    extract($_GET);
   	
	$db = new db( new mysqli($host, $user, $pass, $db) );

	$db->query("DELETE FROM wp_usermeta WHERE user_id = {$user_id} AND meta_key LIKE '%openpay%' ");


	header("location: ".$_SERVER["HTTP_REFERER"]);
?>