<?php

/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Wolive_Admin {

	public function __construct() {

		add_action( 'init', array( $this, 'includes' ) );
		add_action('current_screen' , array($this, "current_screen"));
		add_action('wolive_init' , array($this, "wolive_init"));

		//add_action( 'current_screen', array( $this, 'conditional_includes' ) );
		//add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );	
		//
	}

        public function includes() {

                if (current_user_can("install_plugins") ) {
                         require_once( WOLIVE__PLUGIN_DIR . 'includes/admin/class.admin.model.php');
                         require_once( WOLIVE__PLUGIN_DIR . 'includes/admin/class.admin.reports.php');
			 require_once( WOLIVE__PLUGIN_DIR . 'includes/admin/admin.functions.php');
			 
			 if (Wolive::is_request("ajax")) {
                                require_once( WOLIVE__PLUGIN_DIR . 'includes/admin/class.admin.ajax.php');
                        } else {
                                require_once( WOLIVE__PLUGIN_DIR . 'includes/admin/class.admin.menus.php');
                        }
                }
	}

        public function current_screen ($screen) {

                 if (!current_user_can("install_plugins") ) {
                        return 0;
                 }

		show_admin_bar(false);
		 if ($screen->id == "toplevel_page_wolive" and current_user_can("install_plugins") ) {

			// Menu
			global $menu;
			$menu = array();
			// Admin Bar delete
		 	global $wp_admin_bar;   
		 	$wp_admin_bar = array();

			add_filter( 'show_admin_bar', '__return_false' );
			add_action('admin_menu',  array($this, 'removeMenus'));
			add_action('wp_print_scripts', array($this, 'removeAllScripts'), 100);

			wp_deregister_script('heartbeat');
			wp_deregister_style('wp-admin');
			
			add_action('admin_enqueue_scripts', array($this,'admin_style_stats'));
			add_action( 'admin_head', array( $this, "admin_head_stats" ));
			add_action('admin_footer', array( $this, "admin_footer_stats" ));
		}
	}

	public function removeMenus() {
		global $submenu;
		unset($submenu);
	}

	public function removeAllScripts() {
		   global $wp_scripts;
    	   $wp_scripts->queue = array();
	}
	public function removeAllStyles() {
   	 	global $wp_styles;
    	$wp_styles->queue = array();
	}

	public function admin_style_stats () {

	}

	public function wolive_init () {


	}

	public function admin_head_stats () {


		echo '
		<!-- Wolive -->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" id="admin-styles-css"  href="'.WOLIVE__PLUGIN_URL.'assets/css/admin.blank.css" type="text/css" media="all" />
		<link rel="stylesheet" id="admin-styles-css"  href="'.WOLIVE__PLUGIN_URL.'assets/css/style.css" type="text/css" media="all" />
		<link rel="stylesheet" id="admin-styles-css"  href="'.WOLIVE__PLUGIN_URL.'assets/css/loading-bar.css" type="text/css" media="all" />
                <link rel="stylesheet" id="admin-styles-css"  href="'.WOLIVE__PLUGIN_URL.'assets/css/flag-icon.min.css" type="text/css" media="all" />
		<link rel="stylesheet" id="admin-styles-css"  href="'.WOLIVE__PLUGIN_URL.'assets/css/nv.d3.css" type="text/css" media="all" />
                <script src="https://use.fontawesome.com/352fa447bc.js"></script>

		
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script> 
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular-route.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular-animate.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular-touch.min.js"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/loading-bar.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/count.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/ui-bootstrap-tpls-2.4.0.min.js" charset="utf-8"></script>

		<!-- CHARTS -->
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/d3.min.js"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/nv.d3.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.9/angular-nvd3.min.js"></script>

		<!-- MAPS -->
	        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCkMPl-5mUDukDZjQKaAhWJe1h4NIlGQc"></script>

		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/moment.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/angular-moment.js" charset="utf-8"></script>

		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/app.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/routes.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/controllers/general-controllers.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/controllers/overview.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/controllers/user.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/controllers/users.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/controllers/woocommerce.js" charset="utf-8"></script>
		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/controllers/reports.js" charset="utf-8"></script>

		<script src="'.WOLIVE__PLUGIN_URL.'assets/js/main.js" charset="utf-8"></script>

                <style type="text/css" media="print">#wpadminbar{ display:none; }</style>


		';
	}

	public function admin_footer_stats () {
		echo '







		';
	}



}


return new Wolive_Admin();
