<?php
/**
 * Single product price — VIORA.
 *
 * Stays a <p class="price"> because assets/css/woocommerce.css styles
 * `p.price del` / `p.price ins` for the strike-through sale price.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$viora_percent = viora_discount_percent( $product );
?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?> viora-single__price">
	<?php echo wp_kses_post( $product->get_price_html() ); ?>

	<?php if ( $viora_percent ) : ?>
		<span class="viora-price__off"><?php echo esc_html( viora_num( $viora_percent ) ); ?>٪ ارزان‌تر</span>
	<?php endif; ?>
</p>
