<?php
	$load = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/wp-load.php';
	if(file_exists($load)){ include_once($load); }

	extract($_POST);

	$info = array();
    $info['user_login']     = sanitize_user($usu, true);
    $info['user_password']  = sanitize_text_field($clv);

    $user_signon = wp_signon( $info, true );
    wp_set_auth_cookie($user_signon->ID);

	exit;
?>