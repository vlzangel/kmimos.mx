$(window).load(function() {
	
	$('#section-1').height( $(window).height() - 1  );
	$('#section-6').height( $(window).height() - 1  );
	
});

$(window).resize(function(){
	$('iframe').width( ($(window).width() * 25) / 100 );
	$('iframe').height( ($(window).height() * 25) / 100 );
});


$('#subscribe').on('click', function(){
  _subscribe();
});
$('#frm-temp').on('submit', function(e){
  e.preventDefault(e);
  _subscribe();
});

function _subscribe(){
  $('#loading').removeClass('hidden');
  $('#msg').html('Enviando...');
  $.ajax( "https://mx.kmimos/landing/list-subscriber.php?source=kmimos-animados&email="+$('#email').val() )
  .done(function(data) {
    if(data == 1){
      $('#loading').addClass('hidden');
      $('#msg').html('Solicitud completada, Redireccionando...');
      $('#frm-redirect').submit();
    }else{
      $('#msg').html('No pudimos completar su solicitud, intente nuevamente');
    }
  })
  .fail(function() {
    $('#msg').html('No pudimos completar su solicitud, intente nuevamente');
    $('#loading').addClass('hidden');
  });  
}
