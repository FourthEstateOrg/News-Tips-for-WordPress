<?php

/**
 * Fetches the plugin options
 *
 * @param boolean|string $field
 * @return array|string|boolean
 */
function get_news_tip_settings( $field = false ) {
    $options = get_option( 'fourth-estate-news-tip-settings' );

    if ( ! $field ) {
        return $options;
    }  

    if ( ! empty( $options[ $field ] ) ) {
        return $options[ $field ];
    }

    return false;
}

function settings_section_panes( $page = 'fourth-estate-news-tip-settings' ) {
    global $wp_settings_sections, $wp_settings_fields;
    
    foreach ( (array) $wp_settings_sections[ $page ] as $section ) {

        echo '<div class="section-pane" id="pane-' . $section['id'] . '">';
    
        if ( $section['callback'] ) {
            call_user_func( $section['callback'], $section );
        }
    
        if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
            continue;
        }
        echo '<table class="form-table" role="presentation">';
        do_settings_fields( $page, $section['id'] );
        echo '</table>';

        echo '</div>';
    }
}
function settings_section_nav( $page = 'fourth-estate-news-tip-settings' ) {
    global $wp_settings_sections, $wp_settings_fields;

    echo '<ul>';

    foreach ( (array) $wp_settings_sections[ $page ] as $section ) {

        echo '<li><a class="setting-pane-trigger" data-target="#pane-' . $section['id'] . '">';
        echo $section['title'];
        echo '</a></li>';
    }

    echo '</ul>';
}