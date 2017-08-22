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
});

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

// POPUP INICIAR SESIÓN
    $(document).on("click", '.popup-iniciar-sesion-1 .km-btn-contraseña-olvidada', function ( e ) {
        e.preventDefault();

        $(".popup-iniciar-sesion-1").hide();
        $(".popup-olvidaste-contrasena").fadeIn("fast");
    });
    $(document).on("click", '.popup-registrarte-1 .km-btn-popup-registrarte-1', function ( e ) {
        e.preventDefault();

        $(".popup-registrarte-1").hide();
        $(".popup-registrarte-nuevo-correo").fadeIn("fast");
    });
    $(document).on("click", '.popup-registrarte-nuevo-correo .km-btn-popup-registrarte-nuevo-correo', function ( e ) {
        e.preventDefault();

        $(".popup-registrarte-nuevo-correo").hide();
        $(".popup-registrarte-datos-mascota").fadeIn("fast");
    });
    $(document).on("click", '.popup-registrarte-datos-mascota .km-btn-popup-registrarte-datos-mascota', function ( e ) {
        e.preventDefault();

        $(".popup-registrarte-datos-mascota").hide();
        $(".popup-registrarte-final").fadeIn("fast");
    });
    // FIN POPUP INICIAR SESIÓN




//Para la integracion del registro

