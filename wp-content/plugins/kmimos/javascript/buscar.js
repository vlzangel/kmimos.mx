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
                    URL_MUNICIPIOS, 
                    {estado: estado_id} 
                ).done(
                    function( data, textStatus, jqXHR ) {
                        var html = "<option value=''>Seleccione un municipio</option>";
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
            jQuery("#municipio_cuidador > option[value='"+jQuery('#municipio_cache').val()+"']").attr('selected', 'selected');
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