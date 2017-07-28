function vlz_select(id){
	if( jQuery("#"+id+" input").prop("checked") ){
		jQuery("#"+id+" input").prop("checked", false);
		jQuery("#"+id).removeClass("vlz_check_select");
	}else{
		jQuery("#"+id+" input").prop("checked", true);
		jQuery("#"+id).addClass("vlz_check_select");
	}
}
jQuery(".vlz_checkbox_contenedor div").on("click", function(e){
	vlz_select( jQuery( this ).attr("id") );
});
jQuery(".vlz_sub_seccion_titulo").on("click", 
	function (){
		var con = jQuery(jQuery(this)[0].nextElementSibling);
		if( con.css("display") == "none" ){
			con.slideDown( "slow", function() { });
		}else{
			con.slideUp( "slow", function() { });
		}
	}
);
function vlz_top(){
	jQuery("html, body").animate({
        scrollTop: 0
    }, 500);
}
jQuery("#estados").on("change", function(e){
	var estado_id = jQuery("#estados").val();       
    if( estado_id != "" ){
    	jQuery.getJSON( 
			HOME+"procesos/generales/municipios.php", 
			{estado: estado_id} 
		).done(
			function( data, textStatus, jqXHR ) {
		        var html = "<option value=''>Seleccione un municipio</option>";
		        jQuery.each(data, function(i, val) {
		            html += "<option value="+val.id+">"+val.name+"</option>";
		        });
		        jQuery("#municipios").html(html);
		    }
	    ).fail(
	    	function( jqXHR, textStatus, errorThrown ) {
		        console.log( "Error: " +  errorThrown );
			}
		);
    }
});
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

var markers = [];
var infos = [];
var map;
function initMap() {
    map = new google.maps.Map(document.getElementById("mapa"), {
        zoom: 3,
        mapTypeId: google.maps.MapTypeId.ROADMAP
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
            icon: "https://www.kmimos.com.mx/wp-content/themes/pointfinder/vlz/img/pin.png"
        });
        infos[index] = new google.maps.InfoWindow({ 
            content: '<a class="mini_map" href="'+cuidador.url+'" target="_blank"> <img src="'+cuidador.img+'" style="max-width: 200px; max-height: 230px;"> <div>'+cuidador.nom+'</div> </a>'
        });
        markers[index].addListener("click", function(e) { 
            infos[this.vlz_index].open(map, this);
        });
    });
    map.fitBounds(bounds);
}
(function(d, s){
	map = d.createElement(s), e = d.getElementsByTagName(s)[0];
	map.async=!0;
	map.setAttribute("charset","utf-8");
	map.src="//maps.googleapis.com/maps/api/js?v=3&key=AIzaSyD-xrN3-wUMmJ6u2pY_QEQtpMYquGc70F8&callback=initMap";
	map.type="text/javascript";
	e.parentNode.insertBefore(map, e);
})(document,"script");
/*
function initForm(){
	// console.log(CAMPOS[0]);
	if( CAMPOS[0]["servicios"] != undefined ){
		jQuery.each(CAMPOS[0]["servicios"], function( index, xvalor ) {
	        vlz_select("servicio_"+xvalor);
	    });
	}

	if( CAMPOS[0]["tamanos"] != undefined ){
		jQuery.each(CAMPOS[0]["tamanos"], function( index, xvalor ) {
	        vlz_select("tamanos_"+xvalor);
	    });
	}
}
jQuery(document).ready(function(){
    initForm();
});
*/

