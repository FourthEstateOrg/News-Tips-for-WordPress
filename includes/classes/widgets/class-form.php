<?php

namespace News_Tip\Widgets;

use News_Tip\Emails\Admin_Notification;
use News_Tip\Field_Validator;
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
        if ( ! wp_verify_nonce( $_POST['nonce'], 'news-tip' ) ) {
            die ( 'Busted!' );
        }

        $validator = new Field_Validator( array(
            "message" => array(
                "required" => true,
            ),
            "email" => array(
                "required" => true,
                "email"    => true,
            ),
        ) );
        $validator->validate( $_POST );

        if ( ! $validator->is_valid() ) {
            die( $validator->get_error_response() );
        }

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

        $tracking_id = wp_generate_password( 12, false, false );
        update_post_meta( $post_id, 'tracking_id', sanitize_text_field( $tracking_id ) );

        // removing white space
        $fileName = preg_replace('/\s+/', '-', $_FILES["file_upload"]["name"]);

        // removing special character but keep . character because . seprate to extantion of file
        $fileName = preg_replace('/[^A-Za-z0-9.\-]/', '', $fileName);

        // rename file using time
	    $fileName = time().'-'.$fileName;

        if ($upload = wp_upload_bits($fileName, null, file_get_contents($_FILES["file"]["tmp_name"])) ) {
            update_post_meta( $post_id, 'file_upload', sanitize_url( $upload['url'] ) );
        }
        
        $admin_notification = new Admin_Notification( get_post( $post_id ) );
        $admin_notification->send();

        do_action( 'news_tip_submission_saved' );

        die( json_encode( [
            "success" => 1,
            "tracking_id" => $tracking_id,
        ] ) );
	}
}