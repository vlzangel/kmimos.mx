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

    $HTML = do_shortcode("[layerslider id='1']")."
    <style>
        #estado_cuidador_main {
            margin: 0px !important;
        }
        #grupo_fecha {
            width: 110% !important;
        }
        .selector_fecha {
            width: 50%;
            overflow: hidden;
        }
        .grupo_fecha {
            overflow: hidden;
        }
        .grupo_selector {
            display: inline-block;
            width: 50%;
            float: left;
            margin-top: 3px;
        }
        html.iOS .fecha_hasta, html.iOS .fecha_desde { width: 118px !important}
        @media only screen and (max-width: 639px) { 
            .grupo_selector { width: 100%; } 
            html.iOS .selector_fecha {width: 50% !important}
            html.iOS .fecha_desde {float: left; margin-top: 0px !important; margin-right: -16px;}
            html.iOS .fecha_hasta {float: right; margin-top: 0px !important; margin-right: -16px;}
            .fecha_desde {float: left;}
            .fecha_hasta { display: block;}
            .fecha_hasta_full { display: none;}
        }
        .grupo_selector .marco {
            display: inline-block;
            border: 1px solid #888;
            width: 99%;
            padding-right: 5px;
        }
        .grupo_selector .icono {
            display: inline-block;
            width: 36px;
            height: 36px;
            float: left;
            padding: 5px;
            font-size: 1.8em;
        }
        .grupo_selector sub {
            top: 8px;
            float: left;
        }
        .grupo_selector select, .grupo_selector input {
            height: 25px;
            width: 87%;
            display: inline-block;
            clear: right;
            float: left;
            margin-top: -10px;
            border: 0px;
            background-color: #ffffff;
        }
        select.activo, .grupo_fecha input[type=date].activo { color: #00d2b7 !important; }
        select:focus{
            outline: 0px;
        }
        #pp_full_res .pp_inline p {
            margin: 7px 0px 15px 38px;
            text-align: left;
        }
        #popup_mas_servicios{
            overflow: hidden;
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 999999999999999999;
            background: rgba(0,0,0,0.6);
            width: 100%;
            height: 100%;
            vertical-align: middle;
        }
        #mas_servicios{
            display: inline-block;
            position: relative;
            max-width: 340px !important;
            vertical-align: middle;
            overflow: hidden;
            background: #FFF;
            padding: 25px 5px 10px;
            margin: 50px auto;
            border-radius: 8px;
            border: solid 5px rgba(0,0,0,0.8);
            vertical-align: middle;
        }
        #cerrar_mas_servicios{
            position: absolute;
            top: 0px;
            right: 0px;
            background: #FFF;
            padding: 3px;
            font-size: 16px;
            border: solid 1px #333;
            border-top: 0px;
            border-right: 0px;
            border-radius: 0px 0px 0px 5px;
            cursor: pointer;
        }
        #popup_mas_servicios span{
            display: inline-block;
            width: 0px;
            height: 100%;
            vertical-align: middle;
        }
    </style>
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

    <script type='text/javascript'>
        var hasGPS=false;

        (function($) {
            'use strict';

            $('#ver_mas_servicios').on('click', function(){
                if( $('#popup_mas_servicios').css('display') == 'none' ){
                    $('#popup_mas_servicios').css('display', 'block');
                }else{
                    $('#popup_mas_servicios').css('display', 'none');
                }
            });

            $('#cerrar_mas_servicios').on('click', function(){
                $('#popup_mas_servicios').css('display', 'none');
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(coordenadas);
            } else {
                $('#selector_locacion').removeClass('hide');
                $('#selector_coordenadas').addClass('hide');
                $('#selector_tipo').addClass('hide');
            }
            if(navigator.platform.substr(0, 2) == 'iP') $('html').addClass('iOS');
            $(function(){
                var edos = $('#estado_cuidador').val();
                if($('#otra-localidad').prop( 'checked' )){
                    $('#selector_locacion').removeClass('hide');
                    $('#selector_coordenadas').addClass('hide');
                    if( edos != ''){
                        $('#estado_cuidador > option[value='+edos+']').attr('selected', 'selected');
                    }
                }
                $('#otra-localidad').click(function(){
                    $('#selector_locacion').removeClass('hide');
                    $('#selector_coordenadas').addClass('hide');
                });
                $('#mi-ubicacion').click(function(){
                    $('#selector_coordenadas').addClass('hide');
                    $('#selector_locacion').addClass('hide');
                });
                function cargar_municipios(CB){
                    var estado_id = jQuery('#estado_cuidador').val();       
                    if( estado_id != '' ){
                        jQuery.getJSON( 
                            '".get_bloginfo( 'template_directory', 'display' )."/vlz/ajax_municipios.php', 
                            {estado: estado_id} 
                        ).done(
                            function( data, textStatus, jqXHR ) {
                                var html = \"<option value=''>Seleccione un municipio</option>\";
                                jQuery.each(data, function(i, val) {
                                    html += '<option value='+val.id+'>'+val.name+'</option>';
                                });
                                jQuery('#municipio_cuidador').html(html);

                                if( CB != undefined) {
                                    CB();
                                }
                            }
                        ).fail(
                            function( jqXHR, textStatus, errorThrown ) {
                                console.log( 'Error: ' +  errorThrown );
                            }
                        );
                    }
                }
                jQuery('#estado_cuidador').on('change', function(e){
                    cargar_municipios();
                });
                cargar_municipios(function(){
                    jQuery(\"#municipio_cuidador > option[value='\"+jQuery('#municipio_cache').val()+\"']\").attr('selected', 'selected');
                });
                jQuery('#municipio_cuidador').on('change', function(e){
                    jQuery('#municipio_cache').attr('value', jQuery('#municipio_cuidador').val() );
                });

                $('.boton_servicio > input:checkbox').each(function(index){
                    var servicio = $(this).attr('data-key');
                    var activo = $(this).prop('checked');
                    if(activo) $(this).parent().addClass('activo');
                    else $(this).parent().removeClass('activo');
                });
                $('.boton_portada > input:checkbox').on('change',function(e){
                    var servicio = $(this).attr('data-key');
                    var activo = $(this).prop('checked');
                    if(activo) $('.servicio_cuidador_'+servicio).parent().addClass('activo');
                    else $('.servicio_cuidador_'+servicio).parent().removeClass('activo');
                });
                $('.modal').fancybox({
                    maxWidth: 340
                });
            });
        })(jQuery);

        function coordenadas(position){
            if(position.coords.latitude != '' && position.coords.longitude != '') {
                document.getElementById('latitud').value=position.coords.latitude;
                document.getElementById('longitud').value=position.coords.longitude;        
            } else {
                var mensaje = 'No es posible leer su ubicación,\nverifique si su GPS está encendido\ny vuelva a recargar la página.'+$('#latitud').val()+','+$('#longitud').val();
                alert(mensaje);        
            }
        }
    </script>
    <div class='vc_row wpb_row vc_row-fluid text-dark hidden-sm hidden-xs vc_custom_1479764110786 vc_row-has-fill' style='background-color: #f9f9f9 !important;'>
        <div class='pf-container'>
            <div class='pf-row'>
                <div class='wpb_column col-lg-12 col-md-12'>
                    <div class='vc_column-inner '>
                        <div class='wpb_wrapper'>
                            <div class='vc_empty_space'  style='height: 10px' >
                                <span class='vc_empty_space_inner'></span>
                            </div>
                            <div class='wpb_text_column wpb_content_element '>
                                <div class='wpb_wrapper'>
                                    <h1 style='text-align: center;'><span style='color: #01d7df;'><strong>Beneficios</strong></span></h1>
                                </div>
                            </div>
                            <div class='vc_empty_space'  style='height: 30px' >
                                <span class='vc_empty_space_inner'></span>
                            </div>
                            <div class='vc_row wpb_row vc_inner vc_row-fluid vc_custom_1478877923520 vc_row-has-fill'>
                                <div class='wpb_column col-lg-3 col-md-3'>
                                    <div class='vc_column-inner '>
                                        <div class='wpb_wrapper'>
                                            <div class='wpb_text_column wpb_content_element  whiteBox'>
                                                <div class='wpb_wrapper'>
                                                    <p style='text-align: center;'>
                                                        <img class='size-full wp-image-686 aligncenter' src='https://www.kmimos.com.mx/iconos/boton-1.png' alt='boton-1' />
                                                    </p>
                                                    <h3 style='text-align: center;'>
                                                        <span style='color: #90a4ae;'>Cuidadores</span><br />
                                                        <span style='color: #90a4ae;'>Certificados</span>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='wpb_column col-lg-3 col-md-3'>
                                    <div class='vc_column-inner '>
                                        <div class='wpb_wrapper'>
                                            <div class='wpb_text_column wpb_content_element  whiteBox'>
                                                <div class='wpb_wrapper'>
                                                    <p style='text-align: center;'>
                                                        <img class='size-full wp-image-687 aligncenter' src='https://www.kmimos.com.mx/iconos/boton-2.png' alt='boton-2' />
                                                    </p>
                                                    <h3 style='text-align: center;'>
                                                        <span style='color: #90a4ae;'>Fotografías</span><br />
                                                        <span style='color: #90a4ae;'>y videos diarios</span>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='wpb_column col-lg-3 col-md-3'>
                                    <div class='vc_column-inner '>
                                        <div class='wpb_wrapper'>
                                            <div class='wpb_text_column wpb_content_element  whiteBox'>
                                                <div class='wpb_wrapper'>
                                                    <p style='text-align: center;'>
                                                        <img class='size-full wp-image-688 aligncenter' src='https://www.kmimos.com.mx/iconos/boton-3.png' alt='boton-3' />
                                                    </p>
                                                    <h3 style='text-align: center;'>
                                                        <span style='color: #90a4ae;'>Atención</span><br />
                                                        <span style='color: #90a4ae;'>personalizada</span>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='wpb_column col-lg-3 col-md-3'>
                                    <div class='vc_column-inner '>
                                        <div class='wpb_wrapper'>
                                            <div class='wpb_text_column wpb_content_element  whiteBox'>
                                                <div class='wpb_wrapper'>
                                                    <p style='text-align: center;'>
                                                        <img class='size-full wp-image-689 aligncenter' src='https://www.kmimos.com.mx/iconos/boton-4.png' alt='boton-4' />
                                                    </p>
                                                    <h3 style='text-align: center;'>
                                                        <span style='color: #90a4ae;'>Cobertura veterinaria</span><br />
                                                        <span style='color: #90a4ae;'>para tu mascota</span>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='vc_btn3-container  leer-mas btn-green vc_btn3-center' style='overflow: hidden; margin: 30px auto; width: 200px; padding: 0px; text-align: center;'>
                        <a 
                            class='
                                vc_general 
                                vc_btn3 
                                vc_btn3-size-md 
                                vc_btn3-shape-square 
                                vc_btn3-style-flat 
                                vc_btn3-color-grey
                            ' 
                            href='https://www.kmimos.com.mx/beneficios/' 
                            title='Beneficios' 
                            target='_self'
                            style='
                                display: inline-block;
                            '
                        >
                            Leer más
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id='bloque_testimonios' style='background: #00c3aa;'>
        <div class='wpb_text_column wpb_content_element' style='padding: 10px 0px;'>
            <div class='wpb_wrapper'>
                <h1 style='text-align: center;'><span style='color: #FFF;'><strong>Testimonios</strong></span></h1>
            </div>
        </div>
        <div style='padding: 0px 0px 60px;'>
            
        </div>
    </div>

    <div class='vc_row wpb_row vc_row-fluid hidden-sm hidden-xs vc_custom_1479764736706'>
        <div class='pf-container'>
            <div class='pf-row'>
                <div class='wpb_column col-lg-12 col-md-12'>
                    <div class='vc_column-inner '>
                        <div class='wpb_wrapper'>
                            <div class='vc_empty_space'  style='height: 10px' >
                                <span class='vc_empty_space_inner'></span>
                            </div>
                            <div class='wpb_text_column wpb_content_element '>
                                <div class='wpb_wrapper'>
                                    <h1 style='text-align: center;'><span style='color: #01d7df;'><strong>Nos Viste en</strong></span></h1>
                                </div>
                            </div>
                            <div class='vc_empty_space'  style='height: 20px' >
                                <span class='vc_empty_space_inner'></span>
                            </div>
                            <div class='wpb_images_carousel wpb_content_element vc_clearfix'>
                                <div class='wpb_wrapper'>
                                    <div id='vc-images-carousel-1-1499063963'  class='vc-slide vc-image-carousel vc-image-carousel-3'>
                                        <div class='vc-carousel-inner '>
                                            <div class='vc-carousel-slideline'>
                                                <div class='vc-carousel-slideline-inner' id='5dbd16152b06f3e47d16faa20c682e6a'>
                                                    <div class='vc-item'>
                                                        <div class='vc-inner'>
                                                            <img src='http://mx.kmimos.dev/wp-content/uploads/2017/02/expansion-360x150.png' alt='' class='pf-vcimage-carousel'>
                                                        </div>
                                                    </div>
                                                    <div class='vc-item'>
                                                        <div class='vc-inner'>
                                                            <img src='http://mx.kmimos.dev/wp-content/uploads/2017/02/reforma-360x150-360x150.png' alt='' class='pf-vcimage-carousel'>
                                                        </div>
                                                    </div>
                                                    <div class='vc-item'>
                                                        <div class='vc-inner'>
                                                            <img src='http://mx.kmimos.dev/wp-content/uploads/2017/02/mural-360x150-360x150.png' alt='' class='pf-vcimage-carousel'>
                                                        </div>
                                                    </div>
                                                    <div class='vc-item'>
                                                        <div class='vc-inner'>
                                                            <img src='http://mx.kmimos.dev/wp-content/uploads/2017/02/entrepreneur-360x150.png' alt='' class='pf-vcimage-carousel'>
                                                        </div>
                                                    </div>
                                                    <div class='vc-item'>
                                                        <div class='vc-inner'>
                                                            <img src='http://mx.kmimos.dev/wp-content/uploads/2017/02/el-universal-360x150-360x150.png' alt='' class='pf-vcimage-carousel'>
                                                        </div>
                                                    </div>
                                                    <div class='vc-item'>
                                                        <div class='vc-inner'>
                                                            <img src='http://mx.kmimos.dev/wp-content/uploads/2017/02/el-norte-360x150-360x150.png' alt='' class='pf-vcimage-carousel'>
                                                        </div>
                                                    </div>
                                                    <div class='vc-item'>
                                                        <div class='vc-inner'>
                                                            <img src='http://mx.kmimos.dev/wp-content/uploads/2017/02/el-financiero-360x150-360x150.png' alt='' class='pf-vcimage-carousel'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript'>
        (function($) {
            'use strict';
            $(function() {
                $('#5dbd16152b06f3e47d16faa20c682e6a').owlCarousel({
                    items : 3,
                    navigation : false,
                    paginationNumbers : false,
                    pagination : false,
                    autoPlay : true,stopOnHover : true,
                    slideSpeed:5000,
                    mouseDrag:true,
                    touchDrag:true,
                    itemSpaceWidth: 10,
                    autoHeight : false,
                    responsive:true,
                    transitionStyle: 'fade', 
                    itemsScaleUp : false,
                    navigationText:false,
                    theme:'owl-theme',
                    singleItem : false,
                });
            });

        })(jQuery);
    </script>
    ";

    echo comprimir_styles($HTML);
?>

