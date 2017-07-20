<?php

    date_default_timezone_set('America/Mexico_City');
	
    $formaction = 'pf_refineinvlist';
    $noncefield = wp_create_nonce($formaction);
    $buttonid = 'pf-ajax-invrefine-button';

    global $wpdb;
    global $current_user;

    $user_id = $current_user->ID;

    $servicios = array(
		2598 => "Hospedaje",
		2599 => "Guardería",
		2602 => "Adiestramiento Básico",
		2606 => "Adiestramiento Intermedio",
		2607 => "Adiestramiento Avanzado",
		2601 => "Paseos"
	);

    $productos 	= $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_author = '{$user_id}' AND post_type = 'product'");
    $rangos = array();
    foreach ($productos as $key => $value) {
    	$temporal = $wpdb->get_var("SELECT meta_value FROM wp_postmeta WHERE post_id = '{$value->ID}' AND meta_key = '_wc_booking_availability' ");
    	$servicio = $wpdb->get_results("SELECT term_taxonomy_id FROM wp_term_relationships WHERE object_id = '{$value->ID}' ");
    	$temp = unserialize( $temporal );
    	$xrangos = "";
	    if( $temp != '' ){
	    	$xrangos = array();
		    foreach ($temp as $key2 => $value2) {
		    	if( $value2['from'] != '' && $value2['to'] != '' ){
			    	$xrangos[] = array(
			    		"from" => $value2['from'],
			    		"to" => $value2['to']
			    	);
		    	}
		    }
	    }
	    $rangos[] = array(
	    	"servicio_id" => $value->ID,
	    	"servicio" => $servicios[ $servicio[1]->term_taxonomy_id ],
	    	"rangos" => $xrangos
	    );
    }

    // echo "<pre>";
    // 	print_r( $rangos );
    // echo "</pre>";

    $tabla = "
    	<table class='tabla_disponibilidad'>
    		<tr>
    			<th> Servicio </th>
    			<th> Desde </th>
    			<th> Hasta </th>
    			<th> Acción </th>
    		</tr>
    ";

    $opciones = "";
    foreach ($rangos as $value) {
    	$servicio_id = $value['servicio_id'];
    	$servicio = $value['servicio'];
    	$opciones .= "<OPTION value='{$servicio_id}' >{$servicio}</OPTION>";
    	if( $value['rangos'] != "" ){
    		foreach ($value['rangos'] as $rango) {
		    	$tabla .= "
		    		<tr>
		    			<td> {$servicio} </td>
		    			<td> {$rango['from']} </td>
		    			<td> {$rango['to']} </td>
		    			<td class='acciones' > 
		    				<SELECT name=''>
								<OPTION>Selecciona una opción</OPTION>
								<OPTION>Editar</OPTION>
								<OPTION>Eliminar</OPTION>
							</SELECT> 
						</td>
		    		</tr>
		    	";
	    	}
    	}
    }

    $tabla .= "</table>";

    $this->FieldOutput .= '
	    <style>
	    	.fechas_box{
				overflow: hidden;
			}
			.fechas_item{
				float: left;
				width: 33.33333333%;
				box-sizing: border-box;
				padding: 5px;
				overflow: hidden;
				position: relative;
			}
			.fechas_item i{
			    position: absolute;
			    top: 11px;
			    font-size: 25px;
			    color: #777;
			    left: 10px;
			}

			.fechas_item input,
			.fechas_item select
			{
			    width: 100%;
			    border: solid 1px #CCC;
			    font-size: 16px;
			    padding: 5px 10px 5px 35px;
			    cursor: pointer;
			    line-height: 1.42857143;
			}

			.fechas_item select{
				width: 100%;
			    border: solid 1px #CCC;
			    font-size: 16px;
			    padding: 5px 10px;
			    outline: none !important;
			}

			.fechas_item select:focus{
			    outline: none !important;
			}

			.table_main {
				margin-top: 10px;
			}

			.table_main table {
			    width: 100%;
			    font-family: "Open Sans",Arial, Helvetica, sans-serif;
			    font-size: 12px;  
			    text-align: left;    
			    border-collapse: collapse; 
		        border: 0px solid #ddd;
			    padding: 0px;
			    margin: 0px;
			}

			.table_main th {     
			    font-size: 14px;     
			    font-weight: normal;     
			    padding: 8px;     
			    background: #59c9a8;
			    border-bottom: 1px solid #fff; 
			    color: #FFF; 
			}

			.table_main td {    
    			padding: 10px 10px 0px;
			    background: #f1f1f1;
			    border-bottom: 1px solid #fff;
			    border-top: 1px solid transparent;
			    vertical-align: top;
			    font-size: 13px;
			    color: #444;
			}

			.table_main th:nth-last-child(1),  
			.table_main td:nth-last-child(1) {    
			    width: 170px;
			}

			.table_main td a{    
			    color: #000; 
			}

			.table_main td a:hover{    
			    color: #2f9c7c;
			}

			.table_main tr:hover td { 
			    background: #e0e0e0; 
			    color: #444; 
			}

			.table_main td select{    
			    padding: 3px 0px;
			    width: 100%;
			    background-color: #59c9a8;
			    border: 0;
			    outline: none;
			    box-shadow: 0px 0px 0px #000;
			    color: #FFF;
			}

			.table_main td select:focus{  
			    outline: none;
			    box-shadow: 0px 0px 0px #000;
			}

			.table_main .cancelled {
			    background-color: red;
			}

			.acciones{
				padding: 5px !important;
			}

			.botones_container{
				display: block;
				overflow: hidden;
			}

			.botones_box{
			    display: inline-block;
			    float: right;
			    width: 33.33333333%;
			    padding: 5px;
			    box-sizing: border-box;
			}

			.botones_box input{
				padding: 10px 0px;
			    width: 100%;
			}

			.fechas{
				display: none;
			}
	    </style>
	    
	    <h1>Disponibilidad</h1><br><hr>

		<div class="fechas_box table_main tabla_disponibilidad_box"> 
			'.$tabla.'

			<div class="botones_container">
		        <div class="botones_box">
		        	<input type="button" id="editar_disponibilidad" value="Editar Disponibilidad" />
		        </div>
	        </div> 
		</div>

		<div class="fechas" >
			<div class="fechas_box " >

				<div class="fechas_item">
					<SELECT id="servicio" name="servicio">
						'.$opciones.'					
					</SELECT>
		        </div>

				<div class="fechas_item">
					<i class="icon-calendario embebed"></i>
			        <input type="date" id="inicio" name="inicio" class="fechas" placeholder="Inicio" min="'.date("Y-m-d").'">
		        </div>

				<div class="fechas_item">
					<div class="icono"><i class="icon-calendario embebed"></i></div>
			        <input type="date" id="fin" name="fin" class="fechas" placeholder="Fin" disabled>
		        </div>
		    </div>

	        <div class="botones_container">
		        <div class="botones_box">
		        	<input type="button" id="guardar_disponibilidad" value="Guardar" />
		        </div>
	        </div>
	    </div>

	    <script>
	    	function editar_disponibilidad(){
	    		jQuery(".fechas").css("display", "block");
	    		jQuery(".tabla_disponibilidad_box").css("display", "none");
	    	}

	    	function guardar_disponibilidad(){
	    		// jQuery(".fechas").css("display", "none");
	    		// jQuery(".tabla_disponibilidad_box").css("display", "block");

	    		var ini = jQuery("#inicio").val();
	    		var fin = jQuery("#fin").val();

	    		if( ini == "" || fin == "" ){
	    			alert("Debes seleccionar las fechas primero");
	    		}else{
		    		jQuery.post(
				   		"'.get_template_directory_uri().'/vlz/admin/process/new_disponibilidad.php", 
				   		{
				   			servicio: jQuery("#servicio").val(),
				   			inicio: ini,
				   			fin: fin,
				   		},
				   		function(data){
					   		// console.log(data);
					   		location.reload();
					   	}
				   	);
	    		}
	    	}

	    	jQuery("#editar_disponibilidad").on("click", function(e){
	    		editar_disponibilidad();
	    	});

	    	jQuery("#guardar_disponibilidad").on("click", function(e){
	    		guardar_disponibilidad();
	    	});

			function seleccionar_checkin() {
			    if( jQuery("#inicio").val() != "" ){
			        var fecha = new Date();
			        jQuery("#fin").attr("disabled", false);

			        var ini = String( jQuery("#inicio").val() ).split("-");
			        var inicio = new Date( parseInt(ini[2]), parseInt(ini[1]), parseInt(ini[0]) );

			        console.log( jQuery("#fin").val() );

			        var fin = String( jQuery("#fin").val() ).split("-");
			        var fin = new Date( fin[0]+"-"+fin[1]+"-"+fin[2] );

			        if( jQuery("#fin").val() != "" ){
			        	if( Math.abs(fin.getTime()) < Math.abs(inicio.getTime()) ){
				            jQuery("#fin").attr("value", ini[0]+"-"+ini[1]+"-"+ini[2] );
				        }
			        }else{
			        	jQuery("#fin").attr("value", ini[0]+"-"+ini[1]+"-"+ini[2] );
			        }
				        
			        jQuery("#fin").attr("min", ini[0]+"-"+ini[1]+"-"+ini[2] );
			    }else{
			        jQuery("#fin").val("");
			        jQuery("#fin").attr("disabled", true);
			    }
			}

	    	jQuery("#inicio").on("change", function(e){
	    		seleccionar_checkin();
	    	});
	    </script>
    ';
?>