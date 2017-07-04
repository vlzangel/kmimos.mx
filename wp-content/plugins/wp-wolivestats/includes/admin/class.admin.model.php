<?php



if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

class Wolive_AdminModel {
    
        // Functions for User ***************************
        public static function get_online_users() {
                global $wpdb; 
                $sql = $wpdb->prepare("SELECT count(*) as users FROM ( SELECT * FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d GROUP BY session_id) as online;",
                        date_i18n("U") - Wolive::get_time_session()
                );
                $data = $wpdb->get_row($sql);
                return $data;
	}

	public static function get_online_users_data () {
	    global $wpdb; 
	    $t_actions = $wpdb->prefix.WOLIVE_TBL_ACT;
	    $t_sessions = $wpdb->prefix.WOLIVE_TBL_SESSION;
	    $sql_string = "SELECT $t_sessions.* FROM $t_actions INNER JOIN $t_sessions ON  $t_actions.session_id = $t_sessions.session_id WHERE $t_actions.timestamp >  %d  GROUP BY session_id;";
	    
	    $sql = $wpdb->prepare($sql_string,
		date_i18n("U") - Wolive::get_time_session()
	    );
	    $users = $wpdb->get_results($sql);

	    return $users;
	}

        public static function get_today_users() {
                $today  = strtotime(current_time('Y-m-d'));
                global $wpdb; 
                
                $sql = $wpdb->prepare("SELECT count(*) as total FROM ( SELECT * FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d GROUP BY session_id) as online;",
                        $today
                );
                $data = $wpdb->get_row($sql);
                return $data;
        }

        public static function get_today_actions() {
                $today  = strtotime(current_time('Y-m-d'));
                global $wpdb; 
                
                $sql = $wpdb->prepare( "SELECT count(*) as total FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d ;",
                        $today
                );
                $data = $wpdb->get_row($sql);
                return $data;
	}

        // Get last users
        public static function get_last_users() {
                global $wpdb; 
                $sql = "SELECT ".$wpdb->prefix.WOLIVE_TBL_SESSION.".* , MAX(".$wpdb->prefix.WOLIVE_TBL_ACT.".timestamp) as last_action  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." INNER JOIN ".$wpdb->prefix.WOLIVE_TBL_SESSION." On ".$wpdb->prefix.WOLIVE_TBL_ACT.".session_id = ".$wpdb->prefix.WOLIVE_TBL_SESSION.".session_id GROUP BY ".$wpdb->prefix.WOLIVE_TBL_ACT.".session_id  DESC LIMIT 0,6;";
		$users = $wpdb->get_results($sql);
                $i = 0;

		$timestamp_now = date_i18n("U");
		foreach ($users as $user) {
			$users[$i]->last_action_timestamp = $users[$i]->last_action;
			$users[$i]->last_action = date_i18n('Y-m-d H:i:s ', $users[$i]->last_action );
			$users[$i]->timestamp_diff = $timestamp_now -  $users[$i]->last_action_timestamp ;
			if (!empty($users[$i]->user_id)) {
			    $users[$i]->metadata  = get_userdata($user->user_id)->data;
			}
			
			$i = $i + 1 ;
		}
                return $users;
	}

	public static function get_last_users_filter() {
	    global $wpdb; 

	    $page = isset($_POST["page"])?(int)$_POST["page"]:1;
	    $string_filters ="";
	    if (isset($_POST["filters"])) 
		$string_filters = Wolive_AdminModel::get_string_filters($_POST["filters"]);

	    $items_by_page = 20;
	    $init =  ($page-1)*$items_by_page;
	    
	    $sql_string = "SELECT ".$wpdb->prefix.WOLIVE_TBL_SESSION.".* , MAX(".$wpdb->prefix.WOLIVE_TBL_ACT.".timestamp) as last_action  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." INNER JOIN ".$wpdb->prefix.WOLIVE_TBL_SESSION." On  ".$wpdb->prefix.WOLIVE_TBL_ACT.".session_id = ".$wpdb->prefix.WOLIVE_TBL_SESSION.".session_id $string_filters GROUP BY  ".$wpdb->prefix.WOLIVE_TBL_ACT.".session_id  DESC LIMIT %d,%d;";
	    $sql = $wpdb->prepare( $sql_string, $init,$items_by_page);


	    $users = $wpdb->get_results($sql);

	    $i=0;
	    $timestamp_now = date_i18n("U");
	    foreach ($users as $user) {
		$users[$i]->last_action_timestamp = (int)$users[$i]->last_action;
		$users[$i]->last_action = date_i18n('Y-m-d H:i:s', $users[$i]->last_action );
		$users[$i]->timestamp_diff = $timestamp_now -  $users[$i]->last_action_timestamp ;
		if (!empty($users[$i]->user_id)) {
			$users[$i]->metadata  = get_userdata($user->user_id)->data;
                }

		$i = $i + 1 ;
	    }
	    
	    $response  = array();
	    $response["users"] = $users;

	    return $response;
	}


