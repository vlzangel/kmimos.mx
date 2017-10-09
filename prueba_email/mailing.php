<?php
	//PHPMailer
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	require 'phpmailer/PHPMailer.php'; // <<<< Ruta de PHP Mailer
	require 'phpmailer/Exception.php'; // <<<< Ruta de PHP Mailer
	require 'phpmailer/SMTP.php';      // <<<< Ruta de PHP Mailer

	// Wordpress
    define('WP_USE_THEMES', false);

    //date_default_timezone_set('America/Mexico_City');
    global $wpdb;
	
	extract($_POST);
	$email = $_POST['email'];
   
    # ********************************************
    # Email de Nuevo registro participantes 
    # ********************************************
	
	

	// ENVIO DE CORREO A USUARIO REGISTRADO
	$mail = new PHPMailer;
    
    $mail->IsSMTP();
    $mail->SMTPAuth = true;                // enable SMTP authentication 
    $mail->SMTPSecure = "tls";              // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com";        // sets Gmail as the SMTP server
    $mail->Port = 587;                     // set the SMTP port for the GMAIL 
    
    $mail->Username = "contactomex@kmimos.la"; // Correo completo a utilizar
    $mail->Password = "Kmimos2017"; // Contraseña
    
	//$mail->isSendmail();
	//$mail->setFrom('b.bros@kmimos.la', 'Blood Brothers | Kmimos');
	$mail->setFrom('contactomex@kmimos.la', 'Correo Mailing | Kmimos');
	$mail->addAddress($email, "Dajan Medina");
	$mail->Subject = 'Prueba correo Mailing | Kmimos';
	$mail->IsHTML(true);
	// $url_imagen_1 = 'https://kmimos.com.mx/bb/boletin-a.jpg'; // <<<<< SUSTITUIR POR URL FINAL
	// $url_imagen_2 = 'https://kmimos.com.mx/bb/boletin-c.jpg'; // <<<<< SUSTITUIR POR URL FINAL
	require_once('email_template/email_mailing.php');
	$body = $html; 
	$mail->Body = $body;
	$envio1=false;
	if ($mail->send()) {
	    $envio1=true;
	}
