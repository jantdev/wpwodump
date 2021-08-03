<?php

/**
 * Plugin Name: compo product
 * Plugin URI: https://jantdev.com/
 * Description: Adds product extra fields.
 * Version: 1.0.0
 * Author: Jantdev
 * Author URI: https://jantdev.com
 * Text Domain: jantdev
 * * @package compo-product
 */


if (!defined('ABSPATH')) exit;

if (!defined("COMPO_PRODUCT_PLUGIN_NAME")) {
  define("COMPO_PRODUCT_PLUGIN_NAME", trim(dirname(plugin_basename(__FILE__)), '/'));
}

if (!defined('COMPO_PRODUCT_PATH')) {
  define('COMPO_PRODUCT_PATH', plugin_dir_path(__DIR__) . "compo_product");
}

require_once COMPO_PRODUCT_PATH . '/includes/helpers/autoloader.php';


function init()
{

  \COMPO_PRODUCT\includes\compo_product_init::get_instance();
}
init();
