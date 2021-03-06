<?php

use News_Tip\Admin\Fourth_Estate_News_Tip_Admin;
use News_Tip\News_Tip_Post_Type;
use News_Tip\Widgets\Form;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.fourthestate.org/
 * @since      1.0.0
 *
 * @package    Fourth_Estate_News_Tip
 * @subpackage Fourth_Estate_News_Tip/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Fourth_Estate_News_Tip
 * @subpackage Fourth_Estate_News_Tip/includes
 * @author     Fourth Estate <info@fourthestate.org>
 */
class Fourth_Estate_News_Tip {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Fourth_Estate_News_Tip_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'FOURTH_ESTATE_NEWS_TIP_VERSION' ) ) {
			$this->version = FOURTH_ESTATE_NEWS_TIP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'fourth-estate-news-tip';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Fourth_Estate_News_Tip_Loader. Orchestrates the hooks of the plugin.
	 * - Fourth_Estate_News_Tip_i18n. Defines internationalization functionality.
	 * - Fourth_Estate_News_Tip_Admin. Defines all hooks for the admin area.
	 * - Fourth_Estate_News_Tip_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once NEWS_TIP_PLUGIN_PATH . 'includes/helpers/helper_functions.php';

		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/class-news-tip-post-type.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/class-template-loader.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/class-field-validator.php';

		/**
		 * Email includes
		 */
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/emails/interface-email-notification.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/emails/class-admin-notification.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/class-fourth-estate-news-tip-loader.php';

		/**
		 * Loading plugin helper classes
		 */
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/class-section.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/class-settings.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/fields/interface-field-markup.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/fields/abstract-field.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/fields/class-text-field.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/fields/class-heading-field.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/fields/class-wysiwyg-field.php';
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/settings/fields/class-select-field.php';

		/**
		 * News Tip Form
		 */
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/classes/widgets/class-form.php';
		

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once NEWS_TIP_PLUGIN_PATH . 'includes/class-fourth-estate-news-tip-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once NEWS_TIP_PLUGIN_PATH . 'admin/class-fourth-estate-news-tip-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once NEWS_TIP_PLUGIN_PATH . 'public/class-fourth-estate-news-tip-public.php';

		$this->loader = new Fourth_Estate_News_Tip_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Fourth_Estate_News_Tip_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Fourth_Estate_News_Tip_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Fourth_Estate_News_Tip_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_settings_page' );

		// Hook our settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		
		// $this->loader->add_action( 'init', $plugin_admin, 'register_post_types' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		new News_Tip_Post_Type( $this->loader );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Fourth_Estate_News_Tip_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		/**
		 * Handles form shortcode and actions
		 */
		$form = new Form( $this->get_loader() );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Fourth_Estate_News_Tip_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
