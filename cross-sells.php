<?php
/**
 * Cross-sells on the cart page — VIORA.
 *
 * Uses the theme product grid (`.viora-products`) instead of the WooCommerce
 * `ul.products` list, matching every other product grid in the theme.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $cross_sells ) {
	return;
}

$viora_heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', 'شاید این‌ها را هم بخواهید' );
?>
<section class="cross-sells viora-cross-sells">
	<?php if ( $viora_heading ) : ?>
		<h2 class="viora-section__title"><?php echo esc_html( $viora_heading ); ?></h2>
	<?php endif; ?>

	<ul class="viora-products viora-products--3 products" data-viora-grid>
		<?php
		$GLOBALS['viora_card_index'] = 0;

		foreach ( $cross_sells as $viora_cross_sell ) {
			$GLOBALS['post'] = get_post( $viora_cross_sell->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride

			setup_postdata( $GLOBALS['post'] );

			wc_get_template_part( 'content', 'product' );
		}
		?>
	</ul>
</section>
<?php
wp_reset_postdata();
