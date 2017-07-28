<?php 
    /*
        Template Name: Home
    */

    wp_enqueue_style('home_kmimos', $home."/wp-content/themes/pointfinder/css/home_kmimos.css", array(), '1.0.0');
    wp_enqueue_style('home_responsive', $home."/wp-content/themes/pointfinder/css/responsive/home_responsive.css", array(), '1.0.0');
    wp_enqueue_script('buscar_home', $home."/wp-content/themes/pointfinder/js/home.js", array(), '1.0.0');
            
    get_header();
        
        $data = get_data_home();

	    extract($data);

	    $home = get_home_url();

	    $HTML = "
	    <script type='text/javascript'> var URL_MUNICIPIOS = '".get_bloginfo( 'template_directory', 'display' )."/procesos/generales/municipios.php'; </script>

	    ";

	    echo comprimir_styles($HTML);

    get_footer(); 
?>


