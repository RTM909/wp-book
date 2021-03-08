<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rahulmehta.dev/
 * @since             1.0.0
 * @package           Wp_Book
 *
 * @wordpress-plugin
 * Plugin Name:       WP Book
 * Plugin URI:
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Rahul Mehta
 * Author URI:        https://rahulmehta.dev/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-book
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_BOOK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-book-activator.php
 */
function activate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-book-activator.php';
	Wp_Book_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-book-deactivator.php
 */
function deactivate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-book-deactivator.php';
	Wp_Book_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_book' );
register_deactivation_hook( __FILE__, 'deactivate_wp_book' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-book.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_book() {

	$plugin = new Wp_Book();
	$plugin->run();

}
run_wp_book();

// Creates and registers custom post type 'Book'
function wpb_create_post_type() {
    register_post_type(
        'Book',
        array(
            'labels' => array(
                'name'          => __( 'Book' ),
                'singular_name' => __( 'Book' )
            ),
            'public'        => true,
            'has_archive'   => false,
            'rewrite'       => array('slug' => 'book'),
        )
    );
}
add_action('init', 'wpb_create_post_type');

// Create custom hierarchical taxonomy called 'Book category'
function wpb_create_bookcategory_taxonomy() {
    $labels = array(
        'name'              => _x( 'Book categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Book category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search book categories' ),
        'all_items'         => __( 'All book categories' ),
        'parent_item'       => __( 'Parent book category' ),
        'parent_item_colon' => __( 'Parent book category:' ),
        'edit_item'         => __( 'Edit book category' ),
        'update_item'       => __( 'Update book category' ),
        'add_new_item'      => __( 'Add new book category' ),
        'new_item_name'     => __( 'New book category name' ),
        'menu_name'         => __( 'Book Category' ),
    );

    // Register taxonomy
    $args = array(
        'labels'                => $labels,
        'description'           => __( 'types of books' ),
        'hierarchical'          => true,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => true,
        'show_in_quick_edit'    => true,
        'show_admin_column'     => true,
        'show_in_rest'          => false,
    );
    register_taxonomy( 'bookcategory', array('book'), $args );
}
add_action('init', 'wpb_create_bookcategory_taxonomy');

// Create custom non-hierarchical taxonomy called 'Book Tag'
function wpb_create_booktag_taxonomy() {
    $labels = array(
        'name'              => _x( 'Book tags', 'taxonomy general name' ),
        'singular_name'     => _x( 'Book tag', 'taxonomy singular name' ),
        'search_items'      => __( 'Search book tags' ),
        'all_items'         => __( 'All book tags' ),
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => __( 'Edit book tag' ),
        'update_item'       => __( 'Update book tag' ),
        'add_new_item'      => __( 'Add new book tag' ),
        'new_item_name'     => __( 'New book tag name' ),
        'menu_name'         => __( 'Book Tag' ),
    );

    $args = array(
        'labels'                => $labels,
        'description'           => __( 'book tags' ),
        'hierarchical'          => false,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => true,
        'show_in_quick_edit'    => true,
        'show_admin_column'     => true,
        'show_in_rest'          => false,
    );
    register_taxonomy( 'booktag', array('book'), $args );
}
add_action('init', 'wpb_create_booktag_taxonomy');

// Create a custom meta box to save book meta information like Author Name, Price, Publisher, Year, Edition, URL, etc.
function wpb_book_meta_box() {
    add_meta_box( 'author-book-info', __('Author/Book info'), 'wpb_display_meta_box', 'book', 'side', 'high', null );
}
add_action('add_meta_boxes', 'wpb_book_meta_box');

function wpb_display_meta_box( $post ) {
    include plugin_dir_path( __FILE__ ) . 'wpb_include/wpb-form.php';
}

// function to save meta data
function wpb_save_book_meta_data( $post_id ) {
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }

    $GLOBALS['post_id'] = $post_id;

    if(isset( $_POST['wpb_author'] ))
    {
        $author_name = $_POST['wpb_author'];
        $price = $_POST['wpb_price'];
        $publisher = $_POST['wpb_publisher'];
        $year = $_POST['wpb_date'];
        $edition = $_POST['wpb_edition'];
        $url = $_POST['wpb_url'];

        global $wpdb;
        $args = array(
            'author_name' => $author_name,
            'post_id' => $post_id,
            'price' => $price,
            'publisher' => $publisher,
            'year' => $year,
            'edition' => $edition,
            'url' => $url);

        $count = $wpdb->get_var("SELECT COUNT(*) FROM wpb_book_meta WHERE post_id = '$post_id'");
        if ($count == 1) {
            $wpdb->update('wpb_book_meta', $args, array('post_id' => $post_id));
        } else {
            $wpdb->insert('wpb_book_meta', $args);
        }
    }
}
add_action( 'save_post', 'wpb_save_book_meta_data');

// Create custom meta table and save all book meta information in that table (See how to extend Metadata API).
function wpb_create_custom_meta_table() {
    $table_name = 'wpb_book_meta';
    require_once ( ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta(
            "CREATE TABLE $table_name (
          ID bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
          post_id int(10) NOT NULL,
          author_name varchar(60) NOT NULL DEFAULT '',
          price decimal(6,2) NOT NULL DEFAULT 0000.00,
          publisher varchar(100) NOT NULL DEFAULT '',
          year varchar(20) NOT NULL,
          edition varchar(5) NOT NULL,
          url varchar(64) DEFAULT '' NOT NULL
        ) CHARACTER SET utf8 COLLATE utf8_general_ci;"
    );
}
add_action( 'init', 'wpb_create_custom_meta_table' );
