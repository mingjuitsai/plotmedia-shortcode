<?php
/**
 * Plugin Name: Plot Media Shortcode
 * Plugin URI: http://plot.net.au
 * Description: Collections of Shortcode Plot Media uses often.
 * Version: 1.0.0
 * Author: Plot Media
 * Author URI: http://plot.net.au
 * License: GPL2
 */


add_action( 'init', 'plotmedia_shortcode_init' );

// Declare shortcode function if NOT exist
if( !function_exists( 'plotmedia_shortcode_init') ) {

	function plotmedia_shortcode_init() {
		// add the shortcodes
		require 'inc/shortcodes.php';

		// add the filters 
		require 'inc/filters.php';
	}
}
