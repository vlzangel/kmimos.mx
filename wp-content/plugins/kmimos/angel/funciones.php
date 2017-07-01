<?php
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
?>