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
	$total  = vlz_num_resultados();
	$paginacion = vlz_get_paginacion($total, $pagina);
	$resultados = $_SESSION['resultado_busqueda'];
	$favoritos = get_favoritos();
	
	$pines = unserialize($_SESSION['pines_array']);
	$pines_v = array();

	$CUIDADORES = "";
	if( $total > 0 ){
		for ($i=$paginacion["inicio"]; $i < $paginacion["fin"]; $i++) {
			$cuidador = $resultados[$i];
			$pines_v[] = $pines[$i];
			$CUIDADORES .= get_ficha_cuidador($cuidador, $i, $favoritos);
		}
	}else{
		$CUIDADORES .= "<h2 style='padding-right: 20px!important; font-size: 21px; text-align: justify; margin: 10px 0px;'>No tenemos resultados para esta búsqueda, si quieres intentarlo de nuevo pícale <a  style='color: #00b69d; font-weight: 600;' href='".$home."/#jj-landing-page'>aquí,</a> o aplica otro filtro de búsqueda.</h2>";
	}

	$xPINES = json_encode($pines_v);

	$busqueda = unserialize($_SESSION['busqueda']);
	$CAMPOS = json_encode($busqueda);

    $HTML = '
    	<script>
    		var pines = eval(\''.$xPINES.'\'); 
    	</script>
    	<div class="km-caja-resultados">
				<div class="km-columna-izq">
					<div class="km-premium km-search-slider">
						<div class="km-search-title">
							RESULTADO DE B&Uacute;SQUEDA '.$total.' CUIDADORES DISPONIBLES
						</div>
						<div style="height: 220px; overflow: hidden;">
							<div class="km-premium-slider">
								<div class="slide">
									<div class="item-slide" style="background-image: url('.getTema().'/images/new/km-buscador/slide-01.jpg);">
										<div class="slide-mask"></div>
										<div class="slide-content">
											<div class="slide-price-distance">
												<div class="slide-price">
													Desde <span>MXN $ 100.00</span>
												</div>
												<!--
												<div class="slide-distance">
													A 96 km de tu búsqueda
												</div>
												-->
											</div>

											<div class="slide-profile">
												<div class="slide-profile-image" style="background-image: url('.getTema().'/images/new/km-buscador/avatar-01.png);"></div>
											</div>

											<div class="slide-name">
												SUSY GALLARDO
											</div>

											<div class="slide-expertice">
												5 años de experiencia
											</div>

											<div class="slide-ranking">
												<div class="km-ranking">
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#"></a>
												</div>
											</div>

											<div class="slide-buttons">
												<a href="#">CONÓCELO +</a>
												<a href="#">RESERVAR</a>
											</div>
										</div>
									</div>
								</div>
								<div class="slide">
									<div class="item-slide" style="background-image: url('.getTema().'/images/new/km-buscador/slide-01.jpg);">
										<div class="slide-mask"></div>
										<div class="slide-content">
											<div class="slide-price-distance">
												<div class="slide-price">
													Desde <span>MXN $ 100.00</span>
												</div>
												<!--
												<div class="slide-distance">
													A 96 km de tu búsqueda
												</div>
												-->
											</div>

											<div class="slide-profile">
												<div class="slide-profile-image" style="background-image: url('.getTema().'/images/new/km-buscador/avatar-02.png);"></div>
											</div>

											<div class="slide-name">
												LUIS ANGEL DÍAZ
											</div>

											<div class="slide-expertice">
												15 años de experiencia
											</div>

											<div class="slide-ranking">
												<div class="km-ranking">
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#"></a>
												</div>
											</div>

											<div class="slide-buttons">
												<a href="#">CONÓCELO +</a>
												<a href="#">RESERVAR</a>
											</div>
										</div>
									</div>
								</div>

								<div class="slide">
									<div class="item-slide" style="background-image: url('.getTema().'/images/new/km-buscador/slide-01.jpg);">
										<div class="slide-mask"></div>
										<div class="slide-content">
											<div class="slide-price-distance">
												<div class="slide-price">
													Desde <span>MXN $ 100.00</span>
												</div>
												<!--
												<div class="slide-distance">
													A 96 km de tu búsqueda
												</div>
												-->
											</div>

											<div class="slide-profile">
												<div class="slide-profile-image" style="background-image: url('.getTema().'/images/new/km-buscador/avatar-03.png);"></div>
											</div>

											<div class="slide-name">
												SOFIA RENGIFO
											</div>

											<div class="slide-expertice">
												5 años de experiencia
											</div>

											<div class="slide-ranking">
												<div class="km-ranking">
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#"></a>
												</div>
											</div>

											<div class="slide-buttons">
												<a href="#">CONÓCELO +</a>
												<a href="#">RESERVAR</a>
											</div>
										</div>
									</div>
								</div>

								<div class="slide">
									<div class="item-slide" style="background-image: url('.getTema().'/images/new/km-buscador/slide-01.jpg);">
										<div class="slide-mask"></div>
										<div class="slide-content">
											<div class="slide-price-distance">
												<div class="slide-price">
													Desde <span>MXN $ 100.00</span>
												</div>
												<!--
												<div class="slide-distance">
													A 96 km de tu búsqueda
												</div>
												-->
											</div>

											<div class="slide-profile">
												<div class="slide-profile-image" style="background-image: url('.getTema().'/images/new/km-buscador/avatar-01.png);"></div>
											</div>

											<div class="slide-name">
												SUSY GALLARDO
											</div>

											<div class="slide-expertice">
												5 años de experiencia
											</div>

											<div class="slide-ranking">
												<div class="km-ranking">
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#" class="active"></a>
													<a href="#"></a>
												</div>
											</div>

											<div class="slide-buttons">
												<a href="#">CONÓCELO +</a>
												<a href="#">RESERVAR</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

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

					<div class="km-resultados-grid">

						'.$CUIDADORES.'

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
    ';

	echo comprimir_styles($HTML);

    get_footer(); 
?>