<?php


	function get_estados_municipios(){
		require_once('vlz_config.php');
		global $host, $user, $pass, $db;
		$conn_my = new mysqli($host, $user, $pass, $db);
		/*$result = $conn_my->query("
			select s.id as estado_id, 
				s.name as estado_descripcion, 
				km.valor as estado_ubicacion, 
				l.id as municipio_id, 
				l.name as municipio_descripcion, 
				ke.valor as municipio_ubicacion 
			from states as s left join locations as l on s.id = l.state_id left join kmimos_opciones as km on km.clave = CONCAT('estado_',s.id) left join kmimos_opciones as ke on ke.clave = CONCAT('municipio_',l.id)
				where s.country_id = 1
			order by municipio_descripcion ASC");*/

		$result = $conn_my->query("
			SELECT 
				s.id AS id,
				s.name AS esta,
				ko.valor AS coord
			FROM 
				states AS s
			INNER JOIN kmimos_opciones AS ko ON  ( ko.clave = CONCAT('estado_', s.id) )
			WHERE 
				country_id = 1
			ORDER BY 
				name ASC");
		$datos = array();
		if( $result->num_rows > 0  ){
			while ($row = $result->fetch_assoc()){
				extract($row);

				$municipios = array();

				$result2 = $conn_my->query("
					SELECT 
						l.id AS id,
						l.name AS muni,
						ko.valor AS coord
					FROM 
						locations AS l
					INNER JOIN kmimos_opciones AS ko ON  ( ko.clave = CONCAT('municipio_', l.id) )
					WHERE 
						state_id = {$id}
					ORDER BY 
						name ASC"
				);

				if( $result2->num_rows > 0  ){
					while ($row2 = $result2->fetch_assoc()){
						$municipios[] = array(
							"id" => $row2['id'],
							"nombre" => $row2['muni'],
							"coordenadas" => unserialize($row2['coord'])
						);
					}
				}

				$datos[$id] = array(
					"nombre" => $esta,
					"coordenadas" => unserialize($coord),
					"municipios" => $municipios
				);

				/*$geo_municipio = unserialize($row['municipio_ubicacion']);
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
				];*/
			}
		}
		$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE );
		return "<script>
				var objectEstados = jQuery.makeArray(
					eval(
						'(".$datos_json.")'
						)
					);
				var estados_municipios = objectEstados[0] ;
			</script>";
	}
