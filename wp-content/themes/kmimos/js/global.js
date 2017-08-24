jQuery( document ).ready(function() {
	jQuery("#close_login").on("click", function(e){
        close_login_modal();
    });

    jQuery("#login").on("click", function(e){
        show_login_modal("login");
    });

	jQuery("#login_movil").on("click", function(e){
        show_login_modal("login");
    });

	jQuery("#recuperar").on("click", function(e){
        show_login_modal("recuperar");
    });

	jQuery("#login_submit").on("click", function(e){
		logear();
		e.preventDefault();
    });

    jQuery("#form_login").submit(function(e){ 
    	logear(); 
   	});
    /** REGISTRO USUARIO*/
    jQuery("#form_register").on("click", function(e){ 
        registroNuevoUsuario(); 
    });
    jQuery("#form_register").submit(function(e){
        registroNuevoUsuario();
    });
});

$('[data-charset]').on({
    keypress : function(e){
            var tipo= $(this).attr('data-charset');
            if(tipo!='undefined' || tipo!=''){
                var cadena = "";

                if(tipo.indexOf('alf')>-1 ){ cadena = cadena + "abcdefghijklmnopqrstuvwxyzáéíóúñüÁÉÍÓÚÑÜ"; }
                if(tipo.indexOf('xlf')>-1 ){ cadena = cadena + "abcdefghijklmnopqrstuvwxyzáéíóúñüÁÉÍÓÚÑÜ "; }
                if(tipo.indexOf('num')>-1 ){ cadena = cadena + "1234567890"; }
                if(tipo.indexOf('cur')>-1 ){ cadena = cadena + "1234567890,."; }
                if(tipo.indexOf('esp')>-1 ){ cadena = cadena + "-_.$%&@,/()"; }
                if(tipo.indexOf('cor')>-1 ){ cadena = cadena + "@"; }
                if(tipo.indexOf('rif')>-1 ){ cadena = cadena + "vjegi"; }

                var key = e.which,
                    keye = e.keyCode,
                    tecla = String.fromCharCode(key).toLowerCase(),
                    letras = cadena;
                if(letras.indexOf(tecla)==-1 && keye!=9&& (key==37 || keye!=37)&& (keye!=39 || key==39) && keye!=8 && (keye!=46 || key==46) || key==161){
                    e.preventDefault();
                }
            }   
        }
    });


