<?php
/**
 * Product rating in the summary — VIORA.
 *
 * Uses the theme star markup (`.viora-stars`) and links to the reviews tab.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$viora_rating_count = (int) $product->get_rating_count();
$viora_review_count = (int) $product->get_review_count();
$viora_average      = (float) $product->get_average_rating();

if ( $viora_rating_count <= 0 ) {
	return;
}
?>
<div class="woocommerce-product-rating viora-single__rating">
	<?php echo viora_get_stars( $viora_average, $viora_rating_count ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped internally. ?>

	<?php if ( comments_open() ) : ?>
		<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
			<?php printf( '%s نظر ثبت‌شده', '<span class="count">' . esc_html( viora_num( $viora_review_count ) ) . '</span>' ); ?>
		</a>
	<?php endif; ?>
</div>
