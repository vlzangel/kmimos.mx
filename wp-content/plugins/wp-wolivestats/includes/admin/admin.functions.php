<?php


function woliveAdmin_StatsTemplate () {
        require_once(WOLIVE__PLUGIN_DIR."includes/tpl/template.stats.php");
}

function woliveAdmin_OptionsTemplate () {
        require_once(WOLIVE__PLUGIN_DIR."includes/tpl/template.options.php");
}


function woliveAdmin_CheckLicense($license)  {
    $response = wp_remote_post( WOLIVE_API_URL_ADD, array(
	'method' => 'POST',
	'timeout' => 45,
	'redirection' => 5,
	'httpversion' => '1.0',
	'blocking' => true,
	'headers' => array(),
	'body' => array(  '_license' => $license, 'domain' => site_url() ),
	'cookies' => array()
    )
);


    $status = 0;
    if ( is_wp_error( $response ) ) {
	$status= -2;
    } else {
	$response_json = json_decode($response["body"]);

	$status = $response_json->status;
    }
    
    return $status;
}

function wolive_SanitizeLicense ($license) {

	$wl_status_license = woliveAdmin_CheckLicense($license);
	update_option( "wolive_license_status", $wl_status_license );
	
	if ( $wl_status_license == 1 ) { 
		return $license;
	} elseif ($wl_status_license == 2) {
		return $license;
	}
	
}

function wolive_noticeAdmin ( $is_dismissible, $class, $text ) {

    $class="";
    if ($is_dismissible){
	$class_dismissible="is-dismissible";
    }

   ?>
       <div class="notice <?php echo $class ?> <?php echo $class_dismissible?> ">
        <p><?php echo $text; ?></p>
    </div>
<?php
    
}

function wolive_noticeSuccess () {
	wolive_noticeAdmin(true, "notice-success", "License activated succesfull" );
}
