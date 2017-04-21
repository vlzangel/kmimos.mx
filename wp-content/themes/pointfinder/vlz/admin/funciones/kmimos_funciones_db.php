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
?>