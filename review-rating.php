<?php
/**
 * Review star rating — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;

$viora_rating = (int) get_comment_meta( $comment->comment_ID, 'rating', true );

if ( ! $viora_rating || ! wc_review_ratings_enabled() ) {
	return;
}

echo viora_get_stars( (float) $viora_rating ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped internally.
