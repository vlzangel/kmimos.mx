var markers = [];
var infos = [];
var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('mapa'), {
        zoom: 3,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var oms = new OverlappingMarkerSpiderfier(map, { 
        markersWontMove: true,   // we promise not to move any markers, allowing optimizations
        markersWontHide: true,   // we promise not to change visibility of any markers, allowing optimizations
        basicFormatEvents: true  // allow the library to skip calculating advanced formatting information
      });

    var bounds = new google.maps.LatLngBounds();

    jQuery.each(pines, function( index, cuidador ) {
        bounds.extend( new google.maps.LatLng(cuidador.lat, cuidador.lng) );
        markers[index] = new google.maps.Marker({ 
            vlz_index: index,
            map: map,
            draggable: false,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(cuidador.lat, cuidador.lng),
            icon: 'https://www.kmimos.com.mx/wp-content/themes/pointfinder/vlz/img/pin.png'
        });
        infos[index] = new google.maps.InfoWindow({ 
            content: '<a class="mini_map" href="'+cuidador.url+'" target="_blank"> <img src="'+cuidador.img+'" style="max-width: 200px; max-height: 230px;"> <div>'+cuidador.nom+'</div> </a>'
        });
        markers[index].addListener('spider_click', function(e) { 
            infos[this.vlz_index].open(map, this);
        });

        oms.addMarker(markers[index]);
    });

    var markerCluster = new MarkerClusterer(map, markers, {imagePath: imges+'images/m'});
    map.fitBounds(bounds);

    minClusterZoom = 14;
    markerCluster.setMaxZoom(minClusterZoom);
    window.oms = oms;
}



jQuery(function() {
	jQuery("#estados").on("change", function(e){
		var estado_id = jQuery("#estados").val(); 
		console.log("Hola: "+estado_id);
	    if( estado_id != "" ){
	        var html = "<option value=''>Seleccione un municipio</option>";
	        jQuery.each(estados_municipios[estado_id]['municipios'], function(i, val) {
	            html += "<option value="+val.id+" data-id='"+i+"'>"+val.nombre+"</option>";
	        });
	        jQuery("#municipios").html(html);
	    }
	});
	jQuery("#municipios").on("change", function(e){
		vlz_coordenadas();
	});
	jQuery(".pficon-imageclick").on("click", function(){
		if(jQuery(this).attr('data-pf-link')){
			jQuery.prettyPhoto.open(jQuery(this).attr('data-pf-link'));
		}
	});
	jQuery('a#boton-izquierda').click(function(e){
		e.preventDefault();
		enlace  = jQuery(this).attr('href');
		if( enlace == '#mapa' ){
			jQuery(this).attr('href', "#lista");
			jQuery(this).html('<span id="icono-izquierda" class="dashicons dashicons-id"></span><div id="titulo-izquierda">Lista</div>');
		}else{
			jQuery(this).attr('href', "#mapa");
			jQuery(this).html('<span id="icono-izquierda" class="dashicons dashicons-location-alt"></span><div id="titulo-izquierda">Mapa</div>');
		}
		jQuery('html, body').animate({
			scrollTop: parseInt(jQuery(enlace).offset().top)-85
		}, 500);
	});
	jQuery('a#boton-derecha').click(function(e){
		e.preventDefault();
		enlace  = jQuery(this).attr('href');
		if( enlace == '#mapa' ){
			jQuery(this).attr('href', "#filtros");
			jQuery(this).html('<span id="icono-derecha" class="dashicons dashicons-admin-settings"></span><div id="titulo-derecha">Filtros</div>');
		}else{
			jQuery(this).attr('href', "#mapa");
			jQuery(this).html('<span id="icono-derecha" class="dashicons dashicons-location-alt"></span><div id="titulo-derecha">Mapa</div>');
		}
		jQuery('html, body').animate({
			scrollTop: parseInt(jQuery(enlace).offset().top)-85
		}, 500);
	});
	jQuery("#mapa").mouseleave(function(){
	    jQuery(".vlz_bloquear_map").css("display", "block");
	});
	if (jQuery(window).width() < 550) {
		jQuery('div.vlz_bloquear_map>p').text('Toca la pantalla para ver en el mapa');
	}
});

