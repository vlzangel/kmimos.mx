<?php
	
	// Wordpress
    define('WP_USE_THEMES', false);
    require('../wp-blog-header.php');
    date_default_timezone_set('America/Mexico_City');
    global $wpdb;
exit();

    $landing_url = "https://www.kmimos.com.mx/referidos";     // URL Landing
	$landing_name = 'kmimos-mx-clientes-referidos'; 	// Name Landing Page

	// Email List
	$email_admin_list = [
		"Adm1" => 'italococchini+admin1@gmail.com',
		"Adm2" => 'italococchini+admin2@gmail.com',
		"Call center" => 'italococchini+callcenter@gmail.com',
	];

	// Redireccion si faltan datos
	if( !isset($_GET['name']) || !isset($_GET['email']) ){ 
		//header('location:/referidos');
	}

	// Parametros
	$name  = $_GET['name'];
	$email = $_GET['email'];
	$referencia = ( isset( $_GET['referencia'] ) )? $_GET['referencia'] : '' ;
	$url = ( $email != '' )? md5($email) : '' ;

	// Verificar si existe el email
	$user = get_user_by( 'email', $email );	
    $notificaciones = "";

	if(!isset($user->ID))
	{
		$meta = explode('@', $email);
		$username = $meta[0];
	    $password = wp_generate_password( 12, false );
	    $user_id  = wp_create_user( $username, $password, $email );
	
	    wp_update_user( array( 'ID' => $user_id, 'display_name' => "{$name}" ));		

		// Registrado desde el landing page
		update_user_meta( $user_id, 'first_name', $name );

	    $user = new WP_User( $user_id );
	    $user->set_role( 'subscriber' );

	    $estatus_registro = 1;
	    $notificaciones = "Nuevo Usuario Registrado.";

	}else{
	    $estatus_registro = 2;
	    $notificaciones = "El usuario ya posee una cuenta.";
	    $user_id = $user->ID;
	}

	// ***************************************************
	// Registrar metas
	// ***************************************************
	if(isset( $user_id ) )
	{
		if($user->ID > 0){
			update_user_meta( $user_id, 'landing-referencia', $referencia );
			update_user_meta( $user_id, "landing-{$landing_name}", date('Y-m-d H:i:s') ); 
		}
	}

	// ***************************************************
	// Email
	// ***************************************************
	if(isset($user->ID) && $estatus_registro==1)
	{
		if($user->ID > 0){

		    add_filter( 'wp_mail_from_name', function( $name ) {
		        return 'Kmimos Mexico';
		    });
		    add_filter( 'wp_mail_from', function( $email ) {
		        return 'kmimos@kmimos.la';
		    });

			// ***************************************************
			// Envio de Email a usuarios
			// ***************************************************
/*
			require_once('email_template/user-registro.php');
		    $message = kmimos_get_email_html("Registro de Nuevo Usuario.", $mensaje_mail, '', true, true);
		    if ( wp_mail( $email, "Kmimos Mexico – Gracias por registrarte! Kmimos la NUEVA forma de cuidar a tu perro!", $message) ) 
		    {
		    	$opt_result = 1;
		    } else {
		    	$opt_result = 0;
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
			}
*/
		}
	}

print_r($estatus_registro);