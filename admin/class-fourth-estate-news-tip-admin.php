<?php

namespace News_Tip\Admin;

use News_Tip\Settings\Fields\Text_Field;
use News_Tip\Settings\Fields\Select_Field;
use News_Tip\Settings\Fields\WYSIWYG_Field;
use News_Tip\Settings\Section;
use News_Tip\Settings\Settings;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fourthestate.org/
 * @since      1.0.0
 *
 * @package    Fourth_Estate_News_Tip
 * @subpackage Fourth_Estate_News_Tip/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fourth_Estate_News_Tip
 * @subpackage Fourth_Estate_News_Tip/admin
 * @author     Fourth Estate <info@fourthestate.org>
 */
class Fourth_Estate_News_Tip_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {
		if ( 'settings_page_fourth-estate-news-tip' != $hook ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fourth-estate-news-tip-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Registers a new post type called news-tip 
	 *
	 * @since	1.0.1
	 * @return 	void
	 */
	public function register_post_types()
	{
		$labels = array(
			'name'                  => _x( 'News Tips', 'Post type general name', 'fourth-estate-news-tip' ),
			'singular_name'         => _x( 'News Tip', 'Post type singular name', 'fourth-estate-news-tip' ),
			'menu_name'             => _x( 'News Tips', 'Admin Menu text', 'fourth-estate-news-tip' ),
			'name_admin_bar'        => _x( 'News Tip', 'Add New on Toolbar', 'fourth-estate-news-tip' ),
			'add_new'               => __( 'Add New', 'fourth-estate-news-tip' ),
			'add_new_item'          => __( 'Add New Tip', 'fourth-estate-news-tip' ),
			'new_item'              => __( 'New Tip', 'fourth-estate-news-tip' ),
			'edit_item'             => __( 'Edit Tip', 'fourth-estate-news-tip' ),
			'view_item'             => __( 'View Tip', 'fourth-estate-news-tip' ),
			'all_items'             => __( 'All Tips', 'fourth-estate-news-tip' ),
			'search_items'          => __( 'Search Tips', 'fourth-estate-news-tip' ),
			'parent_item_colon'     => __( 'Parent Tips:', 'fourth-estate-news-tip' ),
			'not_found'             => __( 'No tips found.', 'fourth-estate-news-tip' ),
			'not_found_in_trash'    => __( 'No tips found in Trash.', 'fourth-estate-news-tip' ),
			'archives'              => __( 'Tips archives', 'fourth-estate-news-tip' ),
			'filter_items_list'     => __( 'Filter Tips', 'fourth-estate-news-tip' ),
		);
	 
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'menu_position'		 => 28,
			'menu_icon'			 => 'dashicons-buddicons-pm',
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'news-tips' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor' ),
		);
	 
		register_post_type( 'news-tips', $args );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fourth_Estate_News_Tip_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fourth_Estate_News_Tip_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fourth-estate-news-tip-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the settings page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_settings_page() {
		// Create our settings page as a submenu page.
		add_submenu_page(
			'edit.php?post_type=news-tips',                             // parent slug
			__( 'Settings', 'fourth-estate-news-tip' ),      // page title
			__( 'Settings', 'fourth-estate-news-tip' ),      // menu title
			'manage_options',                        // capability
			'fourth-estate-news-tip-settings',                           // menu_slug
			array( $this, 'display_settings_page' )  // callable function
		);
	}

	/**
	 * Display the settings page content for the page we have created.
	 *
	 * @since    1.0.0
	 */
	public function display_all_tips() {
		echo "all tips";
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/fourth-estate-news-tip-admin-display.php';

	}
	
	/**
	 * Display the settings page content for the page we have created.
	 *
	 * @since    1.0.0
	 */
	public function display_settings_page() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/fourth-estate-news-tip-admin-display.php';

	}

	/**
	 * Register the settings for our settings page.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

		$setting_id = $this->plugin_name . '-settings';

		// Here we are going to register our setting.
		$settings = new Settings( $setting_id );

		$general_section = new Section( $setting_id, $this->plugin_name . '-settings-section', 'General Settings' );
		$general_section->add(
			new Text_Field( 
				'email',
				'Email',
				array(
					'label_for' => 'email',
					'description' => __( '(Optional) The email who will receive notifications whenever a tip was sent. If empty, defaults to admin email.', 'fourth-estate-news-tip' )
				),
			)
		);
		$general_section->render();

		$buttonSection = new Section( $setting_id, $this->plugin_name . '-settings-section-button', 'Button' );
		$buttonSection->add(
			new Text_Field( 
				'label',
				'Label',
				array(
					'label_for' => 'label',
					'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
				),
			)
		);
		$buttonSection->render();

		$formSection = new Section( $setting_id, $this->plugin_name . '-settings-section-form', 'Form' );
		$formSection->add(
			new WYSIWYG_Field( 
				'before_content',
				'Before Content',
				array(
					'label_for' => 'before_content',
					'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
				),
			)
		);
		$formSection->add(
			new WYSIWYG_Field( 
				'before_submit',
				'Before Submit',
				array(
					'label_for' => 'before_submit',
					'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
				),
			)
		);
		$formSection->render();

	}

	/**
	 * Sandbox our section for the settings.
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_section() {

		return;

	}

	/**
	 * Sandbox our single checkboxes.
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_single_checkbox( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = 0;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>

			<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>">
				<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" <?php checked( $option, true, 1 ); ?> value="1" />
				<span class="description"><?php echo esc_html( $field_description ); ?></span>
			</label>

		<?php

	}

	/**
	 * Sandbox our multiple checkboxes
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_multiple_checkbox( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = array();

		if ( ! empty( $options[ $field_id ] ) ) {
			$option = $options[ $field_id ];
		}

		if ( $field_id == 'post-types' ) {

			$args = array(
				'public' => true
			);
			$post_types = get_post_types( $args, 'objects' );

			foreach ( $post_types as $post_type ) {

				if ( $post_type->name != 'attachment' ) {

					if ( in_array( $post_type->name, $option ) ) {
						$checked = 'checked="checked"';
					} else {
						$checked = '';
					}

					?>

						<fieldset>
							<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>">
								<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>" value="<?php echo esc_attr( $post_type->name ); ?>" <?php echo $checked; ?> />
								<span class="description"><?php echo esc_html( $post_type->label ); ?></span>
							</label>
						</fieldset>

					<?php

				}

			}

		} else {

			$field_args = $args['options'];

			foreach ( $field_args as $field_arg_key => $field_arg_value ) {

				if ( in_array( $field_arg_key, $option ) ) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}

				?>

					<fieldset>
						<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>">
							<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>" value="<?php echo esc_attr( $field_arg_key ); ?>" <?php echo $checked; ?> />
							<span class="description"><?php echo esc_html( $field_arg_value ); ?></span>
						</label>
					</fieldset>

				<?php

			}

		}

		?>

			<p class="description"><?php echo esc_html( $field_description ); ?></p>

		<?php

	}
}
