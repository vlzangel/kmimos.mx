<?php
	header('Access-Control-Allow-Origin: *');
	// Wordpress
    define('WP_USE_THEMES', false);
    require('../wp-blog-header.php');
    //date_default_timezone_set('America/Mexico_City');
    global $wpdb;


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

	$estatus_registro = 0;

	// Verificar si existe el email
	$user = get_user_by( 'email', $email );	
    $notificaciones = "";

	if(!isset($user->ID))
	{
		$meta = explode('@', $email);
		$username = $meta[0];
	    $password = md5(wp_generate_password( 5, false ));
	    $user_id  = wp_create_user( $username, $password, $email );
	
	    wp_update_user( array( 'ID' => $user_id, 'display_name' => "{$name}" ));		

		// Registrado desde el landing page
		update_user_meta( $user_id, 'first_name', $name );
		update_user_meta( $user_id, 'user_referred', 'Amigo/Familiar' );
		update_user_meta( $user_id, "landing-{$landing_name}", date('Y-m-d H:i:s') ); 		

	    // Buscar clientes referidos
	    if( !empty($referencia) ){
			update_user_meta( $user_id, 'landing-referencia', $referencia );
			// enviar correo al participante

			$sql2 = "select ID, user_email from wp_users where md5(user_email) = '{$referencia}'";
			$user_participante = get_fetch_assoc($sql2);
			// Envio de email cuando se registra un referido
			require_once('email_template/notificacion_registro_referido.php');
			$message_participante = kmimos_get_email_html(
				"Club de las patitas felices",
				$mensaje_mail_partitipante,
				'', true, true);

			if(wp_mail( 
				$user_participante['rows'][0]['user_email'], 
				"¡Felicidades, has hecho a la manada más grande!", 
				$message_participante
			)){
			}
		}

	    $user = new WP_User( $user_id );
	    $user->set_role( 'subscriber' );

		add_filter( 'wp_mail_from_name', function( $name ) { return 'Kmimos Mexico'; });
	    add_filter( 'wp_mail_from', function( $email ) { return 'kmimos@kmimos.la'; });
		require_once('email_template/user-registro.php');
	    $message = kmimos_get_email_html("Registro de Nuevo Usuario.", $mensaje_mail, '', true, true);
	    if(wp_mail( $email, "Kmimos Mexico – Gracias por registrarte! Kmimos la NUEVA forma de cuidar a tu perro!", $message)){
	    	#echo 'enviado';
	    }else{
	    	#echo 'no enviado';
	    }

	    $estatus_registro = 1;
	    $notificaciones = "Nuevo Usuario Registrado.";

		

	}


	function get_fetch_assoc($sql){
		$cnn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$data = [];
		if($cnn){
			$rows = $cnn->query( $sql );
			if(isset($rows->num_rows)){
				if( $rows->num_rows > 0){
					$data['info'] = $rows;
					$data['rows'] = mysqli_fetch_all($rows,MYSQLI_ASSOC);
				}
			}
		}
		return $data;
	}

print_r($estatus_registro);
