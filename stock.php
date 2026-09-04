<?php
/**
 * Stock availability line — VIORA.
 *
 * The wording itself comes from the `woocommerce_get_availability_text` filter
 * in inc/woocommerce.php; this template only adds the icon and badge styling.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $availability ) {
	return;
}

$viora_out = false !== strpos( (string) $class, 'out-of-stock' );
?>
<p class="stock viora-stock <?php echo esc_attr( $class ); ?>">
	<?php viora_icon( $viora_out ? 'close' : 'check', array( 'size' => 16 ) ); ?>
	<span><?php echo wp_kses_post( $availability ); ?></span>
</p>
