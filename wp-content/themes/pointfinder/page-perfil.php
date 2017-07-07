<?php 
    /*
        Template Name: Perfil
    */

    wp_enqueue_style('perfil', $home."/wp-content/themes/pointfinder/css/perfil.css", array(), '1.0.0');
	wp_enqueue_style('perfil_responsive', $home."/wp-content/themes/pointfinder/css/responsive/perfil_responsive.css", array(), '1.0.0');

	wp_enqueue_script('perfil', $home."/wp-content/themes/pointfinder/js/perfil.js", array("jquery"), '1.0.0');

	get_header();

		global $post;

		$MENU = get_menu_header();

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		$avatar = kmimos_get_foto($user_id);

		switch ( $post->post_name ) {
			case 'perfil-usuario':
				
			break;
			case 'mascotas':
				
			break;
			case 'favoritos':
				
			break;
			case 'historial':
				
			break;
			case 'mascotas':
				
			break;
			case 'mascotas':
				
			break;
		}

		$HTML = '
			<div class="body">

				<div class="menu_perfil">

					<div class="vlz_img_portada">
						<div class="vlz_img_portada_fondo" style="background-image: url('.$avatar.'); filter:blur(2px);" ></div>
						<div class="vlz_img_portada_normal" style="background-image: url('.$avatar.');"></div>
					</div>

					<ul>
						'.$MENU["body"].'
					</ul>

				</div>

				<div class="main">

					Page: '.$post->post_name.'
					
				</div>
	        	
	    	</div>
		';

		echo comprimir_styles($HTML);

	get_footer();
?>