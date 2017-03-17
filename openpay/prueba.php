<?php

	include("openpay/Openpay.php");

	$openpay = Openpay::getInstance('mbagfbv0xahlop5kxrui', 'sk_b485a174f8d34df3b52e05c7a9d8cb22');
	Openpay::setProductionMode(true);

	$findDataRequest = array(
	    'creation[gte]' => '2017-02-27',
	    'creation[lte]' => '2017-02-27',
	    'offset' => 0,
	    'limit' => 10000
    );

	$chargeList = $openpay->charges->getList($findDataRequest);

	foreach ($chargeList as $key => $value) {
		echo "Fecha: ".$value->creation_date."   -   Order ID:".$value->order_id."   -   Estatus: ".$value->status."<br>";
	}

?>