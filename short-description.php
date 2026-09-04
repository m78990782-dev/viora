<?php
/**
 * Product short description — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.3.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$viora_short = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $viora_short ) {
	return;
}
?>
<div class="woocommerce-product-details__short-description viora-single__excerpt viora-content">
	<?php echo $viora_short; // phpcs:ignore WordPress.Security.EscapeOutput -- filtered by WooCommerce. ?>
</div>
