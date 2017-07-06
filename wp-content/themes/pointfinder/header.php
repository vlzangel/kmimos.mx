<?php include 'pre-header.php'; ?>
<!doctype html><html lang="es-ES" class="no-js"><head><meta charset="UTF-8"> <?php 

	$HTML = '';	
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
		header('X-UA-Compatible: IE=edge,chrome=1');
	}
	if ( is_page() ){
		global $post;
		$descripcion = get_post_meta($post->ID, 'kmimos_descripcion', true);
		if( $descripcion != ""){
			$HTML .= "<meta name='description' content='{$descripcion}'>";
		}else{
			//$HTML .= '<meta name="description" content="'.bloginfo('description').'">';
		}
	}else{
		//$HTML .= '<meta name="description" content="'.bloginfo('description').'">';
	}
	$HTML .= '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';

	wp_enqueue_style( 'style', get_home_url()."/wp-content/themes/pointfinder/style.css", array(), "1.0.0" );
	wp_enqueue_style( 'fontello', get_home_url()."/wp-content/themes/pointfinder/css/fontello.min.css", array(), "1.0.0" );
	wp_enqueue_script( 'menu_js', get_home_url()."/wp-content/themes/pointfinder/js/menu.js", array(), "1.0.0" );

	wp_head(); 

	$HTML .= '
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
	</head>
	<body class="'.join( ' ', get_body_class( $class ) ).'" >';

	include_once("funciones.php");

	$MENU = get_menu_header();

	$HTML .= '
		<header class="header">

			<div class="iconos_movil_box">
				<span id=""> <img src="'.get_home_url().'/wp-content/uploads/2016/02/patita.png" /> </span>                                       
				<span id="menu_2"> <i class="pfadmicon-glyph-500"></i> </span>                                       
	 			<span id="menu_1"> <i class="pfadmicon-glyph-632"></i> </span>
 			</div>  

			<nav id="menu_usuario" class="menu menu_usuario">
				<div class="container">
					<ul>
						'.$MENU["head"].'			
						'.$MENU["body"].'			
						'.$MENU["footer"].'		
					</ul>
				</div>
			</nav>

			<nav id="menu_syte" class="container">
				<div class="logo_box"></div>
				<ul id="menu_web" class="menu menu_syte_box">
					'.get_menu().'
					<li class="ser_cuidador">			
						<div>Quiero ser cuidador</div>
					</li>	
				</ul>
			</nav> 

		</header>
	';

	echo comprimir_styles($HTML);













































/*	$HTML = '
		<div id="pf-loading-dialog" class="pftsrwcontainer-overlay"></div>
        <header class="wpf-header hidden-print" id="pfheadernav">
		    <div class="pftopline wpf-transition-all">
		       	<div class="pf-container">
					<div class="pf-row">
						<div class="col-lg-12 col-md-12">
							<div class="wpf-toplinewrapper">
								<div class="pf-toplinks-right clearfix">
									<nav id="pf-topprimary-nav" class="pf-topprimary-nav pf-nav-dropdown clearfix hidden-sm hidden-xs">
										<ul class="pf-nav-dropdown pfnavmenu pf-topnavmenu">
											<ul class="pf-nav-dropdown pfnavmenu pf-topnavmenu ">
												'.$MENU["head"].'			
												'.$MENU["body"].'			
												'.$MENU["footer"].'			
											</ul>
										</ul>
									</nav>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		    
		    <div class="wpf-navwrapper">
		        <a href="'.get_home_url().'/" class="jj-patica-menu">
		        	<img src="https://www.kmimos.com.mx/wp-content/uploads/2016/02/patita.png">
		        </a>  
		        <a id="pf-primary-nav-button" title="Menú">
		        	<i class="pfadmicon-glyph-500"></i>
		        </a>
				<a id="pf-topprimary-nav-button" title="Menú del Usuario">
					<i class="pfadmicon-glyph-632"></i>
				</a>
				<div class="pf-container pf-megamenu-container">
					<div class="pf-row">
						<div class="col-lg-2 col-md-2">
							<a class="pf-logo-container" href="'.get_home_url().'"></a>
						</div>
						<div class="col-lg-10 col-md-10" id="pfmenucol1">
							<div class="pf-menu-container">
								<nav id="pf-primary-nav" class="pf-nav-dropdown clearfix">
									<style>
										.ser_cuidador{
											vertical-align: middle;
											text-align: center;
										}
										.ser_cuidador span{
											height: 74px;
											vertical-align: middle;
											display: inline-block;
										}
										.ser_cuidador div{
											vertical-align: middle;
											display: inline-block;
											padding: 5px 10px;
											background-color: #fefe78;
											color: #333333;
											box-sizing: border-box;
											-webkit-font-smoothing: antialiased;
											text-rendering: optimizeLegibility;
											font-family: "Open Sans";
											font-weight: 600;
											font-style: normal;
											border-radius: 2px;
										}
										.pfshrink .ser_cuidador span{
											height: 38px;
										}
										@media (max-width: 568px){
											.wpf-header #pf-primary-nav .pfnavmenu .main-menu-item > a {
												height: auto !important;
												line-height: 18px !important;
											}
											.wpf-header #pf-primary-nav .pfnavmenu .pfnavsub-menu > li a.sub-menu-link, .anemptystylesheet {
												text-align: left !important;
											}
											.wpf-header #pf-primary-nav li a, .wpf-header #pf-primary-nav.pfmobileview .pfnavmenu .main-menu-item > a {
												text-align: left !important;
											}
											#pfmenucol1, .pfnavmenu li.pf-megamenu-main {
												margin-bottom: 3px;
											}
											.wpf-navwrapper .pf-menu-container.pfactive {
												margin-top: 10px;
												margin-bottom: 15px;
											}
											.ser_cuidador {
												padding: 0px 0px 13px !important;
											}
											.ser_cuidador span {
												height: auto;
												vertical-align: middle;
												display: inline-block;
											}
											.ser_cuidador div {
												display: block;
												text-align: center;
											}

											#pf-primary-nav-button,
											#pf-topprimary-nav-button{
												display: inline-block;
												padding: 4px 0px;
											}
										} 
									</style>
									<ul class="pf-nav-dropdown pfnavmenu pf-topnavmenu">';

										echo comprimir_styles($HTML);

										$HTML = "";

										//pointfinder_navigation_menu();
									
										$EC = is_cuidador();
										if( $EC != 1 ){
											$HTML .= "
												<li>
													<a class='ser_cuidador' href='".get_home_url()."/quiero-ser-cuidador-certificado-de-perros/'>
														<span></span>
														<div class='theme_button button_header'>Quiero ser cuidador</div>
													</a>
												<li>
											";
										} $HTML .= '
									</ul>

								</nav>	

								<nav id="pf-topprimary-navmobi" class="pf-topprimary-nav pf-nav-dropdown clearfix" style="display: none;">
									<ul class="pf-nav-dropdown  pfnavmenu pf-topnavmenu pf-nav-dropdownmobi">
										'.$MENU["body"].'
									</ul>
								</nav>

								<script type="text/javascript">
									jQuery("#nav-menu-item-1617 ul a").attr("target", "_blank");
								</script>
						
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<style type="text/css">
			.pfloggedin:hover .pfnavsub-menu{
				    display: inline-block;
				    min-width: 214px !important;
				    left: 0px;
			}
			.main-menu-item:hover .pfnavsub-menu{
			    display: inline-block;
			    min-width: 214px !important;
			    left: 0px;
			}
		</style>
		
        <div class="wpf-container">
        	<div id="pfmaincontent" class="wpf-container-inner">';*/

        // echo comprimir_styles($HTML);

