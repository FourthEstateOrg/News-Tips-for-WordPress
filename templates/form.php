<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

?>

<form action="?" id="news-tip-form">
    <div class="nt-form-group">
        <label for="message" class="nt-label"><?php _e( 'Message', 'fourth-estate-news-tip' ) ?></label>
        <textarea name="message" id="message" cols="30" rows="10" class="nt-field" placeholder="What would you like to tell us?"></textarea>
    </div>

    <div class="nt-form-group">
        <label for="email" class="nt-label"><?php _e( 'Email', 'fourth-estate-news-tip' ) ?></label>
        <input type="text" name="email" id="email" class="nt-field" placeholder="your@email.com" />
    </div>

    <div class="nt-form-group">
        <label for="full_name" class="nt-label"><?php _e( 'Full Name (Optional)', 'fourth-estate-news-tip' ) ?></label>
        <input type="text" name="full_name" id="full_name" class="nt-field" placeholder="Full Name" />
    </div>

    <div class="nt-form-group">
        <label for="contact_number" class="nt-label"><?php _e( 'Contact Number (Optional)', 'fourth-estate-news-tip' ) ?></label>
        <input type="text" name="contact_number" id="contact_number" class="nt-field" placeholder="+1912345678" />
    </div>

    <div class="nt-form-group">
        <label for="file_upload" class="nt-label"><?php _e( 'Upload File (Optional)', 'fourth-estate-news-tip' ) ?></label>
        <input type="file" name="file_upload" id="file_upload" class="nt-field" />
    </div>

    <?php if ( $before_submit ): ?>
        <div class="nt-before-submit-container">
            <?php echo wpautop($before_submit); ?>
        </div>
    <?php endif; ?>

    <?php do_action( 'before_news_tip_submit' ); ?>

    <input type="hidden" name="action" value="send_news_tip" />
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('news-tip') ?>" >

    <div class="nt-form-group">
        <button type="submit"><?php _e( 'Submit', 'fourth-estate-news-tip' ) ?></button>
    </div>
</form>

<?php do_action( 'after_news_tip_form' ); ?>