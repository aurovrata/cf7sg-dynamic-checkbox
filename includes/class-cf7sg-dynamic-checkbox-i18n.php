<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/aurovrata/
 * @since      1.0.0
 *
 * @package    Cf7sg_Dynamic_Checkbox
 * @subpackage Cf7sg_Dynamic_Checkbox/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cf7sg_Dynamic_Checkbox
 * @subpackage Cf7sg_Dynamic_Checkbox/includes
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7sg_Dynamic_Checkbox_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cf7sg-dynamic-checkbox',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
