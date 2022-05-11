<?php
/**
 * Plugin Name: Kebbet plugins - Custom Post Type: Easter egg
 * Plugin URI:  https://github.com/kebbet/kebbet-cpt-easteregg
 * Description: Registers a Custom Post Type.
 * Version:     1.2.0
 * Author:      Erik Betshammar
 * Author URI:  https://verkan.se
 * Update URI:  false
 *
 * @package kebbet-cpt-easteregg
 * @author Erik Betshammar
*/

namespace cpt\kebbet\easteregg;

const POSTTYPE    = 'easter-egg';
const SLUG        = 'egg';
const ICON        = 'carrot';
const MENUPOS     = 28;
const THUMBNAIL   = false;
const ARCHIVE_OPT = true;

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
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ .'\enqueue_scripts' );
}
add_action( 'init', __NAMESPACE__ . '\init', 0 );

/**
 * Flush rewrite rules on registration.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
function activation_hook() {
	register();
	\flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activation_hook' );

/**
 * Deactivation hook.
 */
function deactivation_hook() {
    \unregister_post_type( POSTTYPE );
    \flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . 'deactivation_hook' );

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'kebbet-cpt-easteregg', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register Custom Post Type
 */
function register() {
	$labels_args       = array(
		'name'                     => _x( 'Easter eggs', 'Post Type General Name', 'kebbet-cpt-easteregg' ),
		'singular_name'            => _x( 'Egg', 'Post Type Singular Name', 'kebbet-cpt-easteregg' ),
		'menu_name'                => __( 'Eggs', 'kebbet-cpt-easteregg' ),
		'name_admin_bar'           => __( 'Egg', 'kebbet-cpt-easteregg' ),
		'all_items'                => __( 'All eggs', 'kebbet-cpt-easteregg' ),
		'add_new_item'             => __( 'New egg', 'kebbet-cpt-easteregg' ),
		'add_new'                  => __( 'Add new egg', 'kebbet-cpt-easteregg' ),
		'new_item'                 => __( 'New egg', 'kebbet-cpt-easteregg' ),
		'edit_item'                => __( 'Edit egg', 'kebbet-cpt-easteregg' ),
		'update_item'              => __( 'Update egg', 'kebbet-cpt-easteregg' ),
		'view_item'                => __( 'View egg', 'kebbet-cpt-easteregg' ),
		'view_items'               => __( 'View eggs', 'kebbet-cpt-easteregg' ),
		'search_items'             => __( 'Search eggs', 'kebbet-cpt-easteregg' ),
		'not_found'                => __( 'Not found', 'kebbet-cpt-easteregg' ),
		'not_found_in_trash'       => __( 'No eggs found in Trash', 'kebbet-cpt-easteregg' ),
		'featured_image'           => __( 'Egg image', 'kebbet-cpt-easteregg' ),
		'set_featured_image'       => __( 'Set egg image', 'kebbet-cpt-easteregg' ),
		'remove_featured_image'    => __( 'Remove egg image', 'kebbet-cpt-easteregg' ),
		'use_featured_image'       => __( 'Use as egg image', 'kebbet-cpt-easteregg' ),
		'insert_into_item'         => __( 'Insert into item', 'kebbet-cpt-easteregg' ),
		'uploaded_to_this_item'    => __( 'Uploaded to this egg', 'kebbet-cpt-easteregg' ),
		'items_list'               => __( 'Items list', 'kebbet-cpt-easteregg' ),
		'items_list_navigation'    => __( 'Items list navigation', 'kebbet-cpt-easteregg' ),
		'filter_items_list'        => __( 'Filter items list', 'kebbet-cpt-easteregg' ),
		'item_published'           => __( 'Egg published', 'kebbet-cpt-easteregg' ),
		'item_published_privately' => __( 'Egg published privately', 'kebbet-cpt-easteregg' ),
		'item_reverted_to_draft'   => __( 'Egg reverted to Draft', 'kebbet-cpt-easteregg' ),
		'item_scheduled'           => __( 'Egg scheduled', 'kebbet-cpt-easteregg' ),
		'item_updated'             => __( 'Egg updated', 'kebbet-cpt-easteregg' ),
		// 5.7 + 5.8
		'filter_by_date'           => __( 'Filter eggs by date', 'kebbet-cpt-easteregg' ),
		'item_link'                => __( 'Eggs post link', 'kebbet-cpt-easteregg' ),
		'item_link_description'    => __( 'A link to a egg post', 'kebbet-cpt-easteregg' ),
	);

	$supports_args = array(
		'editor',
		'page-attributes',
	);

	if ( true === THUMBNAIL ) {
		$supports_args = array_merge( $supports_args, array( 'thumbnail' ) );
	}

	$capabilities_args = \cpt\kebbet\easteregg\roles\capabilities();
	$post_type_args    = array(
		'label'               => __( 'Egg post type', 'kebbet-cpt-easteregg' ),
		'description'         => __( 'Custom post type for easter eggs', 'kebbet-cpt-easteregg' ),
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
 * Enqueue plugin scripts and styles.
 *
 * @since 1.2.0
 *
 * @param string $page The page/file name.
 * @return void
 */
function enqueue_scripts( $page ) {
	$assets_pages = array(
		'index.php',
	);
	if ( in_array( $page, $assets_pages, true ) ) {
		wp_enqueue_style( POSTTYPE . '_scripts', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', array(), '1.2.0' );
	}
}

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
 * Adjust roles and capabilities for post type
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/roles.php';

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
 * @since 1.2.0
 *
 * @return string
 */
function menu_icon() {
	$icon_base64 = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjEuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxhZ2VyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHBhdGggZD0iTTIuNiwxMy45YzAuMSwxLDAuNSwxLjksMSwyLjdjMS42LTEuNiwxLjQtMS40LDMsMC4xQzguMywxNSw4LDE1LDkuNywxNi43YzEuNy0xLjcsMS41LTEuNywzLjEsMGMxLjYtMS42LDEuNC0xLjcsMy0wLjEKCWMwLjUtMC44LDAuOC0xLjcsMS0yLjdIMi42eiBNMi43LDEwLjdjLTAuMSwwLjUtMC4xLDEuMS0wLjEsMS42aDE0LjNjMC0wLjYsMC0xLjEtMC4xLTEuNkgyLjd6IE0xNC40LDE3LjNjLTEuNywxLjctMS40LDEuNy0zLjEsMAoJYy0xLjcsMS43LTEuNCwxLjctMy4xLDBDNi41LDE5LDYuNywxOSw1LDE3LjNsLTAuNSwwLjVjMi44LDIuOSw3LjYsMi45LDEwLjMsMEwxNC40LDE3LjNMMTQuNCwxNy4zeiBNNSw1LjhjMS43LTEuNywxLjQtMS43LDMuMSwwCgljMS43LTEuNywxLjUtMS43LDMuMSwwYzEuNy0xLjcsMS41LTEuNywzLjEsMGwwLjktMC45QzEyLjUtMS42LDctMS42LDQuMSw0LjlMNSw1Ljh6IE0xMi45LDEuN2MwLjMsMCwwLjUsMC4yLDAuNSwwLjUKCWMwLDAuMy0wLjIsMC41LTAuNSwwLjVjLTAuMywwLTAuNS0wLjMtMC41LTAuNUMxMi4zLDEuOSwxMi42LDEuNywxMi45LDEuN3ogTTkuNywxLjdjMC4zLDAsMC41LDAuMiwwLjUsMC41YzAsMC4zLTAuMiwwLjUtMC41LDAuNQoJYy0wLjMsMC0wLjUtMC4zLTAuNS0wLjVDOS4yLDEuOSw5LjQsMS43LDkuNywxLjd6IE02LjYsMS43YzAuMywwLDAuNSwwLjIsMC41LDAuNWMwLDAuMy0wLjMsMC41LTAuNSwwLjVjLTAuMywwLTAuNS0wLjMtMC41LTAuNQoJQzYuMSwxLjksNi4zLDEuNyw2LjYsMS43eiBNMTYuNiw5LjJjLTAuMi0xLTAuNC0xLjktMC43LTIuOGMtMS43LDEuNy0xLjQsMS42LTMuMS0wLjFjLTEuNywxLjctMS40LDEuNy0zLjEsMAoJQzgsOC4xLDguMyw4LjEsNi42LDYuNEM0LjksOCw1LjIsOC4xLDMuNSw2LjRDMy4yLDcuMywzLDguMywyLjksOS4ySDE2LjZMMTYuNiw5LjJ6Ii8+Cjwvc3ZnPgo=';

	$icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

	return $icon_data_uri;
}
