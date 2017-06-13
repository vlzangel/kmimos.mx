<?php
	
	include_once('includes/functions/vlz_functions.php');

    if(!function_exists('angel_menus')){
        function angel_menus($menus){
            


            return $menus;
        }
    }

    if(!function_exists('get_data_booking')){
        function get_data_booking($id){
            global $wpdb;
            $metas = get_post_meta($id);
            $servicio = strtotime($metas['_booking_product_id'][0]);
            $cantidad_mascotas = 0;
            $mascotas = unserialize($metas['_booking_persons'][0]);
            foreach ($mascotas as $key => $value) {
                $cantidad_mascotas += $value;
            }
            return array(
                "inicio" => strtotime($metas['_booking_start'][0]),
                "fin" => strtotime($metas['_booking_end'][0]),
                "servicio" => $servicio,
                "mascotas" => $cantidad_mascotas,
                "acepta" => get_post_meta($servicio, "_wc_booking_qty", true),
                "autor" => $wpdb->get_var("SELECT post_author FROM ID = {$servicio}")
            );
        }
    }

    if(!function_exists('update_cupos')){
        function update_cupos($id, $accion){
            global $wpdb;
            $data = get_data_booking($id);
            extract($data);
            $cupos = $wpdb->get_row("SELECT * FROM cupos WHERE servicio = '{$servicio}' AND fecha = '{$fecha}'");
            if( isset($cupos->cupos) ){
                $wpdb->query("UPDATE cupos SET cupos = cupos {$accion} {$mascotas} WHERE servicio = '{$servicio}' AND ( fecha >= '{$inicio}' AND fecha <= '{$fin}' )");
                $wpdb->query("UPDATE cupos SET full = 1 WHERE servicio = '{$servicio}' AND ( fecha >= '{$inicio}' AND fecha <= '{$fin}' AND cupos >= acepta )");
                $wpdb->query("UPDATE cupos SET full = 0 WHERE servicio = '{$servicio}' AND ( fecha >= '{$inicio}' AND fecha <= '{$fin}' AND cupos < acepta )");
            }else{
                for ($i=$inicio; $i < $fin; $i+=86400) { 
                    $fecha = date("Y-m-d H:i:s", $i);
                    $full = 0;
                    if( $mascotas >= $acepta ){ $full = 1; }
                    $sql = "
                        INSERT INTO cupos VALUES (
                            NULL,
                            '{$autor}',
                            '{$servicio}',
                            '{$fecha}',
                            '{$mascotas}',
                            '{$acepta}',
                            '{$full} '        
                        );
                    ";
                    $wpdb->query($sql);
                }
            }
        }
    }

