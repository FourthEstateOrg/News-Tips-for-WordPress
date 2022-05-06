<?php

namespace News_Tip;

class News_Tip_Post_Type {

    /**
     * Plugin loader class
     *
     * @var \Fourth_Estate_News_Tip_Loader
     */
    protected $loader;

    /**
     * Class constructor
     *
     * @param \Fourth_Estate_News_Tip_Loader $loader
     * @return void
     */
    public function __construct( $loader )
    {
        $this->loader = $loader;

        $this->define_hooks();
    }

    public function define_hooks()
    {
        $this->loader->add_action( 'init', $this, 'register_post_types' );
		$this->loader->add_action( 'admin_init', $this, 'admin_init');
        $this->loader->add_filter( 'manage_news-tips_posts_columns', $this, 'add_columns' );
        $this->loader->add_filter( 'manage_news-tips_posts_custom_column', $this, 'modify_columns', 10, 2 );
    }

	public function admin_init()
	{
		global $typenow;

        if (empty($typenow)) {
            // try to pick it up from the query string
            if (!empty($_GET['post'])) {
                $post = get_post($_GET['post']);
                $typenow = $post->post_type;
            }
        }

        add_action('admin_print_footer_scripts', array($this, 'add_unread_counter_script'));

        if ($typenow == 'news-tips') {
            add_filter('display_post_states', '__return_false');
            add_action('edit_form_after_title', array($this, 'adminEditAfterTitle'), 100);
            add_filter('post_row_actions', array($this, 'adminPostRowActions'), 10, 2);
            add_filter('bulk_actions-edit-news-tips', array($this, 'adminBulkActionsEdit'));
            add_action('admin_print_footer_scripts', array($this, 'adminPrintFooterScripts'));

            add_action('in_admin_header', array($this, 'adminScreenLayout'));
            add_filter('views_edit-news-tips', array($this, 'adminViewsEdit'));

            if (is_admin()) {
                add_filter('gettext', array($this, 'adminGetText'), 10, 3);
            }

            wp_enqueue_script('jquery');
        }
	}

    /**
	 * Registers a new post type called news-tip
	 *
	 * @since	1.0.1
	 * @return 	void
	 */
	public function register_post_types()
	{
		$labels = array(
			'name'                  => _x( 'News Tips', 'Post type general name', 'fourth-estate-news-tip' ),
			'singular_name'         => _x( 'News Tip', 'Post type singular name', 'fourth-estate-news-tip' ),
			'menu_name'             => __( 'News Tips', 'Admin Menu text', 'fourth-estate-news-tip' ),
			'name_admin_bar'        => _x( 'News Tip', 'Add New on Toolbar', 'fourth-estate-news-tip' ),
			'add_new_item'          => __( 'Add New Tip', 'fourth-estate-news-tip' ),
			'new_item'              => __( 'New Tip', 'fourth-estate-news-tip' ),
			'edit_item'             => __( 'Edit Tip', 'fourth-estate-news-tip' ),
			'view_item'             => __( 'View Tip', 'fourth-estate-news-tip' ),
			'all_items'             => __( 'All Tips', 'fourth-estate-news-tip' ),
			'search_items'          => __( 'Search Tips', 'fourth-estate-news-tip' ),
			'parent_item_colon'     => __( 'Parent Tips:', 'fourth-estate-news-tip' ),
			'not_found'             => __( 'No tips found.', 'fourth-estate-news-tip' ),
			'not_found_in_trash'    => __( 'No tips found in Trash.', 'fourth-estate-news-tip' ),
			'archives'              => __( 'Tips archives', 'fourth-estate-news-tip' ),
			'filter_items_list'     => __( 'Filter Tips', 'fourth-estate-news-tip' ),
		);

		$args = array(
			'labels'              => $labels,
			'exclude_from_search' => true,
			'public'              => false,
			'publicly_queryable'  => false,
			'menu_position'		  => 28,
			'menu_icon'			  => 'dashicons-buddicons-pm',
			'show_ui'             => true,
			// 'show_in_menu'       => true,
			'show_in_admin_bar'  => false,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'nada' ),
			'can_export' => false,
		);

		register_post_type( 'news-tips', $args );

