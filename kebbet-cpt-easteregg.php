<?php
/**
 * Plugin Name: Kebbet plugins - Custom Post Type: Easter egg
 * Plugin URI:  https://github.com/kebbet/kebbet-cpt-eastereegg
 * Description: Registers a Custom Post Type.
 * Version:     1.0.0
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
	add_filter( 'wp_insert_post_data', __NAMESPACE__ .'\set_post_title', 99, 2 );
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
	$icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjEuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9ImVnZ19sYXllciIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiCgkgdmlld0JveD0iMCAwIDIwIDIwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAyMCAyMDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiNGRkZGRkY7fQo8L3N0eWxlPgo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOSw1LjFjMS4yLTAuNywyLjUtMS40LDMuOC0xLjhjMS41LTAuMywyLjgtMC4yLDQuMSwwLjNjMi4zLDAuOSwyLjYsNC4xLDIuNSw2LjJjLTAuMSwyLjMsMS40LDMuMy0wLjEsNS41CgljLTEuNCwyLjEtNC42LDEuOS02LjgsMC43Yy0xLjMtMC43LTIuNSwwLjktMy45LDAuNWMtMC45LTAuMS0yLjUtMS4zLTIuOS0xLjVjLTEuMS0wLjUtMy4xLTAuMy00LjEtMS4yYy0wLjctMC43LTEuMS0xLjYtMS4zLTIuNQoJYy0wLjUtMS44LTAuNS0zLjgsMS01LjFjMC42LTAuNSwxLjMtMC44LDIuMS0xQzUuMSw0LjksNyw2LjIsOSw1LjFMOSw1LjF6IE0zLjUsNi43YzAuNC0wLjEsMC43LDAuNSwwLjMsMC43CgljLTEuNSwwLjUtMS43LDEuNy0xLjksM0MxLjQsOC44LDEuNyw3LjQsMy41LDYuN0wzLjUsNi43eiBNMTIuNyw2LjdjMS45LDAsMy41LDEuMywzLjUsM3MtMS42LDMuMS0zLjUsMy4xcy0zLjUtMS40LTMuNS0zLjEKCUM5LjIsOC4xLDEwLjgsNi43LDEyLjcsNi43eiBNMTAuOCw4LjJjMC40LTAuMywwLjksMC4yLDAuNywwLjVjLTAuNywwLjctMC45LDEuNS0wLjUsMi43QzExLjIsMTEuOCw5LDEwLjEsMTAuOCw4LjJMMTAuOCw4LjJ6CgkgTTkuMiw1LjZjMi40LTEuNCw0LjUtMi42LDcuNS0xLjVDMTguOCw0LjksMTksOCwxOC44LDkuOWMtMC4xLDIsMS4yLDIuOCwwLjIsNC44Yy0wLjksMS44LTMuOSwyLjMtNi41LDAuN2MtMS0wLjYtMi41LDAuOS0zLjksMC41CgljLTEuNC0wLjQtMi4xLTEuMy0yLjctMS41Yy0yLjUtMC45LTQsMC4zLTQuOS0zLjJDMCw4LDEuNCw2LjMsMy41LDUuOUM1LjEsNS41LDcsNi45LDkuMiw1LjZMOS4yLDUuNnoiLz4KPC9zdmc+Cg==';

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
		'menu_icon'           => $icon,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => false,
		'capabilities'        => $capabilities_args,
		'template'            => array( array( 'core/quote' ) ),
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

	// Gets the editor and administrator roles.
	$admins = get_role( 'administrator' );
	$editor = get_role( 'editor' );

	// Add custom capabilities.
	$admins->add_cap( 'edit_' . POSTTYPE );
	$admins->add_cap( 'edit_' . POSTTYPE .'s' );
	$admins->add_cap( 'edit_others_' . POSTTYPE .'s' );
	$admins->add_cap( 'publish_' . POSTTYPE .'s' );
	$admins->add_cap( 'read_' . POSTTYPE .'s' );
	$admins->add_cap( 'read_private_' . POSTTYPE .'s' );
	$admins->add_cap( 'delete_' . POSTTYPE );

	$editor->add_cap( 'edit_' . POSTTYPE );
	$editor->add_cap( 'edit_' . POSTTYPE .'s' );
	$editor->add_cap( 'edit_others_' . POSTTYPE .'s' );
	$editor->add_cap( 'publish_' . POSTTYPE .'s' );
	$editor->add_cap( 'read_' . POSTTYPE .'s' );
	$editor->add_cap( 'read_private_' . POSTTYPE .'s' );
	$editor->add_cap( 'delete_' . POSTTYPE );
}
add_action( 'admin_init', __NAMESPACE__ . '\add_custom_capabilities');

/**
 * Post type update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function post_updated_messages( $messages ) {

	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages[ POSTTYPE ] = array(
		0  => '',
		1  => __( 'Egg updated.', 'kebbet-cpt-eastereegg' ),
		2  => __( 'Custom field updated.', 'kebbet-cpt-eastereegg' ),
		3  => __( 'Custom field deleted.', 'kebbet-cpt-eastereegg' ),
		4  => __( 'Egg updated.', 'kebbet-cpt-eastereegg' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Egg restored to revision from %s', 'kebbet-cpt-eastereegg' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Egg published.', 'kebbet-cpt-eastereegg' ),
		7  => __( 'Egg saved.', 'kebbet-cpt-eastereegg' ),
		8  => __( 'Egg submitted.', 'kebbet-cpt-eastereegg' ),
		9  => sprintf(
			/* translators: %1$s: date and time of the scheduled post */
			__( 'Egg scheduled for: <strong>%1$s</strong>.', 'kebbet-cpt-eastereegg' ),
			date_i18n( __( 'M j, Y @ G:i', 'kebbet-cpt-eastereegg' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Egg draft updated.', 'kebbet-cpt-eastereegg' ),
	);
	if ( $post_type_object->publicly_queryable && POSTTYPE === $post_type ) {

		$permalink         = get_permalink( $post->ID );
		$view_link         = sprintf(
			' <a href="%s">%s</a>',
			esc_url( $permalink ),
			__( 'View Egg', 'kebbet-cpt-eastereegg' )
		);
		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link      = sprintf(
			' <a target="_blank" href="%s">%s</a>',
			esc_url( $preview_permalink ),
			__( 'Preview Egg', 'kebbet-cpt-eastereegg' )
		);

		$messages[ $post_type ][1]  .= $view_link;
		$messages[ $post_type ][6]  .= $view_link;
		$messages[ $post_type ][9]  .= $view_link;
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;

	}

	return $messages;

}
add_filter( 'post_updated_messages', __NAMESPACE__ . '\post_updated_messages' );

