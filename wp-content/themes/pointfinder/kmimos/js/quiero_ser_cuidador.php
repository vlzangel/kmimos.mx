<script>
	//MODAL PRECIOS SUGERIDOS-----------------------------------------------------------------------------------------------
		var modalOpend= false;
		function modalPrecios(){
			jQuery(window).scroll(function() {
			    if (jQuery(document).scrollTop() > 1800) {
				    if (modalOpend != true) {
				    	jQuery('#jj_modal').fadeIn();
				       	modalOpend= true;
				    }  
			      
			    // } else {
			      jQuery('#jj_modal').fadeOut();
			      //console.log('Modal cierra')
			     }
			});
		}

		function ocultarModal(){
			jQuery('#jj_modal').fadeOut();
			jQuery('#jj_modal').css('display', 'none');
			modalOpend= true;
		}
	//MODAL PRECIOS SUGERIDOS END-----------------------------------------------------------------------------------------------

	jQuery( document ).ready(function() {
	  	cambiar_img();
	});

	jQuery( window ).resize(function() {
  		cambiar_img();
	});

	function cambiar_img(){
	  	var w = jQuery( window ).width();
  		if( w < 992 ){
  			var img = jQuery("#cargar_imagen_1").html();
  			if( img != "" ){
	  			jQuery("#cargar_imagen_1").html("");
	  			jQuery("#cargar_imagen_2").html(img);
	  			document.getElementById("portada").addEventListener("change", vista_previa, false);
	  			jQuery("#cargar_imagen_2").css("display", "block");
	  			jQuery("#kmimos_datos_personales").removeClass("vlz_cell50");
  			}else{
	  			jQuery("#cargar_imagen_1").css("display", "none");
  			}
  		}else{
  			var img = jQuery("#cargar_imagen_2").html();
  			jQuery("#cargar_imagen_1").css("display", "inline-block");
  			if( img != "" ){
	  			jQuery("#cargar_imagen_2").html("");
	  			jQuery("#cargar_imagen_1").html(img);
	  			document.getElementById("portada").addEventListener("change", vista_previa, false);
	  			jQuery("#kmimos_datos_personales").addClass("vlz_cell50");
  			}else{
	  			jQuery("#cargar_imagen_2").css("display", "none");
  			}
  		}
	}

	var form = document.getElementById('vlz_form_nuevo_cuidador');
	form.addEventListener( 'invalid', function(event){
	    event.preventDefault();
	    jQuery("#error_"+event.target.id).removeClass("no_error");
	    jQuery("#error_"+event.target.id).addClass("error");
	    jQuery("#"+event.target.id).addClass("vlz_input_error");
	}, true);

	function especiales(id){
		switch(id){
			case "ife":
	      		var ife = jQuery( "#ife" ).val();
	      		if( ife.length == 13 ){
	      			return true;
	      		}else{
	      			return false;
	      		}
			break;
			case "telefono":
	      		var telefono = jQuery( "#telefono" ).val();
	      		if( telefono.length >= 7 ){
	      			return true;
	      		}else{
	      			return false;
	      		}
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
			case "hospedaje":
	      		var z = 0;
				var t = [
					'pequenos',
					'medianos',
					'grandes',
					'gigantes'
				];

				jQuery.each(t, function( index, value ) {
					var temp = jQuery('#hospedaje_'+value).attr('value');
					if( temp == '' ){ temp = 0; }
					z += parseInt( temp );
						console.log("Z: "+z);	
				});

				if( z == 0 ){
					jQuery('#error_hospedaje').attr('class', 'error');
				}else{
					jQuery('#error_hospedaje').attr('class', 'no_error');
				}

				return ( z == 0 );
			break;
			default:
				return true;
			break;
		}
	}

	form.addEventListener( 'keyup', function(event){
	    if ( event.target.validity.valid && especiales(event.target.id) ) {
	    	if( jQuery("#error_"+event.target.id).hasClass( "error" ) ){
	    		jQuery("#error_"+event.target.id).removeClass("error");
	        	jQuery("#error_"+event.target.id).addClass("no_error");
	        	jQuery("#"+event.target.id).removeClass("vlz_input_error");
	    	}
	    } else {
	    	if( jQuery("#error_"+event.target.id).hasClass( "no_error" ) ){
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

	           		jQuery(".kmimos_cargando").css("display", "block");
	           		
	    			redimencionar(e.target.result, function(img_reducida){
	    				jQuery(".vlz_img_portada_fondo").css("background-image", "url("+img_reducida+")");
	        			jQuery(".vlz_img_portada_normal").css("background-image", "url("+img_reducida+")");
	        			jQuery("#vlz_img_perfil").attr("value", img_reducida);
	        			jQuery("#error_vlz_img_perfil").css("display", "none");

	           			jQuery(".kmimos_cargando").css("display", "none");
	    			});

	    			
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

	jQuery(".vlz_boton_agregar").on("click", function(){
		jQuery(".vlz_boton_quitar").off("click");
		var servicios = jQuery('<select class="vlz_input" id="servicio[]" name="servicio[]"><option value="8">Guarder&iacute;a (Cuidado durante el d&iacute;a)</option><option value="9">Adiestramiento de obediencia b&aacute;sico</option><option value="10">Adiestramiento de obediencia intermedio</option><option value="11">Adiestramiento de obediencia avanzado</option><option value="12">Paseos</option></select>');
		var contCampos = jQuery("<div>", {"class": "vlz_cell66 jj_input_cell00"});
		<?php
		$tam = array(
			"pequenos" => "Peque&ntilde;os",
			"medianos" => "Medianos",
			"grandes"  => "Grandes",
			"gigantes" => "Gigantes",
		);
		$txts = array(
			"pequenos" => "",
			"medianos" => "",
			"grandes"  => "",
			"gigantes" => ""
		);
			foreach ($tam as $key => $value) {
			echo "var ".$key." = jQuery(\"<div class='vlz_cell25'><input type='text' id='adicional_".$key."' name='adicional_".$key."[]' class='vlz_input' placeholder='".$value."' title='".$txts[$key]."'><div class='no_error' id='error_adicional_".$key."'></div></div>\");";
			echo "jQuery(contCampos).append( ".$key." );";
		}
		?>
		
		var contBoton = jQuery("<div>", {"class": "vlz_cell25"});
			jQuery(contBoton).append( jQuery("<div>", {"class": "vlz_boton_quitar"}) );

		var lista = jQuery("<div>", {"class": "vlz_cell75 jj_input_cell00"});
			jQuery(lista).append( servicios );

		var contLista = jQuery("<div>", {"class": "vlz_cell33 jj_input_cell00"});
		jQuery(contLista).append( contBoton );
		jQuery(contLista).append( lista );

		var newItem = jQuery("<div>", {"class": "vlz_sub_seccion"});
		jQuery(newItem).append( contLista );
		jQuery(newItem).append( contCampos );

		jQuery( ".vlz_contenedor_adicionales" ).append( newItem );

		jQuery(".vlz_boton_quitar").on("click", function(){
			jQuery(this).parent().parent().parent().remove();
		});

	});

	jQuery("#vlz_form_nuevo_cuidador").submit(function(e){

		jQuery("#vlz_modal_cerrar_registrar").attr("onclick", "");

		if( form.checkValidity() ){
	    	var terminos = jQuery("#terminos").attr("value");
			if( terminos == 1){

				var a = "<?php echo get_home_url()."/wp-content/themes/pointfinder/kmimos/registro_cuidador/vlz_procesar.php"; ?>";
		  		jQuery("#vlz_contenedor_botones").css("display", "none");
		  		jQuery(".vlz_modal_contenido").css("display", "none");
		  		jQuery("#vlz_cargando").css("display", "block");
		  		jQuery("#vlz_cargando").css("height", "auto");
		  		jQuery("#vlz_cargando").css("text-align", "center");
		  		jQuery("#vlz_cargando").html("<h2>Registrando, por favor espere...</h2>");
		  		jQuery("#vlz_titulo_registro").html("Registrando, por favor espere...");
		     	
				jQuery.post( a, jQuery("#vlz_form_nuevo_cuidador").serialize(), function( data ) {
		      		data = eval(data);
		      		if( data.error == "SI" ){
		      			jQuery('html, body').animate({ scrollTop: jQuery("#email").offset().top-75 }, 2000);
		      			alert(data.msg);
		      			jQuery("#terminos_y_condiciones").css("display", "none");
		      			jQuery("#vlz_contenedor_botones").css("display", "block");
			      		jQuery(".vlz_modal_contenido").css("display", "block");
			      		jQuery("#terminos").css("display", "block");
			      		jQuery("#vlz_cargando").css("height", "auto");
			      		jQuery("#vlz_cargando").css("display", "none");
			      		jQuery("#vlz_cargando").css("text-align", "justify");
			      		jQuery("#vlz_titulo_registro").html('Términos y Condiciones');
		  				jQuery("#boton_registrar_modal").css("display", "inline-block");
		      		}else{
		      			jQuery("#vlz_titulo_registro").html("Registro Completado!");
					  	jQuery("#vlz_cargando").html(data.msg);
			      		jQuery("#vlz_registro_cuidador_cerrar").css("display", "inline-block");
		      		}
		      	});

				}else{
		  		alert("Debe aceptar los términos y condiciones.");
				vlz_modal('terminos', 'Términos y Condiciones');
			}

		}

		e.preventDefault();
	});

	function GoToHomePage(){
		location = 'http://kmimos.ilernus.com';  
	}

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

	function vlz_validar(){
		var error = 0;

		if( !form.checkValidity() )		{ error++; }
		if( !especiales("clave") )		{ error++; }
		if(  especiales("hospedaje") )	{ error++; }

		if( error > 0 ){
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
			vlz_modal('terminos', 'Términos y Condiciones');
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

	/* DIRECCIONES */

	jQuery("#estado").on("change", function(e){
		var estado_id = jQuery("#estado").val(); 
	    if( estado_id != "" ){
	        var html = "<option value=''>Seleccione un municipio</option>";
	        jQuery.each(estados_municipios[estado_id]['municipios'], function(i, val) {
	            html += "<option value="+val.id+" data-id='"+i+"'>"+val.nombre+"</option>";
	        });
	        jQuery("#municipio").html(html);
	        var location    = estados_municipios[estado_id]['coordenadas']['referencia'];
	        var norte       = estados_municipios[estado_id]['coordenadas']['norte'];
	        var sur         = estados_municipios[estado_id]['coordenadas']['sur'];
	        jQuery("#latitud").attr("value", location.lat);
	        jQuery("#longitud").attr("value", location.lng);
	    }
	});

	jQuery("#municipio").on("change", function(e){
		vlz_coordenadas();
	});

	function vlz_coordenadas(){
		var estado_id = jQuery("#estado").val();            
	    var municipio_id = jQuery('#municipio > option[value="'+jQuery("#municipio").val()+'"]').attr('data-id');   

	    if( estado_id != "" ){

	        var location    = estados_municipios[estado_id]['municipios'][municipio_id]['coordenadas']['referencia'];
	        var norte       = estados_municipios[estado_id]['municipios'][municipio_id]['coordenadas']['norte'];
	        var sur         = estados_municipios[estado_id]['municipios'][municipio_id]['coordenadas']['sur'];

	        jQuery("#latitud").attr("value", location.lat);
	        jQuery("#longitud").attr("value", location.lng);

	    }
	}
</script>
