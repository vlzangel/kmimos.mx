<?php
	header('Access-Control-Allow-Origin: *');
	// Wordpress
    define('WP_USE_THEMES', false);

    require('../wp-blog-header.php');
    //date_default_timezone_set('America/Mexico_City');
    global $wpdb;
	
	$http = (isset($_SERVER['HTTPS']))? 'https://' : 'http://' ;
	 extract($_POST);
	$email = $_POST['email'];
    # ********************************************
    # Email de Nuevo registro participantes 
    # ********************************************
	require_once('email_template/email_mailing.php');
	wp_mail(
		$email,
		"Lista Mailing",
		$html
	);
    # ********************************************
    echo "Email recibido y enviado se supone ".$email;