	public static function get_users_online() {
	    global $wpdb; 

	    $since  =  date_i18n("U") - Wolive::get_time_session();
	    $page = isset($_POST["page"])?(int)($_POST["page"]):1;
	    $items_by_page = 20;

	    $init =  ($page-1)*$items_by_page;
	    
	    $sql_string = "SELECT ".$wpdb->prefix.WOLIVE_TBL_SESSION.".* , MAX(".$wpdb->prefix.WOLIVE_TBL_ACT.".timestamp) as last_action  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." INNER JOIN ".$wpdb->prefix.WOLIVE_TBL_SESSION." On ".$wpdb->prefix.WOLIVE_TBL_ACT.".session_id = ".$wpdb->prefix.WOLIVE_TBL_SESSION.".session_id   WHERE  ".$wpdb->prefix.WOLIVE_TBL_ACT.".timestamp > %d GROUP BY  ".$wpdb->prefix.WOLIVE_TBL_ACT.".session_id  ORDER BY last_action DESC LIMIT %d,%d;";
	    $sql = $wpdb->prepare( $sql_string, $since, $init,$items_by_page);
	    $users = $wpdb->get_results($sql);

	    $i=0;
	    $timestamp_now = date_i18n("U");	    
            foreach ($users as $user) {
                $users[$i]->last_action_timestamp = $users[$i]->last_action;
		$users[$i]->last_action = date_i18n('Y-m-d H:i:s', $users[$i]->last_action );
		$users[$i]->timestamp_diff = $timestamp_now -  $users[$i]->last_action_timestamp ;
	    	if (!empty($users[$i]->user_id)) {
			$users[$i]->metadata  = get_userdata($users[$i]->user_id)->data;
		}
		$i = $i + 1 ;
		
	    }
	    
	    $response  = array();
	    $response["users"] = $users;

	    return $response;
	}

        public static function get_users_platforms() {
                global $wpdb; 

                $sql_string = "SELECT platform as label , count(*) as value FROM ".$wpdb->prefix.WOLIVE_TBL_SESSION." B 
                        INNER JOIN (SELECT session_id FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d GROUP BY session_id) A ON
                        A.session_id = B.session_id  GROUP BY B.platform order by B.platform desc;
                ";

                $sql = $wpdb->prepare( $sql_string, 
                        date_i18n("U") - Wolive::get_time_session()
                );
                $data = $wpdb->get_results($sql);
                return $data;
	}

	public static function get_user_time_average () {
	    global $wpdb; 
	    $today  = strtotime(current_time('Y-m-d'));
	    $sql_string = "SELECT avg(timeAverage) as timeAverage FROM (SELECT (MAX(timestamp)-MIN(timestamp)) as timeAverage FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d GROUP BY session_id) avgTable";
	    $sql = $wpdb->prepare( $sql_string,$today);
	    $data = $wpdb->get_row($sql);

	    return $data;
	}

        public static function scopeOverview ($timestamp) {
                global $wpdb; 
                $sql_string = "SELECT * FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d ORDER BY timestamp ASC";
                $sql = $wpdb->prepare ($sql_string, $timestamp);
                $results = $wpdb->get_results($sql);
		
                return $results;
	}


	/* ********
	 **** functions for user
	 ***/

