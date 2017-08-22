<?php  
	if (isset( $_POST['submit'] )) { 
		//El formulario ha sido enviado
  		global $reg_errors;
  		$reg_errors = new WP_Error;

  		$nombres = sanitize_text_field($_POST['nombres']);
  		$apellidos = sanitize_text_field($_POST['apellidos']);
  		$numid = sanitize_text_field($_POST['numid']);
  		$email_1 = sanitize_text_field($_POST['email_1']);
  		$passw = sanitize_text_field($_POST['passw']);
  		$movil = sanitize_text_field($_POST['movil']);
  		
  	}


?>