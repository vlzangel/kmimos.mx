<?php
	include("../db.php");

	extract($_POST);

	$home = $db->get_var("SELECT option_value FROM wp_options WHERE option_name = 'siteurl'");

?>