
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style type="text/css">
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

	<div class="">

	    <div class="row">
	        <div class="col-md-12">
				<h2 class="kmimos_titulos">Sistema de Administración de Kmimos - Configuración</h2>
			</div>
		</div>

			<?php
				$sql = "
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

				/*
					echo "<pre>";
						print_r($administradores);
					echo "</pre>";
				*/

				echo "<t class='kmimos_'> <select name=''>";
					foreach ($administradores as $key => $value) {
						echo "<option>{$value->nombre}</option>";
					}
				echo "</select>";
			?>

		</div>
        <div class="col-md-4">
			Es una
		</div>
        <div class="col-md-4">
			Prueba
		</div>
	

</div>