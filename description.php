<?php
/**
 * Description tab — VIORA.
 *
 * The visible heading is dropped because the tab label already says
 * "توضیحات"; repeating it inside the panel is noise.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$viora_content = $post->post_content;

if ( ! $viora_content ) {
	viora_empty_state(
		array(
			'icon'  => 'sparkle',
			'title' => 'توضیحی برای این محصول ثبت نشده است.',
		)
	);

	return;
}

the_content();
