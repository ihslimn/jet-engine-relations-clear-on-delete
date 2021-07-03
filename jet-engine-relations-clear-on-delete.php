<?php
/**
 * Plugin Name: JetEngine - Related posts - clear relations on delete
 * Plugin URI: #
 * Description: Removes post ID from related posts relation meta when post is deleted permanently.
 * Version:     1.0.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'before_delete_post', 'jet_rpcp_handler' );

function jet_rpcp_handler( $post_id ) {

	if ( ! function_exists( 'jet_engine' ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );

	$relation_fields = jet_engine()->relations->get_relation_fields_for_post_type( $post_type );

	if ( ! empty( $relation_fields ) ) {
		foreach ( $relation_fields as $field ) {
			jet_engine()->relations->data->delete_all_related_meta( $field[ 'name' ], $post_id );
		}
	}

}
