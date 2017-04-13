<?php global $wpdb;
// Reservas 
require_once('core/ReservasController.php');
// Parametros: Filtro por fecha
$date = getdate();
$desde = date("Y-m-01", $date[0] );
$hasta = date("Y-m-d", $date[0]);
if(	!empty($_POST['desde']) && !empty($_POST['hasta']) ){
	$desde = (!empty($_POST['desde']))? $_POST['desde']: "";
	$hasta = (!empty($_POST['hasta']))? $_POST['hasta']: "";
}
// Buscar Reservas
$reservas = getReservas($desde, $hasta);
?>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
  <div class="x_title">
    <h2>Panel de Control <small>Reservas</small></h2>
    <hr>
    <div class="clearfix"></div>
  </div>
  <div class="col-sm-12">
  	
	<!-- Filtros -->
    <div class="row text-right"> 
    	<div class="col-sm-12">
	    	<form class="form-inline" action="/wp-admin/admin.php?page=bp_Reservas" method="POST">
			  <label>Filtrar:</label>
			  <div class="form-group">
			    <div class="input-group">
			      <div class="input-group-addon">Desde</div>
			      <input type="date" class="form-control" name="desde" value="<?php echo $desde; ?>">
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="input-group">
			      <div class="input-group-addon">Hasta</div>
			      <input type="date" class="form-control" name="hasta" value="<?php echo $hasta ?>">
			    </div>
			  </div>
				<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>			  
		    </form>
			<hr>  
		</div>
    </div>

  	<?php if( empty($reservas) ){ ?>
  		<!-- Mensaje Sin Datos -->
	    <div class="row alert alert-info"> No existen registros </div>
  	<?php }else{ ?>  		
	    <div class="row"> 
	    	<div class="col-sm-12" style="">
	  		<!-- Listado de Reservas -->
			<table 	id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" 
					cellspacing="0" width="100%">
			  <thead>
			    <tr>
			      <th width="1%"></th>
			      <!-- Row Principal %-->
			      <th width="20%">Estatus</th>
			      <th width="10%">Fecha Solicitud</th>
			      <th width="10%"># Reserva</th>
			      <th width="30%">Nombre del Cliente</th>
			      <th width="5%">Desde</th>
			      <th width="5%">Hasta</th>
			      <th width="5%"># Noches</th>
			      <th width="5%"># Pedido</th>
			      <th width="5%"># Mascotas</th>
			      <th width="5%">Estado</th>
			      <th width="5%">Municipio</th>
			      <th width="10%">Total a pagar</th>	      
			      <!-- Detalle 100%-->
			      <th width="100%">Observaci&oacute;n</th>
			      <th width="100%">Forma de Pago</th>	      
			      <th width="100%">Monto Pagado</th>
			      <th width="100%">Total Noches</th>
			      <th width="100%">Monto Remanente</th>
			      <th width="100%">Nombre del Cuidador</th>
			      <th width="100%">Servicios</th>
			      <th width="100%">Mascotas</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $count=0; ?>
			  	<?php foreach( $reservas as $reserva ){ ?>
 
				  	<?php 
				  		// *************************************
				  		// Cargar Metadatos
				  		// *************************************
				  		# Mascotas del Cliente
				  		$mypets = getMascotas($reserva->cliente_id); 
				  		# Servicios de la Reserva
				  		$services = getServices($reserva->nro_reserva);
				  		# Status
				  		$estatus = get_status(
				  			$reserva->estatus_reserva, 
				  			$reserva->estatus_pago, 
				  			$reserva->metodo_pago_pk 
				  		);
				  	?>
 
				    <tr>
				    	<th class="text-center"><small class="hidden"><?php echo ++$count; ?></small></th>
						<th class="text-center"><?php echo $estatus['sts_corto']; ?></th>
						<th class="text-center"><?php echo $reserva->fecha_solicitud; ?></th>
						<th><?php echo $reserva->nro_reserva; ?></th>
						<th><?php echo $reserva->cliente_nombre; ?></th>
						<th><?php echo $reserva->desde; ?></th>
						<th><?php echo $reserva->hasta; ?></th>
						<th class="text-center"><?php echo $reserva->nro_noches; ?></th>
						<th><?php echo $reserva->nro_pedido; ?></th>
						<th class="text-center"><?php echo $reserva->nro_mascotas; ?></th>
						<th><?php echo utf8_decode( $reserva->estado ); ?></th>
						<th><?php echo utf8_decode( $reserva->municipio ); ?></th>
						<th><?php echo $reserva->monto_total; ?></th>
						<th><span class="label label-primary"><?php echo $estatus['sts_largo']; ?></span></th>
						<th><?php echo $reserva->forma_pago; ?></th>			
						<th><?php echo $reserva->monto_pagado; ?></th>
						<th><?php echo $reserva->total_noches; ?></th>
						<th><?php echo $reserva->monto_remanente; ?></th>
						<th><?php echo $reserva->cuidador_nombre; ?></th>
						<!-- Producto Titulo -->
						<!-- th class='hidden'><?php echo $reserva->producto_title; ?></th -->
						<th class="text-left ">
							<article class="col-sm-12">
								<h4 class="alert alert-success">
									<?php echo $reserva->producto_title; ?>
								</h4>
							</article>
							<article class="col-sm-12">
								<p><strong>SERVICIOS ADICIONALES</strong></p>
								<div class="row">
								<?php foreach( $services as $service ){ ?>
									<div class="col-sm-6">
										<div class="row services-item">
											<span class="col-sm-7 text-left">
												<i class="fa fa-check-square-o" aria-hidden="true"></i>
												<?php echo str_replace("(precio por mascota)", "", $service->descripcion); ?>
											</span>
											<span class="col-sm-4">
												<?php echo str_replace("Servicios Adicionales", "", $service->servicio); ?> 
											</span>
										</div>
									</div>
								<?php } ?>
								</div>
							</article>
						</th>
						<!-- Producto Titulo -->
						<!-- Producto Adicionales -->
						<!-- th class="hidden">
							<?php foreach( $mypets as $pet_id => $pet){ ?>
							[ <?php echo $pet['name']; ?> ] 
							<?php } ?>
						</th -->
						<th > 
							<hr>
							<section class="col-sm-12">
								<div class="row">

								<?php foreach( $mypets as $pet_id => $pet){ ?>
									<article class="col-sm-6 col-md-3">
									    <div class="thumbnail">
									      <img src="<?php echo photo_exists($pet['photo']); ?>" alt="..." class="img-responsive" >
									      <div class="caption">
									        <h4><strong><?php echo $pet['name']; ?></strong></h4>
									        <div class="row">
									        	<span class="col-sm-4 text-left">Tamaño:</span> 
									        	<span class="col-sm-7"><?php echo $pet['size']; ?></span>
									        </div>
									        <div class="row">
									        	<span class="col-sm-4 text-left">Raza:</span> 
									        	<span class="col-sm-7"><?php echo $pet['raza_nombre']; ?></span>
									        </div>
									        <div class="row">
									        	<span class="col-sm-4 text-left">Color:</span> 
									        	<p class="col-sm-7"><?php echo $pet['colors']; ?></p>
									        </div>
									        <div class="row">
									        	<span class="col-sm-4 text-left">Edad:</span> 
									        	<span class="col-sm-7"><?php echo getEdad( $pet['birthdate'] ); ?></span>
									        </div>
									        <div class="row">
									        	<span class="col-sm-4 text-left">Esterilizado:</span>
									        	<span class="col-sm-7">
									        	<?php echo ($pet['strerilized']==1 )? 
									        		'<span class="label label-success">Si</span>' : 
									        		'<span class="label label-warning">No</span>' ; 
									        	?>
									        	</span>
									        </div>
									        <div class="row">
	 								        	<span class="col-sm-4 text-left">Agresivo:</span>
	 								        	<span class="col-sm-7">
		 								        	<?php echo ($pet['aggresive_humans']==1)? 
										        		'<span class="label label-warning">Humanos</span>' : ''; ?>
									        		<?php echo ($pet['aggresive_pets']==1)? 
										        		'<span class="label label-warning">Mascotas</span>' : ''; ?>
									        		<?php echo ($pet['aggresive_pets']==0 and $pet['aggresive_humans']==0)? 
										        		'<span class="label label-success">No</span>' : ''; ?>
									        	</span>
									        </div>
									        <div class="row">
									        	<span class="col-sm-4 text-left">Sociable:</span> 
									        	<span class="col-sm-7">
													<span class="label label-<?php echo ($pet['sociable']==1)? 'success' : 'warning'; ?>">
												        <?php echo ($pet['sociable']==1)? 'Si' : 'No'; ?>
												    </span>
											    </span>
									        </div>

									      </div>
									    </div>
									</article>
								<?php } ?>
									
								</div>
							</section>
						</th>
						<!-- Producto Adicionales -->

				    </tr>
			   	<?php } ?>
			  </tbody>
			</table>
			</div>
		</div>
	<?php } ?>	
  </div>
</div>
</div>
<div class="clearfix"></div>	
