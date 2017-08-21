<?php
	/**
	* The template for displaying product content in the single-product.php template
	**/

	global $wpdb;

	$D = $wpdb;

	$id_user = get_current_user_id(); // [SERVER_NAME] 

	$actual = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$referencia = $_SERVER['HTTP_REFERER'];

	if( $actual == $referencia ){
		$referencia = get_home_url();
	} 

	$DS = kmimos_session();
    if( $DS ){ ?>
		
			<?php if( $DS["saldo_temporal"] > 0 ){ ?>
				<div class="theme_button" style="padding: 10px; margin-bottom: 20px;">
					<strong><?php echo kmimos_saldo_titulo(); ?>:</strong> MXN $<?php echo $DS["saldo"]; ?>
				</div>
			<?php }else{ 
					$kmisaldo = kmimos_get_kmisaldo();
					if( $kmisaldo > 0 ){ ?>
						<div class="theme_button" style="padding: 10px; margin-bottom: 20px;">
							<strong><?php echo kmimos_saldo_titulo(); ?>:</strong> MXN $<?php echo $kmisaldo; ?>
						</div>
			<?php 	}
				  } ?>
		 <?php
		if( isset($DS["reserva"]) ){ ?>
			<div class="theme_button" style="padding: 10px 10px 10px 40px; margin-bottom: 20px; position: relative;">
				<img src="<?php echo get_template_directory_uri()."/images/advertencia.png"; ?>" style="position: absolute; top: 4px; left: 6px; width: 30px;" />
				
				<span style="font-weight: 600;">Importante:</span> Confirme previamente con el cuidador la disponibilidad del ajuste que usted desea realizar.
			</div> <?php 
		}
    }

	$busqueda = getBusqueda();

	$servicio_id = get_the_ID();

	$tipo = $wpdb->get_var("
        SELECT
            tipo_servicio.slug AS slug
        FROM 
            wp_term_relationships AS relacion
        LEFT JOIN wp_terms as tipo_servicio ON ( tipo_servicio.term_id = relacion.term_taxonomy_id )
        WHERE 
            relacion.object_id = '{$servicio_id}' AND
            relacion.term_taxonomy_id != 28
    ");

	$cuidador = $wpdb->get_row( "SELECT * FROM cuidadores WHERE user_id = ".$post->post_author );

	$cuidador_name = $wpdb->get_var( "SELECT post_title FROM wp_posts WHERE ID = ".$cuidador->id_post );

    $precios = "";
    
	$adicionales = unserialize($cuidador->adicionales);

    if( $tipo == "hospedaje" ){
    	$precios = getPrecios( unserialize($cuidador->hospedaje) );
    }else{
    	$precios = getPrecios( $adicionales[$tipo] );
    }
    
	$servicios = $wpdb->get_results( "SELECT * FROM wp_posts WHERE ID = ".get_the_ID() );
	$productos = '<div class="row">';
	foreach ($servicios as $servicio) {
        $tamanos = array();
        $tamanos_servicio = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_parent = '{$servicio->ID}' AND post_type = 'bookable_person' AND post_status = 'publish' ");
        foreach ($tamanos_servicio as $tamano ) {
        	$tamanos[] = get_tamano($tamano->post_title, "$40.00", false, $busqueda["tamanos"], "ARRAY");
        }
	}

	$transporte = getTransporte($adicionales);
	if( $transporte != "" ){
		$transporte = '
			<div class="km-service-title"> TRANSPORTACI&Oacute;N </div>
			<div class="km-services">
				<select id="transporte" name="transporte" class="km-input-custom"><option value="">Seleccione una opci&oacute;n</option>'.$transporte.'</select>
			</div>
		';
	}

	$adicionales = getAdicionales($adicionales);
	if( $adicionales != "" ){
		$adicionales = '
			<div class="km-service-title"> SERVICIOS ADICIONALES </div>
			<div id="adicionales" class="km-services">
				'.$adicionales.'
			</div>
		';
	}

	$productos .= '</div>';

	/*
 		<!--
		<form id="reservar">

			<label class="titulos_inputs">Fechas:</label>
			<div id="fechas_container" class="inputs_container">
				<div class="input_fechas_box">
					<input type="text" id="checkin" name="checkin" placeholder="DESDE" value="'.$busqueda["checkin"].'" class="km-input-custom km-input-date date_from" readonly>
				</div>
				<div class="input_fechas_box">
					<input type="text" id="checkout" name="checkout" placeholder="HASTA" value="'.$busqueda["checkout"].'" class="km-input-custom km-input-date date_to" readonly>
	 			</div>
 			</div>

			<label class="titulos_inputs">Tama&ntilde;os:</label>
			<div class="inputs_container">
 				'.$precios.'
 			</div>

			'.$transporte.'
 		</form>
 		-->
	*/

	$HTML .= '
 		<script> var SERVICIO_ID = "'.get_the_ID().'"; </script>


 		<form id="reservar" class="km-content km-content-reservation">
			<div class="km-col-steps">
				<div class="km-col-content">
					<ul class="steps-numbers">
						<li><span class="number active">1</span></li>
						<li class="line"></li><li><span class="number">2</span></li>
						<li class="line"></li><li><span class="number">3</span></li>
					</ul>

					<div class="km-title-step">
						RESERVACIÓN
					</div>

					<div class="km-sub-title-step">
						Reserva las fechas y los servicios con tu cuidador(a) '.$cuidador_name.'
					</div>

					<div class="km-dates-step">
						<div class="km-ficha-fechas">
							<input type="text" id="checkin" name="checkin" placeholder="DESDE" value="'.$busqueda["checkin"].'" class="date_from" readonly>
							<input type="text" id="checkout" name="checkout" placeholder="DESDE" value="'.$busqueda["checkout"].'" readonly>
						</div>
					</div>

					<div class="km-content-step">
						<div class="km-content-new-pet">
							'.$precios.'
							<div class="km-services-content">
								'.$transporte.'
								'.$adicionales.'
							</div>

							<div class="km-services-total">
								<div class="valido">
									<span class="km-text-total">TOTAL</span>
									<span class="km-price-total">$0.00</span>
								</div>
								<div class="invalido">
									
								</div>
							</div>

						</div>
					</div>

					<div class="km-text-end-form">
						* Precio final (incluye cobertura veterinaria y gastos administrativos; no incluye servicios adicionales)
					</div>

					<a href="#" class="km-end-btn-form">
						<span>SIGUIENTE</span>
					</a>

				</div>
			</div>

			<div class="km-col-empty">
				<br><br><br><br><br><br><br><br>
				<img src="'.getTema().'/images/new/bg-cachorro.png" style="max-width: 100%;">
			</div>
		</form>

		<!-- SECCIÓN BENEFICIOS -->
		<div class="km-beneficios km-beneficios-footer" style="margin-top: 60px;">
			<div class="container">
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
							<img src="'.getTema().'/images/new/km-certificado.svg">
						</div>
						<div class="km-beneficios-text">
							<h5 class="h5-sub">CUIDADORES CERTIFICADOS</h5>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="km-beneficios-icon">
							<img src="'.getTema().'/images/new/km-veterinaria.svg">
						</div>
						<div class="km-beneficios-text">
							<h5 class="h5-sub">COBERTURA VETERINARIA</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
 	';

	echo comprimir_styles($HTML);
?>