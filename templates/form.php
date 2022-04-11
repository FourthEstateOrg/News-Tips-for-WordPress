<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

?>

<form action="" id="news-tip-form">
    <div class="nt-form-group">
        <label for="message" class="nt-label"><?php _e( 'Message', 'fourth-estate-news-tip' ) ?></label>
        <textarea name="message" id="message" cols="30" rows="10" class="nt-textarea"></textarea>
    </div>

    <div class="nt-form-group">
        <label for="full_name" class="nt-label"><?php _e( 'Full Name', 'fourth-estate-news-tip' ) ?></label>
        <input type="text" name="full_name" id="full_name" class="nt-input" />
    </div>

    <div class="nt-form-group">
        <label for="email" class="nt-label"><?php _e( 'Email', 'fourth-estate-news-tip' ) ?></label>
        <input type="text" name="email" id="email" class="nt-input" />
    </div>

    <?php if ( $before_submit ): ?>
        <div class="nt-before-submit-container">
            <?php echo wpautop($before_submit); ?>
        </div>
    <?php endif; ?>

    <div class="nt-form-group">
        <button type="submit"><?php _e( 'Submit', 'fourth-estate-news-tip' ) ?></button>
    </div>
</form>