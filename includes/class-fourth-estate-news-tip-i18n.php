<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.fourthestate.org/
 * @since      1.0.0
 *
 * @package    Fourth_Estate_News_Tip
 * @subpackage Fourth_Estate_News_Tip/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Fourth_Estate_News_Tip
 * @subpackage Fourth_Estate_News_Tip/includes
 * @author     Fourth Estate <info@fourthestate.org>
 */
class Fourth_Estate_News_Tip_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fourth-estate-news-tip',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
