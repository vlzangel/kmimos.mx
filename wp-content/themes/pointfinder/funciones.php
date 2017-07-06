<?php
	function get_menu(){
		$defaults = array(
		    'theme_location'  => 'pointfinder-main-menu',
		    'menu'            => '',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => '',
		    'menu_id'         => '',
		    'echo'            => false,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '%3$s',
		    'depth'           => 0
		);
		return wp_nav_menu( $defaults );
	}
?>