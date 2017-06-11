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
		SELECT reserva.ID AS id, reserva.post_author AS autor, producto.post_name AS producto, reserva.post_title AS reserva FROM wp_posts AS reserva

		LEFT JOIN wp_postmeta as endmeta   	  ON ( reserva.ID = endmeta.post_id 		)
		LEFT JOIN wp_postmeta as producto_id  ON ( reserva.ID = producto_id.post_id 		)
		LEFT JOIN wp_posts    as producto  	  ON ( producto.ID = producto_id.meta_value 	)
		WHERE 
			reserva.post_type  = 'wc_booking' 			AND 
			endmeta.meta_key   = '_booking_end' 		AND 
			producto_id.meta_key   = '_booking_product_id' 		AND 
			(
				reserva.post_status NOT LIKE '%cancelled%' OR 
				reserva.post_status != 'was-in-cart' 
			) AND  (
				endmeta.meta_value >= '{$actual}'
			)
		GROUP BY reserva.ID
	";

	$resultados = $db->get_results($sql);

	echo "<pre>";
		echo $sql."<br><br>";
		print_r($resultados);
	echo "</pre>";
?>