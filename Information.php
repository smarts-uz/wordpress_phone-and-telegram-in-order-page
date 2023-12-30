<?php
/*
Plugin Name: Phone number and Telegram link in WooCommerce
Description: Adds custom fields for Telegram and phone number in WooCommerce settings.
Version: 1.0
Author: Isomukhammad
*/

// Add custom fields to WooCommerce settings
add_filter( 'woocommerce_general_settings', 'add_custom_fields_to_woocommerce_settings' );
function add_custom_fields_to_woocommerce_settings( $settings ) {
  $settings[] = array(
    'title' => __( 'Telegram Link', 'woocommerce' ),
    'desc'  => __( 'Enter your Telegram link', 'woocommerce' ),
    'id'    => 'telegram_link',
    'type'  => 'text',
    'default' => '',
    'desc_tip' => true,
  );

  $settings[] = array(
    'title' => __( 'Support Phone Number', 'woocommerce' ),
    'desc'  => __( 'Enter your support phone number', 'woocommerce' ),
    'id'    => 'support_phone_number',
    'type'  => 'text',
    'default' => '',
    'desc_tip' => true,
  );

  return $settings;
}

// Display custom fields on the order received page
add_filter( 'woocommerce_thankyou_order_received_text', 'display_custom_fields_on_order_received_page', 10, 2 );
function display_custom_fields_on_order_received_page( $text, $order ) {
  // Retrieve custom field values
  $support_phone_number = get_option( 'support_phone_number' );
  $telegram_link = get_option( 'telegram_link' );

  // Customize the message
  $additional_content = '';
  if ( $support_phone_number ) {
    $additional_content .= 'Please contact us at <a href="tel:' . esc_attr( $support_phone_number ) . '">' . esc_html( $support_phone_number ) . '</a>.<br>';
  }
  if ( $telegram_link ) {
    $additional_content .= 'You can also reach us on Telegram: <a href="' . esc_url( $telegram_link ) . '">Telegram</a>.<br>';
  }

  // Append the additional content to the existing thank you message
  $text .= '<div>' . $additional_content . '</div>';

  return $text;
}