var form = document.getElementById('form_nuevo_cliente');
    form.addEventListener( 'invalid', function(event){
        event.preventDefault();
        jQuery("#error_"+event.target.id).html( jQuery("#error_"+event.target.id).attr("data-title") );

        jQuery("#error_"+event.target.id).removeClass("no_error");
        jQuery("#error_"+event.target.id).addClass("error");
        jQuery("#"+event.target.id).addClass("vlz_input_error");
    }, true);

    function especiales(id){
        switch(id){
            case "movil":
                var telefono = jQuery( "#movil" ).val();

                if( telefono.length >= 10 && telefono.length <= 11 ){
                    return true;
                }else{
                    return false;
                }
            break;
            case "telefono":
                var telefono = jQuery( "#telefono" ).val();

                if( telefono.length >= 10 && telefono.length <= 11 ){
                    return true;
                }else{
                    return false;
                }
            break;
            case "email_2":
                var clv1 = jQuery("#email_1").attr("value");
                var clv2 = jQuery("#email_2").attr("value");
                return ( clv1 == clv2 );
            break;
            case "clave":
                var clv1 = jQuery("#clave").attr("value");
                var clv2 = jQuery("#clave2").attr("value");

                return ( clv1 == clv2 );
            break;
            case "clave2":
                var clv1 = jQuery("#clave").attr("value");
                var clv2 = jQuery("#clave2").attr("value");

                return ( clv1 == clv2 );
            break;
            default:
                return true;
            break;
        }
    }

    form.addEventListener( 'keypress', function(event){
        if ( event.target.validity.valid && especiales(event.target.id) ) {
            if( jQuery("#error_"+event.target.id).hasClass( "error" ) ){
                jQuery("#error_"+event.target.id).removeClass("error");
                jQuery("#error_"+event.target.id).addClass("no_error");
                jQuery("#"+event.target.id).removeClass("vlz_input_error");
            }
        } else {
            if( jQuery("#error_"+event.target.id).hasClass( "no_error" ) ){
                jQuery("#error_"+event.target.id).html( jQuery("#error_"+event.target.id).attr("data-title") );
                jQuery("#error_"+event.target.id).removeClass("no_error");
                jQuery("#error_"+event.target.id).addClass("error");
                jQuery("#"+event.target.id).addClass("vlz_input_error");
            } 
        }
    }, true);

    form.addEventListener( 'change', function(event){
        if ( event.target.validity.valid && especiales(event.target.id) ) {
            if( jQuery("#error_"+event.target.id).hasClass( "error" ) ){
                jQuery("#error_"+event.target.id).removeClass("error");
                jQuery("#error_"+event.target.id).addClass("no_error");
                jQuery("#"+event.target.id).removeClass("vlz_input_error");
            }
        } else {
            if( jQuery("#error_"+event.target.id).hasClass( "no_error" ) ){
                jQuery("#error_"+event.target.id).html( jQuery("#error_"+event.target.id).attr("data-title") );
                jQuery("#error_"+event.target.id).removeClass("no_error");
                jQuery("#error_"+event.target.id).addClass("error");
                jQuery("#"+event.target.id).addClass("vlz_input_error");
            } 
        }

    }, true);

    jQuery(".vlz_input").each(function( index ) {
        var error = jQuery("<div class='no_error' id='error_"+( jQuery( this ).attr('id') )+"' data-id='"+( jQuery( this ).attr('id') )+"'></div>");
        var txt = jQuery( this ).attr("data-title");
        if( txt == "" || txt == undefined ){ txt = "Completa este campo."; }
        error.attr( "data-title", txt );
        error.html( txt );
        jQuery( this ).parent().append( error );
    });

        function vista_previa(evt) {
        var files = evt.target.files;
        for (var i = 0, f; f = files[i]; i++) {  
            if (!f.type.match("image.*")) {
                continue;
            }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
               return function(e) {
                    jQuery(".vlz_img_portada_fondo").css("background-image", "url("+e.target.result+")");
                    jQuery(".vlz_img_portada_normal").css("background-image", "url("+e.target.result+")");
                    jQuery("#vlz_img_perfil").attr("value", e.target.result);
                    jQuery("#error_vlz_img_perfil").css("display", "none");
               };
           })(f);
           reader.readAsDataURL(f);
        }
    }      
        document.getElementById("portada").addEventListener("change", vista_previa, false);

        jQuery(".vlz_pin_check").on("click", function(){
            if( jQuery("input", this).attr("value") == "0" ){
                jQuery("input", this).attr("value", "1");
                jQuery(this).removeClass("vlz_no_check");
                jQuery(this).addClass("vlz_check");
            }else{
                jQuery("input", this).attr("value", "0");
                jQuery(this).removeClass("vlz_check");
                jQuery(this).addClass("vlz_no_check");
            }
        });

        function mail_ext_temp(id){
            jQuery(".vlz_modal_contenido").css("display", "none");
            jQuery("#vlz_cargando").css("display", "block");

            // jQuery("#vlz_cargando").html("<h2>Enviando Informaci&oacute;n al correo...</h2>");

            jQuery.ajax({
            url: '<?php echo get_home_url()."/wp-content/themes/pointfinder"."/vlz/form/vlz_mail_cliente.php"; ?>',
            type: "post",
            data: {
                nombre: jQuery("#nombres").attr("value")+" "+jQuery("#apellidos").attr("value"),
                clave:   jQuery("#clave").attr("value"),
                email:   jQuery("#email_1").attr("value")
            },
            success: function (r) {
                data = eval(r);
                if( data.error == "SI" ){
                    alert(data.msg);
                }else{
                    location.href = "<?php echo get_home_url(); ?>/?init="+id;
                }
            }
        });
        }

        jQuery("#form_nuevo_cliente").submit(function(e){

            e.preventDefault();

            jQuery("#vlz_modal_cerrar_registrar").attr("onclick", "");

            if( form.checkValidity() ){

            var terminos = jQuery("#terminos").attr("value");
            if( terminos == 1){

                var a = "<?php echo get_home_url()."/wp-content/themes/pointfinder"."/vlz/form/vlz_registrar.php"; ?>";

                jQuery("#vlz_contenedor_botones").css("display", "none");
                jQuery(".vlz_modal_contenido").css("display", "none");
                jQuery("#vlz_cargando").css("display", "block");
                jQuery("#vlz_cargando").css("height", "auto");
                jQuery("#vlz_cargando").css("text-align", "center");
                jQuery("#vlz_cargando").html("<h2>Registrando, por favor espere...</h2>");
                jQuery("#vlz_titulo_registro").html("Registrando, por favor espere...");
                
                jQuery.post( a, jQuery("#form_nuevo_cliente").serialize(), function( data ) {
                    // console.log(data);
                    mail_ext_temp(data);
                });

            }else{
                alert("Debe aceptar los términos y condiciones.");
                    vlz_modal('terminos', 'Términos y Condiciones');
            }

            }

        });

        

        function mails_iguales(e){
            if( e.currentTarget.name == 'email_1' || e.currentTarget.name == 'email_2' ){
            var clv1 = jQuery("#email_1").attr("value");
            var clv2 = jQuery("#email_2").attr("value");
            if( clv1 != clv2 ){
                jQuery("#error_email_2").html("Los emails deben ser iguales");
                jQuery("#error_email_2").removeClass("no_error");
                jQuery("#error_email_2").addClass("error");
                jQuery("#email_2").addClass("vlz_input_error");
            }else{
                jQuery("#error_email_2").removeClass("error");
                jQuery("#error_email_2").addClass("no_error");
                jQuery("#email_2").removeClass("vlz_input_error");
            }
            }
        }

        jQuery( "#email_1" ).keyup(mails_iguales);
        jQuery( "#email_2" ).keyup(mails_iguales);



        function clvs_iguales(e){
            var clv1 = jQuery("#clave").attr("value");
            var clv2 = jQuery("#clave2").attr("value");

            if( clv1 == clv2 ){

                jQuery("#error_clave").removeClass("error");
            jQuery("#error_clave").addClass("no_error");
            jQuery("#clave").removeClass("vlz_input_error");

                jQuery("#error_clave2").removeClass("error");
            jQuery("#error_clave2").addClass("no_error");
            jQuery("#clave2").removeClass("vlz_input_error");

            }else{
            jQuery("#error_clave").removeClass("no_error");
            jQuery("#error_clave").addClass("error");
            jQuery("#clave").addClass("vlz_input_error");

            jQuery("#error_clave2").removeClass("no_error");
            jQuery("#error_clave2").addClass("error");
            jQuery("#clave2").addClass("vlz_input_error");
            }
        }

        jQuery( "#clave" ).keyup(clvs_iguales);
        jQuery( "#clave2" ).keyup(clvs_iguales);

        jQuery( "#email_1" ).blur(function(){
            var a = "<?php echo get_home_url()."/wp-content/themes/pointfinder"."/vlz/form/vlz_verificar_email.php"; ?>";
            jQuery.post( a, {email: jQuery("#email_1").attr("value")}, function( data ) {
            data = eval(data);
            if( data.error == "SI" ){
                jQuery("#error_email_1").html("Este email ya esta en uso");
                jQuery("#error_email_1").removeClass("no_error");
                jQuery("#error_email_1").addClass("error");
                jQuery("#email_1").addClass("vlz_input_error");
                jQuery('html, body').animate({ scrollTop: jQuery("#email_1").offset().top-75 }, 2000);
            }else{
                jQuery("#error_email_1").html("Formato Invalido<br>Ej: xxxx@mail.com");
            }
        });
        });

        function vlz_validar(){
            var error = 0;
            var campos = ["movil", "telefono", "email_1", "email_2", "clave", "clave2"];
            campos.forEach(function(item, index){
                if( !especiales(item) ){
                    console.log(item);
                    error++;
                }
            });
            if( !form.checkValidity() || error > 0 ){
                var primer_error = ""; var z = true;
                jQuery( ".error" ).each(function() {
                if( jQuery( this ).css( "display" ) == "block" ){
                    if( z ){
                        primer_error = "#"+jQuery( this ).attr("data-id");
                        z = false;
                    }
                }
            });
                jQuery('html, body').animate({ scrollTop: jQuery(primer_error).offset().top-75 }, 2000);
            }else{
            var a = "<?php echo get_home_url()."/wp-content/themes/pointfinder"."/vlz/form/vlz_verificar_email.php"; ?>";
                jQuery.post( a, {email: jQuery("#email_1").attr("value")}, function( data ) {
                data = eval(data);
                if( data.error == "SI" ){
                    jQuery("#error_email_1").html("Este email ya esta en uso");
                    jQuery("#error_email_1").removeClass("no_error");
                    jQuery("#error_email_1").addClass("error");
                    jQuery("#email_1").addClass("vlz_input_error");
                    jQuery('html, body').animate({ scrollTop: jQuery("#email_1").offset().top-75 }, 2000);
                }else{
                    vlz_modal('terminos', 'Términos y Condiciones');
                }
            });
            }
        }

        function vlz_modal(tipo, titulo, contenido){
            switch(tipo){
                case "terminos":
                    jQuery("#vlz_titulo_registro").html(titulo);
                    jQuery("#terminos_y_condiciones").css("display", "table");
                    jQuery("#boton_registrar_modal").css("display", "inline-block");
                break;
            }
        }