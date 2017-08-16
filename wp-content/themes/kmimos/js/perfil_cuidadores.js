function vlz_galeria_ver(url){
	// jQuery('.vlz_modal_galeria_interna').css('background-image', 'url('+url+')');
	// jQuery('.vlz_modal_galeria').css('display', 'table');
}
function vlz_galeria_cerrar(){
	// jQuery('.vlz_modal_galeria').css('display', 'none');
	// jQuery('.vlz_modal_galeria_interna').css('background-image', '');
}

var map_cuidador;
function initMap() {
	var latitud = lat;
	var longitud = lng;
	map_cuidador = new google.maps.Map(document.getElementById('mapa'), {
		zoom: 5,
		center:  new google.maps.LatLng(latitud, longitud), 
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false
	});
	marker = new google.maps.Marker({
		map: map_cuidador,
		draggable: false,
		animation: google.maps.Animation.DROP,
		position: new google.maps.LatLng(latitud, longitud),
		icon: "https://www.kmimos.com.mx/wp-content/themes/pointfinder/vlz/img/pin.png"
	});
}

(function(d, s){
	map = d.createElement(s), e = d.getElementsByTagName(s)[0];
	map.async=!0;
	map.setAttribute("charset","utf-8");
	map.src="//maps.googleapis.com/maps/api/js?v=3&key=AIzaSyD-xrN3-wUMmJ6u2pY_QEQtpMYquGc70F8&callback=initMap";
	map.type="text/javascript";
	e.parentNode.insertBefore(map, e);
})(document,"script");