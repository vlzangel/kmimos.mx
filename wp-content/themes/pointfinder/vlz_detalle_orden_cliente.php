<?php 

	/*
		Template Name: vlz detalle orden cliente
	*/

	get_header();

		$valores = explode("/", $_SERVER['REDIRECT_URL']);
		$orden = $valores[ count($valores)-2 ] ?>

		<section role="main">
			<div class="pf-container clearfix">
				<div class="pf-row clearfix">
					<div style="padding: 20px 0px">

						<?php 
							echo kmimos_style(
								array(
									"limpiar_tablas",
									"tablas",
									"celdas"
								)
							); 

							include("./wp-content/themes/pointfinder/vlz/admin/ver_orden.php");

							//CLASS BOOKING
							$_kmimos_booking->Booking_Details($orden);
						?>

						<section>
							<div class="vlz_titulos_superior">
								<a href="<?php echo get_home_url()."/perfil-usuario/?ua=invoices"; ?>" style="color: #00d2b7; border: solid 1px; padding: 3px 10px; margin: 0px; display: inline-block;">
									Volver
								</a> - Detalles de la reserva - <?php echo $orden; ?>
							</div>
						</section>

						<section>
							<div class="cell25">
								<?php //echo $_kmimos_tables->Create_Table_Client($_kmimos_booking->user_client,$_kmimos_booking->user_meta_client); ?>
								<?php echo $_kmimos_tables->Create_Table_Caregiver($_kmimos_booking->user_caregiver,$_kmimos_booking->user_meta_caregiver); ?>
								<?php echo $_kmimos_tables->Create_Table_Service($orden); ?>
							</div>
							<div class="cell75">
								<?php echo $_kmimos_tables->Create_Table_Pets($_kmimos_booking->user_client); ?>
								<?php //echo $_kmimos_tables->Create_Table_Confirmation($orden); ?>
								<div class="vlz_titulos_tablas">Detalles de facturación</div>
								<div class="vlz_contenido_tablas">
									<?php echo $detalles_factura; ?>
								</div>

							</div>
						</section>

					</div>
				</div>
			</div>
		</section> <?php

	get_footer(); 
?>