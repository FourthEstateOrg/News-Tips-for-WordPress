<?php

namespace News_Tip\Settings;

use News_Tip\Settings\Fields\Field;
use News_Tip\Settings\Fields\FieldRenderer;

class Section
{
    /**
     * Array of Field objects
     *
     * @var Field[]
     */
    protected $fields = [];

    protected $setting_id;
    
    protected $section_id;

    /**
     * Registering sections to settings using add_settings_section()
     *
     * @param string $setting_id
     * @param string $section_id
     * @param string $label
     */
    public function __construct( string $setting_id, string $section_id, string $label)
    {
        $this->setting_id = $setting_id;
        $this->section_id = $section_id;

        add_settings_section(
			$this->section_id,
			__( $label, 'fourth-estate-news-tip' ),
			array( $this, 'section_callback' ),
			$this->setting_id,
		);
    }

    public function section_callback( $arg ) {
		return;
	}
    

    public function add( Field $field )
    {
        $this->fields[] = $field;
    }

    public function render()
    {
        foreach ( $this->fields as $field ) {
            $field->assign($this->setting_id, $this->section_id)->render();
        }
    }
}