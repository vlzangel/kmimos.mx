<?php include 'pre-header.php'; ?><!doctype html><html lang="es-ES" class="no-js"><head><title>Kmimos</title><meta charset="UTF-8"><?php 
	$HTML = '';	
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
		header('X-UA-Compatible: IE=edge,chrome=1');
	}
	if ( is_page() ){
		global $post;
		$descripcion = get_post_meta($post->ID, 'kmimos_descripcion', true);
		if( $descripcion != ""){
			$HTML .= "<meta name='description' content='{$descripcion}'>";
		}
	}

	$HTML .= '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';

	wp_enqueue_style( 'style', getTema()."/style.css", array(), "1.0.0" );

	wp_enqueue_style( 'generales_css', getTema()."/css/generales.css", array(), "1.0.0" );
	wp_enqueue_style( 'jquery.bxslider', getTema()."/css/jquery.bxslider.css", array(), "1.0.0" );
	wp_enqueue_style( 'bootstrap.min', getTema()."/css/bootstrap.min.css", array(), "1.0.0" );
	wp_enqueue_style( 'datepicker.min', getTema()."/css/datepicker.min.css", array(), "1.0.0" );
	wp_enqueue_style( 'kmimos_style', getTema()."/css/kmimos_style.css", array(), "1.0.0" );

	wp_enqueue_style( 'jquery.datepick', getTema()."/lib/datapicker/jquery.datepick.css", array(), "1.0.0" );

	wp_head(); 

	global $post;
	$reserrvacion_page = "";
	if( $post->post_name == 'reservar' ){
		$reserrvacion_page = "page-reservation";
	}

	$HTML .= '
		<script type="text/javascript"> 
			var HOME = "'.getTema().'/"; 
			var RAIZ = "'.get_home_url().'/"; 
			var pines = [];
			var AVATAR = "";
		</script>
	</head>

	<body class="'.join( ' ', get_body_class( $class ) ).' '.$reserrvacion_page.'" >';

	include_once("funciones.php");

	$MENU = get_menu_header();

	if( !isset($MENU["head"]) ){
		$menus_normal = '
			<li><a style="padding-right: 15px" data-toggle="modal" data-target="#popup-iniciar-sesion">INICIAR SESIÓN</a></li>
			<li><a  style="padding-left: 15px; border-left: 1px solid white;" data-toggle="modal" data-target="#myModal">REGISTRARME</a></li>
		';
		$menus_movil = '
			<li><a class="km-nav-link hidden-sm hidden-md hidden-lg" data-toggle="modal" data-target="#popup-iniciar-sesion">INICIAR SESIÓN</a></li>
			<li><a href="#" class="km-nav-link hidden-sm hidden-md hidden-lg" data-toggle="modal" data-target="#myModal">REGISTRARME</a></li>
		';
	}else{
		$menus_normal = $MENU["head"].$MENU["body"].$MENU["footer"];
		$menus_movil = $MENU["head_movil"].$MENU["body"].$MENU["footer"];
	}

	if( !is_user_logged_in() ){

		$HTML .= '
			
			<nav class="navbar navbar-fixed-top bg-transparent">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<img src="'.getTema().'/images/new/km-navbar-mobile.svg" width="30">
						</button>
						
					</div>
					<ul class="hidden-xs nav-login">
						'.$menus_normal.'
					</ul>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="'.get_home_url().'"/busqueda/" class="km-nav-link">BUSCAR CUIDADOR</a></li>
							<li><a href="km-cuidador.html" class="km-btn-primary hidden-xs">QUIERO SER CUIDADOR</a></li>

							'.$menus_movil.'

							<li><a href="'.get_home_url().'"/busqueda/" class="km-nav-link hidden-sm hidden-md hidden-lg">BUSCAR CUIDADOR</a></li>
							<li><a href="km-cuidador.html" class="km-btn-primary hidden-sm hidden-md hidden-lg" >QUIERO SER CUIDADOR</a></li>
						</ul>
					</div>
				</div>
			</nav>
		';

		// $HTML .= "
		// 	<div id='modal_login' class='modal_login'>
		//         <div class='modal_container'>
		//             <div class='modal_box'>
		//                 <img id='close_login' src='".getTema()."/images/closebl.png' />

		// 				<form id='form_login'>
		//                 	<div class='form_box'>
		// 	                	<input type='text' id='usuario' placeholder='Correo El&eacute;ctronico'>
		// 	                	<input type='password' id='clave' placeholder='Contraseña'>
		//                 	</div>
		//                 	<div class='botones_box'>
		//                 		<input type='submit' value='Ingresar' style='display: none;'>
		//                 		<span id='login_submit'>Ingresar</span>
		//                 	</div>
		//                 </form>

		// 				<form id='form_recuperar'>
		//                 	<div class='form_box'>
		// 	                	<input type='text' id='usuario' placeholder='Correo El&eacute;ctronico'>
		//                 	</div>
		//                 	<div class='botones_box'>
		//                 		<span id='login_submit'>Recuperar</span>
		//                 	</div>
		//                 </form>

		//             </div>
		//         </div>
		//     </div>
		// ";
		include_once('partes/modal_login.php');
	}else{
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		$avatar = kmimos_get_foto($user_id);
		$HTML .= '
		<script> var AVATAR = "'.$avatar.'"; </script>
		<nav class="navbar navbar-fixed-top bg-transparent nav-sesion">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<img class="km-avatar" src="'.$avatar.'" width="40">
					</button>
					<a class="navbar-brand" href="#"><img src="'.$avatar.'" height="60" style="height: 60px;"></a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown hidden-xs">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="padding: 0px;"><img src="'.$avatar.'" style="width: 45px;"></a>
							<ul class="dropdown-menu">
								<li><a href="#" style="padding: 19px 15px 15px;">MI PERFIL</a></li>
								<li><a href="#" style="padding: 19px 15px 15px;">MIS MASCOTAS</a></li>
								<li><a href="#" style="padding: 19px 15px 15px;">HISTORIAL</a></li>
								<li><a href="#" style="padding: 19px 15px 15px;">MIS SOLICITUDES</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="'.wp_logout_url( "/" ).'" style="padding: 19px 15px 15px;">CERRAR SESIÓN</a></li>
							</ul>
						</li>
						<li><a href="#" class="km-nav-link hidden-sm hidden-md hidden-lg" style="padding: 19px 15px 15px; color: white;">MI PERFIL</a></li>
						<li><a href="#" class="km-nav-link hidden-sm hidden-md hidden-lg" style="padding: 19px 15px 15px; color: white;">MIS MASCOTAS</a></li>
						<li><a href="#" class="km-nav-link hidden-sm hidden-md hidden-lg" style="padding: 19px 15px 15px; color: white;">HISTORIAL</a></li>
						<li><a href="#" class="km-nav-link hidden-sm hidden-md hidden-lg" style="padding: 19px 15px 15px; color: white;">MIS SOLICITUDES</a></li>
						<li><a href="http://kmimos-web.bitballoon.com/" class="km-nav-link hidden-sm hidden-md hidden-lg" style="padding: 19px 15px 15px; color: white;">CERRAR SESIÓN</a></li>
					</ul>
				</div>
			</div>
		</nav>
		';
	}
	include_once('partes/modal_register.php');
	echo comprimir_styles($HTML);
/*
	global $wpdb;
	$sql = "SELECT * FROM cuidadores";
	$cuidadores = $wpdb->get_results($sql);

	foreach ($cuidadores as $cuidador) {
		$adicionales = unserialize($cuidador->adicionales);
		$new_adicionales = array();
		foreach ($adicionales as $key => $servicio) {
			if( is_array($servicio) ){
				$total = 0;
				foreach ($servicio as $key2 => $valor) {
					$total += $valor;
				}
				if( $total > 0 && $key != "" ){
					$new_adicionales[ $key ] = $servicio;
				}
			}else{
				if( $servicio > 0 ){
					$new_adicionales[ $key ] = $servicio;
				}
			}
		}
		$sql = "UPDATE cuidadores SET adicionales = '".serialize($new_adicionales)."' WHERE user_id = ".$cuidador->user_id.";";
		$wpdb->query($sql);
	}*/