jQuery('div.product_meta').hide();
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
}
jQuery(document).ready(function() { activar_continuar(); });