<?php 
    /*
        Template Name: Perfil
    */

    wp_enqueue_style('perfil', getTema()."/css/perfil.css", array(), '1.0.0');
	wp_enqueue_style('perfil_responsive', getTema()."/css/responsive/perfil_responsive.css", array(), '1.0.0');

	$btn_txt = "Actualizar";
	$mostrar_btn = true;
	switch ( $post->post_name ) {
		case 'perfil-usuario':
			wp_enqueue_script('perfil', getTema()."/js/perfil.js", array("jquery", "global_js"), '1.0.0');
		break;
		case 'mascotas':
		    wp_enqueue_style('mascotas', getTema()."/css/mascotas.css", array(), '1.0.0');
			wp_enqueue_style('mascotas_responsive', getTema()."/css/responsive/mascotas_responsive.css", array(), '1.0.0');
			wp_enqueue_script('mascotas', getTema()."/js/mascotas.js", array("jquery", "global_js"), '1.0.0');

			$btn_txt = "Nueva Mascota";
		break;
		case 'ver':
			$padre = $wpdb->get_var("SELECT post_name FROM wp_posts WHERE ID = {$post->post_parent}");
			switch ($padre) {
				case 'historial':
					$mostrar_btn = false;
					wp_enqueue_style('ver_historial', getTema()."/css/ver_historial.css", array(), '1.0.0');
				break;
				case 'mascotas':
					wp_enqueue_style('ver_mascotas', getTema()."/css/ver_mascotas.css", array(), '1.0.0');
					wp_enqueue_style('ver_mascotas_responsive', getTema()."/css/responsive/ver_mascotas_responsive.css", array(), '1.0.0');
					wp_enqueue_script('ver_mascotas', getTema()."/js/ver_mascotas.js", array("jquery", "global_js"), '1.0.0');
				break;
			}
		break;
		case 'nueva':
		    wp_enqueue_style('nueva_mascotas', getTema()."/css/nueva_mascotas.css", array(), '1.0.0');
			wp_enqueue_style('nueva_mascotas_responsive', getTema()."/css/responsive/nueva_mascotas_responsive.css", array(), '1.0.0');
			wp_enqueue_script('nueva_mascotas', getTema()."/js/nueva_mascotas.js", array("jquery", "global_js"), '1.0.0');
			$btn_txt = "Crear Mascota";
		break;
		case 'favoritos':
		    wp_enqueue_style('favoritos', getTema()."/css/favoritos.css", array(), '1.0.0');
			wp_enqueue_style('favoritos_responsive', getTema()."/css/responsive/favoritos_responsive.css", array(), '1.0.0');
			wp_enqueue_script('favoritos', getTema()."/js/favoritos.js", array("jquery", "global_js"), '1.0.0');
		break;
		case 'historial':
		    wp_enqueue_style('historial', getTema()."/css/historial.css", array(), '1.0.0');
			wp_enqueue_style('historial_responsive', getTema()."/css/responsive/historial_responsive.css", array(), '1.0.0');
			wp_enqueue_script('historial', getTema()."/js/historial.js", array("jquery", "global_js"), '1.0.0');
		break;
	}

	get_header();

		global $post;
		global $wpdb;

		$MENU = get_menu_header();

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		$img_perfil = kmimos_get_foto($user_id, true);
		$avatar = $img_perfil["img"];

		echo '<script> var URL_PROCESOS_PERFIL = "'.getTema().'/procesos/perfil/"; </script>';

		switch ( $post->post_name ) {
			case 'perfil-usuario':
				include("admin/frontend/perfil.php");
			break;
			case 'mascotas':
				echo '
					<script> 
						var URL_NUEVA_IMG = "'.get_home_url().'/perfil-usuario/mascotas/nueva/";
						var IMG_DEFAULT = "'.get_home_url().'/wp-content/themes/pointfinder/images/noimg.png";
					</script>';
				include("admin/frontend/mascotas.php");
			break;
			case 'ver':
				$padre = $wpdb->get_var("SELECT post_name FROM wp_posts WHERE ID = {$post->post_parent}");
				switch ($padre) {
					case 'historial':
						$mostrar_btn = false;
						include("admin/frontend/ver_historial.php");
					break;
					case 'mascotas':
						include("admin/frontend/ver_mascotas.php");
					break;
				}
			break;
			case 'nueva':
				echo '<script> var IMG_DEFAULT = "'.get_home_url().'/wp-content/themes/pointfinder/images/noimg.png"; </script>';
				include("admin/frontend/nueva_mascotas.php");
			break;
			case 'favoritos':
				$mostrar_btn = false;
				include("admin/frontend/favoritos.php");
			break;
			case 'historial':
				$mostrar_btn = false;
				include("admin/frontend/historial.php");
			break;
		}

		$HTML_BTN = '';
		if( $mostrar_btn ){
			$HTML_BTN = '
			<div class="container_btn">
				<input type="submit" id="btn_actualizar" value="'.$btn_txt.'">
				<div class="perfil_cargando" style="background-image: url('.getTema().'/images/cargando.gif);" ></div>
			</div>';
		}

		$HTML = '
			<script> var RUTA_IMGS = "'.get_home_url().'/imgs"; </script>
			<div class="body">
				<div class="menu_perfil">
					<div class="vlz_img_portada">
						<div class="vlz_img_portada_fondo" style="background-image: url('.$avatar.'); filter:blur(2px);" ></div>
						<div class="vlz_img_portada_normal" style="background-image: url('.$avatar.');"></div>
					</div>
					<ul>
						'.$MENU["body"].'
					</ul>
					<!-- Page: '.$post->post_name.' -->
				</div>
				<div class="main">
					<form id="form_perfil" autocomplete="off">
						'.$CONTENIDO.'
						'.$HTML_BTN.'
					</form>
				</div>
	    	</div>
		';

		echo comprimir_styles($HTML);

	get_footer();
?>