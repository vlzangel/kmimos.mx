
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<?php echo kmimos_style( array("celdas") ); ?>

<link rel="stylesheet" href="<?php echo get_home_url()."/wp-content/plugins/kmimos/dashboard/setup/css/setup_css.css"; ?>">
<script type="text/javascript"> var SETUP_URL_AJAX = "<?php echo get_home_url()."/wp-content/plugins/kmimos/dashboard/ajaxs.php"; ?>"; </script>
<script type="text/javascript" src="<?php echo get_home_url()."/wp-content/plugins/kmimos/dashboard/setup/js/setup_scripts.js"; ?>"></script>

<div class="wrap">

	<?php 
		settings_fields('kmimos_group');
		@do_settings_fields('kmimos_group');
	?>

	<div>

	    <div class="row">
	        <div class="col-md-12">
				<h2 class="kmimos_titulos">Sistema de Administración de Kmimos - Configuración</h2>
			</div>
		</div>

	    <div class="row" style="overflow: hidden;">

	        <div class="col-md-6">
	        	<div style='position: relative;'>
	        		<div class='kmimos_modal_interno' id='editar_tipo_usuario_modal'>
		        		<div class='kmimos_modal_interno_celda'>
		        			<div class='kmimos_modal_interno_area'>
			        			<select id='tipo_usuario' class='kmimos_select'>
									<option>Administrador</option>
									<option>Customer Service</option>
								</select>
								<input type='hidden' id='user_id'>
								<input type="button" value="Guardar" onclick="update_tipo_usuario()" >
			        		</div>
		        		</div>
	        		</div>

					<table width="100%">
						<thead style="border-right: solid 1px #CCC;">
							<tr>
								<th> Usuario </th>
								<th> Email </th>
								<th style="width: 80px;">
									Tipo
								</th>
							</tr>
						</thead>
						<tbody id="kmimos_panel_setup"></tbody>
					<tfoot>
						<tr>
							<th colspan='3' id='kmimos_panel_setup_paginacion'>
								
							</th>
						</tr>
					</tfoot>
					</table>
				</div>

			</div>
	        <div class="col-md-6">
				<div class='kmimos_modal_interno' id='editar_descripcion_modal'>
	        		<div class='kmimos_modal_interno_celda'>
	        			<div class='kmimos_modal_interno_area'>
		        			<textarea id='descripcion' style='display: block; width: 500px; height: 200px;'></textarea>
							<input type='hidden' id='page_id'>
							<div class="kmimos_botonera">
								<input type="button" value="Guardar" onclick="update_descripcion()" >
							</div>
		        		</div>
	        		</div>
	    		</div>
				<table width="100%">
					<thead>
						<tr>
							<th>
								Pagina
							</th>
							<th style="width: 50%;">
								Descripción
							</th>
						</tr>
					</thead>
					<tbody id="kmimos_setup_descripciones"></tbody>
					<tfoot>
						<tr>
							<th colspan='2' id='kmimos_setup_descripciones_paginacion'>
								
							</th>
						</tr>
					</tfoot>
				</table>
			</div>

		</div>

</div>

