<?php
/**
 * Single product content: gallery + summary grid, then tabs and related.
 *
 * @package VIORA
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Notices.
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput

	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php woocommerce_breadcrumb(); ?>

	<div class="viora-single">
		<div class="viora-single__gallery">
			<?php
			/**
			 * woocommerce_show_product_images (20) — the sale flash is moved into
			 * the summary meta row by inc/woocommerce.php.
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>

		<div class="summary entry-summary viora-single__summary">
			<?php
			/**
			 * meta-top (4), title (5), rating (10), price (10), excerpt (20),
			 * add to cart (30), wishlist (31), trust (35), meta (40), sharing (50).
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>
		</div>
	</div>

	<?php
	/**
	 * Tabs (10), upsells (15), related (20).
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
