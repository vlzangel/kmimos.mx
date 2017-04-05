<?php
function kmimos_backpanel_style() {
	global $wp_styles;
}

// ========================================
// Script Dashboard ( New backpanel )
// ========================================
/*
wp_enqueue_script( 'kmimos_jqueryui_script1', plugins_url("dashboard/assets/vendor/jquery/dist/jquery.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script2', plugins_url("dashboard/assets/vendor/bootstrap/dist/js/bootstrap.min.js", __FILE__), array(), '1.11.1', true  );
//wp_enqueue_script( 'kmimos_jqueryui_script3', plugins_url("dashboard/assets/vendor/fastclick/lib/fastclick.js", __FILE__), array(), '1.11.1', true  );
//wp_enqueue_script( 'kmimos_jqueryui_script4', plugins_url("dashboard/assets/vendor/nprogress/nprogress.js", __FILE__), array(), '1.11.1', true  );
//wp_enqueue_script( 'kmimos_jqueryui_script5', plugins_url("dashboard/assets/vendor/iCheck/icheck.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script6', plugins_url("dashboard/assets/vendor/datatables.net/js/jquery.dataTables.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script7', plugins_url("dashboard/assets/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script8', plugins_url("dashboard/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script9', plugins_url("dashboard/assets/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script10', plugins_url("dashboard/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script11', plugins_url("dashboard/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script12', plugins_url("dashboard/assets/vendor/datatables.net-buttons/js/buttons.print.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script13', plugins_url("dashboard/assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script14', plugins_url("dashboard/assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script15', plugins_url("dashboard/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script16', plugins_url("dashboard/assets/vendor/datatables.net-responsive-bs/js/responsive.bootstrap.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script17', plugins_url("dashboard/assets/vendor/datatables.net-scroller/js/dataTables.scroller.min.js", __FILE__), array(), '1.11.1', true  );
wp_enqueue_script( 'kmimos_jqueryui_script18', plugins_url("dashboard/assets/js/custom.js", __FILE__), array(), '2.12.0', true  );
}
*/
// add_action( 'wp_enqueue_scripts', 'kmimos_dashboard_scripts' );