function registroNuevoUsuario(){
    var nombre = document.form_nuevo_cliente.nombre.value;
    var apellido = document.form_nuevo_cliente.apellido.value;
    var dni = document.form_nuevo_cliente.dni.value;
    var email_1 = document.form_nuevo_cliente.email_1.value;
    var clave = document.form_nuevo_cliente.clave.value;
    var movil = document.form_nuevo_cliente.movil.value;

    if (nombre.length == 0) {
        alert('Debe ingresar su nombre');
        return 0;
    } else {

        if (apellido.length == 0) {
            alert('Debe ingresar su apellido');
            return 0;
        }else {
            if (dni.length == 0) {
                alert('Ingrese su DNI por favor');
                dni.focus();
                return 0;
            } else {
                if (email_1.length == 0) {
                    alert('Ingrese un email por favor');
                    email_1.focus();
                    return 0;
                } else {
                    if (clave.length == 0) {
                        alert('Ingrese una clave por favor');
                        clave.focus();
                        return 0;
                    } else {
                        if (movil.length == 0 && movil.length > 10) {
                            alert('Ingrese su telefono movil por favor');
                            movil.focus();
                        } else {
                            if($('#genero').val() == ''){
                                alert('selecciones si es Hombre o Mujero por favor');
                                $('#genero').parent('div').css('color', 'red');
                            }else{
                                var vGenero = $('#genero').val();
                                if ($('#edad').val() =='') {
                                    alert('selecciones su rango de edad, por favor');
                                    $('#edad').parent('div').css('color', 'red');
                                } else {
                                    var vEdad = $('#edad').val();
                                    if ($('#fumador').val() =='') {
                                            alert('selecciones si es Fumador o no, por favor');
                                            $('#fumador').parent('div').css('color', 'red');
                                    }else {
                                        var vFumador = $('#fumador').val();
                                        var campos = [nombre,apellido,dni,email_1,clave,
                                                      movil,vGenero,vEdad,vFumador];
                                        console.log(campos);
                                        var emial = { 'dato': campos[3]}
                                        validaEmail(emial);
                                         
                                        var datos = {
                                                'name': campos[0],
                                                'lastname': campos[1],
                                                'idn': campos[2],
                                                'email': campos[3],
                                                'password': campos[4],
                                                'movil': campos[5],
                                                'gender': campos[6],
                                                'age': campos[7],
                                                'smoker': campos[8]
                                            }
                                        registraUsuario(datos);     
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function validaEmail(dato){
    $.ajax({
        data:  dato, //datos que se envian a traves de ajax
        url:   HOME+"/procesos/login/validate_email.php", //archivo que recibe la peticion
        type:  'post', //método de envio
        beforeSend: function () { // carga mientras va hacer la consulta
                $("#resultado").html("Procesando, espere por favor...");
                $("#resultado").css('color','green');
        },
        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                if (response == 'SI') {
                    $("#resultado").html("Este email ya esta en uso");
                    $("#resultado").css('color','red');
                }else{
                    $("#resultado").html("");
                }
        }
    });
}

function registraUsuario(datos){
    $.ajax({
        data:  datos, //datos que se envian a traves de ajax
        url:   HOME+"/procesos/login/registro.php", //archivo que recibe la peticion
        type:  'post', //método de envio
        beforeSend: function () {
            $("#guardando").html("Guardando informacion...");
            $("#guardando").css('color','green');
        },
        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            $("#guardando").html("Este datos se guardo "+response);
            $("#guardando").css('color','red');
        }
    });
}
function logear(){
    jQuery.post( 
        HOME+"/procesos/login/login.php", 
        {
            usu: jQuery("#form_login #usuario").val(),
            clv: jQuery("#form_login #clave").val()
        },
        function( data ) {
            if( data.login ){
                location.reload();
            }else{
                alert( data.mes );
            }
        },
        "json"
    );
}

function show_login_modal(seccion){
	switch(seccion){
		case "login":
			jQuery("#modal_login form").css("display", "none");
			jQuery("#form_login").css("display", "block");
		break;
		case "recuperar":
			jQuery(".modal_login form").css("display", "none");
			jQuery("#form_recuperar").css("display", "block");
		break;
	}
    jQuery("#modal_login").css("display", "table");
}

function close_login_modal(){
    jQuery(".modal_login").hide();
}

function postJSON(FORM, URL, ANTES, RESPUESTA){
	jQuery("#"+FORM).submit(function( event ) {
	  	event.preventDefault();
        if( validarAll(FORM) ){
            ANTES();
            // jQuery.post(URL, jQuery("#"+FORM).serialize(), RESPUESTA, 'json');
            jQuery.post(URL, jQuery("#"+FORM).serialize(), RESPUESTA);
        }
	});
}

function subirImg(evt){
	var files = evt.target.files;
    var padre = jQuery(this).parent().parent();
    getRealMime(this.files[0]).then(function(MIME){
        if( MIME.match("image.*") ){
            padre.children('.vlz_img_portada_cargando').css("display", "block");
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    redimencionar(e.target.result, function(img_reducida){
                        //var img_pre = Cookies.get("img_temp");
                        jQuery.post( RUTA_IMGS+"/procesar.php", {img: img_reducida, previa: ""}, function( url ) {
                            //Cookies.set("img_temp", url);
                            padre.children('.vlz_img_portada_fondo').css("background-image", "url("+RUTA_IMGS+"/Temp/"+url+")");
                            padre.children('.vlz_img_portada_normal').css("background-image", "url("+RUTA_IMGS+"/Temp/"+url+")");
                            padre.children('.vlz_img_portada_cargando').css("display", "none");
                            padre.siblings('.vlz_img_portada_valor').val(url);
                            padre.children('.vlz_cambiar_portada').children('input').val("");
                        });
                    });      
                };
           })(files[0]);
           reader.readAsDataURL(files[0]);
        }else{
            padre.children('.vlz_cambiar_portada').children('input').val("");
            padre.children('.vlz_img_portada_cargando').css("display", "none");
            alert("Solo se permiten imagenes");
        }
    }).catch(function(error){
        padre.children('.vlz_cambiar_portada').children('input').val("");
        padre.children('.vlz_img_portada_cargando').css("display", "none");
        alert("Solo se permiten imagenes");
    });  	
}

function getRealMime(file) {
    return new Promise((resolve, reject) => {
        if (window.FileReader && window.Blob) {
            let slice = file.slice(0, 4);
            let reader = new FileReader();
          
            reader.onload = () => {
                let buffer = reader.result;
                let view = new DataView(buffer);
                let signature = view.getUint32(0, false).toString(16);
                let mime = 'unknown';

                switch ( String(signature).toLowerCase() ) {
                    case "89504e47":
                        mime = "image/png";
                    break;
                    case "47494638":
                        mime = "image/gif";
                    break;
                    case "ffd8ffe0":
                        mime = "image/jpeg";
                    break;
                    case "ffd8ffe1":
                        mime = "image/jpeg";
                    break;
                    case "ffd8ffe2":
                        mime = "image/jpeg";
                    break;
                    case "ffd8ffe3":
                        mime = "image/jpeg";
                    break;
                    case "ffd8ffe8":
                        mime = "image/jpeg";
                    break;
                }

                resolve(mime);

            }
            reader.readAsArrayBuffer(slice);
        } else {
            reject(new Error('Usa un navegador moderno para una mejor experiencia'));
        }
    });
}

function initImg(id){
    document.getElementById(id).addEventListener("change", subirImg, false);
}  

/** VALIDACIONES REGISTRO USUARIO*/


/* FIN VALIDACIONES DE REGISTRO */


$(document).on("click", '.popup-registrarte-1 .km-btn-popup-registrarte-1', function ( e ) {
    e.preventDefault();

    $(".popup-registrarte-1").hide();
    $(".popup-registrarte-nuevo-correo").fadeIn("fast");
});

$(document).on("click", '.popup-registrarte-datos-mascota .km-btn-popup-registrarte-datos-mascota', function ( e ) {
    e.preventDefault();

    $(".popup-registrarte-datos-mascota").hide();
    $(".popup-registrarte-final").fadeIn("fast");
});
    // FIN POPUP INICIAR SESIÓN
$(document).on("click", '.popup-registro-cuidador .km-btn-popup-registro-cuidador', function ( e ) {
    e.preventDefault();

    $(".popup-registro-cuidador").hide();
    $(".popup-registro-cuidador-correo").fadeIn("fast");
});

$(document).on("click", '.popup-registro-cuidador-correo .km-btn-popup-registro-cuidador-correo', function ( e ) {
    e.preventDefault();

    $(".popup-registro-cuidador-correo").hide();
    $(".popup-registro-exitoso").fadeIn("fast");
});
$(document).on("click", '.popup-registro-exitoso .km-btn-popup-registro-exitoso', function ( e ) {
    e.preventDefault();

    $(".popup-registro-exitoso").hide();
    $(".popup-registro-cuidador-paso1").fadeIn("fast");
});
$(document).on("click", '.popup-registro-cuidador-paso1 .km-btn-popup-registro-cuidador-paso1', function ( e ) {
    e.preventDefault();

    $(".popup-registro-cuidador-paso1").hide();
    $(".popup-registro-cuidador-paso2").fadeIn("fast");
});
$(document).on("click", '.popup-registro-cuidador-paso2 .km-btn-popup-registro-cuidador-paso2', function ( e ) {
    e.preventDefault();

    $(".popup-registro-cuidador-paso2").hide();
    $(".popup-registro-cuidador-paso3").fadeIn("fast");
});
$(document).on("click", '.popup-registro-cuidador-paso3 .km-btn-popup-registro-cuidador-paso3', function ( e ) {
    e.preventDefault();

    $(".popup-registro-cuidador-paso3").hide();
    $(".popup-registro-exitoso-final").fadeIn("fast");
});


/* Procesado de imagenes */

function d(s){ return jQuery(s)[0].outerHTML; }
function c(i){
   var e = document.getElementById(i);
   if(e && e.getContext){
      var c = e.getContext('2d');
      if(c){
         return c;
      }
   }
   return false;
}

function contenedor_temp(){
    if( jQuery("#kmimos_redimencionar_imagenes").html() == undefined ){
        var img = jQuery("<img>", {
            id: "kmimos_img_temp"
        })[0].outerHTML;

        var cont_canvas = jQuery("<span>", {
            id: "kmimos_canvas_temp"
        })[0].outerHTML

        var cont_general = jQuery("<div>", {
            id: "kmimos_redimencionar_imagenes",
            html: cont_canvas+img,
            style: "display: none;"
        })[0].outerHTML;

        return jQuery("body").append(cont_general);
    }else{
        var img = jQuery("<img>", {
            id: "kmimos_img_temp"
        })[0].outerHTML;

        var cont_canvas = jQuery("<span>", {
            id: "kmimos_canvas_temp"
        })[0].outerHTML

        var cont_general = jQuery("<div>", {
            id: "kmimos_redimencionar_imagenes",
            html: cont_canvas+img,
            style: "display: none;"
        })[0].outerHTML;

        jQuery("#kmimos_redimencionar_imagenes").html(cont_general);
    }
}

function rotar(){
    
}

function redimencionar(IMG_CACHE, CB){
    contenedor_temp();
    var ximg = new Image();
    ximg.src = IMG_CACHE;

    ximg.onload = function(){
        jQuery("#kmimos_redimencionar_imagenes #kmimos_img_temp").attr("src", ximg.src);
        var rxi = jQuery("#kmimos_redimencionar_imagenes #kmimos_img_temp")[0];

        var rw = rxi.width;
        var rh = rxi.height;

        var w = 800;
        var h = 600;

        if( rw > rh ){
            h = Math.round( ( rh * w ) / rw );
        }else{
            w = Math.round( ( rw * h ) / rh );
        }
      
        CA = d("<canvas id='kmimos_canvas' width='"+w+"' height='"+h+"'>");
        jQuery("#kmimos_redimencionar_imagenes #kmimos_canvas_temp").html(CA);
        CA = jQuery("#kmimos_redimencionar_imagenes #kmimos_canvas_temp #kmimos_canvas");

        CTX = c("kmimos_canvas");
        if(CTX){
            CTX.drawImage(ximg, 0, 0, w, h);
            CB( CA[ 0 ].toDataURL("image/jpeg") );
        }else{
            return false;
        }
    }
}

/*  Validaciones */

function validar(id){
    var e = jQuery("#"+id);
    var validaciones = String(e.attr("data-valid")).split(",");

    var error = false;

    jQuery.each(validaciones, function( index, value ) {
        var validacion = value.split(":");
        switch(validacion[0]){
            case "requerid":
                if( e.val() == "" ){ error = true; break; }
            break;
            case "min":
                if( e.val().length < validacion[1] ){ error = true; break; }
            break;
            case "max":
                if( e.val().length > validacion[1] ){ error = true; break; }
            break;
            case "equalTo":
                if( e.val() != jQuery("#"+validacion[1]).val() ){ 
                    error = true; 
                    aplicar_error(validacion[1], true);
                    break; 
                }else{
                    aplicar_error(validacion[1], false);
                }
            break;
        }
    });

    aplicar_error(id, error);

    return error;
}

function pre_validar(elemento){
    if( elemento.attr("data-valid") != undefined ){
        var error = jQuery("<div class='no_error' id='error_"+( elemento.attr('id') )+"' data-id='"+( elemento.attr('id') )+"'></div>");
        var txt = elemento.attr("data-title");
        if( txt == "" || txt == undefined ){ txt = "Completa este campo."; }
        error.html( txt );
        elemento.parent().append( error );

        elemento.on("keyup", function(event){
            validar(event.target.id);
        }); 
        elemento.on("change", function(event){
            validar(event.target.id);
        }); 
            
    } 
}

function aplicar_error(id, error){
    if ( error  ) {
        if( jQuery("#error_"+id).hasClass( "no_error" ) ){
            jQuery("#error_"+id).removeClass("no_error");
            jQuery("#error_"+id).addClass("error");
        } 
    } else {
        if( jQuery("#error_"+id).hasClass( "error" ) ){
            jQuery("#error_"+id).removeClass("error");
            jQuery("#error_"+id).addClass("no_error");
        }
    }
}

function validarAll(Form){

    var submit = true;
    jQuery( "#"+Form+" [data-valid]" ).each(function( index ) {
        if( validar( jQuery( this ).attr("id") ) ){
            submit = false;
        }
    });

    if(!submit){
        var primer_error = ""; var z = true;
        jQuery( ".error" ).each(function() {
            if( jQuery( this ).css( "display" ) == "block" ){
                if( z ){
                    primer_error = "#"+jQuery( this ).attr("data-id"); z = false;
                }
            }
        });

        jQuery('html, body').animate({ scrollTop: jQuery(primer_error).offset().top-130 }, 2000);
    }

    return submit;
}