<?php

namespace News_Tip\Admin;

use News_Tip\Settings\Fields\Heading;
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
		if ( 'news-tips_page_fourth-estate-news-tip-settings' != $hook ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fourth-estate-news-tip-admin.css', array(), $this->version, 'all' );

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

		$page_select_values = array();

		/**
		 * @var \WP_Post[] $pages 
		 */
		$pages = get_pages();
		foreach ( $pages as $page ) {
			$page_select_values[ $page->ID ] = $page->post_title;
		}

		$general_section->add(
			new Select_Field( 
				'instruction_page',
				'Instruction Page',
				array(
					'label_for' => 'instruction_page',
					'description' => __( 'You can select which page you wish to include as the instruction content of the popup.', 'fourth-estate-news-tip' ),
					'values' => $page_select_values,
				),
			)
		);
		$general_section->render();

		$formSection = new Section( $setting_id, $this->plugin_name . '-settings-section-form', 'Form' );
		$formSection->add(
			new Text_Field( 
				'label',
				'Button Label',
				array(
					'label_for' => 'label',
					'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
				),
			)
		);
		$formSection->add(
			new Text_Field( 
				'label',
				'Button Label',
				array(
					'label_for' => 'label',
					'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
				),
			)
		);
		$formSection->add(
			new Select_Field( 
				'display_as',
				'Display trigger as',
				array(
					'label_for' => 'display_as',
					'description' => __( 'You can select which page you wish to include as the instruction content of the popup.', 'fourth-estate-news-tip' ),
					'default'	=> 'button',
					'values' => [
						"button" => "Button",
						"link"  => "Link",
					],
				),
			)
		);
		$formSection->add(
			new WYSIWYG_Field( 
				'before_content',
				'Before Content',
				array(
					'label_for' => 'before_content',
					'description' => __( 'The extra content you want to display before the form.', 'fourth-estate-news-tip' )
				),
			)
		);
		$formSection->add(
			new WYSIWYG_Field( 
				'before_submit',
				'Before Submit',
				array(
					'label_for' => 'before_submit',
					'description' => __( 'The extra content you want to display before the submit button.', 'fourth-estate-news-tip' )
				),
			)
		);
		$formSection->render();

		$email_section = new Section( $setting_id, $this->plugin_name . '-settings-section-email', 'Notification' );
		$email_section->add(
			new Text_Field( 
				'email',
				'Email',
				array(
					'label_for' => 'email',
					'description' => __( '(Optional) The email who will receive notifications whenever a tip was sent. If empty, defaults to admin email.', 'fourth-estate-news-tip' )
				),
			)
		);
		$email_section->add(
			new Text_Field( 
				'email_subject',
				'Email Subject',
				array(
					'label_for' => 'email_subject',
					'description' => __( 'You can use these place holders. {name}, {email}, {contact_number}, {tracking_id}, {message}', 'fourth-estate-news-tip' )
				),
			)
		);
		$email_section->add(
			new WYSIWYG_Field( 
				'email_content',
				'Email Content',
				array(
					'label_for' => 'email_content',
					'description' => __( 'You can use these place holders. {name}, {email}, {contact_number}, {tracking_id}, {message}', 'fourth-estate-news-tip' )
				),
			)
		);
		$email_section->render();

		$integration = new Section( $setting_id, $this->plugin_name . '-settings-section-integration', 'Integration' );
		$integration->add(
			new Heading( 
				'recaptcha-heading-1',
				'reCaptcha v2',
				array(
				),
			)
		);
		$integration->add(
			new Text_Field( 
				'site_key',
				'Site Key',
				array(
					'label_for' => 'site_key',
				),	
			)
		);
		$integration->add(
			new Text_Field( 
				'site_secret',
				'Site Secret',
				array(
					'label_for' => 'site_secret',
				),	
			)
		);

		$integration->add(
			new Heading( 
				'recaptcha-heading-2',
				'reCaptcha v3',
				array(
				),
			)
		);
		$integration->add(
			new Text_Field( 
				'site_key_v3',
				'Site Key',
				array(
					'label_for' => 'site_key_v3',
				),	
			)
		);
		$integration->add(
			new Text_Field( 
				'site_secret_v3',
				'Site Secret',
				array(
					'label_for' => 'site_secret_v3',
				),	
			)
		);
		$integration->render();

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
