
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<style type="text/css">
	body{
	    background: transparent;
	}
	.kmimos_btn{
		text-decoration: none;
	    border: solid 1px #00d3b8;
	    padding: 5px 10px;
	    background: #00d3b8;
	    color: #FFF;
	    font-weight: 600;
	}
	.kmimos_titulos{
        border-bottom: solid 3px #b5b5b5;
        line-height: 1.5;
	}
	.kmimos_select{
	    background: transparent;
	    border: solid 0px;
	    box-shadow: 0px 0px 0px;
	    font-size: 12px;
	}
	.kmimos_select:focus{
	    background: transparent;
	    border: solid 0px;
	    box-shadow: 0px 0px 0px;
	}
	th{
	    font-family: Roboto;
	    background: #CCC;
    	padding: 5px;
	}
	td{
		border-bottom: solid 1px #CCC;
	    font-family: Roboto;
	}
	.kmimos_panel_setup{
		height: 200px;
		overflow: auto;
	}
	.submit{
		text-align: right !important;
	}
</style>

<?php
	echo kmimos_style( array("celdas") );
?>

<div class="wrap">

	<?php 
		settings_fields('kmimos_group');
		@do_settings_fields('kmimos_group'); 

		global $wpdb;
	?>

	<div>

	    <div class="row">
	        <div class="col-md-12">
				<h2 class="kmimos_titulos">Sistema de Administración de Kmimos - Configuración</h2>
			</div>
		</div>

	    <div class="row">

	        <div class="col-md-4">

				<?php $sql = "
					SELECT 
						U.user_email AS email,
						U.display_name AS nombre
					FROM 
						wp_users AS U 
					INNER JOIN wp_usermeta AS UM_1 ON ( U.ID = UM_1.user_id ) 
					WHERE 
						1=1 AND 
						( UM_1.meta_key = 'wp_capabilities' AND UM_1.meta_value = 'a:1:{s:13:\"administrator\";b:1;}' ) 
					GROUP BY 
						U.ID
				";
				$administradores = $wpdb->get_results($sql); 

				$tipos = "
					<select class='kmimos_select'>
						<option>Administrador</option>
						<option>Customer Service</option>
					</select>
				";
				?>

				<table width="100%">
					<thead>
						<tr>
							<th>
								Usuario
							</th>
							<th style="width: 80px;">
								Tipo
							</th>
						</tr>
					</thead>
					<tbody class="kmimos_panel_setup">
						<?php
							foreach ($administradores as $key => $value) {
								echo "
									<tr>
										<td>{$value->nombre}</td>
										<td style='width: 80px;'> {$tipos} {$value->tipo} </td>
									</tr>";
							}
						?>
					</tbody>
				</table>

			</div>
	        <div class="col-md-4">
				
			</div>
	        <div class="col-md-4">
				
			</div>

		</div>

	    <div class="row">
	        <div class="col-md-12">
				<?php @submit_button(); ?>
			</div>
		</div>

</div>