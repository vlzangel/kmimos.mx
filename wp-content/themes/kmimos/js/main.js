function playVideo(e) {
	var el = $(e);
	var p = el.parent().parent().parent();
	$('video', p).get(0).play();
	$('.km-testimonial-text').css('display','none');
	$('.img-testimoniales').css('display','none');
	$('video').css('display','block');

}

function menu(){
	var w = $(window).width();
	if($(this).scrollTop() > 10) {
		$('.bg-transparent').addClass('bg-white');
		$('.navbar-brand img').attr('src', HOME+'/images/new/km-logos/km-logo-negro.png');
		$('.navbar-toggle img').attr('src', HOME+'/images/new/km-navbar-mobile-negro.svg');
		$('.nav li a').css('padding','10px 15px 8px');
		$('.navbar-brand>img').css('height','40px');
		$('.nav li:first-child a').addClass('pd-tb11');
		$('.nav-login').addClass('dnone');
		$('.navbar').css('padding-top', '15px');
		if( w >= 768 ){
			$('a.km-nav-link, .nav-login li a').css('color','black');
		}
	} else {
		$('.bg-transparent').removeClass('bg-white');
		$('.navbar-brand img').attr('src', HOME+'/images/new/km-logos/km-logo.png');
		$('.navbar-toggle img').attr('src', HOME+'/images/new/km-navbar-mobile.svg');
		$('.nav li a').css('padding','19px 15px 15px');
		$('.navbar-brand>img').css('height','60px');
		$('.nav li:first-child a').removeClass('pd-tb11');
		$('.nav-login').removeClass('dnone');
		$('.navbar').css('padding-top', '30px');
		if( w >= 768 ){
			$('a.km-nav-link, .nav-login li a').css('color','white');
		}
	}
}

$(window).resize(function() {
	menu();
});

$(document).ready(function(){
	menu();

	$(window).scroll(function() {
		menu();
	});

	$('.bxslider').bxSlider({
	  buildPager: function(slideIndex){
		switch(slideIndex){
		  case 0:
			return '<img src="'+HOME+'/images/new/km-testimoniales/thumbs/testimonial-1.jpg">';
		  case 1:
			return '<img src="'+HOME+'/images/new/km-testimoniales/thumbs/testimonial-2.jpg">';
		  case 2:
			return '<img src="'+HOME+'/images/new/km-testimoniales/thumbs/testimonial-3.jpg">';
		}
	  }
	});
	$('.km-premium-slider').bxSlider({
	    slideWidth: 200,
	    minSlides: 1,
	    maxSlides: 3,
	    slideMargin: 10
	  });

	$('.km-galeria-cuidador-slider').bxSlider({
	    slideWidth: 200,
	    minSlides: 1,
	    maxSlides: 3,
	    slideMargin: 10
	});

	$('.km-opcion').on('click', function(e) {
		$(this).toggleClass('km-opcionactivo');
        $(this).children("input:checkbox").prop("checked", !$(this).children("input").prop("checked"));
	});

	$('.km-servicio-opcion').on('click', function(e) {
		$(this).toggleClass('km-servicio-opcionactivo');
	});

	$(document).on("click", '.show-map-mobile', function ( e ) {
		e.preventDefault();
		$(".km-map-content").addClass("showMap");
	});

	$(document).on("click", '.km-map-content .km-map-close', function ( e ) {
		e.preventDefault();
		$(".km-map-content").removeClass("showMap");
	});

	var $date_f = $(".date_from");
	var $date_t = $(".date_to");

	$date_f.datepicker({
		language: 'es',
		onSelect: function (fd, date) {
			$date_t.data('datepicker').update('minDate', date);
			$date_t.focus();
		}
	});

	$date_f.data('datepicker').update('minDate', new Date() );

	$date_t.datepicker({
		language: 'es',
		onSelect: function (fd, date) {
			//$date_f.data('datepicker').update('maxDate', date);
			$date_t.blur();
		}
	});

	$("#buscar").on("click", function ( e ) {
		e.preventDefault();
		$("#buscador").submit();
	});

	$("#buscar_no").on("click", function ( e ) {
		e.preventDefault();
		$("#buscador").submit();
	});
});
