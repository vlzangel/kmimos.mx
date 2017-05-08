<?php 
	/*
		Template Name: vlz quiero ser cuidador
	*/

	get_header();
	
		if(function_exists('PFGetHeaderBar')){PFGetHeaderBar();} 

		wp_enqueue_script(
			'redimencionar_imagenes',
			get_home_url()."/wp-content/themes/pointfinder/js/kmimos_imgs.js",
			array('jquery'),
			'1.0.0',
			true
		); 

		echo get_estados_municipios(); ?>


		<?php include("vlz/form/vlz_styles.php"); ?>

		<div class="pf-blogpage-spacing pfb-top"></div>
		<section role="main" class="blog-full-width">
			<div class="pf-container">
				<div class="pf-row">
					<div class="col-lg-12">

						<article style='position: relative'>

							<div class="vlz_seccion">
								<div class="vlz_cell75 vlz_titulo_contenedor">
									<h1 class="vlz_titulo">Sé parte de Kmimos</h1>
									<div class="vlz_sub_titulo">Para registrarte como cuidador de Kmimos, llena este formulario y nos pondremos en contacto contigo.</div>
								</div>
								<div class="vlz_cell25 vlz_banner_cuidador_contenedor">
									<img class="vlz_banner_cuidador" src="<?php echo get_home_url(); ?>/wp-content/themes/pointfinder/images/banner_cuidador.jpeg">
								</div>
							</div>

							<form id="vlz_form_nuevo_cuidador" class="vlz_form" enctype="multipart/form-data" method="POST">

								<?php
									$tam = array(
										"pequenos" => "Peque&ntilde;os (0.0 cm - 25.0)",
										"medianos" => "Medianos (25.0 cm - 58.0 cm)",
										"grandes"  => "Grandes (58.0 cm - 73.0 cm)",
										"gigantes" => "Gigantes (73.0 cm - 200.0 cm)",
									);
								?>

								<div class="vlz_parte">
									<div class="vlz_titulo_parte">Informaci&oacute;n General</div>

									<h2 class="vlz_titulo_interno">Datos Personales</h2>
									
									<div class="">

										<div class="vlz_cell50 jj_input_cell00">

											<div class="vlz_sub_seccion">
												<div class="vlz_cell50">
													<input data-title="Debes ingresar tu apellido<br>Este debe tener mínimo 3 caracteres."  type='text' id='nombres' name='nombres' class='vlz_input' placeholder='Nombres' required minlength="3">
												</div>
												
												<div class="vlz_cell50">
													<input data-title="Debes ingresar tu apellido<br>Este debe tener mínimo 3 caracteres." type='text' id='apellidos' name='apellidos' class='vlz_input' placeholder='Apellidos' required minlength="3" >
												</div>
											</div>

											<div class="vlz_sub_seccion">
												<div class="vlz_cell50">
													<input data-title="El IFE debe ser de 13 dígitos." type='number' id='ife' name='ife' class='vlz_input' placeholder='IFE' maxlength="13" required pattern="[0-9]{13}" >
												</div>
												
												<div class="vlz_cell50">
													<input data-title="Debes ingresar tu número telefónico<br>Este debe tener al menos 10 dígitos." type='number' id='telefono' name='telefono' min="10" class='vlz_input' placeholder='Tel&eacute;fono' required pattern="[0-9]">
												</div>
											</div>

											<div class="vlz_sub_seccion">
												<div class="vlz_cell100">
													<select id="referido" name="referido" class="vlz_input" data-title="Debes seleccionar una opción" required>
														<option value="">¿Cómo nos conoció?</option>
														<?php
															$referidos = get_referred_list_options();
															foreach ($referidos as $key => $value) {
																echo "<option value='{$key}'>{$value}</option>";
															}
														?>
	                                                </select>
												</div>
											</div>

											<div class="vlz_sub_seccion">
												<div class="vlz_cell100">
													<textarea data-title="Ingresa una descripción de al menos 50 caracteres incluyendo los espacios." class='vlz_input jj_desc' id='descripcion' name='descripcion' placeholder='Preséntate con la comunidad Kmimos' required minlength="50"></textarea>
												</div>
											</div>

										</div>
									
										<div class="vlz_cell50 jj_input_cell00">

											<div class="">
												<div class="vlz_img_portada">
					                                <div class="vlz_img_portada_fondo" style="background-image: url(<?php echo get_home_url()."/wp-content/themes/pointfinder"."/images/noimg.png"; ?>);"></div>
					                                <div class="vlz_img_portada_normal" style="background-image: url(<?php echo get_home_url()."/wp-content/themes/pointfinder"."/images/noimg.png"; ?>);"></div>
					                                <div class="vlz_cambiar_portada">
					                                	Subir Foto
					                                	<input type="file" id="portada" name="portada" accept="image/*" />
													</div>
			                                	</div>
				                                <input type="text" id="vlz_img_perfil" name="vlz_img_perfil" class="vlz_input" style="visibility: hidden; height: 0px !important; margin: 0px; padding: 0px;" value="" data-title="Debes cargar una foto. Fomatos aceptados: png, jpg, jpeg, gif"  />
											</div>

										</div>

									</div>

									<h2 class="vlz_titulo_interno">Datos de Acceso</h2>
									
									<div class="vlz_seccion">

										<div class="vlz_cell25">
											<!-- data-toggle="tooltip" data-placement="top" -->
											<input data-title="Ingresa un usuario<br>Este debe tener una longitud de al menos 3 caracteres."  title="El nombre de usuario que colocaste aquí es con el que vas a ingresar en tu perfil y tu nombre y apellido será utilizado en las reservas" type='text' id='username' name='username' class='vlz_input' placeholder='Nombre de Usuario' required minlength="3">
										</div>

										<div class="vlz_cell25">
											<input data-title="Ingresa tu E-mail<br>Ej: xxxx@xxx.xx" autocomplete="off" type='text' id='email' name='email' class='vlz_input' placeholder='E-mail' required pattern="^[\w._%-]+@[\w.-]+\.[a-zA-Z]{2,4}$" title="Ej. xxxx@xxxxx.xx">
										</div>
																				
										<div class="vlz_cell25">
											<input 
												type='password' 
												id='clave' 
												name='clave' 
												data-title="<strong>Las contraseñas son requeridas y deben ser iguales</strong>" 
												class='vlz_input' 
												placeholder='Contraseña' 
												required 
												autocomplete="off"
											>
										</div>
										
										<div class="vlz_cell25">
											<input 
												type='password' 
												id='clave2' 
												name='clave2' 
												data-title="<strong>Las contraseñas son requeridas y deben ser iguales</strong>" 
												class='vlz_input' 
												placeholder='Contraseña' 
												required 
												autocomplete="off"
											>
										</div>
										
									</div>

									<h2 class="vlz_titulo_interno">Datos de Ubicaci&oacute;n</h2>
									
									<div class="vlz_seccion" style="margin: 0 !important;">

										<div class="vlz_sub_seccion" style="margin: 0 !important;">

											<div class="vlz_contenedor_listados">
												<select id="estado" name="estado" class="vlz_input" data-title="Debe seleccionar un Estado" required>
													<option value="">Seleccione un Estado</option>
													<?php
														global $wpdb;

													    $estados = $wpdb->get_results("SELECT * FROM states WHERE country_id = 1 ORDER BY name ASC");
													    $str_estados = "";
													    foreach($estados as $estado) { 
													        $str_estados .= "<option value='".$estado->id."'>".$estado->name."</option>";
													    } 

													    echo $str_estados = utf8_decode($str_estados);
													?>
												</select>
											</div>

											<div class="vlz_contenedor_listados">
												<select id="municipio" name="municipio" class="vlz_input" data-title="Debe seleccionar un Municipio">
													<option value="">Seleccione un Municipio</option>
												</select>
											</div>

											<div class="vlz_contenedor_dir">
												<input type='text' id='direccion' name='direccion' class='vlz_input' placeholder='Direcci&oacute;n' data-title="Debe agregar una Dirección">
											</div>

											<input type="hidden" class="geolocation" id="latitud" name="latitud" placeholder="Latitud" step="any" value="" />
											<input type="hidden" class="geolocation" id="longitud" name="longitud" placeholder="Longitud" step="any" value="" />


										</div>

										<script type="text/javascript">
											jQuery("#estado").on("change", function(e){
												var estado_id = jQuery("#estado").val();            
	    
											    if( estado_id != "" ){

											        var html = "<option value=''>Seleccione un municipio</option>";
											        jQuery.each(estados_municipios[estado_id]['municipios'], function(i, val) {
											            html += "<option value="+val.id+" data-id='"+i+"'>"+val.nombre+"</option>";
											        });

											        jQuery("#municipio").html(html);

											        var location    = estados_municipios[estado_id]['coordenadas']['referencia'];
											        var norte       = estados_municipios[estado_id]['coordenadas']['norte'];
											        var sur         = estados_municipios[estado_id]['coordenadas']['sur'];

											        jQuery("#latitud").attr("value", location.lat);
											        jQuery("#longitud").attr("value", location.lng);

											    }

											});

											jQuery("#municipio").on("change", function(e){
												vlz_coordenadas();
											});

											function vlz_coordenadas(){
												var estado_id = jQuery("#estado").val();            
										        var municipio_id = jQuery('#municipio > option[value="'+jQuery("#municipio").val()+'"]').attr('data-id');   

										        if( estado_id != "" ){

										            var location    = estados_municipios[estado_id]['municipios'][municipio_id]['coordenadas']['referencia'];
										            var norte       = estados_municipios[estado_id]['municipios'][municipio_id]['coordenadas']['norte'];
										            var sur         = estados_municipios[estado_id]['municipios'][municipio_id]['coordenadas']['sur'];

											        jQuery("#latitud").attr("value", location.lat);
											        jQuery("#longitud").attr("value", location.lng);

										        }
											}
										</script>

									</div>

									<h2 class="vlz_titulo_interno">Datos como Cuidador</h2>

									<div class="vlz_seccion">

										<div class="vlz_cell25">
											<input type='number' id='num_mascotas_casa' min='0' name='num_mascotas_casa' class='vlz_input' placeholder='Num. de mascotas en casa' required>
										</div>
										
										<div class="vlz_cell25">
											<select class='vlz_input' id='num_mascotas_aceptadas' name='num_mascotas_aceptadas' required>
												<option value="">Num. de mascotas aceptadas</option>
												<?php
													$anio = date("Y");
													for ($i=1; $i <= 6; $i++) { 
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
												?>
											</select>
										</div>
										
										<div class="vlz_cell25">
											<select class='vlz_input' id='cuidando_desde' name='cuidando_desde' required>
												<option value="">Cuidando desde</option>
												<?php
													$anio = date("Y");
													for ($i=$anio; $i > 1900; $i-=1) { 
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
												?>
											</select>
										</div>
										
										<div class="vlz_cell25">
											<select class='vlz_input' id='emergencia' name='emergencia' required>
												<option value="">&#191;Transporte de Emergencia?</option>
												<option value="1">Si</option>
												<option value="0">No</option>
											</select>
										</div>
										
									</div>

									<div style="display: none;">
										<h2 class="vlz_titulo_interno">&#191;Qu&eacute; Tama&ntilde;os tienen tus Mascotas?</h2>
																		
										<div class="vlz_seccion">

											<?php
												foreach ($tam as $key => $value) {
													echo '
														<div class="vlz_cell25">
															<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="tengo_'.$key.'" name="tengo_'.$key.'" value="0">'.$value.'</div>
														</div>
													';
												}
											?>
											
										</div>

										<div class="vlz_seccion">

											<div class="vlz_cell50 jj_input_cell00">

												<h2 class="vlz_titulo_interno">&#191;Qu&eacute; Edades Aceptas?</h2>

												<div class="vlz_cell50">
													<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="cachorros" name="cachorros" value="0">Cachorros</div>
												</div>
												
												<div class="vlz_cell50 ">
													<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="adultos" name="adultos" value="0">Adultos</div>
												</div>

											</div>

											<div class="vlz_cell50 jj_input_cell00">
												
												<h2 class="vlz_titulo_interno">&#191;Qu&eacute; Condiciones Aceptas?</h2>

												<div class="vlz_cell50 jj_input_cell00">
													<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="esterilizado" name="esterilizado" value="0">No Esterilizados</div>
												</div>

											</div>
																				
										</div>
									</div>

									<h2 class="vlz_titulo_interno">&#191;Qu&eacute; Tama&ntilde;o de Mascotas Aceptas?</h2>
																	
									<div class="vlz_seccion">

										<?php
											foreach ($tam as $key => $value) {
												echo '
													<div class="vlz_cell25">
														<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="acepto_'.$key.'" name="acepto_'.$key.'" value="0">'.$value.'</div>
													</div>
												';
											}
										?>
										
									</div>

									<h2 class="vlz_titulo_interno">&#191;Qu&eacute; Comportamientos Aceptas?</h2>
																	
									<div class="vlz_seccion">

										<?php
								
											$Comportamientos = array(
												"sociables" 		=> "Sociables",
												"no_sociables" 		=> "No sociables",
												"agresivos_perros"  => "Agresivos con perros",
												"agresivos_humanos" => "Agresivos con humanos",
											);

											foreach ($Comportamientos as $key => $value) {
												echo '
													<div class="vlz_cell25">
														<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="comportamiento_'.$key.'" name="comportamiento_'.$key.'" value="0">'.$value.'</div>
													</div>
												';
											}
										?>
										
									</div>

									<h2 class="vlz_titulo_interno">Datos de t&uacute; Propiedad</h2>

									<div class="vlz_seccion">

										<div class="vlz_cell25">
											<select class='vlz_input' id="tipo_propiedad" name="tipo_propiedad" required>
												<option value="">Tipo de Propiedad</option>
												<option value="1">Casa</option>
												<option value="2">Departamento</option>
											</select>
										</div>
										
										<div class="vlz_cell25">
											<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="areas_verdes" name="areas_verdes" value="0">&#191;Tiene Areas Verdes?</div>
										</div>
										
										<div class="vlz_cell25">
											<div class="vlz_input vlz_no_check vlz_pin_check"><input type="hidden" id="tiene_patio" name="tiene_patio" value="0">&#191;Tiene Patio?</div>
										</div>
										
									</div>

								</div>

								<div class="vlz_parte">
									<div class="vlz_titulo_parte">Informaci&oacute;n sobre los Servicios que Brindas</div>

									<h2 class="vlz_titulo_interno">Horario</h2>

									<div>

										<div class="vlz_cell25">
											<select class='vlz_input' id="entrada" name="entrada" required>
												<option value="">Hora de Entrada</option>
												<?php
													$dial = " a.m.";
													for ($i=7; $i < 20; $i++) {

														$t = $i;
														if( $t > 12 ){ 
															$t = $t-12; $dial = ' p.m.';
														}else{
															if($t == 12){
																$dial = ' m';
															}
														}
														if( $t < 10 ){ $x = "0"; }else{ $x = ''; }
														if( $i < 10 ){ $xi = "0"; }else{ $xi = ''; }

														echo '<option value="'.$xi.$i.':00:00" data-id="'.$i.'">'.$x.$t.':00 '.$dial.'</option>';
														if( $i != 19){
															echo '<option value="'.$xi.$i.':30:00" data-id="'.$i.'.5">'.$x.$t.':30 '.$dial.'</option>';
														}
													}
												?>
											</select>
										</div>

										<div class="vlz_cell25">
											<select class='vlz_input' id="salida" name="salida" required>
												<option value="">Hora de Salida</option>
												<?php
													$dial = " a.m.";
													for ($i=7; $i < 20; $i++) {

														$t = $i;
														if( $t > 12 ){ 
															$t = $t-12; $dial = ' p.m.';
														}else{
															if($t == 12){
																$dial = ' m';
															}
														}
														if( $t < 10 ){ $x = "0"; }else{ $x = ''; }
														if( $i < 10 ){ $xi = "0"; }else{ $xi = ''; }

														echo '<option value="'.$xi.$i.':00:00" data-id="'.$i.'">'.$x.$t.':00 '.$dial.'</option>';
														if( $i != 19){
															echo '<option value="'.$xi.$i.':30:00" data-id="'.$i.'.5">'.$x.$t.':30 '.$dial.'</option>';
														}
													}
												?>
											</select>
										</div>
								
									</div>
							
									<h2 class="vlz_titulo_interno">Precios de Hospedaje </h2>
				 
									<div id="jj_modal" class="vlz_modal">

										<div class="vlz_modal_interno">

											<div class='vlz_modal_fondo' onclick="jQuery('#jj_modal').css('display', 'none');"></div>

											<div class="vlz_modal_ventana jj_modal_ventana" style="margin-top: 12%!important;">

												<div class="vlz_modal_titulo">Precios Sugeridos</div>

												<div class="vlz_modal_contenido" style="height: auto;">
														<p align="justify">
															Kmimos no te obliga a fijar un precio, sin embargo quisiéramos sugerir que sigas la siguiente tabla, la cual está creada en base a las tendencias de mercado actuales
														</p>
														<ul style="margin-left: -10px;">
															<li style="font-size: 12px;">Tamaño pequeño: 120 pesos por noche</li>
															<li style="font-size: 12px;">Tamaño mediano: 180 <span>pesos por noche</span></li>
															<li style="font-size: 12px;">Tamaño grande: 220 <span>pesos por noche</span></li>
															<li style="font-size: 12px;">Tamaño gigante: 250 <span>pesos por noche</span></li>
														</ul>
														<p align="justify">
															<strong>IMPORTANTE:</strong> recuerda que siempre podrás colocar el precio que a ti mejor se te acomode
														</p>
														
														<p align="justify">
															<strong>NOTA</strong>: en esta sección deberás colocar el precio que deseas percibir como ingreso. sobre dicho precio, el sistema le incrementará un 20% de manera automática. Cuando un cliente haga una búsqueda y se le despliegue los diferentes cuidadores disponibles para él, el precio que le mostrará la página será tu costo mas dicho 20%.
														</p>
												</div>
												<div class="vlz_modal_pie" style="border-radius: 0px 0px 5px 5px!important; height: 70px;">

													<input type='button' style="text-align: center;" class="vlz_boton_siguiente" value='Cerrar' onclick="jQuery('#jj_modal').css('display', 'none');" />

												</div>
											</div>
										</div>
									</div>
									<!-- /Modal "Precios de Hosedajes"-->

									<div class="vlz_seccion">
										<?php
											$txts = array(
												"pequenos" => "Kmimos no te obliga a fijar un precio, sin embargo quisiéramos sugerir que sigas la siguiente tabla, la cual está creada en base a las tendencias de mercado actuales es de 120 pesos por noche",
												"medianos" => "Kmimos no te obliga a fijar un precio, sin embargo quisiéramos sugerir que sigas la siguiente tabla, la cual está creada en base a las tendencias de mercado actuales es de 180 pesos por noche",
												"grandes"  => "Kmimos no te obliga a fijar un precio, sin embargo quisiéramos sugerir que sigas la siguiente tabla, la cual está creada en base a las tendencias de mercado actuales es de 220 pesos por noche",
												"gigantes" => "Kmimos no te obliga a fijar un precio, sin embargo quisiéramos sugerir que sigas la siguiente tabla, la cual está creada en base a las tendencias de mercado actuales es de 250 pesos por noche"
											);
											foreach ($tam as $key => $value) {
												echo '
													<div class="vlz_cell25">
														<input type="text" class="vlz_input" id="hospedaje_'.$key.'" name="hospedaje_'.$key.'" placeholder="'.$value.'" >
													</div>
												';
											}
										?>

										<div class='no_error' id='error_hospedaje' style="margin: 3px 6px 0px;">Debe llenar al menos uno de los campos</div>
																			
									</div>

									<div style="display: none;">

										<h2 class="vlz_titulo_interno" style="margin-top: 10px;">Servicios Adicionales</h2>

										<div class="vlz_seccion">

											<div class="vlz_contenedor_adicionales"></div>

											<div class="vlz_boton_agregar">Agregar Servicio Adicional</div>
																				
										</div>

										<div>

											<div class="vlz_cell50 jj_cell50">
												<h2 class="vlz_titulo_interno">Transportaci&oacute;n Sencilla</h2>
												<?php
												    $rutas = array(
												        "corto" => "Cortas",
												        "medio" => "Medias",
												        "largo" => "Largas"
												    );

													foreach ($rutas as $key => $value) {
														echo '
															<div class="vlz_cell33">
																<input type="text" class="vlz_input" id="trans_sencillo_'.$key.'" name="trans_sencillo_'.$key.'" placeholder="'.$value.'">
															</div>
														';
													}
												?>
											</div>

											<div class="vlz_cell50 jj_cell50">
												<h2 class="vlz_titulo_interno">Transportaci&oacute;n Redonda </h2>
												<?php
													foreach ($rutas as $key => $value) {
														echo '
															<div class="vlz_cell33">
																<input type="text" class="vlz_input" id="trans_redonda_'.$key.'" name="trans_redonda_'.$key.'" placeholder="'.$value.'">
															</div>
														';
													}
												?>
											</div>

										</div>

										<h2 class="vlz_titulo_interno">Otros Servicios</h2>

										<div class="vlz_seccion jj_input_cell00">

											<?php
											    $adicionales_extra = array(
											        "bano"                      => "Baño",
											        "corte"                     => "Corte de pelo y uñas",
											        "limpieza_dental"           => "Limpieza Dental",
											        "visita_al_veterinario"     => "Visita al Veterinario",
											        "acupuntura"                => "Acupuntura"
											    );

												foreach ($adicionales_extra as $key => $value) {
													echo '
														<div class="vlz_cell20 jj_input_cell00">
															<input type="text" class="vlz_input" id="adicional_'.$key.'" name="adicional_'.$key.'" placeholder="'.$value.'">
														</div>
													';
												}
											?>

										</div>

									</div>

									<?php include("vlz_terminos_cuidador.php"); ?>

									<div class="vlz_contenedor_botones_footer">
										<div class="vlz_bloqueador"></div>
										<input type='button' id="vlz_boton_modal_terminos" class="vlz_boton_siguiente" value='Registrarme' onclick="vlz_validar()" />
									</div>

								</div>

								<div class="vlz_banner_footer">
									<div class="vlz_cell25">
										<img src="<?php echo get_home_url(); ?>/wp-content/themes/pointfinder/images/hombre.png">
									</div>
									<div class="vlz_cell75">
										<span class='vlz_verde'>Tienes dudas sobre el registro? Tienes poco tiempo para registrarte?</span> Kmimos te ayuda!
										Ponte en contacto con nosotros. Mándanos un mail a <span class='vlz_naranja'>a.vera@kmimos.la</span> o por Teléfono o Whatsapp al <span class='vlz_naranja'>(55) 6178 0320</span>.

										<span class='vlz_gris_footer'>La familia Kmimos te espera!!</span>
									</div>
								</div>

							</form>

							<script>

							//MODAL PRECIOS SUGERIDOS-----------------------------------------------------------------------------------------------
								var modalOpend= false;
								function modalPrecios(){
									jQuery(window).scroll(function() {
									    if (jQuery(document).scrollTop() > 1800) {
										    if (modalOpend != true) {
										    	jQuery('#jj_modal').fadeIn();
										       	modalOpend= true;
										    }  
									      
									    // } else {
									      jQuery('#jj_modal').fadeOut();
									      //console.log('Modal cierra')
									     }
									});
								}

								function ocultarModal(){
									jQuery('#jj_modal').fadeOut();
									jQuery('#jj_modal').css('display', 'none');
									modalOpend= true;
								}
							//MODAL PRECIOS SUGERIDOS END-----------------------------------------------------------------------------------------------

								var form = document.getElementById('vlz_form_nuevo_cuidador');
								form.addEventListener( 'invalid', function(event){
							        event.preventDefault();
							        jQuery("#error_"+event.target.id).removeClass("no_error");
							        jQuery("#error_"+event.target.id).addClass("error");
							        jQuery("#"+event.target.id).addClass("vlz_input_error");
								}, true);

								function especiales(id){
									switch(id){
										case "ife":
								      		var ife = jQuery( "#ife" ).val();

								      		if( ife.length == 13 ){
								      			return true;
								      		}else{
								      			return false;
								      		}
										break;
										case "telefono":
								      		var telefono = jQuery( "#telefono" ).val();

								      		if( telefono.length >= 10 ){
								      			return true;
								      		}else{
								      			return false;
								      		}
										break;
										case "clave":
								      		var clv1 = jQuery("#clave").attr("value");
								      		var clv2 = jQuery("#clave2").attr("value");

								      		return ( clv1 == clv2 );
										break;
										case "clave2":
								      		var clv1 = jQuery("#clave").attr("value");
								      		var clv2 = jQuery("#clave2").attr("value");

								      		return ( clv1 == clv2 );
										break;
										case "hospedaje":
								      		var z = 0;
											var t = [
												'pequenos',
												'medianos',
												'grandes',
												'gigantes'
											];

											jQuery.each(t, function( index, value ) {
												var temp = jQuery('#hospedaje_'+value).attr('value');
												if( temp == '' ){ temp = 0; }
												z += parseInt( temp );
						      					console.log("Z: "+z);	
											});

											if( z == 0 ){
												jQuery('#error_hospedaje').attr('class', 'error');
											}else{
												jQuery('#error_hospedaje').attr('class', 'no_error');
											}

											return ( z == 0 );
										break;
										default:
											return true;
										break;
									}
								}

								form.addEventListener( 'keyup', function(event){
							        if ( event.target.validity.valid && especiales(event.target.id) ) {
							        	if( jQuery("#error_"+event.target.id).hasClass( "error" ) ){
							        		jQuery("#error_"+event.target.id).removeClass("error");
								        	jQuery("#error_"+event.target.id).addClass("no_error");
								        	jQuery("#"+event.target.id).removeClass("vlz_input_error");
							        	}
								    } else {
							        	if( jQuery("#error_"+event.target.id).hasClass( "no_error" ) ){
							        		jQuery("#error_"+event.target.id).removeClass("no_error");
								        	jQuery("#error_"+event.target.id).addClass("error");
								        	jQuery("#"+event.target.id).addClass("vlz_input_error");
							        	} 
								    }
								}, true);

								form.addEventListener( 'change', function(event){
							        if ( event.target.validity.valid && especiales(event.target.id) ) {
							        	if( jQuery("#error_"+event.target.id).hasClass( "error" ) ){
							        		jQuery("#error_"+event.target.id).removeClass("error");
								        	jQuery("#error_"+event.target.id).addClass("no_error");
								        	jQuery("#"+event.target.id).removeClass("vlz_input_error");
							        	}
								    } else {
							        	if( jQuery("#error_"+event.target.id).hasClass( "no_error" ) ){
							        		jQuery("#error_"+event.target.id).removeClass("no_error");
								        	jQuery("#error_"+event.target.id).addClass("error");
								        	jQuery("#"+event.target.id).addClass("vlz_input_error");
							        	} 
								    }
								}, true);

								jQuery(".vlz_input").each(function( index ) {
								  	var error = jQuery("<div class='no_error' id='error_"+( jQuery( this ).attr('id') )+"' data-id='"+( jQuery( this ).attr('id') )+"'></div>");
								  	var txt = jQuery( this ).attr("data-title");
								  	if( txt == "" || txt == undefined ){ txt = "Completa este campo."; }
								  	error.html( txt );
								  	jQuery( this ).parent().append( error );
								});

						      	function vista_previa(evt) {
							      	var files = evt.target.files;
							      	for (var i = 0, f; f = files[i]; i++) {  
							           	if (!f.type.match("image.*")) {
							                continue;
							           	}
							           	var reader = new FileReader();
							           	reader.onload = (function(theFile) {
							               return function(e) {
			                        			/*jQuery(".vlz_img_portada_fondo").css("background-image", "url("+e.target.result+")");
			                        			jQuery(".vlz_img_portada_normal").css("background-image", "url("+e.target.result+")");
			                        			jQuery("#vlz_img_perfil").attr("value", e.target.result);*/

			                        			redimencionar(e.target.result, function(img_reducida){
			                        				jQuery(".vlz_img_portada_fondo").css("background-image", "url("+img_reducida+")");
				                        			jQuery(".vlz_img_portada_normal").css("background-image", "url("+img_reducida+")");
				                        			jQuery("#vlz_img_perfil").attr("value", img_reducida);
				                        			jQuery("#error_vlz_img_perfil").css("display", "none");
			                        			});

			                        			
							               };
							           })(f);
							           reader.readAsDataURL(f);
							       	}
								}      
						      	document.getElementById("portada").addEventListener("change", vista_previa, false);

						      	jQuery(".vlz_pin_check").on("click", function(){
						      		if( jQuery("input", this).attr("value") == "0" ){
						      			jQuery("input", this).attr("value", "1");
						      			jQuery(this).removeClass("vlz_no_check");
						      			jQuery(this).addClass("vlz_check");
						      		}else{
						      			jQuery("input", this).attr("value", "0");
						      			jQuery(this).removeClass("vlz_check");
						      			jQuery(this).addClass("vlz_no_check");
						      		}
						      	});

						      	jQuery(".vlz_boton_agregar").on("click", function(){
						      		jQuery(".vlz_boton_quitar").off("click");
						      		var servicios = jQuery('<select class="vlz_input" id="servicio[]" name="servicio[]"><option value="8">Guarder&iacute;a (Cuidado durante el d&iacute;a)</option><option value="9">Adiestramiento de obediencia b&aacute;sico</option><option value="10">Adiestramiento de obediencia intermedio</option><option value="11">Adiestramiento de obediencia avanzado</option><option value="12">Paseos</option></select>');
						      		var contCampos = jQuery("<div>", {"class": "vlz_cell66 jj_input_cell00"});
						      		<?php
										$tam = array(
											"pequenos" => "Peque&ntilde;os",
											"medianos" => "Medianos",
											"grandes"  => "Grandes",
											"gigantes" => "Gigantes",
										);
										$txts = array(
											"pequenos" => "",
											"medianos" => "",
											"grandes"  => "",
											"gigantes" => ""
										);
						      			foreach ($tam as $key => $value) {
											echo "var ".$key." = jQuery(\"<div class='vlz_cell25'><input type='text' id='adicional_".$key."' name='adicional_".$key."[]' class='vlz_input' placeholder='".$value."' title='".$txts[$key]."'><div class='no_error' id='error_adicional_".$key."'></div></div>\");";
											echo "jQuery(contCampos).append( ".$key." );";
										}
						      		?>
						      		
						      		var contBoton = jQuery("<div>", {"class": "vlz_cell25"});
						      			jQuery(contBoton).append( jQuery("<div>", {"class": "vlz_boton_quitar"}) );

						      		var lista = jQuery("<div>", {"class": "vlz_cell75 jj_input_cell00"});
						      			jQuery(lista).append( servicios );

						      		var contLista = jQuery("<div>", {"class": "vlz_cell33 jj_input_cell00"});
						      		jQuery(contLista).append( contBoton );
						      		jQuery(contLista).append( lista );

						      		var newItem = jQuery("<div>", {"class": "vlz_sub_seccion"});
						      		jQuery(newItem).append( contLista );
						      		jQuery(newItem).append( contCampos );

						      		jQuery( ".vlz_contenedor_adicionales" ).append( newItem );

						      		jQuery(".vlz_boton_quitar").on("click", function(){
						      			jQuery(this).parent().parent().parent().remove();
						      		});

						      	});

						      	function GoToHomePage(){
							    	location = '<?php echo get_home_url()."/perfil-usuario/?ua=profile"; ?>';   
							    	//location = 'http://kmimos.ilernus.com/';   
							  	}

						      	jQuery("#vlz_form_nuevo_cuidador").submit(function(e){

						      		jQuery("#vlz_modal_cerrar_registrar").attr("onclick", "");

						      		if( form.checkValidity() ){
							            var terminos = jQuery("#terminos").attr("value");
							      		if( terminos == 1){

							      			/*var portada = jQuery("#vlz_img_perfil").attr("value");
							      			if( portada != "" ){*/
								      			// var a = "<?php echo get_home_url()."/wp-content/themes/pointfinder/vlz/form/vlz_procesar.php"; ?>";

								      			var a = "<?php echo get_home_url()."/wp-content/themes/pointfinder/kmimos/registro_cuidador/vlz_procesar.php"; ?>";
									      		jQuery("#vlz_contenedor_botones").css("display", "none");
									      		jQuery(".vlz_modal_contenido").css("display", "none");
									      		jQuery("#vlz_cargando").css("display", "block");
									      		jQuery("#vlz_cargando").css("height", "auto");
									      		jQuery("#vlz_cargando").css("text-align", "center");
									      		jQuery("#vlz_cargando").html("<h2>Registrando, por favor espere...</h2>");
									      		jQuery("#vlz_titulo_registro").html("Registrando, por favor espere...");
								             	
												jQuery.post( a, jQuery("#vlz_form_nuevo_cuidador").serialize(), function( data ) {
										      		data = eval(data);

										      		if( data.error == "SI" ){

										      			jQuery('html, body').animate({ scrollTop: jQuery("#email").offset().top-75 }, 2000);

										      			alert(data.msg);

										      			jQuery("#terminos_y_condiciones").css("display", "none");

										      			jQuery("#vlz_contenedor_botones").css("display", "block");
											      		jQuery(".vlz_modal_contenido").css("display", "block");
											      		jQuery("#terminos").css("display", "block");
											      		jQuery("#vlz_cargando").css("height", "auto");

											      		jQuery("#vlz_cargando").css("display", "none");

											      		jQuery("#vlz_cargando").css("text-align", "justify");

											      		jQuery("#vlz_titulo_registro").html('Términos y Condiciones');
									      				jQuery("#boton_registrar_modal").css("display", "inline-block");

										      		}else{

										      			jQuery("#vlz_titulo_registro").html("Registro Completado!");
													  	jQuery("#vlz_cargando").html(data.msg);
											      		jQuery("#vlz_registro_cuidador_cerrar").css("display", "inline-block");

										      		}
										      	});

									      	/*}else{
									      		jQuery('.vlz_modal').css('display', 'none');
									      	}*/

							      		}else{
								      		alert("Debe aceptar los términos y condiciones.");
						      				vlz_modal('terminos', 'Términos y Condiciones');
							      		}

						      		}

						      		e.preventDefault();
						      	});

						      	function clvs_iguales(e){
						      		var clv1 = jQuery("#clave").attr("value");
						      		var clv2 = jQuery("#clave2").attr("value");

						      		if( clv1 == clv2 ){

						      			jQuery("#error_clave").removeClass("error");
							        	jQuery("#error_clave").addClass("no_error");
							        	jQuery("#clave").removeClass("vlz_input_error");

						      			jQuery("#error_clave2").removeClass("error");
							        	jQuery("#error_clave2").addClass("no_error");
							        	jQuery("#clave2").removeClass("vlz_input_error");

						      		}else{
						        		jQuery("#error_clave").removeClass("no_error");
							        	jQuery("#error_clave").addClass("error");
							        	jQuery("#clave").addClass("vlz_input_error");

						        		jQuery("#error_clave2").removeClass("no_error");
							        	jQuery("#error_clave2").addClass("error");
							        	jQuery("#clave2").addClass("vlz_input_error");
						      		}
						      	}

						      	jQuery( "#clave" ).keyup(clvs_iguales);
						      	jQuery( "#clave2" ).keyup(clvs_iguales);

						      	function vlz_validar(){
						      		var error = 0;

						      		if( !form.checkValidity() ){
						      			error++;						      			
						      		}

						      		if( !especiales("clave") ){
						      			error++;						      			
						      		}

						      		if( especiales("hospedaje") ){
						      			error++;						      			
						      		}

						      		if( error > 0 ){
						      			var primer_error = ""; var z = true;
						      			jQuery( ".error" ).each(function() {
										  	if( jQuery( this ).css( "display" ) == "block" ){
										  		if( z ){
										  			primer_error = "#"+jQuery( this ).attr("data-id");
										  			z = false;
										  		}
										  	}
										});

						      			jQuery('html, body').animate({ scrollTop: jQuery(primer_error).offset().top-75 }, 2000);
						      		}else{
						      			vlz_modal('terminos', 'Términos y Condiciones');
						      		}

						      	}

						      	function vlz_modal(tipo, titulo, contenido){
						      		switch(tipo){
						      			case "terminos":
						      				jQuery("#vlz_titulo_registro").html(titulo);
						      				jQuery("#terminos_y_condiciones").css("display", "table");
						      				jQuery("#boton_registrar_modal").css("display", "inline-block");
						      			break;
						      		}
						      	}

					      	</script> 

						</article>
						
					</div>
					
				</div>
			</div>
		</section>
		<div class="pf-blogpage-spacing pfb-bottom"></div> <?php 

	get_footer(); 
?>