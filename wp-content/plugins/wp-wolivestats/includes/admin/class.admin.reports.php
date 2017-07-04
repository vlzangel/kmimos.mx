<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wolive_AdminReports {


    public static function get_filter ($type) {

	$filter =  new stdClass();

	if ($type == "today")  {
	    $filter->from = strtotime("today 00:00:00", current_time("timestamp"));
	    $filter->to =strtotime('today 23:59:59', current_time("timestamp"));
	}

	if ($type == "yesterday") {
	    $filter->from = strtotime('yesterday 00:00:00', current_time("timestamp"));
	    $filter->to = strtotime('yesterday 23:59:59', current_time("timestamp") );
	}

	if ($type == "this week") {
	    $filter->from = strtotime('-1 week monday 00:00:00', current_time("timestamp") );
	    $filter->to = strtotime('sunday 23:59:59', current_time("timestamp") );
	}

	if ($type == "last week") {
	    $filter->from= strtotime('-2 week monday 00:00:00', current_time("timestamp"));
	    $filter->to = strtotime('-1 week sunday 23:59:59', current_time("timestamp"));

	}

	if ($type == "this month") {
	    $filter->from = strtotime("first day of this month 00:00:00 ", current_time("timestamp")); 
	    $filter->to = strtotime("last day of this month 23:59:59 ", current_time("timestamp")); 
	}

	if ($type == "last month") {
	    $filter->from = strtotime("first day of last month 00:00:00 ", current_time("timestamp") ); 
	    $filter->to = strtotime("last day of last month 23:59:59 ", current_time("timestamp"));
	}

	if ($type == "this year") {
	    $filter->from = date('U',strtotime(date('Y-01-01'),  current_time("timestamp") ));
	    $filter->to = current_time("timestamp");
	}

	if ($type == "range"){

	    if ( ($_POST["range"]["from"])  == ($_POST["range"]["to"]) ) { 
			$type = "day";
	    }
	    
	    $from = @strtotime($_POST["range"]["from"]);
	    $to = (@strtotime($_POST["range"]["to"])+60*60*24);
	    $from_tm= date_i18n('U', $from );
	    $to_tm= date_i18n('U', $to );

	    $filter->from = $from_tm ;
	    $filter->to = $to_tm ;
	}


	$filter->type = $type;

	return $filter;

    }

    public static function getVisits ($filter_date) {

	$response = array();
	$response["table"] = array();

	$filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;
	if ($filter_date == "today" or $filter_date == "yesterday" or $filter->type == "day"  ) {
	    $today  = strtotime(current_time('Y-m-d'));
	    $response["actions"] = Wolive_AdminReports::get_actions_by_hour($filter->from, $filter->to);
	    $response["visits"] = Wolive_AdminReports::get_visits_by_hour($filter->from,  $filter->to );

	   foreach ($response["actions"] as $action) {
		$action -> x = (int) $action -> x ;
		if ( !isset($response["table"][$action -> x]) ) {
		    $response["table"][$action->x] = new stdClass();
		}
		$response["table"][$action -> x]->actions = $action -> y ;
	    }
	    foreach ($response["visits"] as $visit) {
		$visit -> x = (int) $visit -> x ;
		if ( !isset($response["table"][$visit -> x]) ) {
		    $response["table"][$visit->x] = new stdClass();
		}
		$response["table"][$visit -> x]->visits = $visit -> y ;
	    }
	    ksort($response["table"]);

	} else {
		
	    $response["actions"] = Wolive_AdminReports::get_actions_by_day($filter->from,$filter->to);
	    $response["visits"] = Wolive_AdminReports::get_visits_by_day($filter->from,$filter->to);

	    foreach ($response["actions"] as $action) {
		$action -> x = (int) $action -> x ;
		if ( !isset($response["table"][$action->date_f]) ) {
		    $response["table"][$action->date_f] = new stdClass();
		    $response["table"][$action->date_f]->timestamp = $action -> x;
		}
		$response["table"][$action -> date_f]->actions = $action -> y ;
	    }
	    foreach ($response["visits"] as $visit) {
		$visit -> x = (int) $visit -> x ;
		if ( !isset($response["table"][$visit->date_f] ) ) {
		    $response["table"][$visit->date_f] = new stdClass();
		    $response["table"][$visit->date_f]->timestamp = $visit -> x;
		}
		$response["table"][$visit->date_f]->visits = $visit -> y ;
	    }
	    ksort($response["table"]);
	    
	}

	

	return $response;
    }

    public static function get_actions_by_hour($from, $to) {
	global $wpdb; 

	$from  = $from;
	$to  = $to;
	$sql_string = "SELECT  count(*) as y, HOUR(from_unixtime(timestamp)) AS x , timestamp as date_ FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d and timestamp < %d GROUP BY x ASC";
	$sql = $wpdb->prepare( $sql_string,$from, $to);
	$data = $wpdb->get_results($sql);

	$i = 0;
	foreach ($data as $row) {
	    $data[$i]->x = date_i18n('H', $row->date_ );
	    $i = $i + 1 ;
	}
	return $data;
    }
    public static function get_visits_by_hour($from, $to) {
	global $wpdb; 
	$from  = $from;
	$to  = $to;
	$sql_string = "SELECT count(*) as y, HOUR(from_unixtime(timestamp)) AS x , timestamp as date_ FROM ( SELECT  *, MIN( timestamp ) FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d and timestamp < %d GROUP BY session_id ASC ) tabla GROUP BY x;";
	$sql = $wpdb->prepare( $sql_string,$from, $to);
	$data = $wpdb->get_results($sql);
	$i = 0;

	foreach ($data as $row) {
	    $data[$i]->x = date_i18n('H', $row->date_ );
	    $i = $i + 1 ;
	}
	return $data;
    }


    public static function get_actions_by_day($from, $to) {
	global $wpdb; 

	$from  = $from;
	$to  = $to;
	$sql_string = "SELECT  count(*) as y, DATE_FORMAT( from_unixtime (timestamp), '%%Y-%%m-%%d') AS date_f, timestamp  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d and timestamp < %d GROUP BY date_f ASC";
	$sql = $wpdb->prepare( $sql_string,$from, $to);
	$data = $wpdb->get_results($sql);

	$i = 0;
	foreach ($data as $row) {
	    $data[$i]->x = date_i18n('U', $row->timestamp );
	    $i = $i + 1 ;
	}
	return $data;
    }

    
    public static function get_visits_by_day($from, $to) {
	global $wpdb; 
	$from  = $from;
	$to  = $to;
	$sql_string = "SELECT count(*) as y, DATE_FORMAT( from_unixtime (timestamp), '%%Y-%%m-%%d')  as date_f, timestamp FROM ( SELECT  *, MIN( timestamp ) FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp > %d and timestamp < %d GROUP BY session_id ASC ) tabla GROUP BY date_f ASC; ";
	$sql = $wpdb->prepare( $sql_string,$from, $to);
	$data = $wpdb->get_results($sql);
	$i = 0;
	foreach ($data as $row) {
	    $data[$i]->x = date_i18n('U', $row->timestamp );
	    $i = $i + 1 ;
	}
	return $data;
    }

    public static function getSearch($filter_date) {

	$response = array();
	$response["table"] = array();

	$filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;

	global $wpdb; 
	$sql = $wpdb->prepare("SELECT value_int as id, count(*) as value FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and timestamp < %d and action_type='".WL_ACTION_FRONTEND_SEARCH."' GROUP BY   value_int   ORDER BY value DESC LIMIT   0,100;",
	    $filter->from, $filter->to
	);

	$results = $wpdb->get_results($sql);
	$n = 0;
	foreach ($results as $result) {
	    $table_name = $wpdb->prefix . WOLIVE_TBL_URL;
	    $blogtime = current_time( 'mysql' );
	    $row = $wpdb->get_row( "SELECT * FROM $table_name WHERE url_id = '{$result->id}'" );
	    $results[$n]->label = $row->title;
	    $results[$n]->url = $row->url;
	    $n  = $n + 1;
	}
	$response["rows"] = $results;

	return $response;
    }

    public static function getPost ($filter_date) {

	$response = array();
	$response["table"] = array();
	$filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;
	
	global $wpdb; 
	$frontend_actions = array(WL_ACTION_FRONTEND_POST );
	$frontend_string ="";
	for ($i = 0; $i < count($frontend_actions) - 1; ++$i) {
	    $frontend_string .= "'".$frontend_actions[$i]."',";
	}
	$frontend_string .= "'".$frontend_actions[count($frontend_actions)-1]."'";
	$sql = $wpdb->prepare("SELECT action_type,value_int as id , count(*) as value  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and timestamp < %d and action_type  in (".$frontend_string.")  GROUP BY  action_type, id ORDER BY value  DESC LIMIT 0,100 ;",
	    $filter->from,
	    $filter->to
	);
	$post = $wpdb->get_results($sql);

	$n = 0;
	foreach ($post as $product) {
	    if ($product->action_type == WL_ACTION_FRONTEND_POST  ) {
		$post[$n]->meta = get_post($product->id); 
		$post[$n]->url =  get_permalink($product->id);
		$post[$n]->label = $post[$n]->meta -> post_title ;
	    } 
	    $post[$n]->total =  @(int) $post[$n]->total;
	    $n  = $n + 1;
	}


	$response["rows"] = $post;
	return $response;

    }

    public static function getURL ($filter_date) {
	$response = array();
	$response["table"] = array();
	$filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;
	
	global $wpdb; 
        $frontend_actions = array(WL_ACTION_FRONTEND_URL, WL_ACTION_FRONTEND_POST, WL_ACTION_FRONTEND_INDEX, WL_ACTION_FRONTEND_SEARCH );

	$frontend_string ="";
	for ($i = 0; $i < count($frontend_actions) - 1; ++$i) {
	    $frontend_string .= "'".$frontend_actions[$i]."',";
	}
	$frontend_string .= "'".$frontend_actions[count($frontend_actions)-1]."'";
	$sql = $wpdb->prepare("SELECT action_type,value_int as id , count(*) as value  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and timestamp < %d and action_type  in (".$frontend_string.")  GROUP BY  action_type, id ORDER BY value  DESC LIMIT 0,100 ;",
	    $filter->from,
	    $filter->to
	);
	$post = $wpdb->get_results($sql);

	$n = 0;
	foreach ($post as $product) {
	    if ($product->action_type == WL_ACTION_FRONTEND_POST  ) {
		$post[$n]->meta = get_post($product->id); 
		$post[$n]->url =  get_permalink($product->id);
		$post[$n]->label = get_permalink($product->id);
	    }
	    elseif (   ($product->action_type == WL_ACTION_FRONTEND_URL) or (WL_ACTION_FRONTEND_SEARCH ==$product->action_type) ) {
		$table_name = $wpdb->prefix . WOLIVE_TBL_URL;
		$blogtime = current_time( 'mysql' );
		$row = $wpdb->get_row( "SELECT url as URL FROM $table_name WHERE url_id = '{$product->id}'" );
		$post[$n]->label = $row->URL;
	    } elseif ( ($product->action_type == WL_ACTION_FRONTEND_INDEX) ) {
		$post[$n]->label = "/";
	    }

	    $post[$n]->total = (int) $post[$n]->total;
	    $n  = $n + 1;
	}

	$response["rows"] = $post;
	return $response;
    }


    // Metadata

    public static function get_metadata($group, $from, $to) {
	global $wpdb; 
	$from  = $from;
	$to  = $to;
	
	$t_actions = $wpdb->prefix.WOLIVE_TBL_ACT;
	$t_sessions = $wpdb->prefix.WOLIVE_TBL_SESSION;

	$sql_string = "SELECT count(*) as value, $group as label    FROM $t_sessions s INNER JOIN ( SELECT  *, MIN( timestamp ) FROM $t_actions WHERE timestamp > %d and timestamp < %d GROUP BY session_id ASC ) a ON s.session_id = a.session_id  GROUP BY label  ORDER BY value DESC ; ";
	$sql = $wpdb->prepare( $sql_string,$from, $to);
	$data = $wpdb->get_results($sql);
	$i = 0;

	return $data;
    }


    public static function get_screen ($from, $to) {
	global $wpdb; 
	$from  = $from;
	$to  = $to;
	
	$t_actions = $wpdb->prefix.WOLIVE_TBL_ACT;
	$t_sessions = $wpdb->prefix.WOLIVE_TBL_SESSION;

	$sql_string = "SELECT count(*) as value, concat(s_width,'x', s_height) as label    FROM $t_sessions s INNER JOIN ( SELECT  *, MIN( timestamp ) FROM $t_actions WHERE timestamp > %d and timestamp < %d GROUP BY session_id ASC ) a ON s.session_id = a.session_id  GROUP BY label  ORDER BY value DESC ; ";
	$sql = $wpdb->prepare( $sql_string,$from, $to);

	$data = $wpdb->get_results($sql);
	return $data;


    }

    public static function getMetadata ($meta, $filter_date) {
	$response = array();
	$response["table"] = array();
	$filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;

	$response["rows"] =  Wolive_AdminReports::get_metadata($meta, $filter->from, $filter->to);
	
	return $response;
    }

    public static function getScreen ( $filter_date) {
	$response = array();
	$response["table"] = array();
	$filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;
	$response["rows"] =  Wolive_AdminReports::get_screen( $filter->from, $filter->to);
	return $response;
    }

    public static function getReferers ( $filter_date) {
	$response = array();
	$response["table"] = array();
	$filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;

	global $wpdb; 
	$sql = $wpdb->prepare("SELECT referer as label, count(*) as value  FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d  and timestamp < %d and referer != '' GROUP BY referer ORDER BY value DESC  LIMIT 0,100 ;",
	    $filter->from,
	    $filter->to 
	);

	$referers = $wpdb->get_results($sql);
	$response["rows"] =  $referers;

	return $response;
    }

    public static function getAddToCart($filter_date) {
        $response = array();
        $response["table"] = array();
        $filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;

	global $wpdb; 
	$sql = $wpdb->prepare("SELECT value_int as id, count(*) as value FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and timestamp < %d and action_type='add_to_cart' GROUP BY  id ORDER BY value desc LIMIT 0,100;",
	    $filter ->from, 
	    $filter -> to
	);
	$products = $wpdb->get_results($sql);
	$n = 0;
	foreach ($products as $product) {
	    $products[$n]->meta = get_post($product->id); 
	    $products[$n]->url =  get_permalink($product->id);
	    $products[$n]->label =  $products[$n]->meta->post_title;
	    $n  = $n + 1;
	}

	$response["rows"] = $products;
	return $response;
    }

    public static function getRemoveFromCart($filter_date) {
        $response = array();
        $response["table"] = array();
        $filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;

	global $wpdb; 
	$sql = $wpdb->prepare("SELECT value_int as id, count(*) as value FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and timestamp < %d and action_type='remove_to_cart' GROUP BY  id ORDER BY value desc LIMIT 0,100;",
	    $filter ->from, 
	    $filter -> to
	);
	$products = $wpdb->get_results($sql);
	$n = 0;
	foreach ($products as $product) {
	    $products[$n]->meta = get_post($product->id); 
	    $products[$n]->url =  get_permalink($product->id);
	    $products[$n]->label =  $products[$n]->meta->post_title;
	    $n  = $n + 1;
	}

	$response["rows"] = $products;
	return $response;
    }

    public static function getCoupons($filter_date) {
        $response = array();
        $response["table"] = array();
        $filter = Wolive_AdminReports::get_filter($filter_date);
	$response["filter"]  = $filter;

	global $wpdb; 
	$sql = $wpdb->prepare("SELECT value as label, count(*) as value FROM ".$wpdb->prefix.WOLIVE_TBL_ACT." WHERE timestamp >  %d and timestamp < %d and action_type='add_coupon' GROUP BY  label ORDER BY value desc LIMIT 0,100;",
	    $filter ->from, 
	    $filter -> to
	);
	$products = $wpdb->get_results($sql);
	$n = 0;
	
	foreach ($products as $product) {
	    $products[$n]->label = json_decode($products[$n]->label)->coupon;
	    $n  = $n + 1;
	}

	$response["rows"] = $products;
	return $response;
    }






}



