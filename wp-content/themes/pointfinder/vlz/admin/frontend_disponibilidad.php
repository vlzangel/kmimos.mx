<?php
	
    $formaction = 'pf_refineinvlist';
    $noncefield = wp_create_nonce($formaction);
    $buttonid = 'pf-ajax-invrefine-button';

    global $wpdb;
    global $current_user;

    $user_id = $current_user->ID;

    $hospedaje 	= $wpdb->get_var("SELECT ID FROM wp_posts WHERE post_author = '{$user_id}' AND post_type = 'product' AND post_name LIKE '%hospedaje%' ");
    $rangos 	= unserialize( $wpdb->get_var("SELECT meta_value FROM wp_postmeta WHERE post_id = '{$hospedaje}' AND meta_key = '_wc_booking_availability' ") );

    $tabla = "
    	<table class='tabla_disponibilidad'>
    		<tr>
    			<th> Servicio </th>
    			<th> Desde </th>
    			<th> Hasta </th>
    			<th> Acción </th>
    		</tr>
    ";

    foreach ($rangos as $value) {
    	if( $value['from'] != '' && $value['to'] != '' ){
	    	$tabla .= "
	    		<tr>
	    			<td> Hospedaje </td>
	    			<td> {$value['from']} </td>
	    			<td> {$value['to']} </td>
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

    $tabla .= "</table>";

    // echo "<pre>";
    // 	print_r($rangos);
    // echo "</pre>";

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
	    </style>
	    
	    <h1>Disponibilidad</h1><br><hr>

		<div class="fechas_box table_main">
			'.$tabla.'
		</div>

		<div class="fechas_box">
			<div class="fechas_item">
				<SELECT name="servicio">
					<OPTION>Hospedaje</OPTION>
					<OPTION>Guardería</OPTION>
				</SELECT>
	        </div>

			<div class="fechas_item">
				<i class="icon-calendario embebed"></i>
		        <input type="date" id="inicio" name="inicio" class="fechas" placeholder="Inicio" value="'.date("Y-m-d").'" min="'.date("Y-m-d").'">
	        </div>

			<div class="fechas_item">
				<div class="icono"><i class="icon-calendario embebed"></i></div>
		        <input type="date" id="fin" name="fin" class="fechas" placeholder="Fin" disabled>
	        </div>
	    </div>
    ';
?>