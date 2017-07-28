<?php 
    /*
        Template Name: Home
    */

    wp_enqueue_style('home_kmimos', getTema()."/css/home_kmimos.css", array(), '1.0.0');
    wp_enqueue_style('home_responsive', getTema()."/css/responsive/home_responsive.css", array(), '1.0.0');
    wp_enqueue_script('buscar_home', getTema()."/js/home.js", array(), '1.0.0');
            
    get_header();
        
        $data = get_data_home();

	    extract($data);

	    $home = get_home_url();

	    $HTML = '
	    <script type="text/javascript"> var URL_MUNICIPIOS ="'.getTema().'/procesos/generales/municipios.php"; </script>

	    <!-- SECCIÓN 1 - PARTE FORMULARIO CUIDADOR -->
		<div class="km-credibilidad">

			<div class="container">
				<div class="km-credibilidad-titular">
					<p>A LA FAMILIA SE LE CUIDA, POR ELLO LE DAMOS A TU MASCOTA CUIDADO Y AMOR</p>
					<h2>tu mascota regresa feliz</h2>
				</div>
			</div>

			<form id="buscador" class="km-cuidador" method="POST" action="'.getTema().'/procesos/busqueda/buscar.php">
				<div class="container">
					<div class="km-formulario-cuidador">
						<div class="row km-fechas">
							<div class="col-xs-12 col-sm-6">
								<select class="km-select-custom km-select-ubicacion" name="">
									<option>UBICACIÓN, ESTADO, MUNICIPIO</option>
									<option>UBICACIÓN, A</option>
									<option>UBICACIÓN, B</option>
								</select>
							</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" name="" placeholder="DESDE CUANDO" value="" class="date_from">
							</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" name="" placeholder="HASTA CUANDO" value="" class="date_to">
							</div>
						</div>
						<div class="row km-servicios mtb-10">
							<div class="col-xs-12 col-sm-3">
								<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-hospedaje.svg">HOSPEDAJE DÍA Y NOCHE</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-guarderia.svg">GUARDERÍA DÍA</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-paseo.svg">PASEOS</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-entrenamiento.svg">ENTRENAMIENTO</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-9">
								<div class="row km-tamanio">
									<div class="col-xs-6 col-sm-3">
										<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-pequenio.svg"><div class="km-opcion-text"><b>PEQUEÑO</b><br>0 a 25 cm</div></div>
									</div>
									<div class="col-xs-6 col-sm-3">
										<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-mediano.svg"><div class="km-opcion-text"><b>MEDIANO</b><br>25 a 58cm</div></div>
									</div>
									<div class="col-xs-6 col-sm-3">
										<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-grande.svg"><div class="km-opcion-text"><b>GRANDE</b><br>58 a 73 cm</div></div>
									</div>
									<div class="col-xs-6 col-sm-3">
										<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-gigante.svg"><div class="km-opcion-text"><b>GIGANTE</b><br>73 a 200 cm</div></div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-3 pd5">
								<a href="#popup-servicios" class="km-btn-primary" role="button" data-toggle="modal">ENCONTRAR CUIDADOR</a>
								<div id="popup-servicios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4><b>RECOMPENSA A TU MASCOTA. INCLUYE UN SERVICIO ADICIONAL</b></h4>
											<div class="km-servicios-adicionales">
												<div class="row">
													<div class="col-xs-12 col-sm-3">
														<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-corteypelo.svg"><div class="km-opcion-text">CORTE DE<br> PELO Y UÑAS</div></div>
													</div>
													<div class="col-xs-12 col-sm-3">
														<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-banoyseco.svg"><div class="km-opcion-text">BAÑO<br> Y SECADO</div></div>
													</div>
													<div class="col-xs-12 col-sm-3">
														<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-dental.svg"><div class="km-opcion-text">LIMPIEZA<br> DENTAL</div></div>
													</div>
													<div class="col-xs-12 col-sm-3">
														<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-veterinario.svg"><div class="km-opcion-text">VISITA AL<br> VETERINARIO</div></div>
													</div>
												</div>
												<div class="row mtb-10">
													<div class="col-xs-12 col-sm-3">
														<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-acupuntura.svg"><div class="km-opcion-text">ACUPUNTURA</div></div>
													</div>
													<div class="col-xs-12 col-sm-3">
														<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-transportesencillo.svg"><div class="km-opcion-text">TRANSPORTE<br> SENCILLO</div></div>
													</div>
													<div class="col-xs-12 col-sm-3">
														<div class="km-opcion"><img src="'.getTema().'/images/new/icon/icon-transporteredondo.svg"><div class="km-opcion-text">TRANSPORTE<br> REDONDO</div></div>
													</div>
													<div class="col-xs-12 col-sm-3">
														<a id="buscar" href="#" class="km-btn-primary" style="height: 70px; line-height: 40px;">AGREGAR SERVICIO</a>
													</div>
												</div>
											</div>
											<a id="buscar_no" class="km-link" style="color: black; display:block; margin-top: 30px;">NO DESEO POR AHORA, GRACIAS</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- FIN SECCIÓN 1 - PARTE FORMULARIO CUIDADOR -->
		<!-- FIN SECCIÓN 1 -->

		<!-- SECCIÓN 2 - BENEFICIOS -->
		<div class="km-beneficios">
			<div class="container">
				<h4><div style="font-family: \'Gotham-Pro-Black\'; display: inline-block;">BENEFICIOS</div> DE DEJAR A TU MASCOTA CON CUIDADORES CERTIFICADOS</h4>
				<div class="row">
					<div class="col-xs-12 col-sm-4">
						<div class="row">
							<div class="col-xs-4 col-sm-12 km-beneficios-icon">
								<img src="'.getTema().'/images/new/km-certificado.svg">
							</div>
							<div class="col-xs-8 col-sm-12">
								<div class="km-beneficios-text">
									<h5>CUIDADORES CERTIFICADOS</h5>
									<p>Certificación bajo estándares internacionales. Respaldando su integridad y experiencia con perros. Siendo capacitados también en la <a class="km-link" href="#">Academia Kmimos.</a></p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4">
						<div class="row">
							<div class="col-xs-4 col-sm-12 km-beneficios-icon">
								<img src="'.getTema().'/images/new/km-veterinaria.svg">
							</div>
							<div class="col-xs-8 col-sm-12">
								<div class="km-beneficios-text">
									<h5>COBERTURA VETERINARIA</h5>
									<p>Sabemos tu mascota es un integrante de tu familia. Ten la certeza recibirá el cuidado necesario, teniendo cobertura contra accidentes durante su estadía.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4">
						<div class="row">
							<div class="col-xs-4 col-sm-12 km-beneficios-icon">
								<img src="'.getTema().'/images/new/km-fotografia.svg">
							</div>
							<div class="col-xs-8 col-sm-12">
								<div class="km-beneficios-text">
									<h5>FOTOGRAFÍAS Y VIDEOS DIARIOS</h5>
									<p>Acercando distancias entre tu mascota y tú. Kmimos monitorea a los cuidadores asociados asegurando la mejor experiencia para ambos.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN SECCIÓN 2 - BENEFICIOS -->

		<!-- SECCIÓN 3 - TESTIMONIALES -->
		<div class="km-testimoniales">
			<div class="container-fluid">
				<div class="row">
					<ul class="bxslider">
						<li>
							<div>
								<div class="overlay"></div>
								<div class="km-testimonial-text">
									<div class="km-video-testimonial">
										<a href="Javascript: void(0);" onclick="playVideo(this)"><img src="'.getTema().'/images/new/icon/icon-video.svg" width="55"></a>
									</div>
									<div class="km-testimonial">“Llegan como huéspedes y se van como mis amigos, lo importante es hacerlos sentir en su hogar”</div>
									<div class="km-autor">JUAN RODRÍGUEZ - México D.F</div>
									<div class="km-autor-descripcion">Cuidador Certificado</div>
								</div>
								<video>
									<source src="'.getTema().'/images/new/videos/km-home/km-video.webm" type="video/webm">
									<source src="'.getTema().'/images/new/videos/km-home/km-video.mp4" type="video/mp4">
									<source src="'.getTema().'/images/new/videos/km-home/km-video.ogv" type="video/ogg">
								</video>
								<img class="img-testimoniales" src="'.getTema().'/images/new/km-testimoniales/testimonial-1.jpg">
							</div>
						</li>
						<li>
							<div>
								<div class="overlay"></div>
								<div class="km-testimonial-text">
									<div class="km-video-testimonial">
										<a href="Javascript: void(0);" onclick="playVideo(this)"><img src="'.getTema().'/images/new/icon/icon-video.svg" width="55"></a>
									</div>
									<div class="km-testimonial">“Llegan como huéspedes y se van como mis amigos, lo importante es hacerlos sentir en su hogar”</div>
									<div class="km-autor">JUAN RODRÍGUEZ - México D.F</div>
									<div class="km-autor-descripcion">Cuidador Certificado</div>
								</div>
								<video>
									<source src="'.getTema().'/images/new/videos/km-home/km-video.webm" type="video/webm">
									<source src="'.getTema().'/images/new/videos/km-home/km-video.mp4" type="video/mp4">
									<source src="'.getTema().'/images/new/videos/km-home/km-video.ogv" type="video/ogg">
								</video>
								<img class="img-testimoniales" src="'.getTema().'/images/new/km-testimoniales/testimonial-2.jpg">
							</div>
						</li>
						<li>
							<div>
								<div class="overlay"></div>
								<div class="km-testimonial-text">
									<div class="km-video-testimonial">
										<a href="Javascript: void(0);" onclick="playVideo(this)"><img src="'.getTema().'/images/new/icon/icon-video.svg" width="55"></a>
									</div>
									<div class="km-testimonial">“Llegan como huéspedes y se van como mis amigos, lo importante es hacerlos sentir en su hogar”</div>
									<div class="km-autor">JUAN RODRÍGUEZ - México D.F</div>
									<div class="km-autor-descripcion">Cuidador Certificado</div>
								</div>
								<video>
									<source src="'.getTema().'/images/new/videos/km-home/km-video.webm" type="video/webm">
									<source src="'.getTema().'/images/new/videos/km-home/km-video.mp4" type="video/mp4">
									<source src="'.getTema().'/images/new/videos/km-home/km-video.ogv" type="video/ogg">
								</video>
								<img class="img-testimoniales" src="'.getTema().'/images/new/km-testimoniales/testimonial-3.jpg">
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- FIN SECCIÓN 3 - TESTIMONIALES -->

		<!-- SECCIÓN 4 - CLUB PATITAS FELICES -->
		<div class="km-club">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-3">
						<img src="'.getTema().'/images/new/club-patita.svg" width="100%" style="max-width: 200px;">
						<h4 style="margin-top: 35px;"><span>Cada amigo que complete 1 reservación</span> GANA $150 Y TÚ GANAS OTROS $150</h4>
					</div>
					<div class="col-xs-12 col-sm-6">
						<h4>CLUB DE LAS</h4>
						<h2>Patitas Felices</h2>
						<div class="box-form">
							<form>
								<input placeholder="NOMBRES Y APELLIDOS" type="text" required="">
								<input placeholder="EMAIL" type="password" required="">
							</form>
						</div>
						<a href="#" class="km-btn-primary ">INSCRÍBETE Y GANA</a>
					</div>
					<div class="hidden-xs col-sm-3">
						<img src="'.getTema().'/images/new/km-club-perro.jpg" width="100%">
					</div>
				</div>
			</div>
		</div>
		<!-- FIN SECCIÓN 4 - CLUB PATITAS FELICES -->
		<!-- SECCIÓN 5 - VACACIONES -->
		<div class="km-vacaciones">
			<div class="container">
				<p>NOSOTROS NOS ENCARGAMOS DE TU MASCOTA, TÚ LIBÉRATE.</p>
				<h2>Vacations Mode On</h2>
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<a href="#" style="background-color: white;"><img src="'.getTema().'/images/new/km-logos/logo-hotel.jpg"></a>
					</div>
					<div class="col-xs-12 col-sm-6">
						<a href="#" style="background-color: black;"><img src="'.getTema().'/images/new/km-logos/logo-volaris.jpg"></a>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN SECCIÓN 5 - VACACIONES -->
		<!-- SECCIÓN 6 - BENEFICIOS -->
		<div class="km-medios">
			<div class="container">
				<h4>NUESTRO RESPALDO</h4>
				<div class="row">
					<div class="col-xs-6 col-md-offset-1 col-md-2">
						<img src="'.getTema().'/images/new/km-medios/reforma.jpg">
					</div>
					<div class="col-xs-6 col-md-2">
						<img src="'.getTema().'/images/new/km-medios/mural.jpg">
					</div>
					<div class="col-xs-6 col-md-2">
						<img src="'.getTema().'/images/new/km-medios/norte.jpg">
					</div>
					<div class="col-xs-6 col-md-2">
						<img src="'.getTema().'/images/new/km-medios/financiero.jpg">
					</div>
					<div class="col-xs-12 col-md-2">
						<img src="'.getTema().'/images/new/km-medios/universal.jpg">
					</div>
				</div>
			</div>
		</div>
		<!-- FIN SECCIÓN 6 - BENEFICIOS -->
		<!-- SECCIÓN 7 - BENEFICIOS -->
		<div class="km-beneficios">
			<div class="container">
				<h4>KMIMOS TE OFRECE</h4>
				<div class="row">
					<div class="col-xs-4">
						<div class="km-beneficios-icon">
							<img src="'.getTema().'/images/new/km-pago.svg">
						</div>
						<div class="km-beneficios-text">
							<h5 class="h5-sub">PAGO EN EFECTIVO O CON TARJETA</h5>
						</div>
					</div>
					<div class="col-xs-4 brd-lr">
						<div class="km-beneficios-icon">
							<img src="'.getTema().'/images/new/km-seguridad.svg">
						</div>
						<div class="km-beneficios-text">
							<h5 class="h5-sub">COBERTURA SERVICIOS VETERINARIOS</h5>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="km-beneficios-icon">
							<img src="'.getTema().'/images/new/km-certificado.svg">
						</div>
						<div class="km-beneficios-text">
							<h5 class="h5-sub">CUIDADORES 100% CERTIFICADOS</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN SECCIÓN 7 - BENEFICIOS -->
	    ';

	    echo comprimir_styles($HTML);

    get_footer(); 
?>


