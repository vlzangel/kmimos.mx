<?php
	$path = dirname(dirname(__DIR__));
	include( $path."/wp-load.php");

	include( $path."/app/db.php");
	include( $path."/app/funciones.php");

	extract($_POST);

	global $wpdb;

	$user = get_user_by( 'email', $email );
    if ( isset( $user, $user->user_login, $user->user_status ) && 0 == (int) $user->user_status ){
        $email = $user->user_login;
    }else{
        $email = sanitize_user($email, true);
    }

	$info = array();
    $info['user_login']     = sanitize_user($email, true);
    $info['user_password']  = sanitize_text_field($clave);

    $user_signon = wp_signon( $info, true );

	if ( is_wp_error( $user_signon )) {
	  	echo json_encode( 
	  		array( 
	  			'login' => false, 
	  			'men'   => "Email y contraseña invalidos."
	  		)
	  	);
	} else {

		$id = $user_signon->data->ID;

		$tipo = "";
		$xtipo = get_user_meta($id, "wp_capabilities", true);
		foreach ($xtipo as $key => $value) {
			$tipo = $key;
		}

		$datos = array(
			"ID" => $id,
			"nombre" => get_user_meta($id, "first_name", true),
			"apellido" => get_user_meta($id, "last_name", true),
			"tipo" => $tipo,
			"img" => app_kmimos_get_foto($id)
		);

	  	echo json_encode( 
	  		array( 
	  			'login' => true, 
	  			'user'  => $datos, 
	  			'men'   => "Login Exitoso!"
	  		)
	  	);
	}

?>