/*    // define the woocommerce_cart_loaded_from_session callback 
    function action_woocommerce_cart_loaded_from_session( $array ) { 
        if ( isset( $cart_item['booking'] ) ) {
            // If the booking is gone, remove from cart!
            $booking_id = $cart_item['booking']['_booking_id'];
            $booking    = get_wc_booking( $booking_id );

            if ( ! $booking || ! $booking->has_status( array( 'was-in-cart', 'in-cart', 'unpaid', 'paid' ) ) ) {
                echo "<br><br><br><br><br>Borrado por inactividad";
            }
        }
    }; 
    add_action( 'woocommerce_cart_loaded_from_session', 'action_woocommerce_cart_loaded_from_session', 10, 1 ); */

    if(!function_exists('vlz_get_paginacion')){
        function vlz_get_paginacion($t, $pagina){
            $paginacion = ""; $h = 15; $inicio = $pagina*$h; 
            $fin = $inicio+$h; if( $fin > $t){ $fin = $t; }
            if($t > $h){
                $ps = ceil($t/$h);
                for( $i=0; $i<$ps; $i++){
                    $active = ( $pagina == $i ) ? "class='vlz_activa'" : "";
                    $paginacion .= "<a href='".$home."/busqueda/".($i)."' ".$active.">".($i+1)."</a>";
                }
            }
            $w = 40*$ps;
            $paginacion .= "<style> .vlz_nav_cont_interno{ width: {$w}px; } </style>";
            return array(
                "inicio" => $inicio,
                "fin" => $fin,
                "html" => $paginacion,
            );
        }
    }

    if(!function_exists('get_destacados')){
        function get_destacados($estado){
            global $wpdb;
            $estado_des = $wpdb->get_var("SELECT name FROM states WHERE id = ".$estado);
            $sql_top = "SELECT * FROM destacados WHERE estado = '{$estado}'";
            $tops = $wpdb->get_results($sql_top);
            $top_destacados = ""; $cont = 0;
            foreach ($tops as $value) {
                $cuidador = $wpdb->get_row("SELECT * FROM cuidadores WHERE id = {$value->cuidador}");
                $data = $wpdb->get_row("SELECT post_title AS nom, post_name AS url FROM wp_posts WHERE ID = {$cuidador->id_post}");
                $nombre = $data->nom;
                $img_url = kmimos_get_foto_cuidador($value->cuidador);
                $url = $home . "/petsitters/" . $data->url;
                $top_destacados .= "
                    <a class='vlz_destacados_contenedor' href='{$url}'>
                        <div class='vlz_destacados_contenedor_interno'>
                            <div class='vlz_destacados_img'>
                                <div class='vlz_descado_img_fondo' style='background-image: url({$img_url});'></div>
                                <div class='vlz_descado_img_normal' style='background-image: url({$img_url});'></div>
                                <div class='vlz_destacados_precio'><sub style='bottom: 0px;'>Hospedaje desde</sub><br>MXN $".($cuidador->hospedaje_desde*1.2)."</div>
                            </div>
                            <div class='vlz_destacados_data' >
                                <div class='vlz_destacados_nombre'>{$nombre}</div>
                                <div class='vlz_destacados_adicionales'>".vlz_servicios($cuidador->adicionales)."</div>
                            </div>
                        </div>
                    </a>
                ";
                $cont++;
            }
            if( $cont > 0 ){
                if( $top_destacados != '' ){
                    $top_destacados = $top_destacados."</div>"; 
                }
                $top_destacados = utf8_decode( '<div class="pfwidgettitle"> <div class="widgetheader">Destacados Kmimos en: '.$estado_des.' '.$municipio_des.'</div> </div> <div class="row" style="margin: 10px auto 20px;">').$top_destacados;
            }

            return comprimir_styles($top_destacados);
        }
    }

    if(!function_exists('vlz_get_page')){
        function vlz_get_page(){
            $valores = explode("/", $_SERVER['REDIRECT_URL']);
            return $valores[ count($valores)-2 ]+0;
        }
    }

    if(!function_exists('comprimir_styles')){
        function comprimir_styles($styles){
            $styles = str_replace("\t", "", $styles);
            $styles = str_replace("      ", " ", $styles);
            $styles = str_replace("     ", " ", $styles);
            $styles = str_replace("    ", " ", $styles);
            $styles = str_replace("   ", " ", $styles);
            $styles = str_replace("  ", " ", $styles);
            return $styles = str_replace("\n", " ", $styles);
        }
    }
    
    if(!function_exists('get_favoritos')){
        function get_favoritos(){
            $favoritos = array();
            global $wpdb;
            $id_user = get_current_user_id()+0;
            if( $id_user > 0 ){
                $rf = $wpdb->get_row("SELECT * FROM wp_usermeta WHERE ( user_id = $id_user AND meta_key = 'user_favorites'");
                preg_match_all('#"(.*?)"#i', $rf->favoritos, $favoritos);
                if( isset($favoritos[1]) ){
                    $favoritos = $favoritos[1];
                }
            }
            return $favoritos;
        }
    }
	
	if(!function_exists('angel_include_script')){
	    function angel_include_script(){
	        
	    }
	}

	if(!function_exists('angel_include_admin_script')){
	    function angel_include_admin_script(){
	        global $current_user;

	        $tipo = get_usermeta( $current_user->ID, "tipo_usuario", true );   

	        switch ($tipo) {
	            case 'Customer Service':
	                global $post;
	                $types = array(
	                    'petsitters',
	                    'pets',
	                    'request',
	                    'wc_booking',
	                    'shop_order'
	                );
	                $pages = array(
	                    'kmimos',
	                    'create_booking'
	                );
	                if( count($_GET) == 0 || (!in_array($post->post_type, $types) && !in_array($_GET['page'], $pages)) ){
	                    header("location: edit.php?post_type=petsitters");
	                }
	                echo kmimos_style(array(
	                    "quitar_edicion",
	                    "menu_kmimos",
	                    "menu_reservas"
	                ));
	                if( $post->post_type == 'shop_order' || $post->post_type == 'wc_booking' ){
	                    echo kmimos_style(array(
	                        'habilitar_edicion_reservas'
	                    )); 
	                }
	            break;
	        }
	    }
	}

	if(!function_exists('kmimos_get_info_syte')){
	    function kmimos_get_info_syte(){
	        return array(
	            "pais"      => "México",
	            "titulo"    => "Kmimos México",
	            "email"     => "contactomex@kmimos.la",
	            "telefono"  => "+52 (55) 1791.4931/ +52 (55) 66319264",
	            "twitter"   => "kmimosmx",
	            "facebook"  => "Kmimosmx",
	            "instagram" => "kmimosmx",
	            "mon_izq" => "",
	            "mon_der" => "$"
	        );
	    }
	}

	if(!function_exists('kmimos_mails_administradores')){
	    function kmimos_mails_administradores(){

            // $headers[] = 'BCC: a.pedroza@kmimos.la';
	        // $headers[] = 'BCC: e.celli@kmimos.la';
	        // $headers[] = 'BCC: r.cuevas@kmimos.la';
	        // $headers[] = 'BCC: r.gonzalez@kmimos.la';
	        // $headers[] = 'BCC: m.castellon@kmimos.la';
	        // $headers[] = 'BCC: a.veloz@kmimos.la';
	        // $headers[] = 'BCC: a.pedroza@kmimos.la';

	        /*        
	        $headers[] = 'BCC: vlzangel91@gmail.com';
	        $headers[] = 'BCC: angelveloz91@gmail.com';
	        */

	        return $headers;
	    }
	}