        register_post_status( 'unread', array(
            'label'                     => _x( 'Unread', 'post' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Unread <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
            'post_type'                 => array( 'news-tips' ),
        ) );

        register_post_status( 'read', array(
            'label'                     => _x( 'Read', 'post' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Read <span class="count">(%s)</span>', 'Read <span class="count">(%s)</span>' ),
            'post_type'                 => array( 'news-tips' ),
        ) );
	}

	public function add_columns( $columns )
	{
		$columns['title'] = 'Sender';
		unset( $columns['date'] );
		$columns['message'] = 'Message';
		$columns['email'] = 'Email';
		$columns['contact_number'] = 'Contact Number';
		$columns['date'] = 'Date';
    	return $columns;
	}

	public function modify_columns( $column_id, $post_id )
	{
		switch( $column_id ) {
			case 'email':
			case 'contact_number':
				echo get_post_meta( $post_id, $column_id, true );
				break;
			case 'message':
				echo get_the_excerpt( $post_id );
				break;
	   	}
	}

	/**
    * change some text on admin pages
    * @param string $translation
    * @param string $text
    * @param string $domain
    * @return string
    */
    public function adminGetText($translation, $text, $domain) {
        if ($domain == 'default') {
            if ($text == 'Edit &#8220;%s&#8221;') {
                $translation = 'View &#8220;%s&#8221;';
            }
        }

        return $translation;
    }

    /**
    * remove views we don't need from post list
    * @param array $views
    * @return array
    */
    public function adminViewsEdit($views) {
        $trash = $views['trash'];
        unset($views['publish']);
        unset($views['draft']);
        unset($views['trash']);

        return $views;
    }

    /**
    * remove unwanted actions from post list
    * @param array $actions
    * @param WP_Post $post
    * @return array
    */
    public function adminPostRowActions($actions, $post) {
        unset($actions['inline hide-if-no-js']);        // "quick edit"
        unset($actions['trash']);
        unset($actions['edit']);

        if ($post && $post->ID) {
            // add View link
            $actions['view'] = sprintf('<a href="%s" title="%s">%s</a>',
                get_edit_post_link($post->ID),
                __('View', 'fourth-estate-news-tip'), __('View', 'fourth-estate-news-tip'));

            // add Delete link
            $actions['delete'] = sprintf('<a href="%s" title="%s" class="submitdelete">%s</a>',
                get_delete_post_link($post->ID, '', true),
                __('Delete', 'fourth-estate-news-tip'), __('Delete', 'fourth-estate-news-tip'));
        }

        return $actions;
    }

    /**
    * change the list of available bulk actions
    * @param array $actions
    * @return array
    */
    public function adminBulkActionsEdit($actions) {
        unset($actions['edit']);

        return $actions;
    }

    /**
    * change the screen layout
    */
    public function adminScreenLayout() {
        // set max / default layout as single column
        add_screen_option('layout_columns', array('max' => 1, 'default' => 1));
    }

    /**
    * drop all the metaboxes and output what we want to show
    */
    public function adminEditAfterTitle( \WP_Post $post ) {
        global $wp_meta_boxes;

        // remove all meta boxes
        $wp_meta_boxes = array('log_emails_log' => array(
            'advanced' => array(),
            'side' => array(),
            'normal' => array(),
        ));

        $this->mark_as_read( $post->ID );

        // show my admin form
		echo Template_Loader::get_template( 'admin/submission.php', array( "post" => $post ) );
    }

    /**
    * replace Trash bulk actions with Delete
    * NB: WP admin already handles the delete action, it just doesn't expose it as a bulk action
    */
    public function adminPrintFooterScripts() {
        ?>

        <script>
        jQuery("select[name='action'],select[name='action2']").find("option[value='trash']").each(function() {
            this.value = 'delete';
            jQuery(this).text("<?php esc_attr_e('Delete', 'fourth-estate-news-tip'); ?>");
        });
        </script>

        <?php
    }

    public function add_unread_counter_script() {
        global $wpdb;

        $count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='news-tips' AND post_status='unread'" );
        if ( $count > 0 ) :
        ?>
            <script>
                jQuery('.menu-icon-news-tips').find('.wp-menu-name').append(' <span class="update-plugins"><?php echo $count ?></span>');
            </script>
        <?php
        endif;
    }

    public function mark_as_read( $post_id )
    {
        wp_update_post( array(
            "ID"    => $post_id,
            "post_status"   => "read",
        ) );
    }
}
