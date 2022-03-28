<?php
/**
 * Plugin Name: Kebbet plugins - Custom Post Type: Easter egg
 * Plugin URI:  https://github.com/kebbet/kebbet-cpt-eastereegg
 * Description: Registers a Custom Post Type.
 * Version:     1.1.0
 * Author:      Erik Betshammar
 * Author URI:  https://verkan.se
 * Update URI:  false
 *
 * @package kebbet-cpt-easter-egg
 * @author Erik Betshammar
*/

namespace cpt\kebbet\easteregg;

const POSTTYPE    = 'easter-egg';
const SLUG        = 'egg';
const ICON        = 'carrot';
const MENUPOS     = 28;
const THUMBNAIL   = false;
const ARCHIVE_OPT = false;

/**
 * Link to ICONS
 *
 * @link https://developer.wordpress.org/resource/dashicons/
 */

/**
 * Hook into the 'init' action
 */
function init() {
	load_textdomain();
	register();
	if ( true === THUMBNAIL ) {
		add_theme_support( 'post-thumbnails' );
	}
	add_filter( 'wp_insert_post_data', __NAMESPACE__ .'\customization\set_post_title', 99, 2 );
}
add_action( 'init', __NAMESPACE__ . '\init', 0 );

/**
 * Flush rewrite rules on registration.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
function rewrite_flush() {
	// First, we "add" the custom post type via the above written function.
	// Note: "add" is written with quotes, as CPTs don't get added to the DB,
	// They are only referenced in the post_type column with a post entry,
	// when you add a post of this CPT.
	register();

	// ATTENTION: This is *only* done during plugin activation hook in this example!
	// You should *NEVER EVER* do this on every page load!!
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\rewrite_flush' );

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'kebbet-cpt-eastereegg', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register Custom Post Type
 */
