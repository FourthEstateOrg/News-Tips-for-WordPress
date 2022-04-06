<?php

namespace News_Tip\Settings\Fields;

class WYSIWYG_Field extends Field
{
    public function __construct( string $name, string $label, array $args )
    {
        parent::__construct( $name, $label, $args );
    }

    public function markup() {
        $field_id = $this->args['label_for'];
		$field_default = $this->args['default'];

        $args = array(
			'textarea_name' => $this->setting_id . '[' . $field_id . ']',
			'media_buttons' => false,
			'teeny'         => false, 
			'tinymce'       => true,
			'wpautop'       => true,
		);

		$options = get_option( $this->setting_id );
		// var_dump( $options ); exit;
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = stripslashes( html_entity_decode( $options[ $field_id ] ) );

		}

		wp_editor( $option, $field_id, $args );
    }
}