<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Booking is cancelled
 *
 * An email sent to the user when a booking is cancelled or not approved.
 *
 * @class 		WC_Email_Admin_Booking_Cancelled
 * @extends 	WC_Email
 */
class WC_Email_Admin_Booking_Cancelled extends WC_Email {

	/**
	 * Constructor
	 */
	function __construct() {
		$this->id             = 'booking_cancelled';
		$this->title          = __( 'Admin Booking Cancelled', 'woocommerce-bookings' );
		$this->description    = __( 'Booking cancelled emails are sent when the status of a booking goes to cancelled.', 'woocommerce-bookings' );

		$this->heading        = __( 'Booking Cancelled', 'woocommerce-bookings' );
		$this->subject        = __( '[{blogname}] A booking of "{product_title}" has been cancelled', 'woocommerce-bookings' );

		$this->template_html  = 'emails/admin-booking-cancelled.php';
		$this->template_plain = 'emails/plain/admin-booking-cancelled.php';

		// Triggers for this email
		add_action( 'woocommerce_booking_pending-confirmation_to_cancelled_notification', array( $this, 'trigger' ) );
		add_action( 'woocommerce_booking_confirmed_to_cancelled_notification', array( $this, 'trigger' ) );
		add_action( 'woocommerce_booking_paid_to_cancelled_notification', array( $this, 'trigger' ) );

		// Call parent constructor
		parent::__construct();

		// Other settings
		$this->template_base = WC_BOOKINGS_TEMPLATE_PATH;
		$this->recipient     = $this->get_option( 'recipient', get_option( 'admin_email' ) );
	}

	/**
	 * trigger function.
	 *
	 * @access public
	 * @return void
	 */
	function trigger( $booking_id ) {
		if ( $booking_id ) {

			// Only send the booking email for booking post types, not orders, etc
			if ( 'wc_booking' !== get_post_type( $booking_id ) ) {
				return;
			}

			$this->object    = get_wc_booking( $booking_id );

			if ( $this->object->get_product() ) {
				$this->find[]    = '{product_title}';
				$this->replace[] = $this->object->get_product()->get_title();
			}

			if ( $this->object->get_order() ) {
				$this->find[]    = '{order_date}';
				$this->replace[] = date_i18n( wc_date_format(), strtotime( $this->object->get_order()->order_date ) );

				$this->find[]    = '{order_number}';
				$this->replace[] = $this->object->get_order()->get_order_number();
			} else {
				$this->find[]    = '{order_date}';
				$this->replace[] = date_i18n( wc_date_format(), strtotime( $this->object->booking_date ) );

				$this->find[]    = '{order_number}';
			}
		}

		if ( ! $this->is_enabled() || ! $this->get_recipient() )
			return;

		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
	}

	/**
	 * get_content_html function.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_html() {
		ob_start();
		wc_get_template( $this->template_html, array(
			'booking' 		=> $this->object,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => false,
			'plain_text'    => false
		), 'woocommerce-bookings/', $this->template_base );
		return ob_get_clean();
	}

	/**
	 * get_content_plain function.
	 *
	 * @access public
	 * @return string
	 */
	function get_content_plain() {
		ob_start();
		wc_get_template( $this->template_plain, array(
			'booking' 		=> $this->object,
			'email_heading' => $this->get_heading(),
			'sent_to_admin' => false,
			'plain_text'    => true
		), 'woocommerce-bookings/', $this->template_base );
		return ob_get_clean();
	}

    /**
     * Initialise Settings Form Fields
     *
     * @access public
     * @return void
     */
    function init_form_fields() {
    	$this->form_fields = array(
			'enabled' => array(
				'title' 		=> __( 'Enable/Disable', 'woocommerce-bookings' ),
				'type' 			=> 'checkbox',
				'label' 		=> __( 'Enable this email notification', 'woocommerce-bookings' ),
				'default' 		=> 'yes'
			),
			'recipient' => array(
				'title'         => __( 'Recipient(s)', 'woocommerce-bookings' ),
				'type'          => 'text',
				'description'   => sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', 'woocommerce-bookings' ), esc_attr( get_option('admin_email') ) ),
				'placeholder'   => '',
				'default'       => ''
			),
			'subject' => array(
				'title' 		=> __( 'Subject', 'woocommerce-bookings' ),
				'type' 			=> 'text',
				'description' 	=> sprintf( __( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', 'woocommerce-bookings' ), $this->subject ),
				'placeholder' 	=> '',
				'default' 		=> ''
			),
			'heading' => array(
				'title' 		=> __( 'Email Heading', 'woocommerce-bookings' ),
				'type' 			=> 'text',
				'description' 	=> sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', 'woocommerce-bookings' ), $this->heading ),
				'placeholder' 	=> '',
				'default' 		=> ''
			),
			'email_type' => array(
				'title' 		=> __( 'Email type', 'woocommerce-bookings' ),
				'type' 			=> 'select',
				'description' 	=> __( 'Choose which format of email to send.', 'woocommerce-bookings' ),
				'default' 		=> 'html',
				'class'			=> 'email_type',
				'options'		=> array(
					'plain'		 	=> __( 'Plain text', 'woocommerce-bookings' ),
					'html' 			=> __( 'HTML', 'woocommerce-bookings' ),
					'multipart' 	=> __( 'Multipart', 'woocommerce-bookings' ),
				)
			)
		);
    }
}

return new WC_Email_Admin_Booking_Cancelled();
