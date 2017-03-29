
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

	.kmimos_modal_interno{
		position: fixed;
	    display: none;
	    top: 0px;
	    left: 0px;
	    width: 100%;
	    height: 100%;
	    background: rgba(0,0,0,0.7);
	    z-index: 99999999999999999;
	}

	.kmimos_modal_interno_celda{
		display: table-cell;

		text-align: center;
		vertical-align: middle;
	}

	.kmimos_modal_interno_area{
		display: inline-block;
		padding: 20px;
		background: #FFF;
	}
</style>

<?php
	echo kmimos_style( array("celdas") );
?>

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

	        		<div class='kmimos_modal_interno'>
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
						<thead>
							<tr>
								<th>
									Usuario
								</th>
								<th>
									Email
								</th>
								<th style="width: 80px;">
									Tipo
								</th>
							</tr>
						</thead>
						<tbody class="kmimos_panel_setup"></tbody>
					</table>
				</div>

			</div>
	        <div class="col-md-6">
				<!-- <pre>
					<?php
						print_r($_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/");
					?>
				</pre> -->
			</div>

		</div>

</div>

<script type="text/javascript">

	function refresh(){
		jQuery.ajax({
		    url: "<?php echo get_home_url()."/wp-content/plugins/kmimos/dashboard/ajaxs.php"; ?>",
		    type: "post",
		    data: {
		    	action: "administradores"
		    },
		    success: function (data) {
	      		jQuery(".kmimos_panel_setup").html(data);
	      		jQuery(".editar_tipo_usuario").on("click", function(e){
	      			var user_id = jQuery(this).attr( "data-id" );
	      			var tipo = jQuery(this).attr( "data-tipo" );

	      			jQuery("#tipo_usuario > option[value='"+tipo+"']").attr('selected', 'selected'); 
	      			jQuery("#user_id").attr('value', user_id); 

	      			jQuery(".kmimos_modal_interno").css("display", "table");
	      		});
		    }
		});
	}
	refresh();

	function update_tipo_usuario(){
		var tipo 	 = jQuery("#tipo_usuario").attr('value');
      	var user_id  = jQuery("#user_id").attr('value');
		jQuery.ajax({
		    url: "<?php echo get_home_url()."/wp-content/plugins/kmimos/dashboard/ajaxs.php"; ?>",
		    type: "post",
		    data: {
		    	action: "update_tipo_usuario",
		    	id: 	user_id,
		    	tipo:   tipo
		    },
		    success: function (data) {
      			jQuery(".kmimos_modal_interno").css("display", "none");
      			refresh();
		    }
		});
	}

</script>