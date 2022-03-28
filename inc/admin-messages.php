<?php
/**
 * Adds admin messages or the post type.
 *
 * @since 1.1.0
 *
 * @package kebbet-cpt-easteregg
 */

namespace cpt\kebbet\easteregg\adminmessages;

use const cpt\kebbet\easteregg\POSTTYPE;

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
		1  => __( 'Egg updated.', 'kebbet-cpt-easteregg' ),
		2  => __( 'Custom field updated.', 'kebbet-cpt-easteregg' ),
		3  => __( 'Custom field deleted.', 'kebbet-cpt-easteregg' ),
		4  => __( 'Egg updated.', 'kebbet-cpt-easteregg' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Egg restored to revision from %s', 'kebbet-cpt-easteregg' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Egg published.', 'kebbet-cpt-easteregg' ),
		7  => __( 'Egg saved.', 'kebbet-cpt-easteregg' ),
		8  => __( 'Egg submitted.', 'kebbet-cpt-easteregg' ),
		9  => sprintf(
			/* translators: %1$s: date and time of the scheduled post */
			__( 'Egg scheduled for: <strong>%1$s</strong>.', 'kebbet-cpt-easteregg' ),
			date_i18n( __( 'M j, Y @ G:i', 'kebbet-cpt-easteregg' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Egg draft updated.', 'kebbet-cpt-easteregg' ),
	);
	if ( $post_type_object->publicly_queryable && POSTTYPE === $post_type ) {
		$permalink         = get_permalink( $post->ID );
		$view_link         = sprintf(
			' <a href="%s">%s</a>',
			esc_url( $permalink ),
			__( 'View Egg', 'kebbet-cpt-easteregg' )
		);
		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link      = sprintf(
			' <a target="_blank" href="%s">%s</a>',
			esc_url( $preview_permalink ),
			__( 'Preview Egg', 'kebbet-cpt-easteregg' )
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
		'updated'   => _n( '%s post updated.', '%s posts updated.', number_format_i18n( $bulk_counts['updated'] ), 'kebbet-cpt-easteregg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'locked'    => _n( '%s post not updated, somebody is editing it.', '%s posts not updated, somebody is editing them.', number_format_i18n( $bulk_counts['locked'] ), 'kebbet-cpt-easteregg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'deleted'   => _n( '%s post permanently deleted.', '%s posts permanently deleted.', number_format_i18n( $bulk_counts['deleted'] ), 'kebbet-cpt-easteregg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'trashed'   => _n( '%s post moved to the Trash.', '%s posts moved to the Trash.', number_format_i18n( $bulk_counts['trashed'] ), 'kebbet-cpt-easteregg' ),
		/* translators: %s: singular of posts, %$s: plural of posts.  */
		'untrashed' => _n( '%s post restored from the Trash.', '%s posts restored from the Trash.', number_format_i18n( $bulk_counts['untrashed'] ), 'kebbet-cpt-easteregg' ),
	);

	return $bulk_messages;
}
add_filter( 'bulk_post_updated_messages', __NAMESPACE__ . '\bulk_post_updated_messages', 10, 2 );
