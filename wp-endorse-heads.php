<?php
/*
 * Plugin Name: WP Endorse Heads
 * Description: Creates Endorsement Custom Post Type and Displays them on Website via "Endorse Heads"
 * Author: Jonathan Rivera
 * Version: 0.1
 */
 
 class WP_Endorse_Heads {

	/**
	 * @var WP_Endorse_Heads The one true WP_Endorse_Heads
	 * @since 1.0
	 */
	private static $instance;

	/**
	 *  Plugin path
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $path;

	/**
	 *  Plugin url
	 *
	 * @var string
	 * @since 1.0
	 */
	public static $url;


	/**
	 * Main WP_Endorse_Heads Instance
	 *
	 * Insures that only one instance of WP_Endorse_Heads exists in memory at any one
	 * time.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @return The one true WP_HTTP_API_Tester
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Endorse_Heads ) ) {

			self::$instance = new WP_Endorse_Heads;

//			if ( ! is_admin() ) {
	//			return;
		//	}

			self::$instance->setup_vars();
			self::$instance->cpt_create();
			self::$instance->endorse_metaboxes();
			self::$instance->includes();

		//	add_action( 'wp_ajax_http_api_test', array( self::$instance, 'process_request' ) );



		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function setup_vars() {

		self::$path = plugin_dir_path( __FILE__ );
		self::$url  = plugin_dir_url( __FILE__ );

	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {
		
		require_once self::$path . 'includes/metaboxes.php';
	//	require_once self::$path . 'frontend/class-yardi-api.php';

	}

	/**
	 * Create The Custom Post Type
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */

	private function cpt_create() {

   $labels = array(
        'name' => _x( 'Endorsements', 'my_custom_post','custom' ),
        'singular_name' => _x( 'Endorsement', 'my_custom_post', 'custom' ),
        'add_new' => _x( 'Add New Endorsement', 'my_custom_post', 'custom' ),
        'add_new_item' => _x( 'Add New Endorsement', 'my_custom_post', 'custom' ),
        'edit_item' => _x( 'Edit Endorsement', 'my_custom_post', 'custom' ),
        'new_item' => _x( 'New Endorsement', 'my_custom_post', 'custom' ),
        'view_item' => _x( 'View Endorsement', 'my_custom_post', 'custom' ),
        'search_items' => _x( 'Search Endorsements', 'my_custom_post', 'custom' ),
        'not_found' => _x( 'No Endorsements found', 'my_custom_post', 'custom' ),
        'not_found_in_trash' => _x( 'No Endorsements found in Trash', 'my_custom_post', 'custom' ),
        'parent_item_colon' => _x( 'Parent Endorsement:', 'my_custom_post', 'custom' ),
        'menu_name' => _x( 'Endorsements', 'my_custom_post', 'custom' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Tennis For Judge Endorsers',
        'supports' => array( 'title', 'author', 'thumbnail', 'excerpt', 'custom-fields','revisions' ), 
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 2,
        'menu_icon' => get_stylesheet_directory_uri() . '/assets/img/endorse-icon.png',
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'public' => false,
        'has_archive' => false,
        'capability_type' => 'post'
    );  
    register_post_type( 'tennis_endorsement', $args );//max 20 charachter cannot contain capital letters and spaces

	}

	private function endorse_metaboxes( ) {

	}

	public static function is_url( $string ) {
		return filter_var( $string, FILTER_VALIDATE_URL ) !== false;
	}



}
add_action( 'plugins_loaded', array( 'WP_Endorse_Heads', 'instance' ) );