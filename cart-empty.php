<?php
/**
 * Empty cart page — VIORA.
 *
 * The default `wc_empty_cart_message` notice is suppressed here because the
 * empty state below already carries the message, and a duplicate notice looks
 * broken inside the theme layout.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );

/*
 * Third-party callbacks (coupon notices, plugin hooks) still run.
 */
do_action( 'woocommerce_cart_is_empty' );

viora_empty_state(
	array(
		'icon'      => 'bag',
		'title'     => 'سبد خرید شما خالی است.',
		'text'      => 'هنوز محصولی به سبد خرید اضافه نکرده‌اید. کالکشن جدید را ببینید و استایل خودتان را بسازید.',
		'cta_label' => 'مشاهده فروشگاه',
		'cta_url'   => viora_shop_url(),
	)
);
