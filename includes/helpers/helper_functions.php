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