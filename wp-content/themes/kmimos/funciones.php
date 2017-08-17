<?php
	function get_menu(){
		$defaults = array(
		    'theme_location'  => 'pointfinder-main-menu',
		    'menu'            => '',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => '',
		    'menu_id'         => '',
		    'echo'            => false,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '%3$s',
		    'depth'           => 0
		);
		return wp_nav_menu( $defaults );
	}

	function getBusqueda(){
		if( !isset($_SESSION) ){ session_start(); }
		$busqueda = array();
		if( isset($_SESSION["busqueda"]) ){
			$busqueda = unserialize($_SESSION["busqueda"]);
		}
		return $busqueda;
	}

	function get_servicio_cuidador($slug){
		switch ($slug) {
			case 'hospedaje':
				return '
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>HOSPEDAJE<br>DÍA Y NOCHE</div>
					</div>';
			break;
			case 'guarderia':
				return '
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>GUARDERÍA<br>DÍA</div>
					</div>';
			break;
			case 'paseos':
				return '
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>PASEOS</div>
					</div>';
			break;
			case 'adiestramiento-basico':
				return '
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>ENTRENAMIENTO<br>B&Aacute;SICO</div>
					</div>';
			break;
			case 'adiestramiento-intermedio':
				return '
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>ENTRENAMIENTO<br>INTERMEDIO</div>
					</div>';
			break;
			case 'adiestramiento-avanzado':
				return '
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>ENTRENAMIENTO<br>AVANZADO</div>
					</div>';
			break;
		}
	}

	function get_tamano($slug, $precio, $activo, $tamanos){

		$tamano = "";
		preg_match_all("#Peque#", $slug, $matches);
		if( count( $matches[0] ) == 1 ){
			$tamano = "pequenos";
		}
		
		preg_match_all("#Medi#", $slug, $matches);
		if( count( $matches[0] ) == 1 ){
			$tamano = "medianos";
		}
		
		preg_match_all("#Grand#", $slug, $matches);
		if( count( $matches[0] ) == 1 ){
			$tamano = "grandes";
		}

		preg_match_all("#Gigan#", $slug, $matches);
		if( count( $matches[0] ) == 1 ){
			$tamano = "gigantes";
		}

		if( is_array($tamanos) ){
			if( $activo && in_array($tamano, $tamanos) ){
				$class = "km-servicio-opcionactivo";
			}
		}

		switch ( $tamano ) {
			case 'pequenos':
				return '
				<div class="km-servicio-opcion '.$class.'">
					<div class="km-servicio-desc">
						<img src="'.getTema().'/images/new/icon/icon-pequenio.svg">
						<div class="km-opcion-text"><b>PEQUEÑO</b><br>0 a 25 cm</div>
					</div>
					<div class="km-servicio-costo"><b>'.$precio.'</b></div>
				</div>';
			break;
			case 'medianos':
				return '
				<div class="km-servicio-opcion '.$class.'">
					<div class="km-servicio-desc">
						<img src="'.getTema().'/images/new/icon/icon-mediano.svg">
						<div class="km-opcion-text"><b>MEDIANO</b><br>25 a 28 cm</div>
					</div>
					<div class="km-servicio-costo"><b>'.$precio.'</b></div>
				</div>';
			break;
			case 'grandes':
				return '
				<div class="km-servicio-opcion '.$class.'">
					<div class="km-servicio-desc">
						<img src="'.getTema().'/images/new/icon/icon-grande.svg">
						<div class="km-opcion-text"><b>GRANDE</b><br>58 a 73 cm</div>
					</div>
					<div class="km-servicio-costo"><b>'.$precio.'</b></div>
				</div>';
			break;
			case 'gigantes':
				return '
				<div class="km-servicio-opcion '.$class.'">
					<div class="km-servicio-desc">
						<img src="'.getTema().'/images/new/icon/icon-gigante.svg">
						<div class="km-opcion-text"><b>GIGANTE</b><br>73 a 200 cm</div>
					</div>
					<div class="km-servicio-costo"><b>'.$precio.'</b></div>
				</div>';
			break;
		}
	}
?>