function vlz_galeria_ver(url){
	jQuery('.vlz_modal_galeria_interna').css('background-image', 'url('+url+')');
	jQuery('.vlz_modal_galeria').css('display', 'table');
}
function vlz_galeria_cerrar(){
	jQuery('.vlz_modal_galeria').css('display', 'none');
	jQuery('.vlz_modal_galeria_interna').css('background-image', '');
}