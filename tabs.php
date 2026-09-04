<?php
/**
 * Product tabs — VIORA.
 *
 * Same structure as core (WooCommerce `wc-tabs` JS binds to `ul.tabs li a`),
 * with a Persian aria-label and the theme wrapper class. Tab titles are
 * localised by viora_product_tabs() in inc/woocommerce.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 9.8.0
 */

defined( 'ABSPATH' ) || exit;

$viora_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( empty( $viora_tabs ) ) {
	return;
}
?>
<div class="woocommerce-tabs wc-tabs-wrapper viora-tabs">
	<ul class="tabs wc-tabs" role="tablist" aria-label="اطلاعات محصول">
		<?php foreach ( $viora_tabs as $viora_key => $viora_tab ) : ?>
			<li role="presentation" class="<?php echo esc_attr( $viora_key ); ?>_tab" id="tab-title-<?php echo esc_attr( $viora_key ); ?>">
				<a href="#tab-<?php echo esc_attr( $viora_key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $viora_key ); ?>">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $viora_key . '_tab_title', $viora_tab['title'], $viora_key ) ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php foreach ( $viora_tabs as $viora_key => $viora_tab ) : ?>
		<div
			class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $viora_key ); ?> panel entry-content wc-tab viora-content"
			id="tab-<?php echo esc_attr( $viora_key ); ?>"
			role="tabpanel"
			aria-labelledby="tab-title-<?php echo esc_attr( $viora_key ); ?>"
		>
			<?php
			if ( isset( $viora_tab['callback'] ) ) {
				call_user_func( $viora_tab['callback'], $viora_key, $viora_tab );
			}
			?>
		</div>
	<?php endforeach; ?>

	<?php do_action( 'woocommerce_product_after_tabs' ); ?>
</div>
