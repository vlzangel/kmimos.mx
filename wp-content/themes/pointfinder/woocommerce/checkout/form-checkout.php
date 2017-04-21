<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>


		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<!-- ****Jauregui******<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php //do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php //do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div> -->
		<div id="customer_details" style="display: block;">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		<p style="display: none;"><strong>(<span style="color: red">*</span>)  Campos obligatorios</strong></p>

	<?php endif; ?>

	<h3 id="order_review_heading"><?php _e( 'Datos de la reserva', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php 
			do_action( 'woocommerce_checkout_order_review' );
		?>
	</div>
	<style type="text/css">
		#add_payment_method #payment ul.payment_methods, .woocommerce-checkout #payment ul.payment_methods>li>label {
		    color: #54c8a7;
		    font-size: large;
		    font-weight: bold;
		    text-shadow: 3px 2px 12px rgba(255, 255, 255, 0.57);
		}
		<?php
			global $current_user;
			$roles = wp_get_current_user()->roles;
			if( $roles[0] != "administrator" ){
				echo "
					.payment_method_wcvendors_test_gateway{
						display: none;
					}
				";
			}
		?>
		@media (max-width: 592px){
			#add_payment_method #payment ul.payment_methods, .woocommerce-checkout #payment ul.payment_methods>li>label {
				font-size: x-small;
			}

		}
	</style>
	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>


</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

 <script>
jQuery( document ).ready(function() {
    jQuery('dt.variation-Duracin').css('display', 'none');
    jQuery('dd.variation-Duracin').css('display', 'none');
    // jQuery('label[for=payment_method_openpay_cards]').css('display', 'none');
});
</script>