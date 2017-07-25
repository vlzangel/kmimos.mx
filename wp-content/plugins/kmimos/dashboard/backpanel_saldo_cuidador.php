<?php global $wpdb;
// PagoCuidador 
require_once('core/ControllerSaldoCuidador.php');
// Buscar PagoCuidador
$PagoCuidador = getPagoCuidador($_desde='', $_hasta='');
?>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_title">
			<h2>Panel de Control <small>PagoCuidador</small></h2>
			<hr>
		</div>
  	</div>
	<div class="clearfix"></div>
  	<div class="col-sm-12">  	

  	<?php if( empty($PagoCuidador) ){ ?>
  		<!-- Mensaje Sin Datos -->
	    <div class="row">
	    	<div class="col-sm-12">
	    		<div class="alert alert-info">
		    		No existen registros
	    		</div>
		    </div>
	    </div> 
  	<?php }else{ ?>  		
	    <div class="row"> 
	    	<div class="col-sm-12" id="table-container" 
	    		style="font-size: 10px!important;">
	  		<!-- Listado de PagoCuidador -->
			<table id="tblPagoCuidador" class="table table-striped table-bordered dt-responsive table-hover table-responsive nowrap datatable-buttons" cellspacing="0" width="100%">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>ID</th>
			      <th>Nombre</th>
			      <th>Apellido</th>
			      <th>Total a pagar</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php $count=0; ?>
			  	<?php foreach( $PagoCuidador as $ID => $row ){ ?>
				    <tr>

				    	<th class="text-center"><?php echo ++$count; ?></th>
				    	<th class="text-center"><?php echo $ID; ?></th>
				    	<th class="text-center"><?php echo $row['nombre']; ?></th>
				    	<th class="text-center"><?php echo $row['apellido']; ?></th>
				    	<th class="text-center"><?php echo $row['total']; ?></th>

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
