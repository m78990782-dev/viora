<?php
/**
 * Related products — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 10.3.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $related_products ) {
	wp_reset_postdata();

	return;
}

/*
 * Keep every related thumbnail lazy: they always sit far below the fold.
 */
if ( function_exists( 'wp_increase_content_media_count' ) ) {
	$viora_media_count = wp_increase_content_media_count( 0 );

	if ( $viora_media_count < wp_omit_loading_attr_threshold() ) {
		wp_increase_content_media_count( wp_omit_loading_attr_threshold() - $viora_media_count );
	}
}

$viora_heading = apply_filters( 'woocommerce_product_related_products_heading', 'محصولات مشابه' );
?>
<section class="related products viora-related">
	<?php if ( $viora_heading ) : ?>
		<h2><?php echo esc_html( $viora_heading ); ?></h2>
	<?php endif; ?>

	<?php
	$GLOBALS['viora_card_index'] = 0;

	woocommerce_product_loop_start();

	foreach ( $related_products as $viora_related_product ) {
		$GLOBALS['post'] = get_post( $viora_related_product->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride

		setup_postdata( $GLOBALS['post'] );

		wc_get_template_part( 'content', 'product' );
	}

	woocommerce_product_loop_end();
	?>
</section>
<?php
wp_reset_postdata();
