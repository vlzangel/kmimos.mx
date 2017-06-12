<?php
	
	class db{

		private $conn;

		function db($con){
			$this->conn = $con;
		}

		function query($sql){
			return $this->conn->query($sql);
		}

		function get_var($sql, $campo = ""){
			$result = $this->query($sql);
			if( $result->num_rows > 0 ){
				if($campo == ""){
					$temp = $result->fetch_array(MYSQLI_NUM);
		            return $temp[0];
				}else{
		            $temp = $result->fetch_assoc();
		            return $temp[$campo];
				}
	        }else{
	        	return false;
	        }
		}

		function get_row($sql){
			$result = $this->query($sql);
			if( $result->num_rows > 0 ){
	            return (object) $result->fetch_assoc();
	        }else{
	        	return false;
	        }
		}

		function get_results($sql){
			$result = $this->query($sql);
			if( $result->num_rows > 0 ){
				$resultados = array();
				while ( $f = $result->fetch_assoc() ) {
					$resultados[] = (object) $f;
				}
	            return $resultados;
	        }else{
	        	return false;
	        }
		}

		function insert_id(){
			return $this->conn->insert_id;
		}
	}

	include("vlz_config.php");

	$conn = new mysqli($host, $user, $pass, $db);

	$db = new db($conn);

	$actual = date( 'YmdHis', time() );

	$sql = "
		SELECT 
			reserva.ID 				 AS id, 
			producto.post_author 	 AS autor, 
			producto.post_name 		 AS producto, 
			startmeta.meta_value 	 AS inicio, 
			endmeta.meta_value		 AS fin,
			acepta.meta_value		 AS acepta,
			order_item_id.meta_value AS item_id,
			(SELECT count(*) FROM wp_woocommerce_order_itemmeta WHERE order_item_id = item_id AND meta_key LIKE '%Mascotas%') AS mascotas

		FROM wp_posts AS reserva

		LEFT JOIN wp_postmeta as startmeta     ON ( reserva.ID 		= startmeta.post_id 		)
		LEFT JOIN wp_postmeta as endmeta   	   ON ( reserva.ID 		= endmeta.post_id 			)
		LEFT JOIN wp_postmeta as order_item_id ON ( reserva.ID 		= order_item_id.post_id 	)
		LEFT JOIN wp_postmeta as producto_id   ON ( reserva.ID 		= producto_id.post_id 		)
		LEFT JOIN wp_posts    as producto  	   ON ( producto.ID 	= producto_id.meta_value 	)
		LEFT JOIN wp_postmeta as acepta  	   ON ( acepta.post_id 	= producto.ID 				)
		WHERE 
			reserva.post_type  		= 'wc_booking' 				AND 
			startmeta.meta_key   	= '_booking_start' 			AND 
			endmeta.meta_key   		= '_booking_end' 			AND 
			producto_id.meta_key   	= '_booking_product_id' 	AND 
			acepta.meta_key   		= '_wc_booking_qty' 		AND 
			order_item_id.meta_key  = '_booking_order_item_id' 	AND 
			(
				reserva.post_status NOT LIKE '%cancelled%' OR 
				reserva.post_status != 'was-in-cart' 
			) AND  (
				endmeta.meta_value >= '{$actual}'
			)
		GROUP BY reserva.ID
		LIMIT 0, 1
	";

	$resultados = $db->get_results($sql);

	echo "<pre>";
		echo $sql."<br><br>";
		print_r($resultados);
	echo "</pre>";

	foreach ($resultados as $reserva) {
		update_cupos($reserva);
	}

	function update_cupos($reserva){
		$inicio = strtotime($reserva->inicio);
		$fin 	= strtotime($reserva->fin);
		for ($i=$inicio; $i < $fin; $i+=86400) { 
			echo date("Y-m-d H:i:s", $i)." - ".$reserva->mascotas."<br>";
		}
	}
?>