<?php 
    /*
        Template Name: Busqueda
    */

    wp_enqueue_style('beneficios_kmimos', getTema()."/css/busqueda.css", array(), '1.0.0');
	wp_enqueue_style('beneficios_responsive', getTema()."/css/responsive/busqueda_responsive.css", array(), '1.0.0');

	wp_enqueue_script('buscar_home', getTema()."/js/busqueda.js", array(), '1.0.0');

    get_header();

    if( !isset($_SESSION)){ session_start(); }

	if( isset($_SESSION['busqueda'])){ $_POST = unserialize($_SESSION['busqueda']); }

	$pagina = vlz_get_page();
	$destacados = get_destacados();
	$total  = vlz_num_resultados();
	$paginacion = vlz_get_paginacion($total, $pagina);
	$resultados = $_SESSION['resultado_busqueda'];
	$favoritos = get_favoritos();
	
	$pines = unserialize($_SESSION['pines_array']);
	$pines_v = array();
 	$t = count($pines);
	for($i = 0; $i < $t; $i++){
		$pines[$i]["ser"] = vlz_servicios($pines[$i]["adi"], true);
		$pines[$i]["rating"] = kmimos_petsitter_rating( $pines[$i]["post_id"], true );
		unset($pines[$i]["adi"]);
	}
 	
 	$TIPO_DISEÑO = "list";
	if( $total > 6 ){
		$TIPO_DISEÑO = "grid";
	}

	$CUIDADORES = "";
	if( $total > 0 ){
		for ($i=$paginacion["inicio"]; $i < $paginacion["fin"]; $i++) {
			$cuidador = $resultados[$i];
			$CUIDADORES .= get_ficha_cuidador($cuidador, $i, $favoritos, $TIPO_DISEÑO);
		}
	}else{
		$CUIDADORES .= "<h2 style='padding-right: 20px!important; font-size: 21px; text-align: justify; margin: 10px 0px;'>No tenemos resultados para esta búsqueda, si quieres intentarlo de nuevo pícale <a  style='color: #00b69d; font-weight: 600;' href='".get_home_url()."/'>aquí,</a> o aplica otro filtro de búsqueda.</h2>";
	}

	$xPINES = json_encode($pines);

	$busqueda = unserialize($_SESSION['busqueda']);
	$CAMPOS = json_encode($busqueda);

	if( $destacados != "" ){
		$destacados_str = '
		<div class="km-premium km-search-slider">
			<div style="height: 220px; overflow: hidden;">
				<div class="km-premium-slider">
					'.$destacados.'
				</div>
			</div>
		</div>';
	}

	if( $total > 6 ){
		$CUIDADORES_STR = '
		<div class="km-resultados-grid">
			'.$CUIDADORES.'
		</div>';
	}else{
		$CUIDADORES_STR = '
		<div class="km-resultados-lista">
			'.$CUIDADORES.'
		</div>';
	}
	

    $HTML = '
    	<script>
    		var pines = eval(\''.$xPINES.'\'); 
    	</script>
    	<div class="km-caja-resultados">
				<div class="km-columna-izq">
					
					'.$destacados_str.'

					<div class="km-superior-resultados">
						<span class="km-texto-resultados">
							<b>Resultado de búsqueda</b> '.$total.' cuidadores disponibles
						</span>

						<div class="km-opciones-resultados">
							<!-- 
							<div class="km-vista-resultados">
								<a href="./km-resultado.html" class="view-list active">
									List
								</a>
								<a href="./km-resultado-grid.html" class="view-grid">
									Gris
								</a>
							</div> -->
							<div class="km-orden-resultados">
								<select class="km-select-custom" name="">
									<option>ORDENAR POR RANKING</option>
									<option>ORDEN A</option>
									<option>ORDEN B</option>
								</select>
							</div>
						</div>
					</div>

					'.$CUIDADORES_STR.'

					<div class="navigation">
						<ul>
							'.$paginacion["html"].'
						</ul>
						<div class="message-nav">
							'.($paginacion["inicio"]+1).' - '.$paginacion["fin"].' de '.$total.' Cuidadores Certificados
						</div>
					</div>
				</div>

				<div class="km-columna-der">
					<div class="km-titulo-mapa">
						UBICACIÓN DE RESULTADOS EN MAPA
					</div>
					<div id="mapa" class="km-mapa"></div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="'.getTema().'/js/markerclusterer.js"></script>
		<script type="text/javascript" src="'.getTema().'/js/oms.min.js"></script>
    ';

	echo comprimir_styles($HTML);



    get_footer(); 
?>