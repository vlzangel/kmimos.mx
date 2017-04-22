<?php

	require_once("../vlz_config.php");
	$sts = 0;

	if(!empty($_GET) ){
		if( !isset($_GET['source'])) { return; }
		if( empty($_GET['source'])) { return; }
		
		if( !isset($_GET['email'])) { return; }
		if( empty($_GET['email'])) { return; }

		$cnn = new mysqli($host, $user, $pass, $db);
		if($cnn){

			$rows = "SELECT * FROM list_subscribe WHERE source = '".$_GET['source']."' and email = '".$_GET['email']."'";
			$r = $cnn->query( $rows );
			if( $r->num_rows == 0){
				# Insertar registro
				$sql = "insert into list_subscribe( source, email) values ( '".$_GET['source']."','".$_GET['email']."' )";
				$rows = $cnn->query( $sql );
			}
			$sts = 1;
		}else{
			$sts = 0;
		}
	}else{
		$sts = 0;
	}
	print_r($sts);
