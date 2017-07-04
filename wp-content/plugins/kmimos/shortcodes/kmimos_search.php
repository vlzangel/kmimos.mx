<?php

    //[kmimos_search]

    $HOY = date("Y-m-d");

    $ESTADOS = "
        <option value=''>Seleccione un estado</option>
        <option value='7'>Aguascalientes</option>
        <option value='8'>Baja California</option>
        <option value='9'>Baja California Sur</option>
        <option value='10'>Campeche</option>
        <option value='13'>Chiapas</option>
        <option value='14'>Chihuahua</option>
        <option value='1'>Ciudad de México</option>
        <option value='11'>Coahuila de Zaragoza</option>
        <option value='12'>Colima</option>
        <option value='15'>Durango</option>
        <option value='2'>Estado de México</option>
        <option value='16'>Guanajuato</option>
        <option value='17'>Guerrero</option>
        <option value='18'>Hidalgo</option>
        <option value='3'>Jalisco</option>
        <option value='19'>Michoac&aacute;n de Ocampo</option>
        <option value='20'>Morelos</option>
        <option value='21'>Nayarit</option>
        <option value='4'>Nuevo León</option>
        <option value='22'>Oaxaca</option>
        <option value='23'>Puebla</option>
        <option value='24'>Queretaro</option>
        <option value='25'>Quintana Roo</option>
        <option value='26'>San Luis Potosi</option>
        <option value='27'>Sinaloa</option>
        <option value='28'>Sonora</option>
        <option value='29'>Tabasco</option>
        <option value='30'>Tamaulipas</option>
        <option value='31'>Tlaxcala</option>
        <option value='32'>Veracruz de Ignacio de la Llave</option>
        <option value='33'>Yucatan</option>
        <option value='34'>Zacatecas</option>
    ";
    $servicios = array(
        'hospedaje'      => '<p>Hospedaje<br><sup>cuidado día y noche</sup></p>', 
        'guarderia'      => '<p>Guardería<br><sup>cuidado durante el día</sup></p>', 
        'paseos'         => '<p>Paseos<br><sup></sup></p>',
        'adiestramiento' => '<p>Entrenamiento<br><sup></sup></p>'
    ); 
    $SERVICIOS = "";
    foreach($servicios as $key => $value){
        if( substr($key, 0, 14) == 'adiestramiento'){ $xkey = 'adiestramiento'; }else{ $xkey = $key; }
        $SERVICIOS .= "
        <div class='contenedor_servicio izquierda text-left'>
            <div class='boton_portada boton_servicio'>
                <input type='checkbox' name='servicios[]' id='servicio_cuidador_{$key}' class='servicio_cuidador_{$key}' value='{$key}' data-key='{$key}'>
                <label for='servicio_cuidador_{$key}'>
                    <i class='icon-{$key}'></i>
                    {$value}
                </label>
            </div>
        </div>";
    }

    $extras = servicios_adicionales(); $MAS_SERVICIOS = "";
    foreach($extras as $key => $value){
        $MAS_SERVICIOS .= "
        <div class='w96pc boton_extra text-center'>
            <div class='boton_portada boton_servicio'>
                <input type='checkbox' name='servicios[]' id='servicio_cuidador_{$key}' class='servicio_cuidador_{$key}' value='{$key}' data-key='{$key}'>
                <label for='servicio_cuidador_{$key}'>
                    <i class='icon-{$value['icon']}'></i>
                    <p>{$value['label']}</p>
                </label>
            </div>
        </div>";
    }

    $tamanos = array(
        'pequenos' => 'Peque&ntilde;os <br><sub>0.0 cm - 25.0cm</sub>',
        'medianos' => 'Medianos <br><sub>25.0 cm - 58.0 cm</sub>',
        'grandes'  => 'Grandes <br><sub>58.0 cm - 73.0 cm</sub>',
        'gigantes' => 'Gigantes <br><sub>73.0 cm - 200.0 cm</sub>',
    );
    $TAMANOS = "";
    foreach($tamanos as $key => $value){
        $TAMANOS .= "
        <div class='jj_btn_tamanos' style='float: left; box-sizing: border-box; padding: 0px 1px; margin-bottom: 2px !important;'>
            <div class='boton_portada boton_servicio' style='margin: 0px !important;'>
                <input type='checkbox' name='tamanos[]' id='tamano_mascota_{$key}' value='{$key}' class='servicio_cuidador_{$key}' data-key='{$key}'>
                <label for='tamano_mascota_{$key}' style='line-height: 12px; padding: 5px;'>
                    <i class='icon-{$key}'></i>
                    {$value}
                </label>
            </div>
        </div>";
    }

    global $wpdb; $TESTIMONIOS = ""; $WIDTH_SLIDER = 0;
    $resultado = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type='testimonials'");
    foreach($resultado as $key => $testimonio){
        $TESTIMONIOS .= "
            <li>
                <div class='testimonio'>
                    <div class='testimonio_cont_data'>
                        <div class='testimonio_titulo'>{$testimonio->post_title}</div>
                        <div class='testimonio_texto'>{$testimonio->post_content}</div>
                    </div>
                </div>
            </li>
        ";
        $WIDTH_SLIDER += 100;
    }

    $home = get_home_url();
    wp_enqueue_style('slider_kmimos', $home."/wp-content/themes/pointfinder/css/new/slider_kmimos.css", array(), '1.0.0');
    wp_enqueue_script('buscar_home', $home."/wp-content/plugins/kmimos/javascript/buscar.js", array(), '1.0.0');

    $HTML = "
    <script type='text/javascript'> var URL_MUNICIPIOS = '".get_bloginfo( 'template_directory', 'display' )."/vlz/ajax_municipios.php'; </script>

    <div class='slider_home' style='background-image: url({$home}/wp-content/themes/pointfinder/images/slider_home/fondo_2.png)'>
        <div class='slider_home_container'>
            <ul style='width: 200%;' class='slider_home_box'>
                <li style='background-image: url({$home}/wp-content/themes/pointfinder/images/slider_home/slider_1_1.png)'></li>
                <li style='background-image: url({$home}/wp-content/themes/pointfinder/images/slider_home/slider_1_2.png)'></li>
            </ul>
        </div>
    </div>

    <div id='portada'>
        <form id='pointfinder-search-form-manual' method='POST' action='".get_home_url()."/wp-content/themes/pointfinder/vlz/buscar.php' data-ajax='false' novalidate='novalidate'>
            <center>
                <div class='buscador_portada'>
                    <div class='w100pc mt10'>
                        <div class='mt10 izquierda'>
                            <label id='estoy_buscando'><strong>ESTOY BUSCANDO</strong></label>
                        </div>
                        <div class='mt10 derecha'>
                            <a href='#mas_servicios' class='theme_button prettyphoto' rel='more_services' id='ver_mas_servicios'>Servicios adicionales...</a>
                        </div>
                    </div>
                    <div id='servicio_cuidador_main' class='w100pc'>
                        {$SERVICIOS}
                    </div>
                    <div id='popup_mas_servicios' style='display:none; overflow: hidden;'>
                        <span></span>
                        <div id='mas_servicios'>
                            <i id='cerrar_mas_servicios' class='fa fa-times' aria-hidden='true'></i>
                            $MAS_SERVICIOS
                       </div>
                    </div>
                    <div class='w100pc'>
                        <div class='mt10 izquierda'>
                            <div id='selector_tipo' class='izquierda'> 
                                <label id='cerca_de' class='izquierda'><strong>CERCA DE </strong></label> 
                                <input type='radio' name='tipo_busqueda' id='otra-localidad' value='otra-localidad' class='ml8' checked> 
                                <label for='otra-localidad'> Otra localidad</label> 
                                <input type='radio' name='tipo_busqueda' id='mi-ubicacion' value='mi-ubicacion' class='ml8' >
                                <label for='mi-ubicacion'> Mi ubicación </label> 
                            </div>
                        </div>
                    </div>
                    <div id='estado_cuidador_main'>
                        <div id='selector_locacion'>
                            <div class='grupo_selector'>
                                <div class='marco'>
                                    <div class='icono'><i class='icon-mapa embebed'></i></div>
                                    <sub>Estado:</sub><br>
                                    <select id='estado_cuidador' name='estados' data-location='mx'>
                                        $ESTADOS
                                    </select>
                                </div>
                            </div>
                            <div class='grupo_selector'>
                                <div class='marco'>
                                    <div class='icono'><i class='icon-mapa embebed'></i></div>
                                    <sub>Municipio:</sub><br>
                                    <select id='municipio_cuidador' name='municipios'>
                                        <option value=''>Seleccione primero un estado</option>
                                    </select>
                                    <input type='hidden' id='municipio_cache' name='municipio_cache'>
                                </div>
                            </div>
                        </div>
                        <div id='selector_coordenadas_x' class='hide'>
                            <input type='text' id='latitud' name='latitud'>
                            <input type='text' id='longitud' name='longitud'>
                        </div>
                    </div>

                    <div class='w100pc'>
                       <div class='mt10 izquierda'>
                            <label id='tamano_mascota'><strong>TAMAÑO DE MI MASCOTA</strong></label>
                        </div>
                    </div>
                    <div id='tamano_mascota_main' style='overflow: hidden;'>
                        {$TAMANOS}
                    </div>
                    <div class='w100pc text-center'>
                        <div class='boton_buscar'>
                            <a class='theme_button button pfsearch' id='pf-search-button-manual'><i class='pfadmicon-glyph-627'></i> Buscar Cuidador</a>
                        </div>
                    </div>
                </div>
            </center>
        </form>
    </div>

    <div class='beneficios_container'>
        <h1 style='text-align: center;'><span style='color: #01d7df;'><strong>Beneficios</strong></span></h1>
        <ul class='beneficios_home'>
            <li>
                <p style='text-align: center;'>
                    <img src='https://www.kmimos.com.mx/iconos/boton-1.png' alt='boton-1' />
                </p>
                <h3 style='text-align: center;'>
                    <span style='color: #90a4ae;'>Cuidadores</span><br />
                    <span style='color: #90a4ae;'>Certificados</span>
                </h3>
            </li>  

            <li>
                <p style='text-align: center;'>
                    <img src='https://www.kmimos.com.mx/iconos/boton-2.png' alt='boton-2' />
                </p>
                <h3 style='text-align: center;'>
                    <span style='color: #90a4ae;'>Fotografías</span><br />
                    <span style='color: #90a4ae;'>y videos diarios</span>
                </h3>
            </li>  

            <li>
                <p style='text-align: center;'>
                    <img src='https://www.kmimos.com.mx/iconos/boton-3.png' alt='boton-3' />
                </p>
                <h3 style='text-align: center;'>
                    <span style='color: #90a4ae;'>Atención</span><br />
                    <span style='color: #90a4ae;'>personalizada</span>
                </h3>
            </li>  

            <li>
                <p style='text-align: center;'>
                    <img src='https://www.kmimos.com.mx/iconos/boton-4.png' alt='boton-4' />
                </p>
                <h3 style='text-align: center;'>
                    <span style='color: #90a4ae;'>Cobertura veterinaria</span><br />
                    <span style='color: #90a4ae;'>para tu mascota</span>
                </h3>
            </li> 
        </ul> 
    </div>

    <div id='bloque_testimonios' style='background: #00c3aa; padding: 20px 0px 50px;'>
        <div class='wpb_text_column wpb_content_element' style='padding: 5px 0px;'>
            <div class='wpb_wrapper'>
                <h1 style='text-align: center;'><span style='color: #FFF;'><strong>Testimonios</strong></span></h1>
            </div>
        </div>
        <div class='testimonios_container'>
            <ul style='width: {$WIDTH_SLIDER}%' class='testimonios_box'>
                ".$TESTIMONIOS."
            </ul>
        </div>
    </div>

    <div class='slider_logos_container'>
        <ul class='slider_logos_box'>
            <li style='background-image: url({$home}/wp-content/uploads/2017/02/expansion-360x150.png)'></li>
            <li style='background-image: url({$home}/wp-content/uploads/2017/02/reforma-360x150-360x150.png)'></li>
            <li style='background-image: url({$home}/wp-content/uploads/2017/02/mural-360x150-360x150.png)'></li>
            <li style='background-image: url({$home}/wp-content/uploads/2017/02/entrepreneur-360x150.png)'></li>

            <li style='background-image: url({$home}/wp-content/uploads/2017/02/el-universal-360x150-360x150.png)'></li>
            <li style='background-image: url({$home}/wp-content/uploads/2017/02/el-norte-360x150-360x150.png)'></li>
            <li style='background-image: url({$home}/wp-content/uploads/2017/02/el-financiero-360x150-360x150.png)'></li>
            <li style='background-image: url({$home}/wp-content/uploads/2017/02/expansion-360x150.png)'></li>
            <li id='logo_solo_movil' style='background-image: url({$home}/wp-content/uploads/2017/02/expansion-360x150.png)'></li>
        </ul>
    </div>";

    echo comprimir_styles($HTML);
?>

