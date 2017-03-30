<?php 
	/*
		Template Name: vlz restablecer
	*/

	get_header();

		if(function_exists('PFGetHeaderBar')){PFGetHeaderBar();} ?>

		<?php 
			include("vlz/form/vlz_styles.php"); 
		?>

		<style type="text/css">
			.vlz_titulo_interno span {
			    color: #d80606;
			    font-size: 11px;
			    vertical-align: middle;
			    float: none;
			    display: block;
			    line-height: 1.2;
			    margin-top: 0px;
			}
			label{
			    display: block;
			}
			.no_error{
				display: none;
			}
			.error{
				display: block;
			    font-size: 10px;
			    border: solid 1px #CCC;
			    padding: 3px;
			    border-radius: 0px 0px 3px 3px;
			    background: #ffdcdc;
			    line-height: 1.2;
			    font-weight: 600;
			}
			.vlz_input_error{
			    border-radius: 3px 3px 0px 0px !important;
    			border-bottom: 0px !important;
			}
			.vlz_seccion {
			    margin-bottom: 0 !important;
			}
			@media screen and (max-width: 568px){
				.vlz_seccion{
				    margin-bottom: 5px;
				}
				.vlz_sub_seccion {
				    margin-bottom: 0px;
				}
				.vlz_cell50{
			        width: calc( 100% - 9px ) !important;
				    margin-bottom: 5px;
				}
			}	
		</style>

		<div class="pf-blogpage-spacing pfb-top"></div>
		<section role="main" class="blog-full-width">
			<div class="pf-container">
				<div class="pf-row">
					<div class="col-lg-12">

						<article style="width: 600px; display: block; margin: 0px auto;">

							<form id="vlz_form_recuperar" class="vlz_form" enctype="multipart/form-data" method="POST">

								<?php
									global $wpdb;
						            $xuser = $wpdb->get_row("SELECT * FROM wp_users WHERE md5(ID) = '{$_GET['r']}'");
						            echo "<input type='hidden' name='user_id' value='{$xuser->ID}' />";
								?>
								<div class="vlz_parte">
									<div class="vlz_titulo_parte">Recuperar Contraseña</div>

									<div class="vlz_seccion">

										<h2 class="vlz_titulo_interno">Datos Personales</h2>

										<div class="vlz_sub_seccion">
											<div class="vlz_cell50">
												<input data-title="Este campo es requerido." type='password' id='clave_1' name='clave_1' class='vlz_input' placeholder='Ingrese su nueva contraseña' required>
											</div>
											
											<div class="vlz_cell50">
												<input data-title="Este campo es requerido." type='password' id='clave_2' name='clave_2' class='vlz_input' placeholder='Reingrese su nueva contraseña' required>
											</div>
										</div>
									
									</div>

									<?php include("vlz_terminos.php"); ?>

									<div class="vlz_contenedor_botones_footer">
										<div class="vlz_bloqueador"></div>
										<input type='submit' id="vlz_boton_modal_terminos" class="vlz_boton_siguiente" value='Recuperar' />
									</div>

								</div>

							</form>

							<script>

								var form = document.getElementById('vlz_form_nuevo_cliente');
								form.addEventListener( 'invalid', function(event){
							        event.preventDefault();
							        jQuery("#error_"+event.target.id).html( jQuery("#error_"+event.target.id).attr("data-title") );

							        jQuery("#error_"+event.target.id).removeClass("no_error");
							        jQuery("#error_"+event.target.id).addClass("error");
							        jQuery("#"+event.target.id).addClass("vlz_input_error");
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
							        		jQuery("#error_"+event.target.id).html( jQuery("#error_"+event.target.id).attr("data-title") );
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
								  	error.attr( "data-title", txt );
								  	error.html( txt );
								  	jQuery( this ).parent().append( error );
								});

						      	jQuery("#vlz_form_recuperar").submit(function(e){

						      		e.preventDefault();

						      		if( form.checkValidity() ){

						      			var a = "<?php echo get_template_directory_uri()."/kmimos/proceso_restablecer.php"; ?>";

							      		jQuery("#vlz_contenedor_botones").css("display", "none");
							      		jQuery(".vlz_modal_contenido").css("display", "none");
							      		jQuery("#vlz_cargando").css("display", "block");
							      		jQuery("#vlz_cargando").css("height", "auto");
							      		jQuery("#vlz_cargando").css("text-align", "center");
							      		jQuery("#vlz_cargando").html("<h2>Recuperando, por favor espere...</h2>");
							      		jQuery("#vlz_titulo_registro").html("Recuperando, por favor espere...");
						             	
						             	jQuery.post( a, jQuery("#vlz_form_recuperar").serialize(), function( data ) {
							      			// console.log(data);
								      		location.href = "<?php echo get_home_url()."/perfil-usuario/?ua=profile"; ?>";
										});
						      		}

						      	});

						      	function clvs_iguales(e){
						      		if( e.currentTarget.name == 'clave' || e.currentTarget.name == 'clave' ){
							      		var clv1 = jQuery("#clave").attr("value");
							      		var clv2 = jQuery("#clave2").attr("value");
							      		if( clv1 != clv2 ){
							      			jQuery("#error_clave2").html("Las contraseñas deben ser iguales");
							      			jQuery("#error_clave2").removeClass("no_error");
								        	jQuery("#error_clave2").addClass("error");
								        	jQuery("#clave2").addClass("vlz_input_error");
							      		}else{
							      			jQuery("#error_clave2").removeClass("error");
								        	jQuery("#error_clave2").addClass("no_error");
								        	jQuery("#clave2").removeClass("vlz_input_error");
							      		}
						      		}
						      		if( e.currentTarget.name == 'email_1' || e.currentTarget.name == 'email_2' ){
							      		var clv1 = jQuery("#email_1").attr("value");
							      		var clv2 = jQuery("#email_2").attr("value");
							      		if( clv1 != clv2 ){
							      			jQuery("#error_email_2").html("Los emails deben ser iguales");
							      			jQuery("#error_email_2").removeClass("no_error");
								        	jQuery("#error_email_2").addClass("error");
								        	jQuery("#email_2").addClass("vlz_input_error");
							      		}else{
							      			jQuery("#error_email_2").removeClass("error");
								        	jQuery("#error_email_2").addClass("no_error");
								        	jQuery("#email_2").removeClass("vlz_input_error");
							      		}
						      		}
						      	}

						      	jQuery( "#clave" ).keyup(clvs_iguales);
						      	jQuery( "#clave2" ).keyup(clvs_iguales);

						      	function vlz_validar(){
						      		var error = 0;
						      		if( !form.checkValidity() ){
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