<?php
function kmimos_dashboard_scripts() {
	global $wp_styles;
	// ******************************
	// Style
	// ******************************

	// <!-- Bootstrap -->
	// wp_enqueue_style( 'bootstrap', 
	// 	plugin_dir_url( __FILE__ )."/assets/source/vendors/bootstrap/dist/css/bootstrap.min.css" );

	// <!-- Font Awesome -->
	// wp_enqueue_style( 'fontawesome', 
	//	plugins_url("/assets/source/vendors/font-awesome/css/font-awesome.min.css", __FILE__));

	// <!-- Datatables -->
	// wp_enqueue_style( 'datatables-bootstrap' 
	// 	plugin_dir_url( __FILE__ )."/assets/source/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css");
	// wp_enqueue_style( 'datatables-bootstrap-net' 
	// 	plugin_dir_url( __FILE__ )."/assets/source/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css");
	// wp_enqueue_style( 'datatables-bootstrap-fixed' 
	// 	plugin_dir_url( __FILE__ )."/assets/source/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css");
	// wp_enqueue_style( 'datatables-bootstrap-responsive' 
	// 	plugin_dir_url( __FILE__ )."/assets/source/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css");
	// wp_enqueue_style( 'datatables-bootstrap-scroller' 
	// 	plugin_dir_url( __FILE__ )."/assets/source/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css");

	// // <!-- Custom Theme Style -->
	// wp_enqueue_style( 'datatable-custom',
	// 	plugin_dir_url( __FILE__ )."/assets/source/build/css/custom.min.css");
}
add_action( 'wp_enqueue_scripts', 'kmimos_dashboard_scripts' );