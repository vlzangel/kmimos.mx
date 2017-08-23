var CARRITO = [];
function initCarrito(){
	CARRITO = [];

	CARRITO["fechas"] = [];

		CARRITO["fechas"] = {
			"inicio" : "",
			"fin" : "",
			"duracion" : ""
		};

	CARRITO["cantidades"] = [];

		CARRITO["cantidades"] = {
			"cantidad" : 0,
			"pequenos" : [],
			"medianos" : [],
			"grandes" : [],
			"gigantes" : []
		};

	CARRITO["adicionales"] = [];

		CARRITO["adicionales"] = {
			"bano" : 0,
			"corte" : 0,
			"acupuntura" : 0,
			"limpieza_dental" : 0,
			"visita_al_veterinario" : 0
		};
    
}
initCarrito();

function validar(status, txt){
	if( status ){
		jQuery(".valido").css("display", "block");
		jQuery(".invalido").css("display", "none");
	}else{
		jQuery(".invalido").html(txt);

		jQuery(".valido").css("display", "none");
		jQuery(".invalido").css("display", "block");
	}
}

function calcular(){
	initCarrito();

	jQuery("#reservar .tamano").each(function( index ) {
		CARRITO["cantidades"]["cantidad"] += parseInt(jQuery( this ).val());
		CARRITO[ "cantidades" ][ jQuery( this ).attr("name") ] = [
			parseFloat( jQuery( this ).val() ),
			parseFloat( jQuery( this ).attr("data-valor") )
		];
	});

	var tranporte = jQuery('#transporte option:selected').val();
	if( tranporte != undefined && tranporte != "" ){
		CARRITO[ "transportacion" ] = [
			"Transportaci&oacute;n - "+jQuery('#transporte option:selected').text(),
			parseFloat(tranporte)
		];
	}

	jQuery("#adicionales input").each(function( index ) {
		var activo = jQuery( this ).attr('class');
        if(activo == "active"){
        	CARRITO[ "adicionales" ][ jQuery( this ).attr("name") ] = parseFloat( jQuery( this ).val() );
        }
	});

	if( jQuery('#checkin').val() != "" ){
		var ini = String( jQuery('#checkin').val() ).split("/");
		CARRITO[ "fechas" ][ "inicio" ] = new Date( ini[2]+"-"+ini[1]+"-"+ini[0] );

		jQuery("#fecha_ini").html( jQuery('#checkin').val() );
	}

	if( jQuery('#checkout').val() != "" ){
		var fin = String( jQuery('#checkout').val() ).split("/");
		CARRITO[ "fechas" ][ "fin" ] = new Date( fin[2]+"-"+fin[1]+"-"+fin[0] );

		jQuery("#fecha_fin").html( jQuery('#checkout').val() );
	}

	var error = "";

	var cupos = verificarCupos();

	if( cupos.excede.length > 0 ){
		error += "Hay cupos insuficientes en las siguientes fechas:<br><ul>";
		jQuery.each(cupos.excede, function( index, item ) {
			error += "<li>"+item[0]+", cupos disponibles: "+item[1]+"</li>";
		});
		error += "</ul>";
	}

	if( cupos.full.length > 0 ){
		error += "Las siguientes fechas no tienen cupos disponibles:<br><ul>";
		jQuery.each(cupos.full, function( index, item ) {
			error += "<li>"+item+"</li>";
		});
		error += "</ul>";
	}

	if( cupos.no_disponible.length > 0 ){
		error += "Las siguientes fechas estan bloqueadas por el cuidador:<br><ul>";
		jQuery.each(cupos.no_disponible, function( index, item ) {
			error += "<li>"+item+"</li>";
		});
		error += "</ul>";
	}

	var dias = 0;
	if( CARRITO[ "fechas" ][ "inicio" ] == undefined || CARRITO[ "fechas" ][ "inicio" ] == "" ){
		error = "Ingrese la fecha de inicio";
	}else{
		if( CARRITO[ "fechas" ][ "fin" ] == undefined || CARRITO[ "fechas" ][ "fin" ] == "" ){
			error = "Ingrese la fecha de finalizaci&oacute;n";
		}else{
			var fechaInicio = CARRITO[ "fechas" ][ "inicio" ].getTime();
			var fechaFin    = CARRITO[ "fechas" ][ "fin" ].getTime();
			var diff = fechaFin - fechaInicio;
			dias = parseInt( diff/(1000*60*60*24) );
	    }

		if( tipo_servicio != "hospedaje" ){
			if( dias == 0 ){
				dias=1;
			}else{
				dias += 1;
			}
		}else{
			if( dias == 0 ){
				error = "Fecha de finalizaci&oacute;n debe ser diferente a la de inicio";
			}
		}

        CARRITO[ "fechas" ][ "duracion" ] = dias;
	}

	var cant = 0, duracion = 0;
	jQuery.each( CARRITO[ "cantidades" ], function( key, valor ) {
		if( key != "cantidad" && valor[0]  != undefined && valor[1] > 0 ){
			cant += ( parseFloat( valor[0] ) * parseFloat( valor[1] ) );
		}
	});	

	if( error == "" ){
		if( cant == 0 ){
			error = "Ingrese la cantidad de mascotas";
		}else{
			cant *= parseFloat( dias );
			jQuery(".km-price-total").html("$"+cant);
		}
	}
	
	jQuery.each( CARRITO[ "adicionales" ], function( key, valor ) {
		if( valor > 0 ){
			cant += valor;
		}
	});	

	if( CARRITO[ "transportacion" ] != undefined ){
		cant = parseFloat( cant ) + parseFloat( CARRITO[ "transportacion" ][1] );
	}
	
	if( error != "" ){
		jQuery(".invalido").html(error);

		jQuery(".valido").css("display", "none");
		jQuery(".invalido").css("display", "block");
	}else{
		jQuery(".valido").css("display", "block");
		jQuery(".invalido").css("display", "none");

		jQuery(".km-price-total").html("$"+cant);
	}
	
	if( error == "" ){
		jQuery("#pago_17").html( "$" + (cant-(cant/1.2)) );
		jQuery("#pago_cuidador").html( "$" + (cant/1.2) );
		jQuery("#monto_total").html( "$" + cant );
	}

	initFactura();
    
}

