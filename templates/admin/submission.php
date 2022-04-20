<?php

/**
 * @var \WP_Post $post
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

$email = get_post_meta( $post->ID, 'email', true );
$contact_number = get_post_meta( $post->ID, 'contact_number', true );
$tracking_id = get_post_meta( $post->ID, 'tracking_id', true );
$file_upload = get_post_meta( $post->ID, 'file_upload', true );

?>

<div class="nt-submission-content">
    <div class="data-row">
        <strong>Tracking ID:</strong> <?php echo esc_html( $tracking_id ); ?>
    </div>
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
    <div class="data-row">
        <strong>Uploaded File:</strong><br />
        <a href="<?php echo $file_upload ; ?>" target="_blank">
            <img src="<?php echo $file_upload ; ?>" />
        </a>
    </div>
</div>