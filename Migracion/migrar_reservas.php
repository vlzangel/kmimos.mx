<?php

	$conn_my = new mysqli("localhost", "root", "", 'kmimos.reservas');

	if (!$conn_my) {
	  	echo "No conectado.\n";
	  	exit;
	}

	echo "<b>wc_booking</b><br><br><table><tr><td>Clave</td><td>Valor</td></tr>";
	$result = $conn_my->query("SELECT * FROM wp_postmeta WHERE post_id = '150684'");
	while ($metas = $result->fetch_assoc()){
		echo utf8_encode( "<tr><td><b>".$metas['meta_key']."</b>: </td><td>".$metas['meta_value']."<br></td></tr>" );
	}




	echo "</table><br><br><b>shop_order</b><br><br><table><tr><td>Clave</td><td>Valor</td></tr>";
	$consulta = "INSERT INTO wp_postmeta VALUES(<br>";
	$result = $conn_my->query("SELECT * FROM wp_postmeta WHERE post_id = '150685'");
	while ($metas = $result->fetch_assoc()){
		echo utf8_encode( "<tr><td><b>".$metas['meta_key']."</b>: </td><td>".$metas['meta_value']."<br></td></tr>" );
		$consulta .= "(NULL, '{\$id_order}', '".$metas['meta_key']."', '".$metas['meta_value']."'),<br>";
	}
	echo $consulta .= ");<br>";



	$consulta = "INSERT INTO wp_postmeta VALUES(<br>";
	echo "</table><br><br><b>shop_order_vendor</b><br><br><table><tr><td>Clave</td><td>Valor</td></tr>";
	$result = $conn_my->query("SELECT * FROM wp_postmeta WHERE post_id = '150686'");
	while ($metas = $result->fetch_assoc()){
		echo utf8_encode( "<tr><td><b>".$metas['meta_key']."</b>: </td><td>".$metas['meta_value']."<br></td></tr></td></tr>" );
		$consulta .= "(NULL, '{\$id_order_vendor}', '".$metas['meta_key']."', '".$metas['meta_value']."'),<br>";
	}
	echo $consulta .= ");<br>";





	$consulta = "INSERT INTO wp_postmeta VALUES(<br>";
	echo "</table><br><br><b>wp_woocommerce_order_itemmeta</b><br><br><table><tr><td>Clave</td><td>Valor</td></tr>";
	$result = $conn_my->query("SELECT * FROM wp_woocommerce_order_itemmeta WHERE order_item_id = '456'");
	while ($metas = $result->fetch_assoc()){
		echo utf8_encode( "<tr><td><b>".$metas['meta_key']."</b>: </td><td>".$metas['meta_value']."<br></td></tr>" );
		$consulta .= "(NULL, '{\$id_item}', '".$metas['meta_key']."', '".$metas['meta_value']."'),<br>";
	}
	echo "</table>";
	$consulta .= ");<br>";
	echo utf8_encode( $consulta);
	
?>