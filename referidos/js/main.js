

$('#frm').on('submit', function(e){
  e.preventDefault(e);
  _registerLanding();
});

$('#send').on('click', function(e){
  _registerLanding();
});

function _registerLanding(){

  $('#loading').removeClass('hidden');
  $('#msg').html('Registrando Usuario.');
  $.ajax( "https://www.kmimos.com.mx/landing/registro-usuario.php?email="+$('#email').val()+"&name="+$('#email').val()+"&referencia="+$('#referencia').val() )
  .done(function() {
    $('#msg').html('Generando url.');
    $('#frm-redirect').submit();
  })
  .fail(function() {
    $('#msg').html('Registro: No pudimos completar su solicitud, intente nuevamente');
    $('#loading').addClass('hidden');
  });  

  $('#loading').removeClass('hidden');
  $('#msg').html('Enviando...');
  $.ajax( "https://www.kmimos.com.mx/landing/list-subscriber.php?source=kmimos-mx-clientes-referidos&email="+$('#email').val() )
  .done(function() {
    $('#loading').addClass('hidden');
    $('#msg').html('Guardando referencia.');

    window.location.href = $('#temp').attr('action')+$('#email').val();
  })
  .fail(function() {
    $('#msg').html('Referencia: No pudimos completar su solicitud, intente nuevamente');
    $('#loading').addClass('hidden');
  });  

}

