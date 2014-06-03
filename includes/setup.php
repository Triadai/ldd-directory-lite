<?php
/**
 * Setup all necessary functionality for the Directory
 *
 * This includes any necessary calls that exist prior to or in the `init` hook. Everything
 * that occurs after `init` can be found in actionfilters.php.
 *
 * @package   ldd_directory_lite
 * @author    LDD Web Design <info@lddwebdesign.com>
 * @license   GPL-2.0+
 * @link      http://lddwebdesign.com
 * @copyright 2014 LDD Consulting, Inc
 */

require_once( LDDLITE_PATH . '/includes/shortcode.php' );

add_image_size( 'directory-listing-featured', 200, 200 );
add_image_size( 'directory-listing', 300, 300 );
add_image_size( 'directory-listing-compact', 105, 300 );
add_image_size( 'directory-listing-search', 100, 100 );



/**
 * Registers our custom taxonomies and post types.
 *
 * @since 0.5.0
 * @todo (low priority) Can we use the internal rewrites effectively?
 */
function ldl_setup__register_custom() {

    register_taxonomy( LDDLITE_TAX_CAT, LDDLITE_POST_TYPE, array(
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false, // We are handling this internally until there's time to explore it fully.
    ));

    register_taxonomy( LDDLITE_TAX_TAG, LDDLITE_POST_TYPE, array(
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
    ));

    $labels =

    $args = array(
        'labels'        => array(
            'name'                  => 'Directory Listings',
            'singular_name'         => 'Directory Listing',
            'add_new'               => 'Add Listing',
            'add_new_item'          => 'Add New Listing',
            'edit_item'             => 'Edit Listing',
            'new_item'              => 'New Directory Listing',
            'view_item'             => 'View Directory Listing',
            'search_items'          => 'Search Directory Listings',
            'not_found'             => 'No directory listings found',
            'not_found_in_trash'    => 'No directory listings found in Trash',
            'parent_item_colon'     => 'Parent Directory Listing',
            'menu_name'             => 'Directory [lite]'
        ),

        'hierarchical'  => false,

        'supports'      => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions' ),
        'taxonomies'    => array( LDDLITE_TAX_CAT, LDDLITE_TAX_TAG ),
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_position' => '27.3',
        'menu_icon'     => '',

        'show_in_nav_menus'     => false,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false, // @todo (high priority) Should it be?
        'has_archive'           => true,
        'query_var'             => true,
        'can_export'            => true,
        'rewrite'               => true,
        'capability_type'       => 'post'
    );

    register_post_type( LDDLITE_POST_TYPE, $args );

}


function ldl_setup__register_scripts() {

    wp_register_script( 'lddlite-responsiveslides', LDDLITE_URL . '/public/js/responsiveslides.js', array( 'jquery' ), '1.54', true );
    wp_register_script( 'lddlite-search',           LDDLITE_URL . '/public/js/search.js', array( 'jquery' ), LDDLITE_VERSION, true );
    wp_register_script( 'lddlite-bootstrap',        LDDLITE_URL . '/public/js/bootstrap.min.js', array( 'jquery' ), '3.1.1', true );
    wp_register_script( 'lddlite-submit',           LDDLITE_URL . '/public/js/submit.js', array( 'jquery' ), LDDLITE_VERSION, true );
    wp_register_script( 'lddlite-happy',            LDDLITE_URL . '/public/js/happy.js', array( 'jquery' ), LDDLITE_VERSION, true );

    wp_register_style( 'lddlite',           LDDLITE_URL . '/public/css/style.css', false, LDDLITE_VERSION );
    wp_register_style( 'lddlite-bootstrap', LDDLITE_URL . '/public/css/bootstrap.css', false, LDDLITE_VERSION );
    // @Todo: roll this into "lddlite"
    wp_register_style( 'lddlite-bootflat',  LDDLITE_URL . '/public/css/bootflat.css', false, LDDLITE_VERSION );

    wp_register_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', false, '4.1.0' );

    // Admin
    wp_register_script( 'lddlite-admin', LDDLITE_URL . '/public/js/admin.js', array( 'jquery-ui-dialog' ), LDDLITE_VERSION, 1 );
    wp_register_style(  'lddlite-admin', LDDLITE_URL . '/public/css/admin.css', false, LDDLITE_VERSION );

}


add_action( 'init', 'ldl_setup__register_custom', 5 );
add_action( 'init', 'ldl_setup__register_scripts', 5 );


/**
 * Initialize all Ajax hooks
 */
require_once( LDDLITE_PATH . '/includes/ajax.php' );

add_action( 'wp_ajax_search_directory',        'ldl_ajax__search_directory' );
add_action( 'wp_ajax_nopriv_search_directory', 'ldl_ajax__search_directory' );

add_action( 'wp_ajax_contact_form',        'ldl_ajax__contact_form' );
add_action( 'wp_ajax_nopriv_contact_form', 'ldl_ajax__contact_form' );

add_action( 'wp_ajax_dropdown_change',        'ldl_ajax__dropdown_change' );
add_action( 'wp_ajax_nopriv_dropdown_change', 'ldl_ajax__dropdown_change' );

add_action( 'wp_ajax_lite_allow_tracking', 'ldl_store_tracking_response' );