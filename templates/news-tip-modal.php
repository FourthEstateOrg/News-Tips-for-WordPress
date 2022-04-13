<?php

use News_Tip\Template_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Don't allow direct access

?>

<div class="news-tip-modal" style="display: none;">
    <div class="news-tip-modal-content">
        <a class="news-tip-close">✕</a>
        
        <h2><?php echo _e( 'Report Information', 'fourth-estate-news-tip' ) ?></h2>

        <ul class="news-tip-tabs">
            <li class="tab-menu active"><a data-target="#instructions"><?php echo _e( 'Instructions', 'fourth-estate-news-tip' ) ?></a></li>
            <li class="tab-menu"><a data-target="#online-form"><?php echo _e( 'Online Form', 'fourth-estate-news-tip' ) ?></a></li>
        </ul>

        <div class="tab-content active" id="instructions">
            <?php 
                $instructions_page_object = get_post($instruction_page); 
                echo do_shortcode( $instructions_page_object->post_content );
            ?>
        </div>

        <div class="tab-content" id="online-form">
            <div class="online-form-container">
                <?php if ( $before_content ): ?>
                    <div class="nt-before-content-container">
                        <?php echo wpautop($before_content); ?>
                    </div>
                <?php endif; ?>

                <?php echo Template_Loader::get_template('form.php', array( 'before_submit' => $before_submit )); ?>
            </div>
        </div>
        
    </div>
</div>