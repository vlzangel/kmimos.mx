<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( 
  in_array( 
    'woocommerce/woocommerce.php', 
    apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
  ) 
) {
	$woocommerce_wl  = "true";
} else {
    $woocommerce_wl = "false";
}

?>

<script>
wolive_assets_url = "<?php echo WOLIVE__PLUGIN_URL."assets/"; ?>";
wolive_scoopeTime = <?php echo WOLIVE_SCOOPE_TIME; ?>;
woocommerce_wl = <?php echo $woocommerce_wl; ?>;
url_options = "<?php echo admin_url('/admin.php?page=wolive-options&license=invalid', 'http')?>" ;
</script>


<div id="wolive_container"  ng-app="Wolive"  >

<div id="navbar" class="navbar-collapse ">



	<ul class="nav navbar-nav navbar-left">
	<li>
		<a class="linkHeader" href="<?php echo get_bloginfo("url"); ?>"> 
		<i class="fa fa-external-link" aria-hidden="true"></i>

<?php echo get_bloginfo("name"); ?> </a></li>

	</ul>
</div>


   <div class="container-fluid" id="container-scroll">
      <div class="row fullHeight" >
        <div class="sidebar" ng-controller="NavController as nav" >
          <ul class="nav nav-sidebar">
			<li ng-class="{ open: isActive('/') }" ><a  href ng-click="go('/')"  ><span class="glyphicon glyphicon-home"></a></li>
			<li ng-show="woocommerce" ng-class="{ open: isActive('/Woocommerce') }" ><a  href ng-click="go('/Woocommerce')"><span class="glyphicon glyphicon-shopping-cart"></a></li>
			<li ng-class="{ open: isActive('/Users') }" ><a  href ng-click="go('/Users')"><span class="glyphicon glyphicon-user"></a></li>
			<li ng-class="{ open: isActive('/Reports') }" ><a href ng-click="go('/Reports')"><span class="glyphicon glyphicon-stats"></a> </li>
			<li ng-class="{ open: isActive('/funnels') }" ng-hide="true" ><a href ng-click="go('/funnels')"><span class="glyphicon glyphicon-filter"></a> </li>
	  </ul>
        </div>

        <div class="main-wolive fullHeight"  >
         <div ng-view class="padding fullHeight"></div>
        </div>
      </div>
    </div>

</div>
