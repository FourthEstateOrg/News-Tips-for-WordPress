<?php

/**
 * @var \WP_Post $post
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$email = get_post_meta( $post->ID, 'email', true );
$contact_number = get_post_meta( $post->ID, 'contact_number', true );

?>

<div class="nt-submission-content">
    <div class="data-row">
        <strong>From:</strong> <?php echo esc_html( $post->post_title ); ?>
    </div>
    <div class="data-row">
        <strong>Email:</strong> <?php echo esc_html( $email ); ?>
    </div>
    <div class="data-row">
        <strong>Contact Number:</strong> <?php echo esc_html( $contact_number ); ?>
    </div>
    <div class="data-row">
        <strong>Message:</strong><br /> <?php echo esc_html( $post->post_content ); ?>
    </div>
</div>