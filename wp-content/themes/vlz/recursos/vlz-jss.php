<script type="text/javascript">

	function buscar_inicio(){
		var est = $("#estado").val();
		var mun = $("#municipio").val();
		jQuery.ajax({
		    url: '<?php echo get_template_directory_uri()."/funciones/buscador.php"; ?>',
		    type: "post",
		    data: {
				estado: est,
				municipio: mun
			},
		    success: function (data) {
		    	console.log(data);
	      		data = eval(data);
	      		var html = "";
	      		$.each(data, function( index, value ) {
				  	html += item_cuidador(value);
				});
				$("#resultados").html(html);
		    }
		});
	}

	function buscar_municipio(val_estado, id_municipio){
		jQuery.ajax({
		    url: '<?php echo get_template_directory_uri()."/funciones/municipio.php"; ?>',
		    type: "post",
		    data: {
				estado: val_estado
			},
		    success: function (data) {
	      		$("#"+id_municipio).html(data);
		    }
		});
	}

	function item_cuidador(datos){
		var html = "";
		html += "<div class='vlz_contenedor_cuidador'>";
		html += 	"<div class='vlz_contenedor_foto' style='background-image: url("+datos.img+");'></div>";
		html += 	"<div class='vlz_foto' style='background-image: url("+datos.img+");'></div>";
		html += 	"<div class='vlz_nombre'>"+datos.nom+" "+datos.ape+"</div>";
		html += 	"<div class='vlz_precio'>Desde: MXN "+datos.pre+" por noche</div>";
		html += 	"<a class='vlz_link' href='<?php echo get_home_url(); ?>/cuidador/"+datos.id+"/'></a>";
		html += "</div>";

		return html;
	}

	$(document).ready(function(){ 
		<?php
			$estados = $wpdb->get_results("SELECT * FROM states ORDER BY name ASC");
			$ests = "<option>Seleccione un Estado</option>";
			foreach ($estados as $value) {
				$ests .= utf8_decode( "<option value={$value->id}>{$value->name}</option>" );
			}
			echo "
				$('#estado').html('{$ests}');
				$('#estado option[value=1]').attr('selected', true);
				buscar_inicio();
			";
		?>
	});
	
</script>