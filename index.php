<?php
/**
 * Plugin Name: Social (Brothers) Band plugin
 * Plugin URI: http://socialbrothers.nl
 * Description: A custom full width Social bar
 * Version: 1.0
 * Author: Andrew Ho
 * Author URI: http://socialbrothers.nl
 * License: Social Brothers VOF
 */
 include( plugin_dir_path( __FILE__ ).'socialband.php');

add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue' );
function my_plugin_enqueue() {
	 wp_enqueue_style( 'footertransparant',plugins_url('/social_brothers_plugin/style.css'), '.css', NULL, NULL, 'all' );
}
