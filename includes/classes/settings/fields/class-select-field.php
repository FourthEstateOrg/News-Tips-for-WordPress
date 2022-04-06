<?php

namespace News_Tip\Settings\Fields;

class Select_Field extends Field
{
    public function __construct( string $name, string $label, array $args )
    {
        parent::__construct( $name, $label, $args );
    }

    public function markup() {
        $values = $this->args['values'];
		$field_id = $this->args['label_for'];
		$field_default = $this->args['default'];  
		$options = get_option( $this->setting_id );
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>
			<select name="<?php echo $this->setting_id . '[' . $field_id . ']'; ?>" id="<?php echo $this->setting_id . '[' . $field_id . ']'; ?>">
				<?php foreach ( $values as $key => $value ) : ?>
					<option value="<?php esc_attr_e( $key ) ?>" <?php echo $key === $option ? 'selected' : '' ?> ><?php esc_attr_e( $value ) ?></option>
				<?php endforeach; ?>
			</select>
		<?php
    }
}