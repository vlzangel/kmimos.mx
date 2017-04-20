function update_tipo_usuario(){
	var tipo 	 = jQuery("#tipo_usuario").attr('value');
  	var user_id  = jQuery("#user_id").attr('value');
	jQuery.ajax({
	    url: SETUP_URL_AJAX,
	    type: "post",
	    data: {
	    	action: "update_tipo_usuario",
	    	id: 	user_id,
	    	tipo:   tipo
	    },
	    success: function (data) {
  			jQuery(".kmimos_modal_interno").css("display", "none");
  			refresh();
	    }
	});
}

function update_descripcion(){
	var descripcion = jQuery("#descripcion").val();
  	var page_id  = jQuery("#page_id").attr('value');
	jQuery.ajax({
	    url: SETUP_URL_AJAX,
	    type: "post",
	    data: {
	    	action: "update_descripcion",
	    	id: 	page_id,
	    	desc:   descripcion
	    },
	    success: function (data) {
	    	console.log(data);
  			jQuery(".kmimos_modal_interno").css("display", "none");
  			refresh();
	    }
	});
}

// Refresh

function listar_administradores(page = 0){
	jQuery.ajax({
	    url: SETUP_URL_AJAX,
	    type: "post",
	    data: {
	    	action: "administradores",
	    	pagina: page
	    },
	    success: function (data) {

	    	var datos = data.split("====");

      		jQuery("#kmimos_panel_setup").html(datos[0]);
      		jQuery("#kmimos_panel_setup_paginacion").html(datos[1]);

      		jQuery(".editar_tipo_usuario").on("click", function(e){
      			var user_id = jQuery(this).attr( "data-id" );
      			var tipo = jQuery(this).attr( "data-tipo" );

      			jQuery("#tipo_usuario > option[value='"+tipo+"']").attr('selected', 'selected'); 
      			jQuery("#user_id").attr('value', user_id); 

      			jQuery("#editar_tipo_usuario_modal").css("display", "table");
      		});
	    }
	});
}

function listar_descripciones(page = 0){
	jQuery.ajax({
	    url: SETUP_URL_AJAX,
	    type: "post",
	    data: {
	    	action: "paginas",
	    	pagina: page
	    },
	    success: function (data) {

	    	var datos = data.split("====");

      		jQuery("#kmimos_setup_descripciones").html(datos[0]);
      		jQuery("#kmimos_setup_descripciones_paginacion").html(datos[1]);

      		jQuery(".editar_descripcion_pagina").on("click", function(e){
      			var page_id = jQuery(this).attr( "data-id" );
      			var desc = jQuery(this).attr( "data-desc" );
	    		
      			jQuery("#page_id").attr("value", page_id);
      			jQuery("#descripcion").val(desc);

      			jQuery("#editar_descripcion_modal").css("display", "table");
      		});
	    }
	});
}

function refresh(){
	listar_administradores(0);
	listar_descripciones(0);
}
refresh();