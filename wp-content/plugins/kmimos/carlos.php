<?php

	include_once('wlabel/wlabel.php');
	include_once('subscribe/subscribe.php');

	include_once('includes/class/class_kmimos_booking.php');
	include_once('includes/class/class_kmimos_tables.php');
	include_once('includes/class/class_kmimos_script.php');
	// include_once('plugins/woocommerce.php');

	if(!function_exists('carlos_include_script')){
	    function carlos_include_script(){
	        
	    }
	}

	if(!function_exists('carlos_include_admin_script')){
	    function carlos_include_admin_script(){
	        
	    }
	}

	if(!function_exists('carlos_menus')){
	    function carlos_menus($menus){
	        


	        return $menus;
	    }
	}

	add_action( 'send_headers', 'add_header_seguridad' );
	function add_header_seguridad() {
	    header( 'X-Content-Type-Options: nosniff' );
	    header( 'X-Frame-Options: SAMEORIGIN' );
	    header( 'X-XSS-Protection: 1' );
	    header( 'Cache-Control: no-cache, no-store, must-revalidate');

	    //Prevent Cache-control http
	    //header('Access-Control-Allow-Origin: *', false);
	}



	////MORE VIEWED
	remove_action('wp_head','adjacent_posts_rel_link_wp_head', 10, 0);

	function theme_set_post_views($postid) {
		$count_key = 'post_views_count';
		$count = get_post_meta($postid, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postid, $count_key);
			add_post_meta($postid, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postid, $count_key, $count);
		}
	}

	add_action('wp_head','theme_track_post_views');
	function theme_track_post_views($postid){
		if (!is_single()){
			return;
		}else if(empty($postid)){
			global $post;
			$postid = $post->ID;
		}
		theme_set_post_views($postid);
	}

	function theme_get_post_views($postid){
		$count_key = 'post_views_count';
		$count = get_post_meta($postid, $count_key, true);
		if($count==''){
			delete_post_meta($postid, $count_key);
			add_post_meta($postid, $count_key, '0');
			return 0;
		}
		return $count;
	}

?>