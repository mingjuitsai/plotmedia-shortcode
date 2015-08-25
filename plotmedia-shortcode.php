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


add_action( 'init', 'add_plotmedia_shortcodes' );

// Declare shortcode function if NOT exist
if( !function_exists( 'add_plotmedia_shortcodes') ) {

	function add_plotmedia_shortcodes() {
		// add the shortcode 
		require 'inc/shortcodes.php';
	}
}
