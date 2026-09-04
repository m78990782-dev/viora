<?php
/**
 * Product loop pagination — VIORA.
 *
 * Delegates to viora_pagination(), the same helper the blog and search
 * archives use, so digits are Persian and the buttons match the rest of the
 * theme. The RTL arrows are already handled inside the helper.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! woocommerce_products_will_display() ) {
	return;
}

$viora_total = (int) wc_get_loop_prop( 'total_pages' );

if ( $viora_total < 2 ) {
	return;
}

$viora_current = (int) wc_get_loop_prop( 'current_page' );
$viora_base    = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );

$viora_links = paginate_links(
	apply_filters(
		'woocommerce_pagination_args',
		array(
			'base'      => $viora_base,
			'format'    => '',
			'add_args'  => false,
			'current'   => max( 1, $viora_current ),
			'total'     => $viora_total,
			'prev_text' => viora_get_icon( 'chev-right', array( 'size' => 18 ) ),
			'next_text' => viora_get_icon( 'chev-left', array( 'size' => 18 ) ),
			'type'      => 'array',
			'end_size'  => 1,
			'mid_size'  => 1,
		)
	)
);

if ( ! is_array( $viora_links ) ) {
	return;
}

echo '<nav class="viora-pagination woocommerce-pagination" aria-label="صفحه‌بندی محصولات">';

foreach ( $viora_links as $viora_link ) {
	$viora_link = str_replace( 'page-numbers', 'page-numbers viora-pagination__btn', $viora_link );
	$viora_link = str_replace( 'viora-pagination__btn current', 'viora-pagination__btn is-current', $viora_link );
	$viora_link = preg_replace_callback(
		'/>([0-9\s,\.]+)</u',
		static fn( array $matches ): string => '>' . viora_num( $matches[1] ) . '<',
		$viora_link
	);

	echo wp_kses_post( (string) $viora_link );
}

echo '</nav>';
