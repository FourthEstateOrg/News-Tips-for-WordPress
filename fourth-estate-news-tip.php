<?php

/**
 * @link              https://www.fourthestate.org/
 * @since             1.0.0
 * @package           Fourth_Estate_News_Tip
 *
 * @wordpress-plugin
 * Plugin Name:       News Tips
 * Plugin URI:        https://www.fourthestate.org/
 * Description:       A secure tool that allows news services to easily solicit, accept, and manage news tips on WordPress.
 * Version:           0.97
 * Author:            Fourth Estate
 * Author URI:        https://www.fourthestate.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       news-tips-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FOURTH_ESTATE_NEWS_TIP_VERSION', '0.97-3' );

define( 'NEWS_TIP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fourth-estate-news-tip-activator.php
 */
function activate_fourth_estate_news_tip() {
	require_once NEWS_TIP_PLUGIN_PATH . 'includes/class-fourth-estate-news-tip-activator.php';
	Fourth_Estate_News_Tip_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fourth-estate-news-tip-deactivator.php
 */
function deactivate_fourth_estate_news_tip() {
	require_once NEWS_TIP_PLUGIN_PATH . 'includes/class-fourth-estate-news-tip-deactivator.php';
	Fourth_Estate_News_Tip_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fourth_estate_news_tip' );
register_deactivation_hook( __FILE__, 'deactivate_fourth_estate_news_tip' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require NEWS_TIP_PLUGIN_PATH . 'includes/class-fourth-estate-news-tip.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fourth_estate_news_tip() {

	$plugin = new Fourth_Estate_News_Tip();
	$plugin->run();

}
run_fourth_estate_news_tip();
