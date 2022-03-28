<?php
/**
 * Adds an option page for ACF to post type.
 *
 * @since 1.1.0
 *
 * @package kebbet-cpt-eastereegg
 */

namespace cpt\kebbet\easteregg\optionspage;

use const cpt\kebbet\easteregg\POSTTYPE;

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
add_action( 'plugins_loaded', __NAMESPACE__ . '\add_options_page' );
