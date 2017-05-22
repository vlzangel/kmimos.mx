
// $('#vigencia').daterangepicker({
//     "showDropdowns": true,
//     "showWeekNumbers": true,
//     "dateLimit": {
//         "days": 30
//     },
//     "startDate": "05/09/2017",
//     "endDate": "05/15/2017",
//     "opens": "left"
// }, function(start, end, label) {
//   console.log("Rago seleccionado: ' + start.format('YYYY-MM-DD') + ' hasta ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
// });

jQuery(function($){


	$('#btnsave').on('click', function(){

		$('#loading').removeClass('hidden');
		$('#msg').html('Enviando...');
		$.post( $("#formsave").attr('action'), { 
			"titulo" : $('#titulo').val(),
			"nombre" : $('#nombre').val(),
			"vigencia" : $('#vigencia').val(),
			"color" : $('#color').val(),
			"logo" : $('#logo').val(),
			"css" : $('#css').val(),
			"js" : $('#js').val(),
			"hhtml" : $("#hhtml").val(),
			"fhtml" : $('#fhtml').val(),
		 } )
		 .done(function(data) {
			$('#loading').addClass('hidden');
			$('#msg').html('Guardando datos.');
			console.log(data);
		 })
		 .fail(function() {
			$('#msg').html('Referencia: No pudimos completar su solicitud, intente nuevamente');
			$('#loading').addClass('hidden');
		 });

	});

	$('[data-target="imgload"]').on('click', function(){
		$('#file').click();
	});

});