function numberFormat(numero){
	numero = String(numero);
    // Variable que contendra el resultado final
    var resultado = "";

    // Si el numero empieza por el valor "-" (numero negativo)
    if(numero[0]=="-"){
        // Cogemos el numero eliminando los posibles puntos que tenga, y sin
        // el signo negativo
        nuevoNumero=numero.replace(/\./g,'').substring(1);
    }else{
        // Cogemos el numero eliminando los posibles puntos que tenga
        nuevoNumero=numero.replace(/\./g,'');
    }

    // Si tiene decimales, se los quitamos al numero
    if(numero.indexOf(",")>=0){
        nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf(","));
    }

    // Ponemos un punto cada 3 caracteres
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++){
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + resultado;
    }

    // Si tiene decimales, se lo añadimos al numero una vez forateado con 
    // los separadores de miles
    if(numero.indexOf(",")>=0){
        resultado+=numero.substring(numero.indexOf(","));
    }

    if(numero[0]=="-"){
        // Devolvemos el valor añadiendo al inicio el signo negativo
        return "-"+resultado;
    }else{
        return resultado;
    }
}

function verificarCupos(){
	var validacion = {
		"no_disponible": [],
		"full": [],
		"excede": [],
	};
	if( 
		CARRITO[ "fechas" ][ "inicio" ] != "" &&
		CARRITO[ "fechas" ][ "fin" ] != "" 
	){
		var ini = CARRITO[ "fechas" ][ "inicio" ].getTime();
		var fin = CARRITO[ "fechas" ][ "fin" ].getTime();
		var act = new Date();
		var tem = "";
		if( 
			ini != undefined && ini != "" &&
			fin != undefined && fin != ""
		){
			jQuery.each(cupos, function( index, item ) {
				tem = String( item.fecha ).split("-");
				act = new Date( tem[0]+"-"+tem[1]+"-"+tem[2] ).getTime();
				if( (ini <= act) && (act <= fin) ){
					if( item.full == 1 || item.no_disponible == 1 ){
						if( item.full == 1 ){
							validacion["full"].push( tem[2]+"/"+tem[1]+"/"+tem[0] );
						}
						if( item.no_disponible == 1 ){
							validacion["no_disponible"].push( tem[2]+"/"+tem[1]+"/"+tem[0] );
						}
					}else{
						var sub_total = parseInt(item.cupos) + parseInt(CARRITO["cantidades"]["cantidad"]);
						if( sub_total > item.acepta ){
							var cupos_disponibles = ( parseInt(item.acepta) - parseInt(item.cupos) );
							if( cupos_disponibles < 0 ){
								cupos_disponibles = 0;
							}
							validacion["excede"].push( [
								tem[2]+"/"+tem[1]+"/"+tem[0],
								cupos_disponibles
							] );
						}
					}
				}
			});
		}
	}
	return validacion;
}

