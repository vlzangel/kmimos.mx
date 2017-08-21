/*jQuery('div.product_meta').hide();
jQuery('span#cerrarModal').click(function(){
	jQuery('#jj_modal_ir_al_inicio').css('display', 'none');	
});

setTimeout(function(){
	jQuery('#jj_modal_ir_al_perfil').css('display', 'table');
	jQuery('#jj_modal_ir_al_inicio').css('display', 'table');
}, 100);

function activar_continuar(){
	jQuery('.single_add_to_cart_button').addClass('xdisabled');
	jQuery('.single_add_to_cart_button').css('background-color', "#60cbac;");
	jQuery('.single_add_to_cart_button').css('color', "#fff;");
	jQuery('.single_add_to_cart_button').html('Continuar');
}*/

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
	}

	if( jQuery('#checkout').val() != "" ){
		var fin = String( jQuery('#checkout').val() ).split("/");
		CARRITO[ "fechas" ][ "fin" ] = new Date( fin[2]+"-"+fin[1]+"-"+fin[0] );
	}

	var error = "";

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
	        CARRITO[ "fechas" ][ "duracion" ] = dias;
	    }
	}

	var cant = 0, duracion = 0;
	jQuery.each( CARRITO[ "cantidades" ], function( key, valor ) {
		if( valor[0]  != undefined && valor[1] > 0 ){
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

jQuery(document).ready(function() { 
	// activar_continuar(); 

	jQuery(".navbar").removeClass("bg-transparent");
	jQuery(".navbar").addClass("bg-white-secondary");
	jQuery('.navbar-brand img').attr('src', HOME+'/images/new/km-logos/km-logo-negro.png');

	jQuery("#transporte").on("change", function(e){
		calcular();
	});

	calcular();

});