<?php
wp_enqueue_script( 'kmimos_bootstrap_js', get_home_url()."/panel/assets/vendor/bootstrap/dist/js/bootstrap.min.js",
	array(), '1.0.0', true );

$url_servicio = [];
$ids = "";

if( isset($_SESSION['busqueda']) ){

	$busqueda = unserialize($_SESSION['busqueda']); 
	$busqueda_servicios = $busqueda['servicios']; 

		// Cargar IDs de Servicios
		$condicion = "";
		if( $busqueda_servicios>0 ){
			$where = implode( "%' or  post_name like '", $busqueda_servicios);
			$where = "post_name like '{$where}%'";
		}
		$sql = "
			SELECT * 
			FROM wp_posts 
			WHERE post_author = {$cuidador->user_id} 
				AND post_status = 'publish'
				AND ( {$where} )
		";
		$rows = $wpdb->get_results($sql);
		foreach ($rows as $row) {
			$separador = (!empty($ids))? ",": "";
			$ids .= $separador.$row->ID;
			// Cargar URL del producto
			$url_servicio[$row->ID]['url'] =  get_home_url().'/producto/'.$row->post_name;
			$url_servicio[$row->ID]['name'] = $row->post_title;
		}
		
}
if( count($url_servicio) > 1 ){

	// Buscar solo productos relacionados a la busqueda por woocomerce
	// $servicios_comando = '[products ids="'.$ids.'"]';
	// do_shortcode($servicios_comando)

	$content_modal .= '<!-- Button trigger modal -->
		<button type="button" class="button reservar" data-toggle="modal" data-target="#selector_servicios">
		  Reservar
		</button>

		<!-- Modal -->
		<div class="modal" id="selector_servicios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div>
		      <div class="modal-content">
		        
		        	<strong class="modal_title">Cual servicio deseas?</stronge>
		        	<button style="float:right;" class="btn btn-default btn-sm close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        
		      </div>
		      <div class="modal-body">
		      	<div  class="row">
		        ';
			    foreach($url_servicio as $url){
					$content_modal .= '
					<a href="'.$url['url'].'">
						<div class="theme_button button text-left modal-items">	
								<h4>'.$url['name'].'</h4>
						</div>
					</a>
					';
			    }
		$content_modal .= '

			      </div>
		      </div>

		    </div>
		  </div>
		</div>';

		echo $content_modal;

}else{
	if( count($url_servicio) == 1){
		// Buscar url del servicio
		foreach ($url_servicio as $item) {
			echo '<a class="button reservar" href="'.$item['url'].'">Reservar</a>';
			break;
		}
	}
	else{				
		echo '<a class="button reservar" href="'.get_home_url().'/producto/hospedaje-'.$slug.'/'.'">Reservar</a>';
	}
}

?>

<style type="text/css">
 #selector_servicios{
 	position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1050;
    display: none;
    overflow: hidden;
    -webkit-overflow-scrolling: touch;
    outline: 0;	
    max-width: 400px;
    margin:auto auto;
 }
 .modal-dialog{
	background-color: #fff;
	border: 1px solid #ccc;
	padding-bottom:20px!important;
	border-radius: 10px;
 }
 .modal-content{
 	padding-left:0px;
 }
 .modal_title{
 	line-height: 22px;
	font-size: 16px;
 }
 .modal-body{
 	margin: 0 auto;padding:0px;
 }
 .modal-items{
 	margin:5px;
 	padding:5px; 
 	border-radius:10px; 
 	border:1px solid #ccc; 
 	max-width: 400px;
	font-weight: bold;
 }
 .modal-items:hover{
	background: #0ab7a1;
	color:#fff;
 }
.modal-items-none{
	background: #0ab7a1;
	color:#fff;
 }
</style>