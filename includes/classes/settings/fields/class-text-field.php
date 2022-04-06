<?php

namespace News_Tip\Settings\Fields;

class Text_Field extends Field
{
    public function __construct( string $name, string $label, array $args )
    {
        parent::__construct( $name, $label, $args );
    }

    public function markup() {
        $field_id = $this->args['label_for'];
		$field_default = $this->args['default'];

        // var_dump($this->setting_id); exit;

		$options = get_option( $this->setting_id );
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>
		
			<input type="text" name="<?php echo $this->setting_id . '[' . $field_id . ']'; ?>" id="<?php echo $this->setting_id . '[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="regular-text" />

		<?php
    }
}