if(!function_exists('vlz_servicios')){
        function vlz_servicios($adicionales){
            $r = ""; $adiestramiento = false;

            $r .= '<span class="tooltip icono-servicios"><span class="tooltiptext">Hospedaje</span><i class="icon-hospedaje"></i></span>';

            $adicionales = unserialize($adicionales);
            
            if( $adicionales != "" ){
                if( count($adicionales) > 0 ){
                    foreach($adicionales as $key => $value){
                        switch ($key) {
                            case 'guarderia':
                                $r .= '<span class="tooltip icono-servicios"><span class="tooltiptext">Guardería</span><i class="icon-guarderia"></i></span>';
                            break;
                            case 'adiestramiento_basico':
                                $adiestramiento = true;
                            break;
                            case 'adiestramiento_intermedio':
                                $adiestramiento = true;
                            break;
                            case 'adiestramiento_avanzado':
                                $adiestramiento = true;
                            break;
                            case 'corte':
                                $r .= '<div class="tooltip icono-servicios"><span class="tooltiptext">Corte de pelo y uñas</span><i class="icon-peluqueria"></i></div>';
                            break;
                            case 'bano':
                                $r .= '<div class="tooltip icono-servicios"><span class="tooltiptext">Baño y secado</span><i class="icon-bano"></i></div>';
                            break;
                            case 'transportacion_sencilla':
                                $r .= '<div class="tooltip icono-servicios"><span class="tooltiptext">Transporte Sencillo</span><i class="icon-transporte"></i></div>';
                            break;
                            case 'transportacion_redonda':
                                $r .= '<div class="tooltip icono-servicios"><span class="tooltiptext">Transporte Redondo</span><i class="icon-transporte2"></i></div>';
                            break;
                            case 'visita_al_veterinario':
                                $r .= '<div class="tooltip icono-servicios"><span class="tooltiptext">Visita al Veterinario</span><i class="icon-veterinario"></i></div>';
                            break;
                            case 'limpieza_dental':
                                $r .= '<div class="tooltip icono-servicios"><span class="tooltiptext">Limpieza dental</span><i class="icon-limpieza"></i></div>';
                            break;
                            case 'acupuntura':
                                $r .= '<div class="tooltip icono-servicios"><span class="tooltiptext">Acupuntura</span><i class="icon-acupuntura"></i></div>';
                            break;
                        }
                    }
                }
            }
            if($adiestramiento){
                $r .= '<div class="tooltip icono-servicios" ><span class="tooltiptext">Adiestramiento de Obediencia</span><i class="icon-adiestramiento"></i></div>';
            }
            return $r;
        }
    }

    if(!function_exists('toRadian')){

        function toRadian($deg) {
            return $deg * pi() / 180;
        };

    }

    if( !function_exists('calcular_rango_de_busqueda') ){

        function calcular_rango_de_busqueda($norte, $sur){
            return ( 6371 * 
                acos(
                    cos(
                        toRadian($norte->lat)
                    ) * 
                    cos(
                        toRadian($sur->lat)
                    ) * 
                    cos(
                        toRadian($sur->lng) - 
                        toRadian($norte->lng)
                    ) + 
                    sin(
                        toRadian($norte->lat)
                    ) * 
                    sin(
                        toRadian($sur->lat)
                    )
                )
            );
        }

    }

    if(!function_exists('vlz_sql_busqueda')){
        function vlz_sql_busqueda($param, $pagina, $actual = false){

            $condiciones = "";
            if( isset($param["servicios"]) ){
                foreach ($param["servicios"] as $key => $value) {
                    if( $value != "hospedaje" ){
                        $condiciones .= " AND adicionales LIKE '%".$value."%'";
                    }
                }
            }

            if( isset($param['tamanos']) ){
                foreach ($param['tamanos'] as $key => $value) {
                    $condiciones .= " AND ( tamanos_aceptados LIKE '%\"".$value."\";i:1%' || tamanos_aceptados LIKE '%\"".$value."\";s:1:\"1\"%' ) ";
                }
            }

            if( isset($param['n']) ){
                if( $param['n'] != "" ){
                    $condiciones .= " AND nombre LIKE '".$param['n']."%' ";
                }
            }

            if( $param['rangos'][0] != "" ){
                $condiciones .= " AND (hospedaje_desde*1.2) >= '".$param['rangos'][0]."' ";
            }

            if( $param['rangos'][1] != "" ){
                $condiciones .= " AND (hospedaje_desde*1.2) <= '".$param['rangos'][1]."' ";
            }

            if( $param['rangos'][2] != "" ){
                $anio_1 = date("Y")-$param['rangos'][2];
                $condiciones .= " AND experiencia <= '".$anio_1."' ";
            }

            if( $param['rangos'][3] != "" ){
                $anio_2 = date("Y")-$param['rangos'][3];
                $condiciones .= " AND experiencia >= '".$anio_2."' ";
            }

            if( $param['rangos'][4] != "" ){
                $condiciones .= " AND rating >= '".$param['rangos'][4]."' ";
            }

            if( $param['rangos'][5] != "" ){
                $condiciones .= " AND rating <= '".$param['rangos'][5]."' ";
            }

            // Ordenamiento

            $orderby = (isset($param['orderby'])) ? "" : "" ;

            if( $orderby == "rating_desc" ){
                $orderby = "rating DESC, valoraciones DESC";
            }

            if( $orderby == "rating_asc" ){
                $orderby = "rating ASC, valoraciones ASC";
            }

            if( $orderby == "distance_asc" ){
                $orderby = "DISTANCIA ASC";
            }

            if( $orderby == "distance_desc" ){
                $orderby = "DISTANCIA DESC";
            }

            if( $orderby == "price_asc" ){
                $orderby = "hospedaje_desde ASC";
            }

            if( $orderby == "price_desc" ){
                $orderby = "hospedaje_desde DESC";
            }

            if( $orderby == "experience_asc" ){
                $orderby = "experiencia ASC";
            }

            if( $orderby == "experience_desc" ){
                $orderby = "experiencia DESC";
            }

            if( $param['tipo_busqueda'] == "otra-localidad" && $param['estados'] != "" && $param['municipios'] != "" ){

                global $wpdb;

                $coordenadas = unserialize( $wpdb->get_var("SELECT valor FROM kmimos_opciones WHERE clave = 'municipio_{$param['municipios']}' ") );

                $latitud  = $coordenadas["referencia"]->lat;
                $longitud = $coordenadas["referencia"]->lng;
                $distancia = calcular_rango_de_busqueda($coordenadas["norte"], $coordenadas["sur"]);

                $ubicacion = " ubi.estado LIKE '%=".$param['estados']."=%' AND ubi.municipios LIKE '%=".$param['municipios']."=%' ";

                $DISTANCIA = ",
                    ( 6371 * 
                        acos(
                            cos(
                                radians({$latitud})
                            ) * 
                            cos(
                                radians(latitud)
                            ) * 
                            cos(
                                radians(longitud) - 
                                radians({$longitud})
                            ) + 
                            sin(
                                radians({$latitud})
                            ) * 
                            sin(
                                radians(latitud)
                            )
                        )
                    ) as DISTANCIA 
                ";

                $FILTRO_UBICACION = "HAVING DISTANCIA < ".($distancia+0);

                $ubicaciones_inner = "INNER JOIN ubicaciones AS ubi ON ( cuidadores.id = ubi.cuidador )";
                $ubicaciones_filtro = "
                    AND (
                        ( $ubicacion ) OR (
                            ( 6371 * 
                                acos(
                                    cos(
                                        radians({$latitud})
                                    ) * 
                                    cos(
                                        radians(latitud)
                                    ) * 
                                    cos(
                                        radians(longitud) - 
                                        radians({$longitud})
                                    ) + 
                                    sin(
                                        radians({$latitud})
                                    ) * 
                                    sin(
                                        radians(latitud)
                                    )
                                )
                            ) <= ".($distancia+0)."
                        )
                    )";

                if( $orderby == "" ){
                    $orderby = "DISTANCIA ASC";
                }

            }else{ 

                if(  $param['tipo_busqueda'] == "otra-localidad" && $param['estados'] != "" ){
                    $ubicaciones_inner = "INNER JOIN ubicaciones AS ubi ON ( cuidadores.id = ubi.cuidador )";
                    $ubicaciones_filtro = "AND ( ubi.estado LIKE '%=".$param['estados']."=%' )";
                }else{

                    // Filtro desde mi ubicación
                    if( $param['tipo_busqueda'] == "mi-ubicacion" && $param['latitud'] != "" && $param['longitud'] != "" ){

                        $DISTANCIA = ",
                            ( 6371 * 
                                acos(
                                    cos(
                                        radians({$param['latitud']})
                                    ) * 
                                    cos(
                                        radians(latitud)
                                    ) * 
                                    cos(
                                        radians(longitud) - 
                                        radians({$param['longitud']})
                                    ) + 
                                    sin(
                                        radians({$param['latitud']})
                                    ) * 
                                    sin(
                                        radians(latitud)
                                    )
                                )
                            ) as DISTANCIA 
                        ";

                        $FILTRO_UBICACION = "HAVING DISTANCIA < 500";

                        if( $orderby == "" ){
                            $orderby = "DISTANCIA ASC";
                        }

                    }else{
                        $DISTANCIA = "";
                        $FILTRO_UBICACION = "";
                    }
                }
            }

            if( $orderby == "" ){
                $orderby = "rating DESC, valoraciones DESC";
            }

            $sql = "
                SELECT 
                    cuidadores.*
                    {$DISTANCIA}
                FROM 
                    cuidadores 
                    {$ubicaciones_inner}
                WHERE 
                    activo = '1' {$condiciones} {$ubicaciones_filtro} {$FILTRO_UBICACION}
                ORDER BY {$orderby}
                LIMIT {$pagina}, 15
            ";

            return $sql;
        }
    }

    if(!function_exists('print_info_cuidadores_map')){
        function print_info_cuidadores_map(){
            
            if( !isset($_SESSION) ){ session_start(); }

            $pines = $_SESSION["pines"];

        }
    }

    if(!function_exists('servicios_adicionales')){
        function servicios_adicionales(){

            $extras = array(
                'corte' => array( 
                    'label'=>'Corte de Pelo y Uñas',
                    'icon' => 'peluqueria'
                ),
                'bano' => array( 
                    'label'=>'Baño y Secado',
                    'icon' => 'bano'
                ),
                'transportacion_sencilla' => array( 
                    'label'=>'Transporte Sencillo',
                    'icon' => 'transporte'
                ),
                'transportacion_redonda' => array( 
                    'label'=>'Transporte Redondo',
                    'icon' => 'transporte2'
                ),
                'visita_al_veterinario' => array( 
                    'label'=>'Visita al Veterinario',
                    'icon' => 'veterinario'
                ),
                'limpieza_dental' => array( 
                    'label'=>'Limpieza Dental',
                    'icon' => 'limpieza'
                ),
                'acupuntura' => array( 
                    'label'=>'Acupuntura',
                    'icon' => 'acupuntura'
                )
            );

            return $extras;
        }
    }

    // 

    if(!function_exists('kmimos_get_foto_cuidador')){
        function kmimos_get_foto_cuidador($id){
            global $wpdb;
            $cuidador = $wpdb->get_row("SELECT * FROM cuidadores WHERE id = ".$id);
            $cuidador_id = $cuidador->id;
            $xx = $name_photo;
            $name_photo = get_user_meta($cuidador->user_id, "name_photo", true);
            if( empty($name_photo)  ){ $name_photo = "0"; }
            if( file_exists("wp-content/uploads/cuidadores/avatares/".$cuidador_id."/{$name_photo}") ){
                $img = get_home_url()."/wp-content/uploads/cuidadores/avatares/".$cuidador_id."/{$name_photo}";
            }else{
                if( file_exists("wp-content/uploads/cuidadores/avatares/".$cuidador_id."/0.jpg") ){
                    $img = get_home_url()."/wp-content/uploads/cuidadores/avatares/".$cuidador_id."/0.jpg";
                }else{
                    $img = get_home_url()."/wp-content/themes/pointfinder".'/images/noimg.png';
                }
            }
            return $img;
        }
    }

    if(!function_exists('kmimos_style')){
        function kmimos_style($styles = array()){
            
            $salida = "<style type='text/css'>";

                if( in_array("limpiar_tablas", $styles)){
                    $salida .= "
                        table{
                            border: 0;
                            background-color: transparent !important;
                        }
                        table >thead >tr >th, table >tbody >tr >th, table >tfoot >tr >th, table >thead >tr >td, table >tbody >tr >td, table >tfoot >tr >td {
                            padding: 0px 10px 0px 0px;
                            line-height: 1.42857143;
                            vertical-align: top;
                            border-top: 0;
                            border-right: 0;
                            background: #FFF;
                        }
                    ";
                }

                if( in_array("tablas", $styles)){
                    $salida .= "
                        .vlz_titulos_superior{
                            font-size: 14px;
                            font-weight: 600;
                            padding: 5px 0px;
                            margin-bottom: 10px;
                            max-width: 350px;
                        }
                        .vlz_titulos_tablas{
                            background: #00d2b7;
                            font-size: 13px;
                            font-weight: 600;
                            padding: 5px;
                            color: #FFF;
                        }
                        .vlz_contenido_tablas{
                            padding: 5px;
                            border: solid 1px #CCC;
                            border-top: 0;
                            margin-bottom: 10px;
                        }
                        .vlz_tabla{
                            width: 100%;
                            margin-bottom: 40px;
                        }
                        .vlz_tabla strong{
                            font-weight: 600;
                        }
                        .vlz_tabla > th{
                            background: #59c9a8!important;
                            color: #FFF;
                            border-top: 1px solid #888;
                            border-right: 1px solid #888;
                            text-align: center;
                            vertical-align: top;
                        }
                        .vlz_tabla > tr > td{
                            border-top: 1px solid #888;
                            border-right: 1px solid #888;
                            vertical-align: top;
                        }
                    ";
                }

                if( in_array("celdas", $styles)){
                    $salida .= "
                        .cell25  {vertical-align: top; width: 25%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
                        .cell33  {vertical-align: top; width: 33.333333333%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
                        .cell50  {vertical-align: top; width: 50%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
                        .cell66  {vertical-align: top; width: 66.666666666%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
                        .cell75  {vertical-align: top; width: 75%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
                        .cell100 {vertical-align: top; width: 100%; margin-right: -5px !important; padding-right: 10px !important; display: inline-block !important;}
                        @media screen and (max-width: 700px){
                            .cell25 { width: 50%; }
                        }
                        @media screen and (max-width: 500px){
                            .cell25, .cell33, .cell50, .cell66, .cell75{ width: 100%; }
                        }
                    ";
                }

                if( in_array("formularios", $styles)){
                    $salida .= "
                        .kmimos_boton{
                            border: solid 1px #59c9a8;
                            background: #59c9a8;
                            padding: 10px 20px;
                            display: inline-block;
                            margin: 20px 0px 0px;
                            color: #FFF;
                            font-weight: 600;
                        }
                    ";
                }

                if( in_array("quitar_edicion", $styles)){
                    $salida .= "
                        .menu-top,
                        .wp-menu-separator,
                        #dashboard-widgets-wrap{
                            display: none;
                        }

                        #wp-admin-bar-wp-logo,
                        #wp-admin-bar-updates,
                        #wp-admin-bar-comments,
                        #wp-admin-bar-new-content,
                        #wp-admin-bar-wpseo-menu,
                        #wp-admin-bar-ngg-menu,
                        .updated,
                        #wpseo_meta,
                        #mymetabox_revslider_0,
                        .vlz_contenedor_botones,
                        .wpseo-score,
                        .wpseo-score-readability,
                        .ratings,
                        #wpseo-score,
                        #wpseo-score-readability,
                        #ratings,
                        .column-wpseo-score,
                        .column-wpseo-score-readability,
                        .column-ratings,
                        #toplevel_page_kmimos li:last-child,
                        #menu-posts-wc_booking li:nth-child(3),
                        #menu-posts-wc_booking li:nth-child(6),
                        #menu-posts-wc_booking li:nth-child(7),
                        #screen-meta-links,
                        #wp-admin-bar-site-name-default,
                        #postcustom,
                        #woocommerce-order-downloads,
                        #wpfooter,
                        #postbox-container-1,
                        .page-title-action,
                        .row-actions,
                        .bulkactions,
                        #commentstatusdiv,
                        #edit-slug-box,
                        #postdivrich,
                        #authordiv,
                        #wpseo-filter,
                        .booking_actions button,

                        #actions optgroup option,
                        #actions option[value='regenerate_download_permissions']

                        {
                            display: none;
                        }

                        #poststuff #post-body.columns-2{
                            margin-right: 0px !important;
                        }

                        #normal-sortables{
                            min-height: 0px !important;
                        }

                        .booking_actions view,
                        #actions optgroup > option[value='send_email_new_order']
                        {
                            display: block;
                        }

                        .wc-order-status a,
                        .wc-customer-user a,
                        .wc-order-bulk-actions,
                        .wc-order-totals tr:nth-child(2),
                        .wc-order-totals tr:nth-child(5)
                        {
                            display: none;
                        }
                    ";
                }

                if( in_array("habilitar_edicion_reservas", $styles)){
                    $salida .= "

                        #poststuff #post-body.columns-2{
                            margin-right: 300px !important;
                        }

                        #postbox-container-1{
                            display: block;
                        }
                    ";
                }

                if( in_array("menu_kmimos", $styles)){
                    $salida .= "
                        #toplevel_page_kmimos{
                            display: block;
                        }
                    ";
                }

                if( in_array("menu_reservas", $styles)){
                    $salida .= "
                        #menu-posts-wc_booking{
                            display: block;
                        }
                    ";
                }

                if( in_array("form_errores", $styles)){
                    $salida .= "
                        .no_error{
                            display: none;
                        }

                        .error{
                            display: block;
                            font-size: 10px;
                            border: solid 1px #CCC;
                            padding: 3px;
                            border-radius: 0px 0px 3px 3px;
                            background: #ffdcdc;
                            line-height: 1.2;
                            font-weight: 600;
                        }

                        .vlz_input_error{
                            border-radius: 3px 3px 0px 0px !important;
                            border-bottom: 0px !important;
                        }
                    ";
                }

            $salida .= "</style>";

            return $salida;
            
        }
    }

?>