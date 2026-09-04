<?php
/**
 * Additional information tab — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$viora_heading = apply_filters( 'woocommerce_product_additional_information_heading', '' );

if ( $viora_heading ) :
	?>
	<h2><?php echo esc_html( $viora_heading ); ?></h2>
	<?php
endif;

do_action( 'woocommerce_product_additional_information', $product );
