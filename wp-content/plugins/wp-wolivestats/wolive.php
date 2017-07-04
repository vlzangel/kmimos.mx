<?php

/**
 * Plugin Name: Wolive - Real Time Stats 
 * Plugin URI: http://wolive.me/
 * Description: Wolive is a plugin to allows track every single visitor of your wordpress & woocommerce site in real time. Track actions and all their activiy in 100% Real Time.
 * Version: 1.03
 * Author: Wolive
 * Author URI: http://wolive.me
 * License: GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wolive; 

if (!function_exists('write_log')) {
    function write_log ( $log )  {
	if ( true === WP_DEBUG ) {
	    if ( is_array( $log ) || is_object( $log ) ) {
		error_log(print_r( $log, true ));
	    } else {
		error_log($log );
	    }
	}
    }
}



define( 'WOLIVE__MINIMUM_WP_VERSION', '3.8' );
define( 'WOLIVE__VERSION', '1.0' );
define( 'WOLIVE__PLUGIN_DIR',         plugin_dir_path( __FILE__ ) );
define( 'WOLIVE__PLUGIN_FILE',        __FILE__ );
define( 'WOLIVE__PLUGIN_URL',        plugin_dir_url( __FILE__ ));
define( 'WOLIVE_NONCE',    "WOLIVE_NONCE_STRING_1.0"  );



require_once( WOLIVE__PLUGIN_DIR . 'includes/constants.php'); 
require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.php'); 
require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.database.php');
require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.ajax.php');

register_activation_hook( __FILE__, array("Wolive","Install"));
require  WOLIVE__PLUGIN_DIR . 'includes/lib/plugin-update/plugin-update-checker.php';

$update = Puc_v4_Factory::buildUpdateChecker(
    WOLIVE_API_URL,
    __FILE__,
    'wp-wolivestats'
);


$update->addQueryArgFilter('filter_update_wolive');
function filter_update_wolive($queryArgs) {
    $license =  get_option('wolive_license_key');    
    if ( !empty($license)) {
        $queryArgs['license_key'] =$license;
    }
    $queryArgs['domain'] = site_url();
    return $queryArgs;
}


