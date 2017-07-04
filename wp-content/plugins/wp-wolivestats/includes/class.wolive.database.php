<?php

class Wolive_database {

        public function __construct() {
                
        }

        public static function createTables() {
        global $wpdb;

	$table_name_actions = $wpdb->prefix.WOLIVE_TBL_ACT;
	$table_name_urls = $wpdb->prefix.WOLIVE_TBL_URL;
        $table_name_sessions = $wpdb->prefix.WOLIVE_TBL_SESSION;
	$charset_collate = $wpdb->get_charset_collate();
        $sql = "
        CREATE TABLE $table_name_actions (
                action_id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                session_id BIGINT(20) NOT NULL,
                action_type VARCHAR(18)  NOT NULL, 
                value_int BIGINT(20) unsigned,
		value TEXT,
		referer TEXT,
                timestamp int(10) NOT NULL,
		PRIMARY KEY  (action_id),
		KEY session_id(session_id),
		KEY timestamp(timestamp)
              ) $charset_collate;  

        CREATE TABLE $table_name_urls (
                url_id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                url varchar(255) NOT NULL,
                key_url varchar(17) NOT NULL ,
                title varchar(255) NOT NULL,
                type enum('CATEGORY','SEARCH','CUSTOM_TAX','TAG','POST_TYPE_ARCHIVE','ARCHIVE','404') NOT NULL,
                PRIMARY KEY  (url_id),
                UNIQUE KEY key_url (key_url)
              ) $charset_collate; 

        CREATE TABLE $table_name_sessions (
                session_id bigint(20) NOT NULL AUTO_INCREMENT,
                user_id  int (10) DEFAULT NULL,
                ip  varchar(45) DEFAULT NULL,
                country  varchar(16) DEFAULT NULL,
                browser  varchar(40) DEFAULT NULL,
                platform varchar(15) DEFAULT NULL,
                language varchar(5) DEFAULT NULL,
                user_agent varchar(2048) DEFAULT NULL,
                s_width smallint(5) DEFAULT NULL,
                s_height smallint(5) DEFAULT NULL,
                session_value text,
                timestamp int(10) NOT NULL,
                session_expiry bigint(20) NOT NULL,
                PRIMARY KEY  (session_id),
		KEY timestamp (timestamp)
              ) $charset_collate; 

        ";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        
        dbDelta( $sql );
        update_option( 'WOLIVE_VERSION', WOLIVE__VERSION ); 
        }

	public static function initialData() {
		update_option("wolive_flag_tracking", 1);
		update_option("wolive_time", current_time("timestamp"));
        }

        public static function addActionType($keyname, $data) {

        }

        public static function update_db_check() {
                if ( get_site_option( 'WOLIVE_VERSION' ) != WOLIVE__VERSION ) {
                        self::createTables();
                }

        }

        public function addAction( $session_id,  $action_type, $value_int,  $value, $referer ) {
                global $wpdb;
                
                //$session_id = self::getIdSession($session_key);
                //
                //
                $table_name = $wpdb->prefix.WOLIVE_TBL_ACT;

                if ($value != null) {
                        $value = maybe_serialize( $value );
                }
                
                $wpdb->insert( 
                        $table_name, 
                        array( 
                                'session_id' => $session_id, 
                                'action_type' => $action_type, 
                                'value_int' => $value_int, 
                                'value' => $value, 
                                'referer' => $referer, 
                                'timestamp' => date_i18n( 'U' )
                        ), 
                        array( 
                                '%s', 
                                '%s', 
                                '%d', 
                                '%s', 
                                '%s', 
                                '%d' 
                        )
                );
                return $wpdb->insert_id;
        }

        public static function addURL($url, $title, $type) {
                global $wpdb;
                $table_name = $wpdb->prefix . WOLIVE_TBL_URL;
                $blogtime = current_time( 'mysql' );
                $key_url = Wolive::key_url($url);
                $url_row = $wpdb->get_row( "SELECT * FROM $table_name WHERE key_url = '$key_url'" );
                if (!is_object($url_row)) {
                $wpdb->insert( 
                        $table_name, 
                        array( 
                                'url' => $url, 
                                'key_url' => $key_url, 
                                'title' => $title, 
                                'type' => $type 
                        ), 
                        array( 
                                '%s', 
                                '%s', 
                                '%s', 
                                '%s' 
                        )
                );
                        return $wpdb->insert_id;
                } else {
                        return $url_row->url_id;                
                }
        }

        private static function getIdSession($session_key) {
                global $wpdb;
                $id = $wpdb->get_var( "SELECT session_id  FROM {$wpdb->prefix}wolive_sessions WHERE session_id='{$session_id}'" );
                return $id;
        }

        private static  function  getTableActionsName() {
                global $wpdb;

                return $wpdb->prefix."wolive_action";
        }


        


}

