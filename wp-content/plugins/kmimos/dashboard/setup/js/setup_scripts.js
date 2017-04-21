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
  	var index  = jQuery("#index").attr('value');

	jQuery(".editar_descripcion_pagina_"+page_id).attr("data-desc", descripcion);
	jQuery(".editar_descripcion_pagina_"+page_id+" .editar_descripcion_pagina_td").html(descripcion);
	paginas.registros[index][1] = descripcion;

	jQuery.ajax({
	    url: SETUP_URL_AJAX,
	    type: "post",
	    data: {
	    	action: "update_descripcion",
	    	id: 	page_id,
	    	desc:   descripcion
	    },
	    success: function (data) {
  			jQuery(".kmimos_modal_interno").css("display", "none");
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

function listar_descripciones(page = 0, init = 0){
	var HTML = "", PAGINAS = "";
	var xpI = page*10;
	var xpF = (page*10)+10;
	if( xpF >= paginas.registros.length) {
		xpF = paginas.registros.length;
	}
	for (var i = xpI; i < xpF; i++) {
		HTML += "<tr class='editar_descripcion_pagina editar_descripcion_pagina_"+paginas.registros[i][0]+"' data-id='"+paginas.registros[i][0]+"' data-desc='"+paginas.registros[i][1]+"' data-index='"+i+"'>";
		HTML += "<td> <a href='"+URL_HOME+"/"+paginas.registros[i][3]+"' target='_blank'> "+paginas.registros[i][2]+" </a> </td>";
		HTML += "<td class='editar_descripcion_pagina_td'> "+paginas.registros[i][1]+" </td>";
		HTML += "</tr>";
	}
	jQuery("#kmimos_setup_descripciones").html(HTML);
	jQuery(".editar_descripcion_pagina").on("click", function(e){
		var page_id = jQuery(this).attr( "data-id" );
		var index = jQuery(this).attr( "data-index" );
		var desc = jQuery(this).attr( "data-desc" );
	
		jQuery("#page_id").attr("value", page_id);
		jQuery("#index").attr("value", index);
		jQuery("#descripcion").val(desc);

		jQuery("#editar_descripcion_modal").css("display", "table");
	});
	if( init == 1){
		for (var i = 0; i < paginas.paginas.length; i++) {
			PAGINAS += "<span class='kmimos_paginacion_item kmimos_paginacion_item_"+paginas.paginas[i]+"' onclick='listar_descripciones("+(paginas.paginas[i]-1)+")'>"+paginas.paginas[i]+"</span>";
		}
		jQuery("#kmimos_setup_descripciones_paginacion").html("<div class='kmimos_paginacion'>"+PAGINAS+"</div>");
	}
	jQuery("#kmimos_setup_descripciones_paginacion .kmimos_paginacion_item").removeClass("kmimos_paginacion_activa");
	jQuery("#kmimos_setup_descripciones_paginacion .kmimos_paginacion_item_"+(page+1)).addClass("kmimos_paginacion_activa");
}

function refresh(){
	listar_administradores(0);
	listar_descripciones(0, 1);
}

jQuery(function() {
  	refresh();
});