	public static function getUser($user_id, $timestamp) {
	    global $wpdb;
	    $t_actions = $wpdb->prefix.WOLIVE_TBL_ACT;
	    $t_sessions = $wpdb->prefix.WOLIVE_TBL_SESSION;

	    $timestamp_now = date_i18n("U");
	    
	    $sql_string = "SELECT * FROM $t_sessions WHERE session_id= %d;";
	    $sql_string = $wpdb->prepare($sql_string, $user_id);
	    $user = $wpdb->get_row($sql_string);

	    $user->first_seen = $timestamp_now-$user->timestamp ;

	    if (!empty($user->user_id)) {
		$user->metadata  = get_userdata($user->user_id)->data;
		$user->metadata->user_registered = $timestamp_now -  strtotime($user->metadata->user_registered);
	    }

	    // actions
	    $is_where = "";
	    if (!empty($timestamp)) {
		$is_where = " and timestamp > $timestamp";
	    }
	    $sql_string = "SELECT * FROM $t_actions WHERE session_id='%s'  $is_where ORDER BY timestamp DESC ;";
	    $sql_string = $wpdb->prepare($sql_string, $user->session_id);
	    $actions = $wpdb->get_results($sql_string);

	    if (!is_array($actions) or empty($actions)){
		return false;
	    }

	    $user->last_action =$timestamp_now -  $actions[0]->timestamp;
	    
	    $i = 0;
	    $table_url= $wpdb->prefix . WOLIVE_TBL_URL;
	    foreach ($actions as $action) {

		if ($action->value) {
			$actions[$i]->value = @json_decode($action->value);
		}

		$actions[$i]->date = date_i18n('Y-m-d H:i:s',  $actions[$i]->timestamp );
		$actions[$i]->diff =  $timestamp_now - $actions[$i]->timestamp;
		if ($actions[$i]->action_type == WL_ACTION_FRONTEND_SEARCH  || $actions[$i]->action_type == WL_ACTION_FRONTEND_URL  ) {
		    $row = $wpdb->get_row( "SELECT * FROM $table_url WHERE url_id = '{$action->value_int}'" );
		    
		    $actions[$i]->url = $row->url;
		    $actions[$i]->title = $row->title;
		    $actions[$i]->type = $row->type;
		}

		if ( $actions[$i]->action_type ==WL_ACTION_FRONTEND_POST ) {
                                $actions[$i]->meta = get_post($action->value_int); 
				$actions[$i]->url =  get_permalink($action->value_int);
		}
		
		if ( ($action->action_type == WL_ACTION_FRONTEND_INDEX) ) {
		    $actions[$i]->url = get_home_url();
		}

		if ( ($action->action_type == "add_to_cart") or ($action->action_type == "remove_to_cart" ) ) {
		    $actions[$i]->product = get_post( $action->value_int );
		    $actions[$i]->url =  get_permalink($action->value_int);
                }

		if ( ($action->action_type == "wc_new_order")  ) {
                    $actions[$i]->order = new WC_Order( $action->value_int );
                    $actions[$i]->total = $actions[$i]->order ->get_total();
		    $actions[$i]->url =  get_edit_post_link($action->value_int,"");
		}
		
		$i = $i + 1 ;
	    }

	    return array("user" => $user, "actions" => $actions);
	}

/*
        Functions for site **********************************************

*/

        public static function get_popular_pages_today ($first=0, $end = 5) {
                $since  =  date_i18n("U") - Wolive::get_time_session();
                global $wpdb; 

                $frontend_actions = array(WL_ACTION_FRONTEND_URL, WL_ACTION_FRONTEND_POST, WL_ACTION_FRONTEND_INDEX, WL_ACTION_FRONTEND_SEARCH );

                $frontend_string ="";

                for ($i = 0; $i < count($frontend_actions) - 1; ++$i) {
                        $frontend_string .= "'".$frontend_actions[$i]."',";
		}
		
                $frontend_string .= "'".$frontend_actions[count($frontend_actions)-1]."'";

                $sql = $wpdb->prepare("SELECT action_type,value_int as id , count(*) as total  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type  in (".$frontend_string.")  GROUP BY  action_type, id ORDER BY total DESC LIMIT %d,%d ;",
                        $since,
                        $first, 
                        $end
                );
                $products = $wpdb->get_results($sql);
		$n = 0;

		// Calculate Total
		$sql_total = $wpdb->prepare("SELECT count(*) as total  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type  in (".$frontend_string.");",
		    $since
		);
		$total = $wpdb->get_row($sql_total);

                foreach ($products as $product) {
                        if ($product->action_type == WL_ACTION_FRONTEND_POST  ) {
                                $products[$n]->meta = get_post($product->id); 
                                $products[$n]->url =  get_permalink($product->id);
                                
                        } elseif (   ($product->action_type == WL_ACTION_FRONTEND_URL) or (WL_ACTION_FRONTEND_SEARCH ==$product->action_type) ) {
                                $table_name = $wpdb->prefix . WOLIVE_TBL_URL;
                                $blogtime = current_time( 'mysql' );
                                $row = $wpdb->get_row( "SELECT url as URL FROM $table_name WHERE url_id = '{$product->id}'" );
                                $products[$n]->url = $row->URL;
                        } elseif ( ($product->action_type == WL_ACTION_FRONTEND_INDEX) ) {
                                $products[$n]->url = "/";
                        }

			$products[$n]->total = (int) $products[$n]->total;
			$products[$n]->percent = (($products[$n]->total)/((int)$total->total))*100;
                        $n  = $n + 1;
		}

                return $products;
	}


