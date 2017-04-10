<?php
	function get_estados_municipios(){
		$conn_my = new mysqli("localhost", "root", "", 'kmimos.mx');
		if (!$conn_my) {
		  	echo "No conectado.\n";
		  	exit;
		}
		$result = $conn_my->query("
			select s.id as estado_id, 
				s.name as estado_descripcion, 
				km.valor as estado_ubicacion, 
				l.id as municipio_id, 
				l.name as municipio_descripcion, 
				ke.valor as municipio_ubicacion 
			from states as s left join locations as l on s.id = l.state_id left join kmimos_opciones as km on km.clave = CONCAT('estado_',s.id) left join kmimos_opciones as ke on ke.clave = CONCAT('municipio_',l.id)
				where s.country_id = 1
			order by estado_descripcion, municipio_descripcion ASC");
		$datos = [];
		while ($row = $result->fetch_assoc()){
			$geo_municipio = unserialize($row['municipio_ubicacion']);
			$geo_estado = unserialize($row['estado_ubicacion']);
			if(array_key_exists($row['estado_id'], $datos)){
				if(array_key_exists('municipios', $datos[$row['estado_id']])){
						$estados = $datos[$row['estado_id']]['municipios'];
				}
			}
			$estados[$row['municipio_id']] = [
					"descripcion" => $row['municipio_descripcion'],
					"ubicacion" => $geo_municipio
				];
			$datos[$row['estado_id']] = [
				"descripcion"=>$row['estado_descripcion'],
				"ubicacion" => $geo_municipio,
				"municipios" => $estados
			];
		}
		$datos_json = json_encode($datos,JSON_UNESCAPED_UNICODE );
		return "<script>
				var objectEstados = jQuery.makeArray(
					eval(
						'(".$datos_json.")'
						)
					);
				var estados_municipios = objectEstados[0] ;
			</script>";
	}
