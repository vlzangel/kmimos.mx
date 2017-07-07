<?php
	wp_enqueue_script( 'kmimos_bootstrap_js', get_home_url()."/panel/assets/vendor/bootstrap/dist/js/bootstrap.min.js", array("jquery"), '1.0.0', true );
	$order = "10";
	$order_service = [
		'hospedaje' => [ 
			"order" => 1, 
			"icon" => "icon-hospedaje" 
		],
		'guarderia' => [ 
			"order" => 2, 
			"icon" => "icon-guarderia" 
		],
		'paseos' => [
			"order" => 3, 
			"icon" => "icon-paseos",
		],
		'entrenamiento' => [ 
			"order"=> 4,
			"icon" => "icon-adiestramiento",
		]
	];
	$url_servicio = [];
	$ids = "";
	if( isset($_SESSION['busqueda']) ){
		$busqueda = unserialize($_SESSION['busqueda']); 
		$busqueda_servicios = $busqueda['servicios']; 
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
			$icon_service = "icon-sentado";
			$temp_option = explode("-", $row->post_name);
			if( count($temp_option) > 0 ){
				$key = strtolower($temp_option[0]);
				if( array_key_exists($key, $order_service) ){
					$i = $order_service[$key];
					$icon_service = $i['icon'];
					$order = $i['order'];
				}
			}
			$url_servicio[ "{$order}-{$row->ID}" ] = [
				'icon' => $icon_service, 
				'url' =>  get_home_url().'/producto/'.$row->post_name,
				'name' => $row->post_title,
			];
		}
		ksort($url_servicio);
	}
	if( count($url_servicio) > 1 ){

		$content_modal .= '
		<button type="button" class="button reservar" data-toggle="modal" data-target="#selector_servicios">
		  Reservar
		</button>

		<div class="modal" id="selector_servicios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  	<div class="modal-dialog" role="document">
		    	<div>
		      		<div class="modal-content">
		        		<strong class="modal_title">Cual servicio deseas?</stronge>
		        		<button style="float:right;" class="btn btn-default btn-sm close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      		</div>
		      		<div class="modal-body">
		      			<div  class="row">';
						    foreach($url_servicio as $url){
								$content_modal .= '
								<a href="'.$url['url'].'">
									<div class="row text-left modal-items">	
										<i class="'.$url['icon'].'"></i>
										<span style="margin-left: 5px;">'.$url['name'].'</span>
									</div>
								</a>
								';
						    } $content_modal .= '
			      		</div>
		      		</div>
		    	</div>
		  	</div>
		</div>';

		$HTML .= $content_modal;

	}else{
		if( count($url_servicio) == 1){
			foreach ($url_servicio as $item) {
				$HTML .= '<a class="button reservar" href="'.$item['url'].'">Reservar</a>';
				break;
			}
		}
		else{				
			$HTML .= '<a class="button reservar" href="'.get_home_url().'/producto/'.$slug.'/'.'">Reservar</a>';
		}
	}
?>