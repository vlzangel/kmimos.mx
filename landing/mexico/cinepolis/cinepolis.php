<?php
	
	// Wordpress
    define('WP_USE_THEMES', false);
    require('../wp-blog-header.php');
    date_default_timezone_set('America/Mexico_City');
    global $wpdb;

    $landing_url = "https://mx.kmimos/landing/";     // URL Landing
	$landing_name = 'cinepolis'; 	// Name Landing Page

	// Email List
	$email_admin_list = [
		"Adm1" => 'italococchini+admin1@gmail.com',
		"Adm2" => 'italococchini+admin2@gmail.com',
		"Call center" => 'italococchini+callcenter@gmail.com',
	];

	// Redireccion si faltan datos
	if( !isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['phone'])){ 
		header('location:'.$landing_url);
	}

	// Parametros
	$name  = $_POST['name'];
	$lastname  = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];

	// Verificar si existe el email
	$user = get_user_by( 'email', $email );	
    $notificaciones = "";

	if(!isset($user->ID))
	{
		$meta = explode('@', $email);
		$username = $meta[0];
	    $password = wp_generate_password( 12, false );
	    $user_id  = wp_create_user( $username, $password, $email );
	
	    wp_update_user( array( 'ID' => $user_id, 'display_name' => "{$name} {$lastname}" ));		

		// Registrado desde el landing page
		update_user_meta( $user_id, 'first_name', $name );
		update_user_meta( $user_id, 'last_name', $lastname );
		update_user_meta( $user_id, 'user_phone', $phone );
		update_user_meta( $user_id, 'landing-register', $landing_name );

	    $user = new WP_User( $user_id );
	    $user->set_role( 'subscriber' );

	    $sts_new_user = true;
	    $notificaciones = "Nuevo Usuario Registrado.";

echo "Usuario registrado - ID: {$user->ID} <br>";
	}else{
	    $sts_new_user = false;
	    $notificaciones = "El usuario ya posee una cuenta.";
		$username = $user->user_login;
	    $password = "";
echo 'Usuario ya existe - ID: {$user->ID}<br>';	    
	}


	if(isset($user->ID))
	{
		if($user->ID > 0){
			update_user_meta( $user_id, "landing-{$landing_name}", date('Y-m-d H:i:s') ); 	// Conversion por landing

			// ***************************************************
			// Filtros Email
			// ***************************************************
		    add_filter( 'wp_mail_from_name', function( $name ) {
		        return 'Kmimos Mexico';
		    });
		    add_filter( 'wp_mail_from', function( $email ) {
		        return 'kmimos@kmimos.la';
		    });

			// ***************************************************
			// Envio de Email a usuarios
			// ***************************************************
			require_once('email_template/user-registro.php');
		    $message = kmimos_get_email_html("Registro de Nuevo Usuario.", $mensaje_mail, '', true, true);
		    if ( wp_mail( $email, "Kmimos Mexico – Gracias por registrarte! Kmimos la NUEVA forma de cuidar a tu perro!", $message) ) 
		    {
echo "Email usuario enviado: {$email}<br>";
		    } else {
echo "Email usuario no enviado: {$email}<br>";
		    }

			// ***************************************************
			// Envio de Email a Administradores
			// ***************************************************
			require_once('email_template/user-callcenter.php');
		    $mensaje_admin = kmimos_get_email_html("Registro de Nuevo Usuario.", $mensaje_mail_admin, '', true, true);
			foreach($email_admin_list as $_name => $_email){
				wp_mail( 
					$_email, 
					"Kmimos Mexico – Gracias por registrarte! Kmimos la NUEVA forma de cuidar a tu perro!", 
					$mensaje_admin
				);
echo "Email usuario enviado: {$_email}<br>";
			}
		}
	}
echo "Finalizado<br>";
