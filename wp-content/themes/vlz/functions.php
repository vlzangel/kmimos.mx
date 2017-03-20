<?php

if ( ! function_exists( 'pointfinder_setup' ) ){

	function vlz_setup() {
		add_theme_support('menus');
	    add_theme_support('post-thumbnails');

	    add_image_size('large', 700, '', true); 
	    add_image_size('medium', 250, '', true);
	    add_image_size('small', 120, '', true);
	    add_image_size('ItemSize2x', 880, 660, true);

	    add_theme_support( 'woocommerce' );
		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list' ) );

		register_nav_menus(array( 
			'main-menu' 	=> esc_html__('Principal', 	'vlz'),
			'main-users' 	=> esc_html__('Users', 	'vlz'),
			'footer-menu' 	=> esc_html__('Footer', 	'vlz')
	    ));
	}

};
add_action('after_setup_theme', 'vlz_setup');

add_filter('widget_text', 'do_shortcode'); 
add_filter('the_excerpt', 'do_shortcode'); 

?>