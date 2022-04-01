<?php

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
			'options-general.php',                             // parent slug
			__( 'News Tip', 'fourth-estate-news-tip' ),      // page title
			__( 'News Tip', 'fourth-estate-news-tip' ),      // menu title
			'manage_options',                        // capability
			'fourth-estate-news-tip',                           // menu_slug
			array( $this, 'display_settings_page' )  // callable function
		);
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

		// Here we are going to register our setting.
		register_setting(
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings',
			array( $this, 'sandbox_register_setting' )
		);

		// Here we are going to add a section for our setting.
		add_settings_section(
			$this->plugin_name . '-settings-section',
			__( 'General Settings', 'fourth-estate-news-tip' ),
			array( $this, 'sandbox_add_settings_section' ),
			$this->plugin_name . '-settings'
		);

		// Here we are going to add fields to our section.
		add_settings_field(
			'email',
			__( 'Email', 'fourth-estate-news-tip' ),
			array( $this, 'sandbox_add_settings_field_input_text' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'email',
				'description' => __( '(Optional) The email who will receive notifications whenever a tip was sent. If empty, defaults to admin email.', 'fourth-estate-news-tip' )
			)
		);

		// Here we are going to add a section for our setting.
		add_settings_section(
			$this->plugin_name . '-settings-section-button',
			__( 'Button', 'fourth-estate-news-tip' ),
			array( $this, 'sandbox_add_settings_section' ),
			$this->plugin_name . '-settings'
		);

		// Here we are going to add fields to our section.
		add_settings_field(
			'label',
			__( 'Label', 'fourth-estate-news-tip' ),
			array( $this, 'sandbox_add_settings_field_input_text' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section-button',
			array(
				'label_for' => 'label',
				'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
			)
		);

		// Here we are going to add a section for our setting.
		add_settings_section(
			$this->plugin_name . '-settings-section-form',
			__( 'Form', 'fourth-estate-news-tip' ),
			array( $this, 'sandbox_add_settings_section' ),
			$this->plugin_name . '-settings'
		);

		// Here we are going to add fields to our section.
		add_settings_field(
			'instructions',
			__( 'Instructions', 'fourth-estate-news-tip' ),
			array( $this, 'sandbox_add_settings_field_editor' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section-form',
			array(
				'label_for' => 'instructions',
				'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
			)

		);
		// Here we are going to add fields to our section.
		add_settings_field(
			'instructions_position',
			__( 'Instructions Position', 'fourth-estate-news-tip' ),
			array( $this, 'sandbox_add_settings_field_radio' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section-form',
			array(
				'label_for' => 'instructions_position',
				'values'	=> array(
					"top"		=> "Top",
					"bottom"	=> "Bottom",
				),
				'description' => __( 'Label of the button', 'fourth-estate-news-tip' )
			)
		);

	}

	/**
	 * Sandbox our settings.
	 *
	 * @since    1.0.0
	 */
	public function sandbox_register_setting( $input ) {

		$new_input = array();

		if ( isset( $input ) ) {
			// Loop trough each input and sanitize the value if the input id isn't post-types
			foreach ( $input as $key => $value ) {
				if ( $key == 'instructions' ) {
					$new_input[ $key ] = $value;
				} else {
					$new_input[ $key ] = sanitize_text_field( $value );
				}
			}
		}

		return $new_input;

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

	/**
	 * Sandbox our inputs with text
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_input_text( $args ) {

		$field_id = $args['label_for'];
		$field_default = $args['default'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>
		
			<input type="text" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="regular-text" />

		<?php

	}

	/**
	 * Sandbox our inputs with wysiwyg editor
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_editor( $args )
	{
		$field_id = $args['label_for'];
		$field_default = $args['default'];  
		$args = array(
			'textarea_name' => $this->plugin_name . '-settings[' . $field_id . ']',
			'media_buttons' => false,
			'teeny'         => false, 
			'tinymce'       => true,
			'wpautop'       => true,
		);

		$options = get_option( $this->plugin_name . '-settings' );
		// var_dump( $options ); exit;
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = stripslashes( html_entity_decode( $options[ $field_id ] ) );

		}

		wp_editor( $option, $field_id, $args );
	}
	/**
	 * Sandbox our inputs with radio buttons editor
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_radio( $args )
	{
		$values = $args['values'];
		$field_id = $args['label_for'];
		$field_default = $args['default'];  
		$options = get_option( $this->plugin_name . '-settings' );
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>
			<select name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>">
				<?php foreach ( $values as $key => $value ) : ?>
					<option value="<?php esc_attr_e( $key ) ?>" <?php echo $key === $option ? 'selected' : '' ?> ><?php esc_attr_e( $value ) ?></option>
				<?php endforeach; ?>
			</select>
		<?php
	}

}
