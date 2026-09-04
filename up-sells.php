<?php
/**
 * Up-sells — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $upsells ) {
	wp_reset_postdata();

	return;
}

$viora_heading = apply_filters( 'woocommerce_product_upsells_products_heading', 'پیشنهاد ویژه برای شما' );
?>
<section class="up-sells upsells products viora-upsells">
	<?php if ( $viora_heading ) : ?>
		<h2><?php echo esc_html( $viora_heading ); ?></h2>
	<?php endif; ?>

	<?php
	$GLOBALS['viora_card_index'] = 0;

	woocommerce_product_loop_start();

	foreach ( $upsells as $viora_upsell ) {
		$GLOBALS['post'] = get_post( $viora_upsell->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride

		setup_postdata( $GLOBALS['post'] );

		wc_get_template_part( 'content', 'product' );
	}

	woocommerce_product_loop_end();
	?>
</section>
<?php
wp_reset_postdata();
