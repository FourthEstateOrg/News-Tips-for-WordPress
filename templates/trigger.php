<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

if ( ! $label ) {
    $label = 'Open News Tip';
}
?>

<?php if ( $display_as == 'link' ): ?>
    <a class="open-news-tip-modal"><?php echo esc_html__( $label, 'fourth-estate-news-tip' ) ?></a>
<?php else: ?>
    <button class="button open-news-tip-modal"><?php echo esc_html__( $label, 'fourth-estate-news-tip' ) ?></button>
<?php endif; ?>