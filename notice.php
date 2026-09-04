<?php
/**
 * Info notices — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 10.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $notices ) {
	return;
}

foreach ( $notices as $viora_notice ) :
	?>
	<div class="woocommerce-info viora-notice viora-notice--info"<?php echo wc_get_notice_data_attr( $viora_notice ); // phpcs:ignore WordPress.Security.EscapeOutput ?> role="status">
		<span class="viora-notice__icon" aria-hidden="true"><?php viora_icon( 'sparkle', array( 'size' => 18 ) ); ?></span>
		<span class="viora-notice__text"><?php echo wc_kses_notice( $viora_notice['notice'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
	</div>
	<?php
endforeach;
