<?php 
// Subscribe 
require_once('core/ControllerCtrParticipantes.php');
// Parametros: Filtro por fecha
$date = getdate();
$desde = date("Y-m-01", $date[0] );
$hasta = date("Y-m-d", $date[0]);
if(	!empty($_POST['desde']) && !empty($_POST['hasta']) ){
	$desde = (!empty($_POST['desde']))? $_POST['desde']: "";
	$hasta = (!empty($_POST['hasta']))? $_POST['hasta']: "";
}
// Buscar Reservas
$landing = 'kmimos-mx-clientes-referidos';
$subscribe = getListsuscribe($landing, $desde, $hasta);
?>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_title">
			<h1>Panel de Control <small>Lista de participantes  ( Club Patitas Felices )</small></h1>
			<div class="clearfix"></div>
		</div>
		<!-- Filtros -->
		<div class="row text-right"> 
			<div class="col-sm-12">
		    	<form class="form-inline" action="/wp-admin/admin.php?page=bp_participantes_club_patitas_felices" method="POST">
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
						  <input type="date" class="form-control" name="hasta" value="<?php echo $hasta; ?>">
						</div>
					</div>
					<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar</button>			  
			    </form>
				<hr>  
			</div>
		</div>
	</div>
  	<div class="col-sm-12">  	

  	<?php if( empty($subscribe) ){ ?>
  		<!-- Mensaje Sin Datos -->
	    <div class="row alert alert-info"> No existen registros </div>
  	<?php }else{ ?>  		
	    <div class="row"> 
	    	<div class="col-sm-12" id="table-container" 
	    		style="font-size: 10px!important;">
	  		<!-- Listado de subscribe -->
			<table id="tblsubscribe" class="table table-striped table-bordered dt-responsive table-hover table-responsive nowrap datatable-buttons" 
					cellspacing="0" width="100%">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Landing</th>
			      <th>Email</th>
			      <th>Cant. Reservas Ref.</th>
			      <th>Fecha Suscripción</th>
			      <th>Fecha Registro</th>
			      <th>Tipo de Usuario</th>
			      <th>Estatus</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $count=0; ?>
			  	<?php while( $row = $subscribe->fetch_assoc() ){
			  		$cant_reservas = get_total_reservas( $row['email'] );
			  		if( count($cant_reservas['rows']) > 0 ){
			  			$cant_reservas = $cant_reservas['rows'][0];
			  		}
			  		
			  	?>
				    <tr>
				    	<th class="text-center"><?php echo ++$count; ?></th>
						<th><?php echo $row['source']; ?></th>
						<th>
							<a href="/wp-admin/admin.php?page=bp_referidos_club_patitas_felices&ref=<?php echo $row['email']; ?>">
								<?php echo $row['email']; ?>	
							</a>
						</th>
						<th class="text-center"><?php echo ($cant_reservas['total_reservas']>0)?$cant_reservas['total_reservas']: 0; ?></th>
						<th class="text-center"><?php echo $row['fecha']; ?></th>
						<th class="text-center"><?php echo $row['fecha_registro']; ?></th>
						<th class="text-center"><?php echo $row['tipo']; ?></th>
						<th class="text-center"><?php echo $row['estatus']; ?></th>
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

