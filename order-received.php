<?php
/**
 * Order received message — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 8.8.0
 *
 * @var WC_Order|false $order
 */

defined( 'ABSPATH' ) || exit;

$viora_message = apply_filters(
	'woocommerce_thankyou_order_received_text',
	$order
		? 'از خرید شما سپاسگزاریم. سفارش شما ثبت شد و به‌زودی برای ارسال آماده می‌شود.'
		: 'سفارشی برای نمایش وجود ندارد.',
	$order
);
?>
<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
	<?php echo wp_kses_post( $viora_message ); ?>
</p>
