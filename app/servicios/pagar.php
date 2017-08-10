<?php
	$path = dirname(dirname(__DIR__));

	include( $path."/app/db.php");
	include( $path."/app/lib/openpay/Openpay.php");

	extract($_POST);

	$data = explode("===", $_POST["carrito"]);
	$info = array();
	foreach ($data as $key => $value) {
		$info[] = json_decode($value);
	}

	extract($info);
	extract($data);

	if( $deviceIdHiddenFieldName != "" ){

		$MERCHANT_ID = "mbdcldmwlolrgxkd55an";

		$openpay = Openpay::getInstance($MERCHANT_ID, 'sk_532855907c61452898d492aa521c8c9f');

		$nombre 	= "Angel";
		$apellido 	= "Veloz";
		$email 		= "vlzangel91@gmail.com";
		$telefono 	= "+584243128807";
		$direccion 	= "Ciudad de México";
		$estado 	= "Ciudad de México";
		$municipio 	= "Miguel Hidalgo";
		$postal  	= 11010;

	   	if( $cliente_openpay != "" ){
	   		$customer = $openpay->customers->get( $cliente_openpay );
	   	}else{
	   		$customerData = array(
				'external_id' 		=> '',
				'name' 				=> $nombre,
				'last_name' 		=> $apellido,
				'email' 			=> $email,
				'requires_account' 	=> false,
				'phone_number' 		=> $telefono,
				'address' => array(
					'line1' 		=> $direccion,
					'state' 		=> $estado,
					'city' 			=> $municipio,
					'postal_code' 	=> $postal,
					'country_code' 	=> 'MX'
				)
		   	);
		   	$customer = $openpay->customers->add($customerData);
	   	}

	   	switch ( $metodo_pago ) {
	   		case 'tarjeta':
	   			
	   			if( $token_id != "" ){
	   				$cardDataRequest = array(
					    'holder_name' => $holder_name,
					    'card_number' => $card_number,
					    'cvv2' => $cvv2,
					    'expiration_month' => $mes,
					    'expiration_year' => $anio,
					    'device_session_id' => $deviceIdHiddenFieldName,
					    'address' => array(
					            'line1' => $customer->address->line1,
					            'line2' => $customer->address->line2,
					            'line3' => $customer->address->line3,
					            'postal_code' => $customer->address->postal_code,
					            'state' => $customer->address->state,
					            'city' => $customer->address->city,
					            'country_code' => 'MX'
					    )
					);

					$cardList = $customer->cards->getList( array() );

					if( count($cardList) == 0 ){
						$card = $customer->cards->add($cardDataRequest);
					}else{
						$no_existe = true;
						$card_num = substr($card_number, 0, 6)."XXXXXX".substr($card_number, -4);
						foreach ($cardList as $key => $card) {
							if( $card_num == $card->card_number ){
								$no_existe = false;
							}
						}
						if( $no_existe ){
							$card = $customer->cards->add($cardDataRequest);
						}
					}

					$chargeData = array(
					    'method' 			=> 'card',
					    'source_id' 		=> $card->id,
					    'amount' 			=> (float) $_POST["monto"],
					    'order_id' 			=> time(),
					    'description' 		=> "Pago de pruebas",
					    'device_session_id' => $_POST["deviceIdHiddenFieldName"]
				    );

					$charge = $customer->charges->create($chargeData);

	   				echo json_encode(array(
	   					"user_id" => $customer->id
					));

	   			}else{
	   				echo json_encode(array(
						"Error" => "Sin tokens",
						"Data"  => $_POST
					));
	   			}

   			break;

	   		case 'tienda':
	   			$due_date = date('Y-m-d\TH:i:s', strtotime('+ 24 hours'));

	   			$chargeRequest = array(
				    'method' => 'store',
				    'amount' => (float) $info[0]->total,
				    'description' => 'Cargo con tienda',
				    'order_id' => time(),
				    'due_date' => $due_date
				);

				$charge = $customer->charges->create($chargeRequest);

   				echo json_encode(array(
   					"user_id" => $customer->id,
					"pdf" => "https://sandbox-dashboard.openpay.mx/paynet-pdf/".$MERCHANT_ID."/".$charge->payment_method->reference,
					"barcode_url"  => $charge->payment_method->barcode_url
				));

   			break;

	   	}

	}else{
		echo json_encode(array(
			"Error" => "Sin ID de dispositivo",
			"Data"  => $info
		));
	}

?>