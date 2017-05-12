<?php
include("../vlz_config.php");
global $host, $user, $pass, $db;
		$conn_my = new mysqli($host, $user, $pass, $db);
		if (!$conn_my) {
		  	exit;
		}

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






				$datos[$id] = array(
					"nombre" => $esta,
					"coordenadas" => unserialize($coord),
//					"municipios" => $municipios
				);

				$ref = $datos[$id]['coordenadas']['referencia'];
				$csv_st = '"'.$id.'"; "'.$esta.'"; "'.$ref->lat.'"; "'.$ref->lng.'"';


				if( $result2->num_rows > 0  ){
					while ($row2 = $result2->fetch_assoc()){
						$municipios[] = array(
							"id" => $row2['id'],
							"nombre" => $row2['muni'],
							"coordenadas" => unserialize($row2['coord'])
						);

					$d = unserialize($row2['coord']);
					$refm = $d['referencia'];
					$muni = '"'.$row2['id'].'"; "'.$row2['muni'].'"; "'.$refm->lat.'"; "'.$refm->lng.'"';
print_r($csv_st.$muni);
echo '<br>';
					}
				}



			}
		}
		$datos_json = json_encode($datos, JSON_UNESCAPED_UNICODE );
