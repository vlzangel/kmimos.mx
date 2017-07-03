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
    
    if(!function_exists('get_menu_header')){
        function get_menu_header(){

            if( is_user_logged_in() ){

                $current_user = wp_get_current_user();
                $user_id = $current_user->ID;
                $user = new WP_User( $user_id );
                $salir = wp_logout_url( home_url() );

                // echo "<pre>";
                //     print_r($user->data->display_name);
                // echo "</pre>";

                $MENU["head"] = '
                    <li class="pf-my-account pfloggedin"></li>
                    <li class="pf-my-account pfloggedin" style="min-width: 200px; text-align: right;">
                        <a href="#"> <i class="pfadmicon-glyph-632"></i> '.$user->data->display_name.' </a>
                        <ul class="pfnavsub-menu sub-menu menu-odd  menu-depth-1 hidden-xs hidden-sm">';

                $MENU["body"] = "";

                $MENUS = array(
                    "vendor" => array(
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=profile",
                            "name"  => "Mi Perfil",
                            "icono" => "460"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=mypets",
                            "name"  => "Mis Mascotas",
                            "icono" => "871"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=favorites",
                            "name"  => "Cuidadores Favoritos",
                            "icono" => "375"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=invoices",
                            "name"  => "Historial",
                            "icono" => "33"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=myshop",
                            "name"  => "Descripción del cuidador",
                            "icono" => "664"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=myservices",
                            "name"  => "Mis Servicios",
                            "icono" => "453"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=mypictures",
                            "name"  => "Mis Fotos",
                            "icono" => "82"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=mybookings",
                            "name"  => "Mis Reservas",
                            "icono" => "33"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=caregiver",
                            "name"  => "Mis Solicitudes",
                            "icono" => "33"
                        ),
                        array(
                            "url"   => $salir,
                            "name"  => "Cerrar Sesión",
                            "icono" => "476"
                        )
                    ),
                    "subscriber" => array(
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=profile",
                            "name"  => "Mi Perfil",
                            "icono" => "460"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=mypets",
                            "name"  => "Mis Mascotas",
                            "icono" => "871"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=favorites",
                            "name"  => "Cuidadores Favoritos",
                            "icono" => "375"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=invoices",
                            "name"  => "Historial",
                            "icono" => "33"
                        ),
                        array(
                            "url"   => $salir,
                            "name"  => "Cerrar Sesión",
                            "icono" => "476"
                        )
                    ),
                    "administrator" => array(
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=profile",
                            "name"  => "Mi Perfil",
                            "icono" => "460"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=mypets",
                            "name"  => "Mis Mascotas",
                            "icono" => "871"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=favorites",
                            "name"  => "Cuidadores Favoritos",
                            "icono" => "375"
                        ),
                        array(
                            "url"   => get_home_url()."/perfil-usuario/?ua=invoices",
                            "name"  => "Historial",
                            "icono" => "33"
                        ),
                        array(
                            "url"   => get_home_url()."/wp-admin/",
                            "name"  => "Panel de Control",
                            "icono" => "421"
                        ),
                        array(
                            "url"   => $salir,
                            "name"  => "Cerrar Sesión",
                            "icono" => "476"
                        )
                    )
                );

                foreach ($MENUS[ $user->roles[0] ] as $key => $value) {
                    $MENU["body"] .= '
                        <li>
                            <a href="'.$value["url"].'">
                                <i class="pfadmicon-glyph-'.$value["icono"].'"></i> 
                                '.$value["name"].'
                            </a>
                        </li>';
                }

                $MENU["footer"] = '</ul></li>';

            }else{
                $MENU["body"] = '
                    <li class="pf-login-register" id="pf-login-trigger-button"><a href="#"><i class="pfadmicon-glyph-584"></i> Iniciar Sesión</a></li>
                    <li class="pf-login-register"><a href="'.get_home_url().'/registrar/"><i class="pfadmicon-glyph-365"></i> Registrarse</a></li>
                    <li class="pf-login-register" id="pf-lp-trigger-button"><a href="#"><i class="pfadmicon-glyph-889"></i> Contraseña Olvidada</a></li>
                ';
            }

            return $MENU;
        }
    }
?>