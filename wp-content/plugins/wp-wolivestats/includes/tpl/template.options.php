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

add_action( 'admin_footer', 'ajax_license' ); // Write our JS below here

function ajax_license() { ?>
	<script type="text/javascript" >
	function checkLicense() {
		var data = {
			'action': 'wolive_checkLicense',
			'license': jQuery("#wolive_license_key").val()
		};
		
		jQuery.post(ajaxurl, data, function(response) {
			var obj =  jQuery.parseJSON(response);
			if ( obj.status === 0  ) {
				// Not valid

			}else if (obj.status === 1) {
				// Valid

			} else if (obj.status === -1) {

			} else {
				
			}
		});
	}

	jQuery(document).ready(function($) {
		jQuery("#button_license").click(checkLicense);
	});
    
	</script> <?php
}

?>

<script>
wolive_assets_url = "<?php echo WOLIVE__PLUGIN_URL."assets/"; ?>";
wolive_scoopeTime = <?php echo WOLIVE_SCOOPE_TIME; ?>;
woocommerce_wl = <?php echo $woocommerce_wl; ?>;

</script>

  <div>
  <?php screen_icon(); ?>
  <h2>Wolive settings</h2>
  <form method="post" action="options.php">

    <?php settings_fields( 'wolive-options' ); ?>
    <?php do_settings_sections( 'wolive-options' ); ?>


<?php 


$license_status = get_option("wolive_license_status");

if ( $license_status == 1  ) : ?>
	<div class="notice notice-success is-dismissible"><p><?php _e('License Activation Successful!'); ?>.</p></div>
<?php endif; ?>

<?php
if ( $license_status == 0 ) : ?>
	<div class="notice notice-error"><p><?php _e('This license is invalid! Get a new license http://wolive.me'); ?>.</p></div>
<?php endif; ?>

<?php
if ( $license_status == -1 ) : ?>
	<div class="notice notice-error"><p><?php _e('This license is using by another site. Get a new license http://wolive.me!'); ?>.</p></div>
<?php endif; ?>


  <table class="form-table">


  <tr valign="top">
  <th scope="row" class="titledesc"><label for="wolive_license_key">License Key</label></th>
  <td class="forminp forminp-email" >
	<input type="text" id="wolive_license_key" placeholder="XXXX-XXXX-XXXX-XXXX" name="wolive_license_key" value="<?php echo esc_attr(get_option('wolive_license_key')); ?>" style="min-width:200px;" /> 
	<!--<input type="button" id="button_license" class="button button-primary" value="Activate Key">-->
    
    </td>
  </tr>

  <tr valign="top">
  <th scope="row" class="titledesc"><label for="wolive_flag_tracking"> Enabled Tracking </label></th>
  <td class="forminp forminp-email" >
  <input type="checkbox" id="wolive_flag_tracking"  name="wolive_flag_tracking" value="1"  <?php checked(get_option('wolive_flag_tracking'),1, true ) ?> /></td>
  </tr>

  </table>

<p>
    <span class="description">The <a href="http://dev.maxmind.com/geoip/legacy/geolite/" target="_blank">MaxMind GeoLite library</a>, which Wolive uses to geolocate visitors, is released under the Creative Commons BY-SA 3.0 license, and cannot be directly bundled with the plugin because of license incompatibility issues. The library is downloaded when you activate this plugin. </span>
</p>



  <?php  submit_button(); ?>
  </form>
  </div>


