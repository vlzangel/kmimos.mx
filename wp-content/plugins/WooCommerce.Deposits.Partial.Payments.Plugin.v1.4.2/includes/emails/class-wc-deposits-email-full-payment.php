<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

if (!class_exists('WC_Deposits_Email_Full_Payment')):

/**
 * @brief Full Payment Email
 *
 * An email sent to the admin when a new order is fully paid for.
 *
 */
class WC_Deposits_Email_Full_Payment extends WC_Email {

  /**
   * Constructor
   */
  function __construct() {

    $this->id         = 'full_payment';
    $this->title      = __('Full Payment', 'woocommerce-deposits');
    $this->description    = __('Full payment emails are sent when an order is full paid.', 'woocommerce-deposits');

    $this->heading      = __('Order fully paid', 'woocommerce-deposits');
    $this->subject        = __('[{site_title}] Order fully paid ({order_number}) - {order_date}', 'woocommerce-deposits');

    $this->template_html  = 'emails/admin-new-order.php';
    $this->template_plain   = 'emails/plain/admin-new-order.php';

    // Triggers for this email
    add_action('woocommerce_order_status_partially-paid_to_processing_notification', array($this, 'trigger'));
    add_action('woocommerce_order_status_partially-paid_to_completed_notification', array($this, 'trigger'));
    add_action('woocommerce_order_status_partially-paid_to_on-hold_notification', array($this, 'trigger'));

    // Call parent constructor
    parent::__construct();

    // Other settings
    $this->recipient = $this->get_option('recipient');

    if (! $this->recipient)
      $this->recipient = get_option('admin_email');
  }

  /**
   * trigger function.
   *
   * @access public
   * @return void
   */
  function trigger($order_id) {

    if ($order_id) {
      $this->object     = wc_get_order($order_id);

      $this->find['order-date']      = '{order_date}';
      $this->find['order-number']    = '{order_number}';

      $this->replace['order-date']   = date_i18n(wc_date_format(), strtotime($this->object->order_date));
      $this->replace['order-number'] = $this->object->get_order_number();
    }

    if (! $this->is_enabled() || ! $this->get_recipient()) {
      return;
    }

    $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
  }

  /**
   * get_content_html function.
   *
   * @access public
   * @return string
   */
  function get_content_html() {
    ob_start();
    wc_get_template($this->template_html, array(
      'order'     => $this->object,
      'email_heading' => $this->get_heading(),
      'sent_to_admin' => true,
      'plain_text'    => false
   ));
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
    wc_get_template($this->template_plain, array(
      'order'     => $this->object,
      'email_heading' => $this->get_heading(),
      'sent_to_admin' => true,
      'plain_text'    => true
   ));
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
        'title'     => __('Enable/Disable', 'woocommerce'),
        'type'      => 'checkbox',
        'label'     => __('Enable this email notification', 'woocommerce'),
        'default'     => 'yes'
     ),
      'recipient' => array(
        'title'     => __('Recipient(s)', 'woocommerce'),
        'type'      => 'text',
        'description'   => sprintf(__('Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', 'woocommerce'), esc_attr(get_option('admin_email'))),
        'placeholder'   => '',
        'default'     => ''
     ),
      'subject' => array(
        'title'     => __('Subject', 'woocommerce'),
        'type'      => 'text',
        'description'   => sprintf(__('This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', 'woocommerce'), $this->subject),
        'placeholder'   => '',
        'default'     => ''
     ),
      'heading' => array(
        'title'     => __('Email Heading', 'woocommerce'),
        'type'      => 'text',
        'description'   => sprintf(__('This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', 'woocommerce'), $this->heading),
        'placeholder'   => '',
        'default'     => ''
     ),
      'email_type' => array(
        'title'     => __('Email type', 'woocommerce'),
        'type'      => 'select',
        'description'   => __('Choose which format of email to send.', 'woocommerce'),
        'default'     => 'html',
        'class'     => 'email_type',
        'options'   => array(
          'plain'     => __('Plain text', 'woocommerce'),
          'html'      => __('HTML', 'woocommerce'),
          'multipart'   => __('Multipart', 'woocommerce'),
       )
     )
   );
    }
}

endif;

return new WC_Deposits_Email_Full_Payment();