function vlz_select(id){
	if( jQuery("#"+id+" input").prop("checked") ){
		jQuery("#"+id+" input").prop("checked", false);
		jQuery("#"+id).removeClass("vlz_check_select");
	}else{

		jQuery("#"+id+" input").prop("checked", true);
		jQuery("#"+id).addClass("vlz_check_select");
	}
}
function vlz_top(){
	jQuery('html, body').animate({
        scrollTop: 0
    }, 500);
}

function vlz_coordenadas(){
	var estado_id = jQuery("#estados").val();            
    var municipio_id = jQuery('#municipios > option[value="'+jQuery("#municipios").val()+'"]').attr('data-id');   
}
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}
function showPosition(position) {
	if( jQuery("#tipo_busqueda option:selected").val() == "mi-ubicacion" ){
		jQuery("#latitud").val(position.coords.latitude);
	    jQuery("#longitud").val(position.coords.longitude);
	}
}
function vlz_tipo_ubicacion(){
	if( jQuery("#tipo_busqueda option:selected").val() == "mi-ubicacion" ){
		jQuery("#vlz_estados").css("display", "none");
		jQuery("#vlz_inputs_coordenadas").css("display", "block");
	}else{
		jQuery("#vlz_estados").css("display", "block");
		jQuery("#vlz_inputs_coordenadas").css("display", "none");
	}
}
vlz_tipo_ubicacion();
function vlz_siguiente(){
	jQuery("#vlz_pagina").val( jQuery("#vlz_pagina").val()+1 );
	jQuery("#vlz_form_buscar").submit();
}
function vlz_anterior(){
	jQuery("#vlz_pagina").val( jQuery("#vlz_pagina").val()-1 );
	jQuery("#vlz_form_buscar").submit();
}

/*
var map;
<?php
	foreach ($coordenadas_all_2 as $value) {
		echo "var infowindow_{$value['ID']}; var marker_{$value['ID']}; ";
	}
?>
function  initMap() {<?php
	echo "
		map = new google.maps.Map(document.getElementById('mapa'), {
			zoom: 5,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var bounds = new google.maps.LatLngBounds();
	";
	$c = 0;
	foreach ($coordenadas_all_2 as $value) {
		$name_photo = get_user_meta($value['USER'], "name_photo", true);
		$cuidador_id = $value['ID'];
		if( empty($name_photo)  ){ $name_photo = "0"; }
		if( file_exists("wp-content/uploads/cuidadores/avatares/".$cuidador_id."/{$name_photo}") ){
			$img = $home."/wp-content/uploads/cuidadores/avatares/".$cuidador_id."/{$name_photo}";
		}elseif( file_exists("wp-content/uploads/cuidadores/avatares/".$cuidador_id."/0.jpg") ){
			$img = $home."/wp-content/uploads/cuidadores/avatares/".$cuidador_id."/0.jpg";
		}else{
			$img = $home."/wp-content/themes/pointfinder".'/images/noimg.png';
		}
		$url = $value['url'];
		$nombre = $value['nombre'];
		$c = $value['ID'];
		echo "
			var point = new google.maps.LatLng('{$value['lat']}', '{$value['lng']}');
			bounds.extend(point);
			marker_{$c} = new google.maps.Marker({
				map: map,
				draggable: false,
				animation: google.maps.Animation.DROP,
				position: new google.maps.LatLng('{$value['lat']}', '{$value['lng']}'),
				icon: '".$home."/wp-content/themes/pointfinder"."/vlz/img/pin.png'
			});
			infowindow_{$c} = new google.maps.InfoWindow({ content: '<a class=\"mini_map\" href=\"{$url}\" target=\"_blank\"> <img src=\"{$img}\" style=\"max-width: 200px; max-height: 230px;\"> <div>{$nombre}</div> </a>' });
			marker_{$c}.addListener('click', function() { infowindow_{$c}.open(map, marker_{$c}); });
		";	
	}
	echo "map.fitBounds(bounds);"; ?>
}
*/