<?php 
/**
 * Plugin Name: Woocommerce Remove Prices
 * Plugin URI: https://omarshishani.com/portfolio-3.0/woocommerce-remove-prices-plugin/
 * Description: Remove prices from your Woocommerce store, including the cart, checkout, and customer emails. 
 * License: GPLv3 
 * License URI: https://opensource.org/licenses/GPL-3.0
 * Version 1.1.0
 * Author: Omar Shishani 
 * Author URI: https://omarshishani.com
*/

/*
Woocommerce Remove Prices is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Woocommerce Remove Prices is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Woocommerce Remove Prices. If not, see https://opensource.org/licenses/GPL-3.0.
*/

/** 
 * Documentation for the below code to hook into locate_template filter: 
 * https://wisdmlabs.com/blog/override-woocommerce-templates-plugin/
*/

add_filter( 'woocommerce_locate_template', 'woo_adon_plugin_template', 1, 3 );

function woo_adon_plugin_template( $template, $template_name, $template_path ) {
  global $woocommerce;
  $_template = $template;
  if ( ! $template_path ) 
  $template_path = $woocommerce->template_url;

  $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/templates/woocommerce/';

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


add_filter( 'woocommerce_cart_needs_payment', 'dont_require_payment' );

function dont_require_payment($needs_payment){ //Hook into WC filter and set needs_payment boolean to false 
  /**
   * We don't want to require payment because all price and payment method fields are omitted via this plugin. 
   * If payment requirement is not removed, user cannot check out, and gets an error when trying to check out. 
  */
  $needs_payment = false; //Set the boolean to false, indicating that payment is not required
  return $needs_payment;
}