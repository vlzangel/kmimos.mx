<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<?php

	// Modificacion Ángel Veloz
	if( !isset($_SESSION) ){ session_start(); }

    global $current_user;
    $user_id = md5($current_user->ID);

    if( isset( $_SESSION["MR_".$user_id] ) ){
        $DS = $_SESSION["MR_".$user_id];

        global $wpdb;

        $id_cupon = $wpdb->get_var("SELECT ID FROM wp_posts WHERE post_name='saldo-{$current_user->ID}'");

        $monto_cupon = $DS["saldo"];
        $servicio    = $DS["servicio"];
        $manana      = date('Y-m-d', time()+84600)." 00:00:00";
        	
    	/*echo "<pre>";
    		print_r($DS);
    	echo "</pre>";*/

    	if( $monto_cupon > 0){

	  //       if( $id_cupon == NULL ){
	  //           date_default_timezone_set('America/Mexico_City');
	  //           $hoy = date("Y-m-d H:i:s");

	  //           $id_cupon = $wpdb->insert('wp_posts', array(
			// 	    "ID" => NULL,
		 //            "post_author" => $current_user->ID,
		 //            "post_date" => $hoy,
		 //            "post_date_gmt" => $hoy,
		 //            "post_content" => "",
		 //            "post_title" => "saldo-".$current_user->ID,
		 //            "post_excerpt" => "",
		 //            "post_status" => "publish",
		 //            "comment_status" => "closed",
		 //            "ping_status" => "closed",
		 //            "post_password" => "",
		 //            "post_name" => "saldo-".$current_user->ID,
		 //            "to_ping" => "",
		 //            "pinged" => "",
		 //            "post_modified" => $hoy,
		 //            "post_modified_gmt" => $hoy,
		 //            "post_content_filtered" => "",
		 //            "post_parent" => 0,
		 //            "guid" => get_home_url()."/?post_type=shop_coupon&#038;p=",
		 //            "menu_order" => 0,
		 //            "post_type" => "shop_coupon",
		 //            "post_mime_type" => "",
		 //            "comment_count" => 0
			// 	));

	  //           $id_cupon = $wpdb->get_var("SELECT ID FROM wp_posts WHERE post_name='saldo-{$current_user->ID}'");

			// 	$wpdb->query("UPDATE wp_posts SET guid = '".get_home_url()."/?post_type=shop_coupon&#038;p=".$id_cupon."' WHERE ID = ".$id_cupon);

			// 	$wpdb->query("
			// 		INSERT INTO wp_postmeta VALUES
	  //                   (NULL, ".$id_cupon.", 'discount_type', 'fixed_cart'),
	  //                   (NULL, ".$id_cupon.", 'coupon_amount', '".$monto_cupon."'),
	  //                   (NULL, ".$id_cupon.", 'individual_use', 'no'),
	  //                   (NULL, ".$id_cupon.", 'product_ids', '".$servicio."'),
	  //                   (NULL, ".$id_cupon.", 'exclude_product_ids', ''),
	  //                   (NULL, ".$id_cupon.", 'usage_limit', '1'),
	  //                   (NULL, ".$id_cupon.", 'usage_limit_per_user', '1'),
	  //                   (NULL, ".$id_cupon.", 'limit_usage_to_x_items', ''),
	  //                   (NULL, ".$id_cupon.", 'expiry_date', '".$manana."'),
	  //                   (NULL, ".$id_cupon.", 'free_shipping', 'no'),
	  //                   (NULL, ".$id_cupon.", 'exclude_sale_items', 'no'),
	  //                   (NULL, ".$id_cupon.", 'product_categories', 'a:0:{}'),
	  //                   (NULL, ".$id_cupon.", 'exclude_product_categories', 'a:0:{}'),
	  //                   (NULL, ".$id_cupon.", 'minimum_amount', ''),
	  //                   (NULL, ".$id_cupon.", 'maximum_amount', ''),                    
	  //                   (NULL, ".$id_cupon.", 'customer_email', 'a:0:{}');
			// 	");
	  //       }else{

	  //       	$sqls = array(
	  //       		"UPDATE wp_postmeta SET meta_value = '".$monto_cupon."' WHERE post_id = ".$id_cupon." AND meta_key = 'coupon_amount'",
	  //       		"UPDATE wp_postmeta SET meta_value = '".$servicio."'    WHERE post_id = ".$id_cupon." AND meta_key = 'product_ids'",
	  //       		"UPDATE wp_postmeta SET meta_value = '".$manana."'      WHERE post_id = ".$id_cupon." AND meta_key = 'expiry_date'"
	  //       	);

	  //       	// echo "<pre>";
	  //       	// 	print_r($sqls);
	  //       	// echo "</pre>";

	  //       	foreach ($sqls as $sql) {
	  //       		$wpdb->query($sql);
	  //       	}

	  //       }

	  //       // exit;

	  //       if( !WC()->cart->has_discount( "saldo-".$current_user->ID ) ){
			// 	WC()->cart->add_discount( "saldo-".$current_user->ID );
			// }
		
		}else{
			/*echo "No se genera cupon";
	    	echo "<pre>";
	    		print_r($DS);
	    	echo "</pre>";*/
		}

    }

    // exit;
?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
<!-- 	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead> -->
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-remove" colspan=2>
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>
				</tr>
				<!-- <tr>
					<td class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
							}
						?>
					</td>
				</tr> -->
				<tr>
					<td colspan=2 class="product-name" > <!-- data-title="<?php _e( 'Product', 'woocommerce' ); ?>" -->

						<?php
							if ( ! $_product->is_visible() ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
					</td>
				</tr>
				<tr>
					<td> <!-- data-title="<?php _e( 'Price', 'woocommerce' ); ?>" -->
						<strong><?php _e( 'Price', 'woocommerce' ); ?></strong>
					</td>
					<td align="right"> <!-- data-title="<?php _e( 'Price', 'woocommerce' ); ?>" -->
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<tr>
					<td> <!-- data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>" -->
						<strong><?php _e( 'Quantity', 'woocommerce' ); ?></strong>
					</td>
					<td align="right"> <!-- data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>" -->
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>
				</tr>
				<tr>
					<td> <!-- data-title="<?php _e( 'Total', 'woocommerce' ); ?>" -->
						<strong><?php _e( 'Total', 'woocommerce' ); ?></strong>
					</td>
					<td align="right"> <!-- data-title="<?php _e( 'Total', 'woocommerce' ); ?>" -->
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<!-- <input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?> -->
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

<!-- Modificacion Ángel Veloz -->
<style>
	.woocommerce .cart-collaterals .cross-sells, .woocommerce-page .cart-collaterals .cross-sells, .woocommerce .cart-collaterals .cart_totals, .woocommerce-page .cart-collaterals .cart_totals {
	    width: 100% !important;
	}
	a.checkout-button.button.alt.wc-forward {
	    margin-top: 10px;
	    max-width: 300px;
	    float: right;
	}
	.vlz_totales td {
	    text-align: right;
	}
	.woocommerce-cart .cart-collaterals .cart_totals table th {
	    width: auto;
	}
</style>