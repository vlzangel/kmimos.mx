<?php

/**

 * Customer invoice email

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-invoice.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).

 * will need to copy the new files to your theme to maintain compatibility. We try to do this.

 * as little as possible, but it does happen. When this occurs the version of the template file will.

 * be bumped and the readme will list any important changes.

 *

 * @see 	    http://docs.woothemes.com/document/template-structure/

 * @author 		WooThemes

 * @package 	WooCommerce/Templates/Emails

 * @version     2.5.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



/**

 * @hooked WC_Emails::email_header() Output the email header

 */

//do_action( 'woocommerce_email_header', $email_heading, $email ); 



echo kmimos_get_email_header();

/*

*   Coloca el contenido

*/

$html .= '    <div class="container">';

$html .= '      <span class="title">'.$email_heading.'</span>';

$html .= '      <div class="content">';



echo $html;



?>



<?php if ( $order->has_status( 'pending' ) ) : ?>

	<p><?php printf( __( 'An order has been created for you on %s. To pay for this order please use the following link: %s', 'woocommerce' ), get_bloginfo( 'name', 'display' ), '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . __( 'pay', 'woocommerce' ) . '</a>' ); ?></p>

<?php endif; ?>



<?php



/**

 * @hooked WC_Emails::order_details() Shows the order details table.

 * @since 2.5.0

 */

do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );



/**

 * @hooked WC_Emails::order_meta() Shows order meta data.

 */

do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );



/**

 * @hooked WC_Emails::customer_details() Shows customer details

 * @hooked WC_Emails::email_address() Shows email address

 */

do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );



/**

 * @hooked WC_Emails::email_footer() Output the email footer

 */



$gretting = 'Atentamente,';



$html = '      </div>

      <div class="gretting">

        <span>'.$gretting.'</span><br>

        <img src="'.get_home_url().'/wp-content/uploads/2016/03/logo-kmimos_120x30.png" alt="Firma Kmimos">

      </div>';



/*

*   Introduce los banners

*/

$html .= kmimos_get_email_banners();

/*

*   Fin de los banners

*/

$html .= '    </div>';

/*

*   Empieza el pie del correo

*/

$html .= kmimos_get_email_footer();

echo $html;



//do_action( 'woocommerce_email_footer', $email ); %>

