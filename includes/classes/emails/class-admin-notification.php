<?php

namespace News_Tip\Emails;

class Admin_Notification implements Email_Notification
{
    /**
     * The post object
     *
     * @var \WP_Post
     */
    protected $post;

    protected $options;

    /**
     * Undocumented function
     *
     * @param \WP_Post $post
     */
    public function __construct( $post )
    {
        $options = get_option( 'fourth-estate-news-tip-settings' );
        $this->post = $post;
        $this->options = $options;
    }

    public function send()
    {
        
        wp_mail( 
            $this->get_recipient(), 
            $this->get_subject(), 
            $this->get_message(), 
            $this->get_headers() 
        );
    }

    public function get_recipient()
    {
        if ( empty( $email = $this->options['email'] ) ) {
            return get_option( 'admin_email' );
        }

        return $email;
    }

    public function get_headers()
    {
        return array( 'Content-Type: text/html; charset=UTF-8' );
    }

    public function get_subject()
    {
        if ( empty( $subject = $this->options['email_subject'] ) ) {
            $subject = "News Tip from {name}";
        }
        return $this->replace_placeholders( $subject );
    }

    public function get_message()
    {
        if ( ! empty( $email_content = $this->options['email_content'] ) ) {
            return $this->replace_placeholders( $email_content );
        }

        ob_start();
        $email = get_post_meta( $this->post->ID, 'email', true );
        $contact_number = get_post_meta( $this->post->ID, 'contact_number', true );
        $file_upload = get_post_meta( $this->post->ID, 'file_upload', true );
        ?>
            <ul style="list-style: none;">
                <li><strong>From:</strong> <?php echo esc_html( $this->post->post_title ) ?></li>
                <li><strong>Email:</strong> <?php echo esc_html( $email ) ?></li>
                <li><strong>Contact Number:</strong> <?php echo esc_html( $contact_number ) ?></li>
                <li><strong>Message:</strong> <?php echo esc_html( $this->post->post_content ) ?></li>

                <?php if ( ! empty( $file_upload ) ): ?>
                <li>
                    <strong>Upload File:</strong>
                    <img src="<?php echo $file_upload ; ?>" />
                </li>
                <?php endif; ?>
            </ul>
        <?php
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function replace_placeholders( $content )
    {
        $email = get_post_meta( $this->post->ID, 'email', true );
        $contact_number = get_post_meta( $this->post->ID, 'contact_number', true );
        $tracking_id = get_post_meta( $this->post->ID, 'tracking_id', true );

        $content = str_replace( '{name}', esc_html( $this->post->post_title ), $content );
        $content = str_replace( '{email}', esc_html( $email ), $content );
        $content = str_replace( '{contact_number}', esc_html( $contact_number ), $content );
        $content = str_replace( '{tracking_id}', esc_html( $tracking_id ), $content );
        $content = str_replace( '{message}', esc_html( $this->post->post_content ), $content );
        return $content;
    }
}