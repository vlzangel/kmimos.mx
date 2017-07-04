<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class Wolive_AdminMenus {


	public function __construct () {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function register_settings() { // whitelist options
		register_setting( 'wolive-options', 'wolive_license_key', 'wolive_SanitizeLicense' );
		register_setting( 'wolive-options', 'wolive_flag_tracking' );
	}


	public function admin_menu() {
		global $menu;
		add_menu_page( __( 'Wolive', 'wolive' ), __( 'Wolive', 'wolive' ), 'install_plugins', 'wolive',  "woliveAdmin_StatsTemplate", "dashicons-chart-line", '55.5' );
		add_submenu_page( 'wolive', 'Wolive settings', 'Settings','manage_options', 'wolive-options', 'woliveAdmin_OptionsTemplate');
	}




}


return  new Wolive_AdminMenus();
