<?php

namespace News_Tip\Settings\Fields;

abstract class Field implements FieldMarkup
{
    protected $args;
    protected $name;
    protected $label;
    protected $setting_id;
    protected $section_id;

    public function __construct( string $name, string $label, array $args )
    {
        $this->name = $name;
        $this->label = $label;
        $this->args = $args;
    }

    /**
     * Assing field to appropriate section and setting
     *
     * @param string $setting_id    The registered setting id on a specific setting object.
     * @param string $section_id    The registered section id on a specific section object.
     * @return Field
     */
    public function assign( $setting_id, $section_id )
    {
        $this->setting_id = $setting_id;
        $this->section_id = $section_id;
        return $this;
    }

    public function render()
    {
        add_settings_field(
            $this->name,
            __( $this->label, 'fourth-estate-news-tip' ),
            array( $this, 'markup' ),
            $this->setting_id,
            $this->section_id,
            $this->args,
        );
    }
}