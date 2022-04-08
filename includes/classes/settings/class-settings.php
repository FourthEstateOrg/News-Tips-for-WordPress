<?php

namespace News_Tip\Settings;

/**
 * News_Tip\Settings\Settings
 * This class is responsible for registering the settings and takes care of the saving part
 * 
 * @since 1.0.1
 */
class Settings
{
    /**
     * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
     * @param string $option_name   The name of the setting
     */
    public function __construct( $option_name )
    {
        register_setting(
			$option_name,
			$option_name,
			array( $this, 'save_settings' )
		);
    }

    /**
	 * Saving our settings.
     * 
     * @since    1.0.1
     * @param array $input
	 */
	public function save_settings( $input ) {

		$new_input = array();
		$wysiwyg_fields = array(
			'before_content',
			'before_submit',
		);

		if ( isset( $input ) ) {
			// Loop trough each input and sanitize the value if the input id isn't instructions
			foreach ( $input as $key => $value ) {
				if ( in_array( $key, $wysiwyg_fields ) ) {
					$new_input[ $key ] = $value;
				} else {
					$new_input[ $key ] = sanitize_text_field( $value );
				}
			}
		}

		return $new_input;

	}
}