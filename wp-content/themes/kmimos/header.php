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
		}else{
			//$HTML .= '<meta name="description" content="'.bloginfo('description').'">';
		}
	}else{
		//$HTML .= '<meta name="description" content="'.bloginfo('description').'">';
	}
	$HTML .= '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';

	wp_enqueue_style( 'style', getTema()."/style.css", array(), "1.0.0" );

	wp_enqueue_style( 'generales_css', getTema()."/css/generales.css", array(), "1.0.0" );
	wp_enqueue_style( 'jquery.bxslider', getTema()."/css/jquery.bxslider.css", array(), "1.0.0" );
	wp_enqueue_style( 'bootstrap.min', getTema()."/css/bootstrap.min.css", array(), "1.0.0" );
	wp_enqueue_style( 'datepicker.min', getTema()."/css/datepicker.min.css", array(), "1.0.0" );
	wp_enqueue_style( 'kmimos_style', getTema()."/css/kmimos_style.css", array(), "1.0.0" );

	/*
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	*/
	wp_enqueue_style( 'select2.min', getTema()."/css/select2.min.css", array(), "1.0.0" );


	wp_head(); 


	$HTML .= '
		<script type="text/javascript"> 
			var HOME = "'.getTema().'/"; 
			var RAIZ = "'.get_home_url().'/"; 
		</script>

	</head>
	<body class="'.join( ' ', get_body_class( $class ) ).'" >';

	include_once("funciones.php");

	$MENU = get_menu_header();

	if( !isset($MENU["head"]) ){
		$menus_normal = '
			<li><a id="login" style="padding-right: 15px">INICIAR SESIÓN</a></li>
			<li><a href="#" style="padding-left: 15px; border-left: 1px solid white;">REGÍSTRATE</a></li>
		';
		$menus_movil = '
			<li><a id="login_movil" class="km-nav-link hidden-sm hidden-md hidden-lg">INICIAR SESIÓN</a></li>
			<li><a href="#" class="km-nav-link hidden-sm hidden-md hidden-lg">REGÍSTRATE</a></li>
		';
	}else{
		$menus_normal = $MENU["head"].$MENU["body"].$MENU["footer"];
		$menus_movil = $MENU["head_movil"].$MENU["body"].$MENU["footer"];
	}

	if( is_front_page() ){
		$HTML .= '
			<nav class="navbar navbar-fixed-top bg-transparent">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<img src="'.getTema().'/images/new/km-navbar-mobile.svg" width="30">
						</button>
						<a class="navbar-brand" href="'.get_home_url().'"><img src="'.getTema().'/images/new/km-logos/km-logo.png" height="60"></a>
					</div>
					<ul class="hidden-xs nav-login">
						'.$menus_normal.'
					</ul>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="'.get_home_url().'/busqueda/" class="km-nav-link">BUSCAR CUIDADOR</a></li>
							<li><a href="km-cuidador.html" class="km-btn-primary hidden-xs">QUIERO SER CUIDADOR</a></li>

							'.$menus_movil.'

							<li><a href="'.get_home_url().'/busqueda/" class="km-nav-link hidden-sm hidden-md hidden-lg">BUSCAR CUIDADOR</a></li>
							<li><a href="km-cuidador.html" class="km-btn-primary hidden-sm hidden-md hidden-lg">QUIERO SER CUIDADOR</a></li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="km-video">
				<div class="container-fluid">
					<div class="row">
						<div class="km-video-bg">
							<div class="overlay"></div>
							<video loop muted autoplay poster="'.getTema().'/images/new/km-hero-desktop.jpg" class="km-video-bgscreen">
								<source src="'.getTema().'/images/new/videos/km-home/km-video.webm" type="video/webm">
								<source src="'.getTema().'/images/new/videos/km-home/km-video.mp4" type="video/mp4">
								<source src="'.getTema().'/images/new/videos/km-home/km-video.ogv" type="video/ogg">
							</video>
						</div>
					</div>
				</div>
			</div>
		';
	}else{
		$HTML .= '
			<nav class="navbar navbar-fixed-top bg-transparent">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<img src="'.getTema().'/images/new/km-navbar-mobile.svg" width="30">
					</button>
					<a class="navbar-brand" href="'.get_home_url().'"><img src="'.getTema().'/images/new/km-logos/km-logo.png" height="60"></a>
				</div>
				<ul class="hidden-xs nav-login">
					'.$menus_normal.'
				</ul>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="'.get_home_url().'/busqueda/" class="km-nav-link">BUSCAR CUIDADOR</a></li>
						<li><a href="km-cuidador.html" class="km-btn-primary hidden-xs">QUIERO SER CUIDADOR</a></li>
						
						'.$menus_movil.'

						<li><a href="km-cuidador.html" class="km-btn-primary hidden-sm hidden-md hidden-lg">QUIERO SER CUIDADOR</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- FIN SECCIÓN MENU -->

		<!-- HEADER SEARCH -->
		<div class="header-search" style="background-image:url('.getTema().'/images/new/km-fondo-buscador.gif);">
			<div class="overlay"></div>
		</div>
		<!-- END HEADER SEARCH -->

		<div class="container contentenedor-buscador-todos">
			<div class="km-contentido-formulario-buscador">
				<form class="km-formulario-buscador" action="'.getTema().'/procesos/busqueda/buscar.php" method="post">
					<div class="km-bloque-cajas">
						<div class="km-div-ubicacion">
							<select class="km-select-custom km-select-ubicacion" name="">
								<option>UBICACIÓN, ESTADO, MUNICIPIO</option>
								<option>UBICACIÓN, A</option>
								<option>UBICACIÓN, B</option>
							</select>
						</div>
						<div class="km-div-fechas">
							<input type="text" name="" placeholder="DESDE" value="" class="km-input-custom km-input-date date_from" readonly>
							<input type="text" name="" placeholder="HASTA" value="" class="km-input-custom km-input-date date_to" readonly>
						</div>
						<div class="km-div-enviar">
							<button type="submit" class="km-submit-custom" name="button">
								BUSCAR
							</button>
						</div>
					</div>

					<div class="km-div-filtro">
						<div class="km-titulo-filtro">
							FILTRAR BÚSQUEDA
						</div>
						<div class="km-cajas-filtro">
							<div class="km-caja-filtro">
								<select class="km-select-custom" name="">
									<option>TIPO DE SERVICIO</option>
									<option>TIPO A</option>
									<option>TIPO B</option>
								</select>
							</div>

							<div class="km-caja-filtro">
								<select class="km-select-custom" name="">
									<option>TAMAÑO DE MASCOTA</option>
									<option>TAMAÑO A</option>
									<option>TAMAÑO B</option>
								</select>
							</div>

							<div class="km-caja-filtro">
								<select class="km-select-custom" name="">
									<option>SERVICIOS ADICIONALES</option>
									<option>SERVICIO A</option>
									<option>SERVICIO B</option>
								</select>
							</div>

							<div class="km-caja-filtro">
								<input type="text" name="nombre" value="" placeholder="BUSCAR POR NOMBRE" class="km-input-custom">
							</div>
						</div>
					</div>
				</form>
			</div>
		';
	}
	

	if( !is_user_logged_in() ){
		$HTML .= "
			<div class='modal_login'>
		        <div class='modal_container'>
		            <div class='modal_box'>
		                <img id='close_login' src='".getTema()."/images/closebl.png' />

						<form id='form_login'>
		                	<div class='form_box'>
			                	<input type='text' id='usuario' placeholder='Correo El&eacute;ctronico'>
			                	<input type='password' id='clave' placeholder='Contraseña'>
		                	</div>
		                	<div class='botones_box'>
		                		<input type='submit' value='Ingresar' style='display: none;'>
		                		<span id='login_submit'>Ingresar</span>
		                	</div>
		                </form>

						<form id='form_recuperar'>
		                	<div class='form_box'>
			                	<input type='text' id='usuario' placeholder='Correo El&eacute;ctronico'>
		                	</div>
		                	<div class='botones_box'>
		                		<span id='login_submit'>Recuperar</span>
		                	</div>
		                </form>

		            </div>
		        </div>
		    </div>
		";
	}

	echo comprimir_styles($HTML);