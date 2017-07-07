<?php 

    wp_enqueue_style('producto', $home."/wp-content/themes/pointfinder/css/producto.css", array("wc-bookings-styles", "toggle-switch"), '1.0.0');
	wp_enqueue_style('producto_responsive', $home."/wp-content/themes/pointfinder/css/responsive/producto_responsive.css", array(), '1.0.0');

	wp_enqueue_script('producto', $home."/wp-content/themes/pointfinder/js/producto.js", array("jquery"), '1.0.0');

	get_header(); ?>
	<div class="body">
        <?php woocommerce_content(); ?>
    </div>
<?php get_footer(); ?>