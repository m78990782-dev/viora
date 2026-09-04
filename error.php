<?php
/**
 * Error notices — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $notices ) {
	return;
}
?>
<ul class="woocommerce-error viora-notice viora-notice--error" role="alert">
	<?php foreach ( $notices as $viora_notice ) : ?>
		<li<?php echo wc_get_notice_data_attr( $viora_notice ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<span class="viora-notice__icon" aria-hidden="true"><?php viora_icon( 'close', array( 'size' => 18 ) ); ?></span>
			<span class="viora-notice__text"><?php echo wc_kses_notice( $viora_notice['notice'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
		</li>
	<?php endforeach; ?>
</ul>
