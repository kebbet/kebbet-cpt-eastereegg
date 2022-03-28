<?php
/**
 * Customizations to post type behavior.
 *
 * @since 1.1.0
 *
 * @package kebbet-cpt-easteregg
 */

namespace cpt\kebbet\easteregg\customization;

use const cpt\kebbet\easteregg\POSTTYPE;

/**
 * Set post title
 *
 * @param array $data An array of slashed, sanitized, and processed post data.
 * @param array $post_arr An array of sanitized (and slashed) but otherwise unmodified post data.
 * @return array
 */
function set_post_title( $data, $post_arr ) {
	if ( POSTTYPE !== $data['post_type'] ) {
		return $data;
	}

	$title = get_citation( $data['post_content'] );
	if ( empty( $title ) ) {
		$title = sprintf(
			__( 'Easter egg #%s', 'kebbet-cpt-easteregg' ),
			$post_arr['ID']
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
