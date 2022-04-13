<?php

namespace News_Tip\Widgets;

use News_Tip\Template_Loader;

class Form
{
    /**
     * Plugin Loader Class 
     *
     * @var \Fourth_Estate_News_Tip_Loader
     */
    protected $loader;

    /**
     * Class constructor
     *
     * @param \Fourth_Estate_News_Tip_Loader $loader
     */
    public function __construct( $loader )
    {
        $this->loader = $loader;

        $this->define_hooks();
    }

    public function define_hooks()
    {
        $this->loader->add_shortcode( 'news-tip-form', $this, 'news_tip_form' );
        $this->loader->add_action( 'wp_ajax_send_news_tip', $this, 'send_news_tip' );
		$this->loader->add_action( 'wp_ajax_nopriv_send_news_tip', $this, 'send_news_tip' );
    }

    public function news_tip_form()
    {
        $options = get_option( 'fourth-estate-news-tip-settings' );

		add_action( 'wp_footer', function() use ( $options ) {
			echo Template_Loader::get_template( 'news-tip-modal.php', $options ); 
		} );

		return Template_Loader::get_template( 'trigger.php', $options ); 
    }

    public function send_news_tip()
	{		
		$full_name = sanitize_text_field( $_POST['full_name'] );
		$message = sanitize_textarea_field( $_POST['message'] );
		$name = isset( $full_name ) && $full_name != '' ? $full_name : 'Anonymous'; 
		$post = array(
			'post_type' => 'news-tips',
			'post_title' => esc_html( $name ),
			'post_content' => esc_html( $message ),
		);
		$post_id = wp_insert_post( $post );

        if ( isset( $_POST['email'] ) ) {
            update_post_meta( $post_id, 'email', sanitize_email( $_POST['email'] ) );
        }
        if ( isset( $_POST['contact_number'] ) ) {
            update_post_meta( $post_id, 'contact_number', sanitize_text_field( $_POST['contact_number'] ) );
        }
	}
}