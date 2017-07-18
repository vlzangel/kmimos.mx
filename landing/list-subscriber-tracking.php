<?php
	header('Access-Control-Allow-Origin: *');
	require_once("../vlz_config.php");
	$sts = 0;

	if(!empty($_GET) ){
		if( !isset($_GET['option'])) { return; }
		if( empty($_GET['option'])) { return; }
		
		if( !isset($_GET['email'])) { return; }
		if( empty($_GET['email'])) { return; }

		$cnn = new mysqli($host, $user, $pass, $db);
		if($cnn){

			$rows = "SELECT * FROM list_subscriber_tracking WHERE `option` = '".$_GET['option']."' and user_email = '".$_GET['email']."'";
			$r = $cnn->query( $rows );
			if( $r->num_rows == 0){
				# Insertar registro
				$sql = "insert into list_subscriber_tracking
							( user_email, `option`, value) 
						values 
							( '".$_GET['email']."','".$_GET['option']."','1' )";
			}else{
				# Update registro
				$sql = "update list_subscriber_tracking set 
							value = value + 1
						where 
							user_email = '".$_GET['email']."' 
							and `option` = '".$_GET['option']."'" 
				;
			}
			if( $cnn->query( $sql ) ){	
				$sts = 1;
			}else{
				$sts = 0;
			}
		}else{
			$sts = 0;
		}
	}else{
		$sts = 0;
	}
	print_r($sts);
