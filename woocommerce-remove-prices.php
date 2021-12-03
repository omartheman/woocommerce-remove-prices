<?php 
/**
 * Plugin Name: Woocommerce Remove Prices
 * Plugin URI: None 
 * Description: Remove all mention of pricing from your Woocommerce store, including the cart, checkout, and customer emails. 
 * Version 1.0
 * Author: Omar Shishani 
 * Author URI: https://omarshishani.com
 */

add_filter( 'woocommerce_locate_template', 'woo_adon_plugin_template', 1, 3 );
function woo_adon_plugin_template( $template, $template_name, $template_path ) {
  global $woocommerce;
  $_template = $template;
  if ( ! $template_path ) 
  $template_path = $woocommerce->template_url;

  $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/template/woocommerce/';

  // Look within passed path within the theme - this is priority
  $template = locate_template(
  array(
    $template_path . $template_name,
    $template_name
  )
  );

  if( ! $template && file_exists( $plugin_path . $template_name ) )
  $template = $plugin_path . $template_name;

  if ( ! $template )
  $template = $_template;

  return $template;
}


// public function needs_payment() {
//   return apply_filters( 'woocommerce_cart_needs_payment', 0 < $this->get_total( 'edit' ), $this );
// }

// function example_callback( $example ) {
//   // Maybe modify $example in some way.
//   return $example;
// }

add_filter( 'woocommerce_cart_needs_payment', 'dont_require_payment' );

function dont_require_payment($needs_payment){
  $needs_payment = false; //Set the boolean to false, indicating that payment is not required
  return $needs_payment;
}