function initFactura(){

	diaNoche = "d&iacute;a";
	if( tipo_servicio == "hospedaje" ){
		diaNoche = "Noche";
	}

	var plural = "";
	if( CARRITO["cantidades"]["cantidad"] > 1 ){
		diaNoche += "s";
		plural += "s";
	}

	var tamanos = {
		"pequenos" : "Peque&ntilde;a",
		"medianos" : "Mediana",
		"grandes" :  "Grande",
		"gigantes" : "Gigante"
	};

	var items = "";
	var subtotal = 0;
	jQuery.each(tamanos, function( key, tamano ) {
		
		if( CARRITO["cantidades"][key][0] != undefined && CARRITO["cantidades"][key][0] > 0 && CARRITO["cantidades"][key][1] > 0 ){
			
			var plural = "";
			if( CARRITO["cantidades"][key][0] > 1 ){
				plural += "s";
			}

			subtotal = 	parseInt( CARRITO["cantidades"][key][0] ) *
						parseInt( CARRITO["fechas"]["duracion"] ) *
						parseFloat( CARRITO["cantidades"][key][1] );

			items += '<div class="km-option-resume-service">'
			items += '	<span class="label-resume-service">'+CARRITO["cantidades"][key][0]+' Mascota'+plural+' '+tamano+plural+' x '+CARRITO["fechas"]["duracion"]+' '+diaNoche+' x $'+CARRITO["cantidades"][key][1]+' </span>'
			items += '	<span class="value-resume-service">$'+subtotal+'</span>'
			items += '</div>';
		}

	});

	var adicionales = {
		"bano": "Ba&ntilde;o",
		"corte": "Corte de pelo y u&ntilde;as",
		"acupuntura": "Acupuntura",
		"limpieza_dental": "Limpieza Dental",
		"visita_al_veterinario": "Visita al veterinario"
	};

	jQuery.each(adicionales, function( key, adicional ) {
		
		if( CARRITO["adicionales"][key] != undefined && CARRITO["adicionales"][key] != "" && CARRITO["adicionales"][key] > 0 ){
			
			//console.log(CARRITO["cantidades"][key]);

			subtotal = 	parseInt( CARRITO["cantidades"]["cantidad"] ) *
						parseFloat( CARRITO["adicionales"][key] );

			items += '<div class="km-option-resume-service">'
			items += '	<span class="label-resume-service">'+adicional+' $'+CARRITO["adicionales"][key]+' x '+CARRITO["cantidades"]["cantidad"]+' Mascotas  </span>'
			items += '	<span class="value-resume-service">$'+subtotal+'</span>'
			items += '</div>';
		}

	});

	if( CARRITO["transportacion"] != undefined && CARRITO["transportacion"][1] > 0 ){
		items += '<div class="km-option-resume-service">'
		items += '	<span class="label-resume-service">'+CARRITO["transportacion"][0]+' - Precio por Grupo </span>'
		items += '	<span class="value-resume-service">$'+CARRITO["transportacion"][1]+'</span>'
		items += '</div>';
	}

	jQuery("#items_reservados").html( items );
}

jQuery(document).ready(function() { 
	// activar_continuar(); 

	jQuery(".navbar").removeClass("bg-transparent");
	jQuery(".navbar").addClass("bg-white-secondary");
	jQuery('.navbar-brand img').attr('src', HOME+'/images/new/km-logos/km-logo-negro.png');

	jQuery("#transporte").on("change", function(e){
		calcular();
	});

	jQuery("#reserva_btn_next_1").on("click", function(e){
		jQuery("#step_1").css("display", "none");
		jQuery("#step_2").css("display", "block");
		e.preventDefault();
	});

	jQuery("#reserva_btn_next_2").on("click", function(e){
		jQuery("#step_2").css("display", "none");
		jQuery("#step_1").css("display", "block");
		e.preventDefault();
	});

	calcular();

});