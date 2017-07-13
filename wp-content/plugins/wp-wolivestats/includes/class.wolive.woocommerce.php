<?php


class Wolive_woocommerce {
        
        protected static $_instance = null;
        private $hooks =  null;


        public function __construct() {
                $this->initHooks();
                $this->includes();
                $this->initVars();
        }
        private function initHooks () {
                add_action ("wolive_init", array ($this, "registerEvents"));
        }

        private function includes () {
                require_once( WOLIVE__PLUGIN_DIR . 'includes/class.wolive.wc.hooks.php');
        }

        private function initVars() {
                
        }

	public function registerEvents () {

	    if (WL() -> is_enable_tracking() )
		return false;	    

                $this->hooks =  new Wolive_wc_hooks();
                $this->hooks->registerHooks(); 
        }


        
        public static function instance() {
                if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
                }
		return self::$_instance;
        }

}


function WL_WC () {
        return Wolive_woocommerce::instance();
}


$GLOBALS['wolive_WC'] = WL_WC();
