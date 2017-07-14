<?php
	header('Access-Control-Allow-Origin: *');
	
	$sts = 0;

	if(isset($_GET['email']))
	{
		$file = fopen("newsletter.csv", "a+");
		fwrite($file, $_GET['email'].";" . PHP_EOL);
		fclose($file);
		$sts=1;
	}

	return $sts;