function register() {
	$labels_args       = array(
		'name'                     => _x( 'Easter eggs', 'Post Type General Name', 'kebbet-cpt-eastereegg' ),
		'singular_name'            => _x( 'Egg', 'Post Type Singular Name', 'kebbet-cpt-eastereegg' ),
		'menu_name'                => __( 'Eggs', 'kebbet-cpt-eastereegg' ),
		'name_admin_bar'           => __( 'Egg', 'kebbet-cpt-eastereegg' ),
		'all_items'                => __( 'All eggs', 'kebbet-cpt-eastereegg' ),
		'add_new_item'             => __( 'New egg', 'kebbet-cpt-eastereegg' ),
		'add_new'                  => __( 'Add new egg', 'kebbet-cpt-eastereegg' ),
		'new_item'                 => __( 'New egg', 'kebbet-cpt-eastereegg' ),
		'edit_item'                => __( 'Edit egg', 'kebbet-cpt-eastereegg' ),
		'update_item'              => __( 'Update egg', 'kebbet-cpt-eastereegg' ),
		'view_item'                => __( 'View egg', 'kebbet-cpt-eastereegg' ),
		'view_items'               => __( 'View eggs', 'kebbet-cpt-eastereegg' ),
		'search_items'             => __( 'Search eggs', 'kebbet-cpt-eastereegg' ),
		'not_found'                => __( 'Not found', 'kebbet-cpt-eastereegg' ),
		'not_found_in_trash'       => __( 'No eggs found in Trash', 'kebbet-cpt-eastereegg' ),
		'featured_image'           => __( 'Egg image', 'kebbet-cpt-eastereegg' ),
		'set_featured_image'       => __( 'Set egg image', 'kebbet-cpt-eastereegg' ),
		'remove_featured_image'    => __( 'Remove egg image', 'kebbet-cpt-eastereegg' ),
		'use_featured_image'       => __( 'Use as egg image', 'kebbet-cpt-eastereegg' ),
		'insert_into_item'         => __( 'Insert into item', 'kebbet-cpt-eastereegg' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this egg', 'kebbet-cpt-eastereegg' ),
		'items_list'               => __( 'Items list', 'kebbet-cpt-eastereegg' ),
		'items_list_navigation'    => __( 'Items list navigation', 'kebbet-cpt-eastereegg' ),
		'filter_items_list'        => __( 'Filter items list', 'kebbet-cpt-eastereegg' ),
		'item_published'           => __( 'Egg published', 'kebbet-cpt-eastereegg' ),
		'item_published_privately' => __( 'Egg published privately', 'kebbet-cpt-eastereegg' ),
		'item_reverted_to_draft'   => __( 'Egg reverted to Draft', 'kebbet-cpt-eastereegg' ),
		'item_scheduled'           => __( 'Egg scheduled', 'kebbet-cpt-eastereegg' ),
		'item_updated'             => __( 'Egg updated', 'kebbet-cpt-eastereegg' ),
		// 5.7 + 5.8
		'filter_by_date'           => __( 'Filter eggs by date', 'kebbet-cpt-eastereegg' ),
		'item_link'                => __( 'Eggs post link', 'kebbet-cpt-eastereegg' ),
		'item_link_description'    => __( 'A link to a egg post', 'kebbet-cpt-eastereegg' ),
	);

	$supports_args = array(
		'editor',
		'page-attributes',
	);

	if ( true === THUMBNAIL ) {
		$supports_args = array_merge( $supports_args, array( 'thumbnail' ) );
	}

	$capabilities_args = array(
		'edit_post'          => 'edit_' . POSTTYPE,
		'edit_posts'         => 'edit_' . POSTTYPE .'s',
		'edit_others_posts'  => 'edit_others_' . POSTTYPE .'s',
		'publish_posts'      => 'publish_' . POSTTYPE .'s',
		'read_post'          => 'read_' . POSTTYPE .'s',
		'read_private_posts' => 'read_private_' . POSTTYPE .'s',
		'delete_post'        => 'delete_' . POSTTYPE,
	);
	$post_type_args    = array(
		'label'               => __( 'Egg post type', 'kebbet-cpt-eastereegg' ),
		'description'         => __( 'Custom post type for easter eggs', 'kebbet-cpt-eastereegg' ),
		'labels'              => $labels_args,
		'supports'            => $supports_args,
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => MENUPOS,
		'menu_icon'           => menu_icon(),
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => false,
		'capabilities'        => $capabilities_args,
		'template'            => array( array( 'core/quote', array( 'className' => 'is-egg' ) ) ),
		'template_lock'       => 'all',
		// Adding map_meta_cap will map the meta correctly.
		'show_in_rest'        => true,
		'map_meta_cap'        => true,
	);
	register_post_type( POSTTYPE, $post_type_args );
}

/**
 * Adds custom capabilities to CPT. Adjust it with plugin URE later with its UI.
 */
function add_custom_capabilities() {
	$roles = array(
		'admin'  => get_role( 'administrator' ),
		'editor' => get_role( 'editor' ),
	);

	foreach ( $roles as $role ) {
		$role->add_cap( 'edit_' . POSTTYPE );
		$role->add_cap( 'edit_' . POSTTYPE .'s' );
		$role->add_cap( 'edit_others_' . POSTTYPE .'s' );
		$role->add_cap( 'publish_' . POSTTYPE .'s' );
		$role->add_cap( 'read_' . POSTTYPE .'s' );
		$role->add_cap( 'read_private_' . POSTTYPE .'s' );
		$role->add_cap( 'delete_' . POSTTYPE );
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\add_custom_capabilities');

/**
 * Add the content to the `At a glance`-widget.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/at-a-glance.php';

/**
 * Adds and modifies the admin columns for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-columns.php';

/**
 * Adds admin messages for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-messages.php';

/**
 * Customizations to post type behavior.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/customization.php';


if ( true === ARCHIVE_OPT ) {
	/**
	 * Adds options page.
	 */
	require_once plugin_dir_path( __FILE__ ) . 'inc/options-page.php';
}

/**
 * Return the BASE64-icon for admin menu.
 *
 * @since 1.1.0
 *
 * @return string
 */
function menu_icon() {
	$icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjEuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxhZ2VyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHBhdGggZD0iTTIuNiwxMy45YzAuMSwxLDAuNSwxLjksMSwyLjdjMS42LTEuNiwxLjQtMS40LDMsMC4xQzguMywxNSw4LDE1LDkuNywxNi43YzEuNy0xLjcsMS41LTEuNywzLjEsMGMxLjYtMS42LDEuNC0xLjcsMy0wLjEKCWMwLjUtMC44LDAuOC0xLjcsMS0yLjdIMi42eiBNMi43LDEwLjdjLTAuMSwwLjUtMC4xLDEuMS0wLjEsMS42aDE0LjNjMC0wLjYsMC0xLjEtMC4xLTEuNkgyLjd6IE0xNC40LDE3LjNjLTEuNywxLjctMS40LDEuNy0zLjEsMAoJYy0xLjcsMS43LTEuNCwxLjctMy4xLDBDNi41LDE5LDYuNywxOSw1LDE3LjNsLTAuNSwwLjVjMi44LDIuOSw3LjYsMi45LDEwLjMsMEwxNC40LDE3LjNMMTQuNCwxNy4zeiBNNSw1LjhjMS43LTEuNywxLjQtMS43LDMuMSwwCgljMS43LTEuNywxLjUtMS43LDMuMSwwYzEuNy0xLjcsMS41LTEuNywzLjEsMGwwLjktMC45QzEyLjUtMS42LDctMS42LDQuMSw0LjlMNSw1Ljh6IE0xMi45LDEuN2MwLjMsMCwwLjUsMC4yLDAuNSwwLjUKCWMwLDAuMy0wLjIsMC41LTAuNSwwLjVjLTAuMywwLTAuNS0wLjMtMC41LTAuNUMxMi4zLDEuOSwxMi42LDEuNywxMi45LDEuN3ogTTkuNywxLjdjMC4zLDAsMC41LDAuMiwwLjUsMC41YzAsMC4zLTAuMiwwLjUtMC41LDAuNQoJYy0wLjMsMC0wLjUtMC4zLTAuNS0wLjVDOS4yLDEuOSw5LjQsMS43LDkuNywxLjd6IE02LjYsMS43YzAuMywwLDAuNSwwLjIsMC41LDAuNWMwLDAuMy0wLjMsMC41LTAuNSwwLjVjLTAuMywwLTAuNS0wLjMtMC41LTAuNQoJQzYuMSwxLjksNi4zLDEuNyw2LjYsMS43eiBNMTYuNiw5LjJjLTAuMi0xLTAuNC0xLjktMC43LTIuOGMtMS43LDEuNy0xLjQsMS42LTMuMS0wLjFjLTEuNywxLjctMS40LDEuNy0zLjEsMAoJQzgsOC4xLDguMyw4LjEsNi42LDYuNEM0LjksOCw1LjIsOC4xLDMuNSw2LjRDMy4yLDcuMywzLDguMywyLjksOS4ySDE2LjZMMTYuNiw5LjJ6Ii8+Cjwvc3ZnPgo=';

	return $icon;
}
