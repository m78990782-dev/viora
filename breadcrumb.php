<?php
/**
 * Shop breadcrumb — VIORA.
 *
 * Adds aria-current to the trailing crumb and localises any digits (page
 * numbers, paginated archives) to Persian. The wrapper, delimiter and home
 * label come from viora_breadcrumb_args() in inc/woocommerce.php.
 *
 * @see     woocommerce_breadcrumb()
 * @package VIORA
 * @version 2.3.0
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $breadcrumb ) ) {
	return;
}

$viora_total = count( $breadcrumb );

echo $wrap_before; // phpcs:ignore WordPress.Security.EscapeOutput -- theme-controlled markup.

foreach ( $breadcrumb as $viora_key => $viora_crumb ) {
	$viora_last  = ( $viora_total === $viora_key + 1 );
	$viora_label = viora_num( (string) $viora_crumb[0] );

	echo $before; // phpcs:ignore WordPress.Security.EscapeOutput

	if ( ! empty( $viora_crumb[1] ) && ! $viora_last ) {
		printf(
			'<a href="%s">%s</a>',
			esc_url( $viora_crumb[1] ),
			esc_html( $viora_label )
		);
	} else {
		printf(
			'<span aria-current="page">%s</span>',
			esc_html( $viora_label )
		);
	}

	echo $after; // phpcs:ignore WordPress.Security.EscapeOutput

	if ( ! $viora_last ) {
		echo $delimiter; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

echo $wrap_after; // phpcs:ignore WordPress.Security.EscapeOutput
