<?php


if($_POST){

	$datos = [];

	$datos['nombre'] = ( !empty(strip_tags($_POST['nombre'])) )? $_POST['nombre'] : '' ; 
	$datos['apellido'] = ( !empty(strip_tags($_POST['apellido'])) )? $_POST['apellido'] : '' ; 
	$datos['sexo'] = ( !empty(strip_tags($_POST['sexo'])) )? $_POST['sexo'] : '' ; 
	$datos['edad'] = ( !empty(strip_tags($_POST['edad'])) )? $_POST['edad'] : '' ; 
	$datos['telf_movil'] = ( !empty(strip_tags($_POST['telf_movil'])) )? $_POST['telf_movil'] : '' ; 
	$datos['telf_casa'] = ( !empty(strip_tags($_POST['telf_casa'])) )? $_POST['telf_casa'] : '' ; 
	$datos['como_nos_conocio'] = ( !empty(strip_tags($_POST['fuente'])) )? $_POST['fuente'] : '' ; 	
	$datos['email'] = ( !empty(strip_tags($_POST['email'])) )? $_POST['email'] : '' ; 
	$datos['clave'] = ( !empty(strip_tags($_POST['clave'])) )? $_POST['clave'] : '' ; 

	// Verificar si existe el email
	$user = get_user_by( 'email', $datos['email'] );
	if(!isset($user->ID)){

		// Registrado de usuario
		$meta = explode('@', $datos['email']);
		$username = $meta[0];
	    $password = md5(wp_generate_password( 5, false ));
	    $user_id  = wp_create_user( $username, $password, $email );

		// Registrado de metas
		update_user_meta( $user_id, 'first_name', $datos['nombre'] );
		update_user_meta( $user_id, 'last_name', $datos['apellido'] );
		update_user_meta( $user_id, 'sexo', $datos['sexo'] );
		update_user_meta( $user_id, 'edad', $datos['edad'] );
		update_user_meta( $user_id, 'telef_movil', $datos['telf_movil'] );
		update_user_meta( $user_id, 'telef_casa', $datos['telf_casa'] );
		update_user_meta( $user_id, 'donde_nos_conocio', $datos['como_nos_conocio'] );

		// Envio de Email Bienvenida
		/*
		require_once('../template/email/register.php');
		if(wp_mail(
			$user_participante['rows'][0]['user_email'], 
			"¡Felicidades, has hecho a la manada más grande!", 
			$message_participante
		)){
		}
		*/

	}

}