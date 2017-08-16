<?php

    wp_enqueue_style('perfil_cuidador', getTema()."/css/perfil_cuidador.css", array(), '1.0.0');
	wp_enqueue_style('perfil_cuidador_responsive', getTema()."/css/responsive/perfil_cuidador_responsive.css", array(), '1.0.0');

	wp_enqueue_script('perfil_cuidadores', getTema()."/js/perfil_cuidadores.js", array("jquery"), '1.0.0');

	get_header();

	$post_id = get_the_id();
	$meta = get_post_meta( $post_id );

	global $wpdb;
	global $post;

	$cuidador = $wpdb->get_row("SELECT * FROM cuidadores WHERE id_post = ".$post->ID);
	$descripcion = $wpdb->get_var("SELECT meta_value FROM wp_usermeta WHERE user_id = {$cuidador->user_id} AND meta_key = 'description'");

	$slug = $wpdb->get_var("SELECT post_name FROM wp_posts WHERE post_type = 'product' AND post_author = '{$cuidador->user_id}' AND post_name LIKE '%hospedaje%' ");

	$latitud 	= $cuidador->latitud;
	$longitud 	= $cuidador->longitud;

	$HTML = '
		<script>
			var lat = '.$latitud.';
			var lng = '.$longitud.';
		</script>
	';

	echo comprimir_styles($HTML);

	$foto = kmimos_get_foto($cuidador->user_id);

	$tama_aceptados = unserialize( $cuidador->tamanos_aceptados );
	$tamanos = array(
		'pequenos' => 'Pequeños',
		'medianos' => 'Medianos',
		'grandes'  => 'Grandes',
		'gigantes' => 'Gigantes'
	);

	$aceptados = array();
	foreach ($tama_aceptados as $key => $value) {
		if( $value == 1){
			$aceptados[] = $tamanos[$key];
		}
	} 

	$edad_aceptada = unserialize( $cuidador->edades_aceptadas );
	$edades = array(
		'cachorros' => 'Cachorros',
		'adultos' => 'Adultos'
	);
	$edades_aceptadas = array();
	foreach ($edad_aceptada as $key => $value) {
		if( $value == 1){
			$edades_aceptadas[] = $edades[$key];
		}
	} 

	$atributos = unserialize( $cuidador->atributos );

	$anios_exp = $cuidador->experiencia;
	if( $anios_exp > 1900 ){
		$anios_exp = date("Y")-$anios_exp;
	}

	$mascota_cuidador = unserialize( $cuidador->mascotas_cuidador );
	$mascotas_cuidador = array();
	foreach ($mascota_cuidador as $key => $value) {
		if( $value == 1){
			$mascotas_cuidador[] = $tamanos[$key];
		}
	}

	$housings = array(
		'1' => 'Casa',
		'2' => 'Departamento'
	);

	$acepto = ""; $t = count($aceptados);
	if( $t > 0 && $t < 4 ){
		$acepto .= implode(', ',$aceptados);
	}else{
		if( $t == 0 ){
			$acepto = "Ninguno";
		}else{
			$acepto = "Todos";
		}
	}
	$num_masc = "";
	if($cuidador->num_mascotas+0 > 0){ 
		if( count($mascotas_cuidador) > 0 ){
			$tams = '<br>('.implode(', ',$mascotas_cuidador).')';
		}else{
			$tams = "";
		} 
		if( $cuidador->num_mascotas > 1 ){
			$num_masc = $cuidador->num_mascotas.' Perro '.$tams;
		}else{
			$num_masc = $cuidador->num_mascotas.' Perros '.$tams;
		}
	}else{
		$num_masc = 'No tiene mascotas';
	}
	$num_masc = strtoupper($num_masc);

	$patio = ( $atributos['yard'] == 1 ) ? 'TIENE PATIO' : 'NO TIENE PATIO';
	$areas = ( $atributos['green'] == 1 ) ? 'TIENE ÁREAS VERDES' : 'NO TIENE ÁREAS VERDES';

	if( $cuidador->mascotas_permitidas > 1 ){
		$cuidador->mascotas_permitidas .= ' PERROS';
	}else{
		$cuidador->mascotas_permitidas .= ' PERRO';
	}

	/* Galeria */
	$id_cuidador = ($cuidador->id)-5000;
	$path_galeria = "wp-content/uploads/cuidadores/galerias/miniatura/".$id_cuidador."/";

	if( is_dir($path_galeria) ){

		if ($dh = opendir($path_galeria)) { 
			$imagenes = array();
	        while (($file = readdir($dh)) !== false) { 
	            if (!is_dir($path_galeria.$file) && $file!="." && $file!=".."){ 
	               $imagenes[] = $path_galeria.$file;
	            } 
	        } 
	      	closedir($dh);

	      	$cant_imgs = count($imagenes);
	      	if( $cant_imgs > 0 ){
	      		$items = array(); $home = get_home_url()."/";
	      		foreach ($imagenes as $value) {
	      			$items[] = "
	      				<div class='slide' data-scale='small' data-position='top' onclick=\"vlz_galeria_ver('".$home.$value."')\">
	      					<div class='vlz_item_fondo' style='background-image: url(".$home.$value."); filter:blur(2px);'></div>
	      					<div class='vlz_item_imagen' style='background-image: url(".$home.$value.");'></div>
	      				</div>
	      			";
	      		}
	      		/*echo "<pre>";
	      			print_r($items);
	      		echo "</pre>";*/
	      		$galeria = '
	      			<p class="km-tit-ficha">MIRA MIS FOTOS Y CONÓCEME</p>
						<div class="km-galeria-cuidador">
							<div class="km-galeria-cuidador-slider">
								'.implode("", $items).'
							</div>
						</div>
	      		'.

	      		"
	      			<div class='vlz_modal_galeria' onclick='vlz_galeria_cerrar()'>
	      				<div class='vlz_modal_galeria_interna'></div>
	      			</div>
	      		";
	      	}else{
	      		$galeria = "";
	      	}
  		} 
	}

	$busqueda = getBusqueda();

	// echo "<pre>";
	// 	print_r($busqueda);
	// echo "</pre>";

	$servicios = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_author = {$cuidador->user_id} AND post_type = 'product' AND post_status = 'publish' ");
	$productos = '<div class="row">';
	foreach ($servicios as $servicio) {
		$tipo = $wpdb->get_var("
            SELECT
                tipo_servicio.slug AS slug
            FROM 
                wp_term_relationships AS relacion
            LEFT JOIN wp_terms as tipo_servicio ON ( tipo_servicio.term_id = relacion.term_taxonomy_id )
            WHERE 
                relacion.object_id = '{$servicio->ID}' AND
                relacion.term_taxonomy_id != 28
        ");

        $titulo = get_servicio_cuidador($tipo);

        $tamanos = '';

        $tamanos_servicio = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_parent = '{$servicio->ID}' AND post_type = 'bookable_person' AND post_status = 'publish' ");
        foreach ($tamanos_servicio as $tamano ) {
        	$activo = false;
        	if( in_array($tipo, $busqueda["servicios"]) ){
        		$activo = true;
        	}
        	preg_match_all("#adiestramiento#", $tipo, $matches);

        	if( in_array("adiestramiento", $busqueda["servicios"]) && count( $matches ) > 0 ){
        		$activo = true;
        	}
        	$tamanos .= get_tamano($tamano->post_title, "$40.00", $activo, $busqueda["tamanos"]);
        }
		$productos .= '
		<div class="col-xs-12 col-md-6">
			<div class="km-ficha-servicio">
				'.$titulo.'
				<p>SELECCIÓN SEGÚN TAMAÑO</p>
				'.$tamanos.'
			</div>
		</div>';
	}

	$productos .= '</div>';

	/*

	$productos = '
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="km-ficha-servicio">
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>HOSPEDAJE<br>DÍA Y NOCHE</div>
					</div>
					<p>SELECCIÓN SEGÚN TAMAÑO</p>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-pequenio.svg">
							<div class="km-opcion-text"><b>PEQUEÑO</b><br>0 a 25 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-mediano.svg">
							<div class="km-opcion-text"><b>MEDIANO</b><br>25 a 28 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-grande.svg">
							<div class="km-opcion-text"><b>GRANDE</b><br>58 a 73 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-gigante.svg">
							<div class="km-opcion-text"><b>GIGANTE</b><br>73 a 200 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="km-ficha-servicio">
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>GUARDERÍA<br>DÍA</div>
					</div>
					<p>SELECCIÓN SEGÚN TAMAÑO</p>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-pequenio.svg">
							<div class="km-opcion-text"><b>PEQUEÑO</b><br>0 a 25 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-mediano.svg">
							<div class="km-opcion-text"><b>MEDIANO</b><br>25 a 28 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-grande.svg">
							<div class="km-opcion-text"><b>GRANDE</b><br>58 a 73 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-gigante.svg">
							<div class="km-opcion-text"><b>GIGANTE</b><br>73 a 200 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="km-ficha-servicio">
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>PASEOS</div>
					</div>
					<p>SELECCIÓN SEGÚN TAMAÑO</p>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-pequenio.svg">
							<div class="km-opcion-text"><b>PEQUEÑO</b><br>0 a 25 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-mediano.svg">
							<div class="km-opcion-text"><b>MEDIANO</b><br>25 a 28 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-grande.svg">
							<div class="km-opcion-text"><b>GRANDE</b><br>58 a 73 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-gigante.svg">
							<div class="km-opcion-text"><b>GIGANTE</b><br>73 a 200 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="km-ficha-servicio">
					<div class="servicio-tit">
						<img src="'.getTema().'/images/new/icon/km-servicios/icon-hospedaje.svg">
						<div>ENTRENAMIENTO</div>
					</div>
					<p>SELECCIÓN SEGÚN TAMAÑO</p>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-pequenio.svg">
							<div class="km-opcion-text"><b>PEQUEÑO</b><br>0 a 25 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-mediano.svg">
							<div class="km-opcion-text"><b>MEDIANO</b><br>25 a 28 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-grande.svg">
							<div class="km-opcion-text"><b>GRANDE</b><br>58 a 73 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
					<div class="km-servicio-opcion km-servicio-opcionactivo">
						<div class="km-servicio-desc">
							<img src="'.getTema().'/images/new/icon/icon-gigante.svg">
							<div class="km-opcion-text"><b>GIGANTE</b><br>73 a 200 cm</div>
						</div>
						<div class="km-servicio-costo"><b>$40.00</b></div>
					</div>
				</div>
			</div>
		</div>
	';

	*/

 	$HTML .= '
 		<div class="km-ficha-bg" style="background-image:url('.getTema().'/images/new/km-ficha/km-bg-ficha.jpg);">
			<div class="overlay"></div>
		</div>
		'.$cuidador->num_mascotas.'
		<div class="km-ficha-info-cuidador">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-3">
						<div class="km-ficha-cuidador" style="background-image: url('.$foto.');"></div>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="km-tit-cuidador">'.strtoupper( get_the_title() ).'</div>
						<div class="km-ficha-icon">
							<div class="km-ranking">
								'.kmimos_petsitter_rating($cuidador->id_post).'
							</div>
							<a class="km-link-comentarios" href="#km-comentario">VER COMENTARIOS</a>
						</div>
					</div>
					<div class="km-costo hidden-xs">
						<p>SERVICIOS DESDE</p>
						<div class="km-tit-costo">MXN $'.($cuidador->hospedaje_desde*1.2).'</div>
						<div class="km-ficha-fechas">
							<input type="text" id="checkin" name="checkin" placeholder="DESDE" value="'.$busqueda["checkin"].'" class="km-input-custom km-input-date date_from" readonly>
							<input type="text" id="checkout" name="checkout" placeholder="HASTA" value="'.$busqueda["checkout"].'" class="km-input-custom km-input-date date_to" readonly>
						</div>
						<a href="#" class="km-btn-secondary">RESERVAR</a>
					</div>
				</div>
			</div>
		</div>

		<div class="km-ficha-info">
			<div class="container">
					<div class="col-xs-12 col-sm-3 hidden-xs">
						<p class="km-tit-ficha">DATOS DEL CUIDADOR</p>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-experiencia-morado.svg">
							<div class="km-desc-ficha">
								<p>EXPERIENCIA</p>
								<p>'.$anios_exp.' AÑO(S)</p>
							</div>
						</div>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
							<div class="km-desc-ficha">
								<p>TIPO DE PROPIEDAD</p>
								<p>'.$housings[ $atributos['propiedad'] ].'</p>
							</div>
						</div>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
							<div class="km-desc-ficha">
								<p>TAMAÑOS ACEPTADOS</p>
								<p>'.$acepto.'</p>
							</div>
						</div>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-edades.svg">
							<div class="km-desc-ficha">
								<p>EDADES ACEPTADAS</p>
								<p>'.implode(', ',$edades_aceptadas).'</p>
							</div>
						</div>
						<p class="km-tit-ficha">DATOS DE PROPIEDAD</p>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-mascotas.svg">
							<div class="km-desc-ficha">
								<p>MASCOTAS EN CASA</p>
								<p>'.$num_masc.'</p>
							</div>
						</div>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
							<div class="km-desc-ficha">
								<p>DETALLES DE PROPIEDAD</p>
								<p>'.$patio.'</p>
							</div>
						</div>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
							<div class="km-desc-ficha">
								<p>DETALLES DE PROPIEDAD</p>
								<p>'.$areas.'</p>
							</div>
						</div>
						<div class="km-desc-ficha-text">
							<img src="'.getTema().'/images/new/icon/icon-mascotas.svg">
							<div class="km-desc-ficha">
								<p>CANTIDAD MÁX. ACEPTADA</p>
								<p>'.$cuidador->mascotas_permitidas.'</p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="km-ficha-datos hidden-sm hidden-md hidden-lg">
							<div class="tabbable">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab1" data-toggle="tab">DATOS DEL <br>CUIDADOR</a></li>
									<li><a href="#tab2" data-toggle="tab">DATOS DE <br>PROPIEDAD</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab1">
										
										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-experiencia-morado.svg">
											<div class="km-desc-ficha">
												<p>EXPERIENCIA</p>
												<p>'.$anios_exp.' AÑO(S)</p>
											</div>
										</div>
										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
											<div class="km-desc-ficha">
												<p>TIPO DE PROPIEDAD</p>
												<p>'.$housings[ $atributos['propiedad'] ].'</p>
											</div>
										</div>
										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
											<div class="km-desc-ficha">
												<p>TAMAÑOS ACEPTADOS</p>
												<p>'.$acepto.'</p>
											</div>
										</div>
										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-edades.svg">
											<div class="km-desc-ficha">
												<p>EDADES ACEPTADAS</p>
												<p>'.implode(', ',$edades_aceptadas).'</p>
											</div>
										</div>

									</div>
									<div class="tab-pane" id="tab2">

										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-mascotas.svg">
											<div class="km-desc-ficha">
												<p>MASCOTAS EN CASA</p>
												<p>'.$num_masc.'</p>
											</div>
										</div>
										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
											<div class="km-desc-ficha">
												<p>DETALLES DE PROPIEDAD</p>
												<p>'.$patio.'</p>
											</div>
										</div>
										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-propiedad.svg">
											<div class="km-desc-ficha">
												<p>DETALLES DE PROPIEDAD</p>
												<p>'.$areas.'</p>
											</div>
										</div>
										<div class="km-desc-ficha-text">
											<img src="'.getTema().'/images/new/icon/icon-mascotas.svg">
											<div class="km-desc-ficha">
												<p>CANTIDAD MÁX. ACEPTADA</p>
												<p>'.$cuidador->mascotas_permitidas.'</p>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div class="km-ficha-datos hidden-sm hidden-md hidden-lg">
							<a href="#" class="km-btn-primary show-map-mobile">VER UBICACIÓN EN MAPA</a>
						</div>

						<p style="text-align: justify;">'.$descripcion.'</p>
						
						'.$galeria.'

						<p class="km-tit-ficha">SERVICIOS QUE OFREZCO</p>
						'.$productos.'
					</div>
					<div class="hidden-xs col-sm-3 km-map-content">
						<a href="#" class="km-map-close">Cerrar</a>
						<p class="km-tit-ficha">UBICACIÓN</p>

						<div id="mapa" class="km-ficha-mapa"></div>

					</div>
				</div>
			</div>
		</div>

		<div id="km-comentario" class="km-ficha-info">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-offset-3 col-sm-6">
						<div class="km-review">
							<p class="km-tit-ficha">COMENTARIOS</p>
							<div class="km-calificacion">4</div>
							<div class="km-calificacion-icono">
								<div>iconos</div>
								<p>85% Lo recomienda</p>
							</div>
						</div>
						<a href="#" class="km-btn-comentario">ESCRIBE UN COMENTARIO</a>
						<div class="km-comentario">
							<div class="row">
								<div class="col-xs-2">
									<img class="km-foto-comentario-cuidador" src="images/km-ficha/km-comentarios-cuidadores/km-comentario-cuidador1.jpg">
								</div>
								<div class="col-xs-10">
									<p>Mis niñas muy contentas y súper bien cuidadas. Gaby es encantadora y tiene un tacto especial con los perritos, súper recomendable!.</p>
									<p class="km-tit-ficha">RAÚL RODRÍGUEZ</p>
									<p class="km-fecha-comentario">29 Mayo 2017</p>
								</div>
							</div>
							<div class="row km-review-categoria">
								<div class="col-xs-6 col-md-3">
									<p>CUIDADO</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
								<div class="col-xs-6 col-md-3">
									<p>PUNTUALIDAD</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
								<div class="col-xs-6 col-md-3">
									<p>LIMPIEZA</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
								<div class="col-xs-6 col-md-3">
									<p>CONFIANZA</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="km-comentario">
							<div class="row">
								<div class="col-xs-2">
									<img class="km-foto-comentario-cuidador" src="images/km-ficha/km-comentarios-cuidadores/km-comentario-cuidador2.jpg">
								</div>
								<div class="col-xs-10">
									<p>Mis niñas muy contentas y súper bien cuidadas. Gaby es encantadora y tiene un tacto especial con los perritos, súper recomendable!.</p>
									<p class="km-tit-ficha">RAÚL RODRÍGUEZ</p>
									<p class="km-fecha-comentario">29 Mayo 2017</p>
								</div>
							</div>
							<div class="row km-review-categoria">
								<div class="col-xs-6 col-md-3">
									<p>CUIDADO</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
								<div class="col-xs-6 col-md-3">
									<p>PUNTUALIDAD</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
								<div class="col-xs-6 col-md-3">
									<p>LIMPIEZA</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
								<div class="col-xs-6 col-md-3">
									<p>CONFIANZA</p>
									<div class="km-ranking">
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#" class="active"></a>
										<a href="#"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
 	';

	echo comprimir_styles($HTML);

	get_footer(); 
?>