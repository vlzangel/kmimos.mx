<?php echo get_estados_municipios(); 
?><script type="text/javascript">var imges = "<?php echo "$home/wp-content/themes/pointfinder/vlz/js/"; ?>"; jQuery(function() {<?php
	if( count($_POST['servicios']) > 0 ){
		foreach ($_POST['servicios'] as $key => $value) {
			echo "vlz_select('servicio_{$value}');";
		}
	}
	if( count($_POST['tamanos']) > 0 ){
		foreach ($_POST['tamanos'] as $key => $value) {
			echo "vlz_select('tamanos_{$value}');";
		}
	} ?>
	jQuery('#orderby > option[value="<?php echo $_POST['orderby']; ?>"]').attr('selected', 'selected'); 
	jQuery('#tipo_busqueda > option[value="<?php echo $_POST['tipo_busqueda']; ?>"]').attr('selected', 'selected'); vlz_tipo_ubicacion(); <?php
?>});</script>
<?php echo print_info_cuidadores_map(); ?>
<script type="text/javascript" src="<?php echo $home."/wp-content/themes/pointfinder/vlz/js/markerclusterer.js"; ?>"></script>
<script type="text/javascript" src="<?php echo $home."/wp-content/themes/pointfinder/vlz/js/oms.min.js"; ?>"></script>
<script src="<?php echo $home."/wp-content/themes/pointfinder/vlz/js/busqueda.js"; ?>"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyD-xrN3-wUMmJ6u2pY_QEQtpMYquGc70F8&callback=initMap"></script>