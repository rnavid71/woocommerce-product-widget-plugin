<?php
/**
 * Plugin Name: Ghost Woocommerce Widget
 * Description: provided a shortcode for custom widget, place this shortCode in a page: [ghost_woocommerce_widget]
 * Author: Navid Rezaei
 * Author URI: https://webnavid.com
 **/

use inc\Base;
use inc\GhostWoocommerce;

// register requirements
require_once plugin_dir_path(__FILE__).'inc/Base.php';
$base_controller = new Base();


// short code:
$ghost_woocommerce = new GhostWoocommerce();
add_shortcode('ghost_woocommerce_widget', array($ghost_woocommerce,'index'));