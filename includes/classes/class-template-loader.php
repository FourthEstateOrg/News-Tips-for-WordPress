<?php

namespace News_Tip;

class Template_Loader {
    public static function locate_template( $template_name, $template_path = '', $default_path = '' )
    {
        // Set variable to search in woocommerce-plugin-templates folder of theme.
        if ( ! $template_path ) :
            $template_path = 'news-tip/';
        endif;

        // Set default plugin templates path.
        if ( ! $default_path ) :
            $default_path = NEWS_TIP_PLUGIN_PATH . 'templates/'; // Path to the template folder
        endif;

        // Search template file in theme folder.
        $template = locate_template( array(
            $template_path . $template_name,
            $template_name
        ) );

        // Get plugins template file.
        if ( ! $template ) :
            $template = $default_path . $template_name;
        endif;

        return apply_filters( 'nt_locate_template', $template, $template_name, $template_path, $default_path );
    }

    public static function get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

        if ( is_array( $args ) && isset( $args ) ) :
            extract( $args );
        endif;
    
        $template_file = self::locate_template( $template_name, $tempate_path, $default_path );
    
        if ( ! file_exists( $template_file ) ) :
            _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
            return;
        endif;

        ob_start();
        include $template_file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}