<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */
?>
<?php	
	if( is_front_page() ){ 
		get_template_part( 'template-parts/footer/footer', 'page' ); 
	}
?>


</div><!-- Container-fluid -->

	
	<script type="text/javascript" src="/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/plugins/bootstrap/js/bootstrap.min.js"></script>

	<?php get_template_part( 'template-parts/footer/footer_service', 'page' ); ?>

	<?php wp_footer(); ?>
</body>
</html>
