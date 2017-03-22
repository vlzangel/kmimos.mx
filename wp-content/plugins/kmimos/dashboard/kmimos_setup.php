<?php
	$ejecutar = false;

	if( $_GET['crear_roles'] == 'si'){
		if( get_role('customer_service') ){
		    remove_role( 'customer_service' );
		}

		if( kmimos_new_role() ){
			$msg = "Se crearon los nuevos roles correctamente!";
		}else{
			$msg = "Los roles ya existen!";
		}
		$ejecutar= true;
	}

?>
<style type="text/css">
	.kmimos_btn{
		text-decoration: none;
	    border: solid 1px #00d3b8;
	    padding: 5px 10px;
	    background: #00d3b8;
	    color: #FFF;
	    font-weight: 600;
	}
	.kmimos_msgs{
	    background: #00d3b8;
	    color: #FFF;
	    padding: 10px;
	    border-radius: 4px;
	}
</style>
<div class="wrap">

	<?php
		if( $msg != "" ){
			echo "<div class='kmimos_msgs'>{$msg}</div>";
		}
	?>
	
	<?php screen_icon();?><h2>Sistema de Administración de Kmimos - Configuración</h2>
	<form method="post" action="options.php">
		<?php settings_fields('kmimos_group'); ?>
		<?php @do_settings_fields('kmimos_group'); ?>
		<table class="form-table">
			<tr class="valign: top">
				<th scope="row">
					<label for="kmimos_title_plugin">Crear Roles</label>
				</th>
				<td>
					<a href="?page=kmimos-setup&crear_roles=si" class="kmimos_btn">Crear</a>
				</td>
			</tr>
		</table>
		<?php @submit_button(); ?>

	</form>

</div>
<?php

	if( $ejecutar ){
		echo " <script> location.href = '?page=kmimos-setup'; </script> ";
	}
	
?>