	public static function get_live_referers ($first, $end) {
            global $wpdb; 
	    $since  =  date_i18n("U") - Wolive::get_time_session();
	    
	    $sql = $wpdb->prepare("SELECT referer as url, count(*) as total  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d  and referer != '' GROUP BY referer ORDER BY total DESC LIMIT %d,%d ;",
		$since,
		$first, 
		$end
	    );
	    
	    $sql_total = $wpdb->prepare ("SELECT count(*) as total  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d  and referer != '';",
		$since
	    );
	    
	    $total=$wpdb->get_row("$sql_total");
	    $referers = $wpdb->get_results($sql);
	    $n=0;

	    foreach ($referers as $referer) {

		$referers[$n]->id = md5($referer->url);
		$referers[$n]->total = (int) $referers[$n]->total ;
		$referers[$n]->percent = (int)((($referers[$n]->total)/((int)$total->total))*100);
		$n=$n+1;
	    }

	    return $referers;
	}


        public static function get_live_searchs () {
                $since  = date_i18n("U") - 60*60; // Ten minutes
                global $wpdb; 
                $sql = $wpdb->prepare("SELECT value_int as id, count(*) as total FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type='".WL_ACTION_FRONTEND_SEARCH."' GROUP BY   value_int;",
                        $since
                );

                $products = $wpdb->get_results($sql);

                $n = 0;
                foreach ($products as $product) {
                        $table_name = $wpdb->prefix . WOLIVE_TBL_URL;
                        $blogtime = current_time( 'mysql' );
                        $row = $wpdb->get_row( "SELECT * FROM $table_name WHERE url_id = '{$product->id}'" );
                        $products[$n]->search = $row->title;
                        $products[$n]->url = $row->url;
                        $n  = $n + 1;
                }
                
                return $products;
        }


/*
        Functions for woocommerce **********************************************
*/
        public static function get_today_sales() {
                $today  = current_time('Y-m-d');
                global $wpdb; 
                $data = $wpdb->get_row("SELECT COALESCE(SUM(meta.meta_value),0) AS sales, COUNT(posts.ID) AS orders FROM {$wpdb->posts} AS posts
                        LEFT JOIN  {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
                        WHERE meta.meta_key = '_order_total'
                        AND posts.post_type = 'shop_order'
                        AND posts.post_status IN ( 'wc-completed', 'wc-processing', 'wc-on-hold' ) AND post_date > '{$today}' ;
		");


                
                return $data;
	}


	public static function get_today_sales_by_hour () {
                $today  = current_time('Y-m-d');
                global $wpdb; 
                $data = $wpdb->get_results("SELECT count(*) as y,  HOUR(post_date) as x  FROM {$wpdb->posts} AS posts
                        LEFT JOIN  {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
                        WHERE meta.meta_key = '_order_total'
                        AND posts.post_type = 'shop_order'
                        AND posts.post_status IN ( 'wc-completed', 'wc-processing', 'wc-on-hold' ) AND post_date > '{$today}' group by x ASC ;
		");
                return $data;
	}

        public static function get_today_cars () {
                $today  = strtotime(current_time('Y-m-d'));
                global $wpdb; 
                $sql = $wpdb->prepare("SELECT count(*) as total_cars FROM ( SELECT * FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type='%s' GROUP BY session_id) as online;",
                        $today,
                        "add_to_cart"
		    );
                $data = $wpdb->get_row($sql);
                return $data->total_cars;
	}


	public static function get_today_cars_by_hour () {
                $today  = strtotime(current_time('Y-m-d'));
                global $wpdb; 
                $sql = $wpdb->prepare(" SELECT  count(*) as y, HOUR(from_unixtime(timestamp)) AS x , timestamp as date_ FROM  (SELECT * FROM ".$wpdb->prefix.WOLIVE_TBL_ACT."  WHERE timestamp >  %d and action_type='%s' GROUP BY session_id ASC) as cart   GROUP BY x ASC ",
                        $today,
                        "add_to_cart"
		    );
		$data = $wpdb->get_results($sql);
		$i = 0;
		foreach ($data as $row) {
		    $data[$i]->x = date_i18n('H', $row->date_ );
		    $i = $i + 1 ;
		}


                return $data;
        }

        public static function get_today_popular_products () {
                $today  = strtotime(current_time('Y-m-d'));
		global $wpdb; 

                $sql = $wpdb->prepare("SELECT value_int as id, count(*) as total FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type='add_to_cart' GROUP BY  value_int LIMIT 0,7;",
                        $today
                );
                $products = $wpdb->get_results($sql);
                $n = 0;
     
		// Calculate Total
		$sql_total = $wpdb->prepare("SELECT  count(*) as total FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type='add_to_cart'"   ,
		    $today
		);
		$total =$wpdb->get_row($sql_total);



		foreach ($products as $product) {
		    $products[$n]->meta = get_post($product->id); 
		    $products[$n]->url =  get_permalink($product->id);

		    $products[$n]->total = (int) $products[$n]->total;
		    $products[$n]->percent = (($products[$n]->total)/((int)$total->total))*100;
		    
		    $n  = $n + 1;
		}



                return $products;
	}

	public static function get_cart_live () {
                $since  =  date_i18n("U") - Wolive::get_time_session();
                global $wpdb; 
                $sql = $wpdb->prepare("SELECT value_int as id, count(*) as value FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type='add_to_cart' GROUP BY   value_int ORDER BY value LIMIT 0,6 ;",
                        $since
                );

                $products = $wpdb->get_results($sql);
                $n = 0;
		
                foreach ($products as $product) {
                        $products[$n]->meta = get_post($product->id); 
                        $products[$n]->label = $products[$n]->meta ->  post_title;
                        $n  = $n + 1;
		}

                return $products;
	}


        public static function get_live_n_cars () {
                $since  =  date_i18n("U") - Wolive::get_time_session();
                global $wpdb; 
                $sql = $wpdb->prepare("SELECT count(*) as total_cars FROM ( SELECT * FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and action_type='%s' GROUP BY session_id) as online;",
                        $since,
                        "add_to_cart"
		    );
                $data = $wpdb->get_row($sql);
                return $data->total_cars;
	}


	public static function get_last_orders() {

                global $wpdb; 
                $data = $wpdb->get_results("SELECT * FROM {$wpdb->posts} AS posts
                        LEFT JOIN  {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
                        WHERE meta.meta_key = '_order_total'
                        AND posts.post_type = 'shop_order'
                        AND posts.post_status IN ( 'wc-completed', 'wc-processing', 'wc-on-hold' ) order by post_date DESC LIMIT 0,6 ;
		");


		$i = 0;
		foreach ($data as $order) {
			$data[$i]->last_action = date_i18n("U") - strtotime($data[$i]->post_date);
			$data[$i]->url = get_edit_post_link( $data[$i]->ID, "" );
			$data[$i]->order  = new WC_Order( $data[$i]->ID );
			$items = $data[$i]->order ->get_items();

			$data[$i]->items = 0;
			foreach ($items as $item) {
			    $data[$i]->items+=$item["qty"];
		    	}
			
			$i = $i + 1 ;
		}
                return $data;
	}




	public static function get_actions_by_hour() {
	    global $wpdb; 
	    $today  = strtotime(current_time('Y-m-d'));
	    $sql_string = "SELECT  count(*) as y, HOUR(from_unixtime(timestamp)) AS x , timestamp as date_ FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d GROUP BY x ASC";
	    $sql = $wpdb->prepare( $sql_string,$today);
	    $data = $wpdb->get_results($sql);

	    $i = 0;
	    foreach ($data as $row) {
		$data[$i]->x = date_i18n('H', $row->date_ );
		$i = $i + 1 ;
	    }
	    return $data;
	}

	public static function get_visits_by_hour() {
            global $wpdb; 
            
	    $today  = strtotime(current_time('Y-m-d'));
	    $sql_string = "select x, count(*) as y, timestamp FROM (SELECT  session_id, hour(from_unixtime(MIN(timestamp)) ) as x, timestamp  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d GROUP BY session_id ) tabla GROUP BY x;";
	    $sql = $wpdb->prepare( $sql_string,$today);
	    $data = $wpdb->get_results($sql);
	    $i = 0;
	    foreach ($data as $row) {
		$data[$i]->x = date_i18n('H', $row->timestamp );
		$i = $i + 1 ;
            }
	    
	    return $data;
	}


	public static function  get_string_filters($filters) {

	    global $wpdb;
	    $t_actions = $wpdb->prefix.WOLIVE_TBL_ACT;
            $t_sessions = $wpdb->prefix.WOLIVE_TBL_SESSION;
	    $table_url= $wpdb->prefix . WOLIVE_TBL_URL;
            
	    $string_filters = "";
	    if (!empty($filters)) {
                // if Date


		if (isset($filters["date"])){
		    $from = @strtotime($filters["date"]["from"]);
		    $to = (@strtotime($filters["date"]["to"])+60*60*24);
		    $from_tm= date_i18n('U', $from );
                    $to_tm= date_i18n('U', $to );
                    if (!empty($string_filters)) $string_filters .="AND ";
		    $string_filters .= "($t_actions.timestamp<$to_tm AND $t_actions.timestamp > $from_tm )";
                }

		if (isset($filters["referer"])){
		    $referer = $filters["referer"]["referer"];
                    if (!empty($string_filters)) $string_filters .="AND ";
		    $string_filters .= "($t_actions.referer LIKE '%%$referer%%')";
                }

                if (isset($filters["visitor_number"])){
		    $visitor_number = (int) $filters["visitor_number"]["visitor"];
                    if (!empty($string_filters)) $string_filters .="AND ";
		    $string_filters .= "($t_sessions.session_id = $visitor_number )";
                }

                if (isset($filters["post_id"])){
		    $id_post = (int) $filters["post_id"]["id_post"];
                    if (!empty($string_filters)) $string_filters .="AND ";
		    $string_filters .= "($t_actions.action_type = '".WL_ACTION_FRONTEND_POST."' and $t_actions.value_int=$id_post )";
                }

                
                if (isset($filters["logged_in"])){
		    $string_filters .= "($t_actions.action_type = 'login'  )";
                }


                if (isset($filters["search"])){
                    $search =  $filters["search"]["search"];

                    $row = $wpdb->get_row( "SELECT * FROM $table_url WHERE title = '{$search}' and type='SEARCH'" );
                    $id_search= $row->url_id;
                    
		    $string_filters .= "($t_actions.action_type = '".WL_ACTION_FRONTEND_SEARCH."' and $t_actions.value_int=$id_search )";
                }

                if (isset($filters["url_view"])){
                    $url =  $filters["url_view"]["url"];
                    $row = $wpdb->get_row( "SELECT * FROM $table_url WHERE url  like  '%{$url}%'" );
                    $id_search= $row->url_id;
		    $string_filters .= "($t_actions.action_type = '".WL_ACTION_FRONTEND_URL."' and $t_actions.value_int=$id_search )";
                }

                if (isset($filters["updated_cart"])){
                    $id_post =  $filters["updated_cart"]["id"];
                    if (!empty($string_filters)) $string_filters .="AND ";
		    $string_filters .= "($t_actions.action_type = 'add_to_cart' and $t_actions.value_int=$id_post ) or ($t_actions.action_type = 'remove_to_cart' and $t_actions.value_int=$id_post ) ";
          
                }

                if (isset($filters["coupon_applied"])){
                    $coupon =  $filters["coupon_applied"]["coupon"];
                    if (!empty($string_filters)) $string_filters .="AND ";
		    $string_filters .= "($t_actions.action_type = 'add_coupon' and $t_actions.value like '%%$coupon%%')";
                }

                if (isset($filters["checkout"])){
                    if (!empty($string_filters)) $string_filters .="AND ";
		    $string_filters .= "($t_actions.action_type = 'wc_new_order')";
                }
	    }

	    if (!empty($string_filters))
                $string_filters = "WHERE ".$string_filters;

	    return $string_filters;
	}

}



