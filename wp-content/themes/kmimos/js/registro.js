function click() {
	alert('Hola');	
}

var form = document.getElementById('vlz_form_nuevo_cliente');
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
				email: 	 jQuery("#email_1").attr("value")
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

		jQuery("#vlz_form_nuevo_cliente").submit(function(e){

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
	         	
	      		jQuery.post( a, jQuery("#vlz_form_nuevo_cliente").serialize(), function( data ) {
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