/**
 * Custom bulk post updates messages
 *
 * @param array  $bulk_messages The messages for bulk updating posts.
 * @param string $bulk_counts Number of updated posts.
 */
function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {

	$bulk_messages[ POSTTYPE ] = array(
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'updated'   => _n( '%s post updated.', '%s posts updated.', number_format_i18n( $bulk_counts['updated'] ), 'kebbet-cpt-eastereegg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'locked'    => _n( '%s post not updated, somebody is editing it.', '%s posts not updated, somebody is editing them.', number_format_i18n( $bulk_counts['locked'] ), 'kebbet-cpt-eastereegg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'deleted'   => _n( '%s post permanently deleted.', '%s posts permanently deleted.', number_format_i18n( $bulk_counts['deleted'] ), 'kebbet-cpt-eastereegg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'trashed'   => _n( '%s post moved to the Trash.', '%s posts moved to the Trash.', number_format_i18n( $bulk_counts['trashed'] ), 'kebbet-cpt-eastereegg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'untrashed' => _n( '%s post restored from the Trash.', '%s posts restored from the Trash.', number_format_i18n( $bulk_counts['untrashed'] ), 'kebbet-cpt-eastereegg' ),
	);

	return $bulk_messages;

}
add_filter( 'bulk_post_updated_messages', __NAMESPACE__ . '\bulk_post_updated_messages', 10, 2 );

/**
 * Add the content to the `At a glance`-widget.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/at-a-glance.php';

/**
 * Adds and modifies the admin columns for the post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/admin-columns.php';

/**
 * Add an option page for the post type.
 */
function add_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_sub_page( array(
			'page_title' => __( 'Egg archive settings', 'kebbet-cpt-eastereegg' ),
			'menu_title' => __( 'Archive settings for eggs', 'kebbet-cpt-eastereegg' ),
			'parent'     => 'edit.php?post_type=' . POSTTYPE,
			'post_id'    => POSTTYPE,
		) );
	}
}

if ( true === ARCHIVE_OPT ) {
	add_action( 'plugins_loaded', __NAMESPACE__ . '\add_options_page' );
}

/**
 * Set post title
 *
 * @param array $data An array of slashed, sanitized, and processed post data.
 * @param array $postarr An array of sanitized (and slashed) but otherwise unmodified post data.
 * @return array
 */
function set_post_title( $data, $postarr ) {
	if ( POSTTYPE !== $data['post_type'] ) {
		return $data;
	}

	$title = get_citation( $data['post_content'] );
	if ( empty( $title ) ) {
		$title = sprintf(
			__( 'Easter egg #%s', 'kebbet-cpt-easteregg' ),
			$postarr['ID']
		);
	}
	$data['post_title'] = $title;

	return $data;
}

/**
 * Get citation from a quote block.
 *
 * @param string $content The post content.
 * @return string
 */
function get_citation( $content ) {
	$matches = array();
	$regex   = '#<cite>(.*?)</cite>#';
	$output  = null;
	preg_match_all( $regex, $content, $matches );
	if ( ! empty( $matches ) && ! empty( $matches[0] ) && ! empty( $matches[0][0] ) ) {
		$output = strip_tags( $matches[0][0] );
	}
	return $output;
}