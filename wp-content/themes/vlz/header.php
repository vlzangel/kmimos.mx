<!doctype html>
<html>
	<head>
		<title>Inicio - Kmimos</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<meta charset="<?php bloginfo('charset'); ?>">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel='stylesheet' id='open-sans-css'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=4.4.7' media='all' />
		<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<meta http-equiv="Expires" content="0" />
		<meta http-equiv="Pragma" content="no-cache" />

		<?php wp_head(); ?>
	</head>
	<body>

		<?php 
			get_template_part( 'recursos/vlz', 'styles' ); 
			get_template_part( 'recursos/vlz', 'jss' ); 
			global $wpdb;
		?>
	
        <header>
        	
			<nav id="site-navigation-user">
				<div class="contenedor_menu_externo">
					<div class="contenedor_menu">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'main-users',
								'menu_class'     => 'secundary-menu',
							 ) );
						?>
					</div>
				</div>
			</nav>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<a class="contenedor_logo" href="<?php echo get_home_url(); ?>" style="background-image: url(<?php echo get_template_directory_uri()."/recursos/imgs/logo-kmimos.png"; ?>);"></a>
				<div class="contenedor_menu">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'main-menu',
							'menu_class'     => 'primary-menu',
						 ) );
					?>
				</div>
			</nav>

        </header>
