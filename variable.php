<?php
/**
 * Variable product add-to-cart — VIORA.
 *
 * Structure and hooks match core so `wc-add-to-cart-variation.js` keeps working.
 * Two theme-specific additions:
 *   - each attribute row carries `data-viora-attribute="<taxonomy>"` so the
 *     swatch/size enhancement in assets/js/viora.js can upgrade the native
 *     <select> into `.viora-size-picker` buttons without losing the fallback;
 *   - the variation add-to-cart row is wrapped in `.viora-single__cart-row`.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 10.9.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' );
?>
<form
	class="variations_form cart"
	action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
	method="post"
	enctype="multipart/form-data"
	data-product_id="<?php echo absint( $product->get_id() ); ?>"
	data-product_variations="<?php echo $variations_attr; // phpcs:ignore WordPress.Security.EscapeOutput ?>"
>
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>

		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', 'این محصول در حال حاضر ناموجود است.' ) ); ?></p>

	<?php else : ?>

		<table class="variations" cellspacing="0" role="presentation">
			<tbody>
				<?php foreach ( $attributes as $viora_attribute_name => $viora_options ) : ?>
					<tr data-viora-attribute="<?php echo esc_attr( $viora_attribute_name ); ?>">
						<th class="label">
							<label for="<?php echo esc_attr( sanitize_title( $viora_attribute_name ) ); ?>">
								<?php echo wc_attribute_label( $viora_attribute_name ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</label>
						</th>

						<td class="value">
							<?php
							wc_dropdown_variation_attribute_options(
								array(
									'options'   => $viora_options,
									'attribute' => $viora_attribute_name,
									'product'   => $product,
								)
							);

							echo end( $attribute_keys ) === $viora_attribute_name
								? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#" aria-label="پاک کردن انتخاب‌ها">پاک کردن</a>' ) )
								: '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>

		<?php
		// Snapshot for late-loading galleries (quick view modals).
		if ( class_exists( '\Automattic\WooCommerce\Internal\VariationGallery\Package' ) && \Automattic\WooCommerce\Internal\VariationGallery\Package::is_enabled() ) :
			?>
			<script type="text/template" class="wc-product-gallery-default-template"><?php echo wc_get_product_gallery_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput ?></script>
			<?php
		endif;
		?>

		<?php do_action( 'woocommerce_after_variations_table' ); ?>

		<div class="single_variation_wrap">
			<?php
			/**
			 * @hooked woocommerce_single_variation - 10
			 * @hooked woocommerce_single_variation_add_to_cart_button - 20
			 */
			do_action( 'woocommerce_before_single_variation' );
			do_action( 'woocommerce_single_variation' );
			do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
