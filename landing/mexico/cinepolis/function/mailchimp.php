<?php

$api_key = '236a508f1053a8e4a6c4b62b58839f7f-us12'; 

// $list_id = '22f3658f33'; 

function mailchimp_add_member($email, $first_name, $last_name, $list_id){

	if( $email == '' || $first_name == '' || $last_name == "" || $list_id == ""){
		return false;
	}

	$auth = base64_encode( 'user:'.$api_key );
	    
	$data = array(
	    'apikey'        => $api_key,
	    'email_address' => $email,
	    'status'        => 'subscribed',
	    'merge_fields'  => array(
	        'FNAME' => $first_name,
	        'LNAME'    => $last_name
	        )    
	    );
	$json_data = json_encode($data);
	 
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://us12.api.mailchimp.com/3.0/lists/{$list_id}/members");
	curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
	curl_setopt($ch, CURLOPT_USERPWD, "anystring:".$api_key);
	curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, true);    
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	 
	$result = curl_exec($ch);
	return $result;
}


