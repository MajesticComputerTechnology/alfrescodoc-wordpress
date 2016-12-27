<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://majestic.com.au
 * @since      1.0.0
 *
 * @package    Alfrescodocument
 * @subpackage Alfrescodocument/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Alfrescodocument
 * @subpackage Alfrescodocument/includes
 * @author     ShibeLord HODL <nath@majestic.com.au>
 */
class Alfrescodocument_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'alfrescodocument',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
