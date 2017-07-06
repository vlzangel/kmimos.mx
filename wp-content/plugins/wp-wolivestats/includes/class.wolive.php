<?php

/**
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Wolive {

    private $wo_hooks =  null;
    private $session =  null;
    protected static $_instance = null;

    private $actions = null;
    private $settings;

    public $license_status;

    public function __construct() {
	$this->includes();
	$this->setVars();
	$this->initHooks(); 
    }


    private function initHooks   () {
	// Database & Upgrades
	add_action( 'plugins_loaded', array("Wolive_database", "update_db_check"));
	// Engine
	add_action('after_setup_theme', array( $this, 'include_template_functions' ), 11);
	add_action('init', array( $this, 'init' ),0 );

    }

    public static function instance() {
	if ( is_null( self::$_instance ) ) {
	    self::$_instance = new self();
	}
	return self::$_instance;
    }

    public function include_template_functions () {
	include_once( 'template-functions.php' );
    }

    public static function install() {
	Wolive_database::createTables();
	Wolive_database::initialData();

	// Install database IPs
	require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.geolocation.php'); 
	Wolive_Geolocation::update_database();

    }

    public  function init () {
	// Create Session
	$this->settings =  $this::get_settings();
	$this->database = new Wolive_database(); 	

	// Put conditional with options tracking front end !!!!!!!!!
	if (self::is_request("frontend") and !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')) and $this->is_enable_tracking() ) {
	    add_action("wp_enqueue_scripts", array("Wolive_ajax", "addFrontEndScripts" ));
	    add_action("wp_ajax_wostats", array($this, "ajaxFrontEnd" ));
	    add_action("wp_ajax_nopriv_wostats", array($this, "ajaxFrontEnd"));
	}

	do_action ("wolive_init");
    }

    public function ajaxFrontEnd () {

	if (current_user_can("install_plugins") or !($this->is_enable_tracking()) ) {
	    return false;
	}

	global $wp;
	$url =  $_POST["url"];
	$data_page =  $_POST["dp"];

	if ( Wolive::validate_checksum($data_page) )  {
	    $data = maybe_unserialize(base64_decode(Wolive::validate_checksum($data_page)));
	    if (empty($data["id"])) 
		$data["id"] = 0;
	    $value = null;
	    $referer = "";
	    if ( $_POST["w_referer"] != "0" ) {
		$referer = $_POST["w_referer"];
	    } 
	    if (isset($value)) {
		$value = json_encode($value);
	    }

	    $data["value"] = $value;
	    $data["referer"] = $referer;
	    $this->addAction($data["action_type"], $data  );
	    $this->session->save_data_item ( "url_last", $url );  
	}

	wp_die();
    }

    private function includes () {

	// [/Actions]
	require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.session.handler.php');
	require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.session.php');
	require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.ajax.php');
	require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.custom_actions.php');
	// [/Actions]
	require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.actions_types.php');

	// Adds for Woocommerce
	if ( 
	    in_array( 
		'woocommerce/woocommerce.php', 
		apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
	    )
	){ 
	    require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.woocommerce.php');
	}



	// Create Admin plugin
	if (self::is_request('admin')  ) {
	    require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.admin.php');
	}
    }


    private function setVars() {
	$this->actions = new Wolive_actions_types();

	//Add actions FRONTEND
	$frontend_actions = array(WL_ACTION_FRONTEND_URL, WL_ACTION_FRONTEND_POST, WL_ACTION_FRONTEND_INDEX, WL_ACTION_FRONTEND_SEARCH );
	foreach ( $frontend_actions as $action ) {
	    $this->actions->addActionType(array (
		"name" => $action,
		"title"=> "Visit URL"
	    ));
	}

    }

    public static function is_request( $type ) {
	switch ( $type ) {
	case 'admin' :
	    return is_admin();
	case 'ajax' :
	    return defined( 'DOING_AJAX' );
	case 'cron' :
	    return defined( 'DOING_CRON' );
	case 'frontend' :
	    return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
	}
    }

    public static function key_url ($url) {
	return WOLIVE_URL_AJAX.substr(md5($url),1,11);
    }

    public function addActionType ($action_type) {
	return $this->actions->addActionType($action_type);
    }

    public function addAction ($action_type,$data) {
	if (current_user_can("install_plugins") or !$this->is_enable_tracking() ) {
	    return false;
	}

	if (!isset($this->session)) {
	    $this->session = new Wolive_session();
	}

	if ($this->actions->getAction($action_type) === 0 ) {
	    return "-1"; // Action is not register
	} else {
	    if (!isset($data["id"])) {
		$data["id"] = 0;
	    } 

	    if (!isset($data["value"])) {
		$data["value"] = 0;
	    } 

	    if (!isset($data["referer"])) {
		$data["referer"] = "";
	    } 

	    $id = $this->session->get_session_id();

	    if ($id == 0 ) return false;

	    $this->database->addAction( $id, $action_type, $data["id"] ,  $data["value"], $data["referer"] );
	}

    }

    public function updateIdSession ($ID){
	$this->session->update_user_id($ID);
    }

    public static function checkSum($data) {
	$settings  = Wolive::get_settings();
	return $data.'@'.md5( $data.$settings["key_secret"] );
    }

    public static function validate_checksum ($hash) {
	list( $data, $checksum ) = explode( '@', $hash );
	$settings  = Wolive::get_settings();

	if ( $checksum === md5( $data . $settings["key_secret"] ) ) {
	    return $data;
	}
	return false;
    }

    public static function get_time_session (  ) {
	// Seconds
	return  60*2.5;
    }

    public static function getPageData ()  {

	$url_parameters =home_url().$_SERVER["REQUEST_URI"];
	$key_url =Wolive::key_url ($url_parameters);

	global $wp;
	$data =  array();
	$data =  array();

	$data["url"] = home_url(add_query_arg(array(),$wp->request));
	$data["original_url"] = $url_parameters;
	$data["action_type"] = WL_ACTION_FRONTEND_INDEX;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	if (isset($_GET["orderby"])) {
	    return false;
	}

	if ( is_front_page() && is_home()  && $paged<2 ) {
	    // Default homepage
	    $data["type"] =  "is_frontpage_home";
	} elseif ( is_front_page() && $paged<2 ) {
	    // static homepage
	    $data["type"] =  "is_frontpage";
	} elseif ( is_home() && $paged<2  ) {
	    // Blog page
	    $data["type"] =  "is_home";
	} 
	else {
	    if ( is_singular() ) {
		$data["action_type"] = WL_ACTION_FRONTEND_POST;
		if (is_single()) {
		    $data["type"] =  WOLIVE_TYPE_SINGLE;                                              
		} elseif (is_page()) {
		    // Wocommerce  is_cart() is_checkout() is_account_page() is_product()
		    $data["type"] =  WOLIVE_TYPE_PAGE;
		}
		if (is_attachment()) {
		    $data["type"] =  WOLIVE_TYPE_ATTACHMENT;  
		}
		$data["id"] = get_queried_object()->ID;
	    } 
	    if ( is_archive() ) {
		// WooCommerce is_shop()  is_product_category()  is_product_tag()
		$data["action_type"] = WL_ACTION_FRONTEND_URL;

		$query_object = get_queried_object();
		if (is_category()) {
		    $data["type"] = WOLIVE_TYPE_CATEGORY;
		} elseif (is_post_type_archive()) {
		    $data["type"] = WOLIVE_TYPE_POST_TYPE_ARCHIVE; 
		} elseif (is_tag()) {
		    $data["type"] =  WOLIVE_TYPE_TAG;
		} elseif (is_tax()) {
		    $data["type"] = WOLIVE_TYPE_CUSTOM_TAX;
		}
		else {
		    $data["type"] =  WOLIVE_TYPE_ARCHIVE;
		}


		$data["id"] = Wolive_database::addURL($data["url"], "", $data["type"]);
	    }
	    if (is_404())  {
		$data["action_type"] = WL_ACTION_FRONTEND_URL;
		$data["type"] =  "404";
		$data["url"] = $url_parameters;
		$data["id"] = Wolive_database::addURL($data["url"], "", $data["type"]);
	    }
	    if (is_search()) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if ($paged<2) {
		    $data["action_type"] = WL_ACTION_FRONTEND_SEARCH;
		    $data["type"] =  WOLIVE_TYPE_SEARCH;
		    $data["search_query"] = trim(get_search_query());
		    $data["url"] = $url_parameters;
		    $data["id"]=Wolive_database::addURL($data["url"], $data["search_query"], $data["type"]);
		}
    
	    } 
	}                  

	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$data["type"]  = apply_filters("wolive_frontend_filter", $data["type"]);
	//set_transient( $key_url, $data, DAY_IN_SECONDS*4);

	return $data;
    }

    public  function is_enable_tracking () {
	return $this->settings["enable_tracking"] ;
    }


    public static function get_settings(){

	$key_secret =  get_option('wolive_key_secret');
	$license =  get_option('wolive_license_key');


	if ( empty ( $key_secret )  ) {
	    $key_secret = wp_hash( uniqid( time(), true ).WL_SECRET_KEY);
	    add_option("wolive_key_secret", $key_secret );
	}

	return array (
	    'key_secret' => $key_secret,
	    'enable_tracking' => get_option('wolive_flag_tracking'),
	    'license' => get_option('wolive_license_key'),
	    'license_status' => get_option('wolive_license_status')
	);
    }

}


// Main Instance
// Prevent Globals
function WL() {
    return Wolive::instance();

}



$GLOBALS['wolive'] = WL();

