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
        'hospedaje'      => '<p><span>Hospedaje</span><sup>cuidado día y noche</sup></p>', 
        'guarderia'      => '<p><span>Guardería</span><sup>cuidado durante el día</sup></p>', 
        'paseos'         => '<p><span>Paseos</span></p>',
        'adiestramiento' => '<p><span>Entrenamiento</span></p>'
    ); 
    $SERVICIOS = "";
    foreach($servicios as $key => $value){
        if( substr($key, 0, 14) == 'adiestramiento'){ $xkey = 'adiestramiento'; }else{ $xkey = $key; }
        $SERVICIOS .= "
        <div class='contenedor_servicio'>
            <div class='boton_servicio'>
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
        <div class='boton_servicio'>
            <input type='checkbox' name='servicios[]' id='servicio_cuidador_{$key}' class='servicio_cuidador_{$key}' value='{$key}' data-key='{$key}'>
            <label for='servicio_cuidador_{$key}'>
                <i class='icon-{$value['icon']}'></i>
                <p>{$value['label']}</p>
            </label>
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
        <div class='contenedor_servicio contenedor_tamanos'>
            <div class='boton_servicio'>
                <input type='checkbox' name='tamanos[]' id='tamano_mascota_{$key}' value='{$key}' class='servicio_cuidador_{$key}' data-key='{$key}'>
                <label for='tamano_mascota_{$key}'>
                    <p>{$value}</p>
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
    wp_enqueue_style('home_kmimos', $home."/wp-content/themes/pointfinder/css/home_kmimos.css", array(), '1.0.0');
    wp_enqueue_style('home_responsive', $home."/wp-content/themes/pointfinder/css/responsive/home_responsive.css", array(), '1.0.0');
    wp_enqueue_script('buscar_home', $home."/wp-content/plugins/kmimos/javascript/buscar.js", array(), '1.0.0');

    $HTML = "
    <script type='text/javascript'> var URL_MUNICIPIOS = '".get_bloginfo( 'template_directory', 'display' )."/vlz/ajax_municipios.php'; </script>

    <div class='modal_video'>
        <div class='modal_container'>
            <div class='modal_box'>
                <i id='close_video' class='fa fa-times' aria-hidden='true'></i>
                <iframe width='100%' height='100%' src='' frameborder='0' allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <div class='modal_servicios'>
        <div class='modal_container'>
            <div class='modal_box'>
                <i id='close_mas_servicios' class='fa fa-times' aria-hidden='true'></i>
                ".$MAS_SERVICIOS."
            </div>
        </div>
    </div>

    <div class='slider_home' style='background-image: url({$home}/wp-content/themes/pointfinder/images/slider_home/fondo_2.png)'>
        <div class='slider_home_container'>
            <ul onclick='show_video();' style='width: 200%;' class='slider_home_box'>
                <li style='background-image: url({$home}/wp-content/themes/pointfinder/images/slider_home/slider_2_1.png)'></li>
                <li style='background-image: url({$home}/wp-content/themes/pointfinder/images/slider_home/slider_2_2.png)'></li>
            </ul>
        </div>
    </div>

    <div class='buscar_box'>
        <form id='buscador' class='container' method='POST' action='".get_home_url()."/wp-content/themes/pointfinder/vlz/buscar.php'>
            
            <div class='adicionales_container'>
                <label class='titulo_buscar_label'>ESTOY BUSCANDO</label>
                <div class='adicionales_button'>Servicios adicionales...</div>
            </div>

            <div class='servicios_container'>
                ".$SERVICIOS."
            </div>

            <div class='selector_tipo_container'>
                <label  for='otra-localidad' class='por_ubicacion check_select'>
                    Otra localidad
                    <input type='radio' name='tipo_busqueda' id='otra-localidad' value='otra-localidad' checked=''>
                </label>
                <label  for='mi-ubicacion' class='por_ubicacion'>
                    Mi ubicación
                    <input type='radio' name='tipo_busqueda' id='mi-ubicacion' value='mi-ubicacion'>
                </label>
            </div>

            <div class='selects_ubicacion_container'>
                <select id='estado_cuidador' name='estado_cuidador'> {$ESTADOS} </select>
                <select id='municipio_cuidador' name='municipio_cuidador'> <option value=''>Seleccione primero un estado</option> </select>
            </div>

            <div class='servicios_container'>
                ".$TAMANOS."
            </div>

            <div id='boton_buscar' class='boton_buscar'>
                <i class='pfadmicon-glyph-627'></i>
                Buscar Cuidador
            </div>
        </form>
    </div>

    <div class='beneficios_container'>
        <h1 style='text-align: center;'><span style='color: #01d7df;'><strong>Beneficios</strong></span></h1>
        <ul class='beneficios_home'>
            <li>
                <div>
                    <p style='text-align: center;'>
                        <img src='https://www.kmimos.com.mx/iconos/boton-1.png' alt='boton-1' />
                    </p>
                    <h3 style='text-align: center;'>
                        <span style='color: #90a4ae;'>Cuidadores</span><br />
                        <span style='color: #90a4ae;'>Certificados</span>
                    </h3>
                </div>
            </li>  

            <li>
                <div>
                    <p style='text-align: center;'>
                        <img src='https://www.kmimos.com.mx/iconos/boton-2.png' alt='boton-2' />
                    </p>
                    <h3 style='text-align: center;'>
                        <span style='color: #90a4ae;'>Fotografías</span><br />
                        <span style='color: #90a4ae;'>y videos diarios</span>
                    </h3>
                </div>
            </li>  

            <li>
                <div>
                    <p style='text-align: center;'>
                        <img src='https://www.kmimos.com.mx/iconos/boton-3.png' alt='boton-3' />
                    </p>
                    <h3 style='text-align: center;'>
                        <span style='color: #90a4ae;'>Atención</span><br />
                        <span style='color: #90a4ae;'>personalizada</span>
                    </h3>
                </div>
            </li>  

            <li>
                <div>
                    <p style='text-align: center;'>
                        <img src='https://www.kmimos.com.mx/iconos/boton-4.png' alt='boton-4' />
                    </p>
                    <h3 style='text-align: center;'>
                        <span style='color: #90a4ae;'>Cobertura veterinaria</span><br />
                        <span style='color: #90a4ae;'>para tu mascota</span>
                    </h3>
                </div>
            </li> 
        </ul> 
    </div>


    <div id='bloque_testimonios'>
        <h1>Testimonios</h1>
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

