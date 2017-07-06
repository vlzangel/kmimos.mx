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

    if(!function_exists('vlz_num_resultados')){
        function vlz_num_resultados(){
            if( !isset($_SESSION)){ session_start(); }
            if( $_SESSION['resultado_busqueda'] ){
                return count($_SESSION['resultado_busqueda'])+0;
            }else{
                return 0;
            }
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

            // return $styles;
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

                $MENU["head"] = '<li id="separador"></li><li style="width: 200px;"><a href="#"> <i class="pfadmicon-glyph-632"></i> '.$user->data->display_name.' </a><ul class="sub-menu">';
                $MENU["body"] = "";

                foreach ($MENUS[ $user->roles[0] ] as $key => $value) {
                    $MENU["body"] .=
                        '<li>
                            <a href="'.$value["url"].'">
                                <i class="pfadmicon-glyph-'.$value["icono"].'"></i> 
                                '.$value["name"].'
                            </a>
                        </li>';
                }

                $MENU["footer"] = '</ul></li>';

            }else{
                $MENU["body"] = 
                '<li id="separador"></li>'.
                '<li id="login"><a href="#"><i class="pfadmicon-glyph-584"></i> Iniciar Sesión</a></li>'.
                '<li id="registrar"><a href="#"><i class="pfadmicon-glyph-365"></i> Registrarse</a></li>'.
                '<li id="recuperar"><a href="#"><i class="pfadmicon-glyph-889"></i> Contraseña Olvidada</a></li>';
            }

            return $MENU;
        }
    }

    if(!function_exists('kmimos_petsitter_rating')){

        function kmimos_petsitter_rating($post_id){
            $html = '<div>';
            $valoracion = kmimos_petsitter_rating_and_votes($post_id);
            $votes = $valoracion['votes'];
            $rating = $valoracion['rating'];
            $valoracion = ($votes==1)? ' Valoración':' Valoraciones';
            $html .= '<div class="vlz_valoraciones">('. number_format($rating, 2).') '.$votes .$valoracion. '</div>';
            if($votes =='' || $votes == 0 || $rating ==''){ 
                for ($i=0; $i<5; $i++){ 
                    $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/vacio.png">';
                }
                $html .= '<div class="vlz_valoraciones">Este cuidador no ha sido valorado</div>';
            } else { 
                for ($i=0; $i<5; $i++){ 
                    if(intval($rating)>$i) { 
                        $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/100.png">';
                    } else if(intval($rating)<$i) {
                        $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/0.png">';
                    } else {
                        $residuo = ($rating-$i)*100+12.5;
                        $residuo = intval($residuo/25);
                        switch($residuo){
                            case 4: // 100% 
                                $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/100.png">';
                            break;
                            case 3: // 75% 
                                $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/75.png">';
                            break;
                            case 2: // 50% 
                                $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/50.png">';
                            break;
                            case 1: // 25% 
                                $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/25.png">';
                            break;
                            default: // 0% 
                                $html .= '<img src="'.get_home_url().'/wp-content/plugins/kmimos/assets/rating/0.png">';
                            break;
                        }
                    }
                }
            }
            $html .= '</div>';
            return $html;
        }
    }

    function get_ficha_cuidador($cuidador, $i, $favoritos){
        $img        = kmimos_get_foto_cuidador($cuidador->id);
        $anios_exp  = $cuidador->experiencia; if( $anios_exp > 1900 ){ $anios_exp = date("Y")-$anios_exp; }
        $url        = $home."/petsitters/".$cuidador->slug;

        if( isset($cuidador->DISTANCIA) ){ $distancia   = 'A '.floor($cuidador->DISTANCIA).' km de tu busqueda'; }

        $fav_check = 'false';
        if (in_array($cuidador->id_post, $favoritos)) {
            $fav_check = 'true'; $favtitle_text = esc_html__('Remove from Favorites','pointfindert2d');
        }

        $ficha = '
            <li>
                <div>
                    <a href="'.$url.'">
                        <div class="vlz_postada_cuidador">
                            <a class="vlz_img_cuidador easyload" data-preload="'.$home.'/wp-content/themes/pointfinder/images/cargando1111.gif" data-original="'.$img.'" href="'.$url.'" style="background-image: url('.$home.'/wp-content/themes/pointfinder/images/loading.gif); filter:blur(2px);"></a>
                            <span class="vlz_img_cuidador_interno easyload" data-original="'.$img.'" data-href="'.$url.'" style="background-image: url();"></span>
                        </div>
                        <div class="nombre">
                            '.utf8_encode($cuidador->titulo).'
                        </div>
                        <div class="rating">
                            '.kmimos_petsitter_rating($cuidador->id_post).'
                        </div>
                        <div class="servicios">
                            <i class="pfadmicon-glyph-109 pin"></i>
                            '.vlz_servicios($cuidador->adicionales).'
                        </div>
                    </a>
                </div>
            </li>
        ';

/*        $ficha = '
        <li class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wpfitemlistdata isotope-item">
            <div class="pflist-item" style="background-color:#ffffff;">  
                    <div class="pflist-item-inner">
                        <div class="pflist-imagecontainer pflist-subitem" >
                            <div class="vlz_postada_cuidador">
                                <a class="vlz_img_cuidador easyload" data-preload="'.$home.'/wp-content/themes/pointfinder/images/cargando1111.gif" data-original="'.$img.'" href="'.$url.'" style="background-image: url('.$home.'/wp-content/themes/pointfinder/images/loading.gif); filter:blur(2px);"></a>
                                <span class="vlz_img_cuidador_interno easyload" data-original="'.$img.'" data-href="'.$url.'" style="background-image: url();"></span>
                            </div>
                            <div class="RibbonCTR">
                                <span class="Sign">
                                    <a class="pf-favorites-link" data-pf-num="'.$cuidador->id_post.'" data-pf-active="'.$fav_check.'" data-pf-item="false" title="Agregar a favoritos">
                                        <i class="pfadmicon-glyph-629"></i>
                                    </a>
                                </span>
                                <span class="Triangle"></span>
                            </div>
                            <div class="pfImageOverlayH hidden-xs"></div>
                            <div class="pfButtons pfStyleV2 pfStyleVAni hidden-xs">
                                <span class="pfHoverButtonStyle pfHoverButtonWhite pfHoverButtonSquare clearfix">
                                    <a class="pficon-imageclick" data-pf-link="'.$img.'" style="cursor:pointer">
                                        <i class="pfadmicon-glyph-684"></i>
                                    </a>
                                </span>
                                <span class="pfHoverButtonStyle pfHoverButtonWhite pfHoverButtonSquare">
                                    <a href="'.$url.'">
                                        <i class="pfadmicon-glyph-794"></i>
                                    </a>
                                </span>
                            </div>
                            <div style="left: 0px; font-size: 12px; position: absolute; top: 0px; font-weight: 600; color: #FFF; padding: 10px; box-sizing: border-box; width: 100%; background: linear-gradient(to top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.75) 100%);">
                                '.$distancia.'
                            </div>
                            <div class="pflisting-itemband">
                                <div class="pflist-pricecontainer">
                                    
                                    <div class="pflistingitem-subelement pf-price"> 
                                        <sub style="bottom: 0px;">Hospedaje desde</sub><br>MXN $'.$cuidador->precio.'
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pflist-detailcontainer pflist-subitem">
                            <ul class="pflist-itemdetails">
                                <li class="pflist-itemtitle text-center">
                                    <div style="display: table-cell; vertical-align: middle; width: 240px; height: 30px; align-content: center;">
                                        <div class="tooltip">
                                            <a href="'.$url.'" style="text-transform: capitalize;">
                                            '.utf8_encode($cuidador->titulo).'
                                            </a>
                                            <span class="tooltiptext">'.$anios_exp.' año(s) de experiencia</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="text-center rating" style="float: none;">
                                        <div id="rating">'.kmimos_petsitter_rating($cuidador->id_post).'</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="pflist-subdetailcontainer pflist-subitem" style="height: 50px; clear: both;">
                            <div style="position: absolute; left: 20px; bottom: 20px; font-size: 25px;">
                                <a onclick="infos['.$i.'].open(map, markers['.$i.']); map.setZoom(15); map.setCenter(markers['.$i.'].getPosition()); vlz_top();" title="VER EN MAPA">
                                    <i class="pfadmicon-glyph-109" style="color: #00b69d;"></i>
                                </a>
                            </div>
                            <div class="clr text-center" style="font-size: 20px; position: absolute; right: 20px; bottom: 20px;">
                                '.vlz_servicios($cuidador->adicionales).'
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        ';*/

        return ($ficha);
    }
?>