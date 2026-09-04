<?php
/**
 * Product attributes table — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}
?>
<table class="woocommerce-product-attributes shop_attributes" aria-label="مشخصات محصول">
	<tbody>
		<?php foreach ( $product_attributes as $viora_key => $viora_attribute ) : ?>
			<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $viora_key ); ?>">
				<th class="woocommerce-product-attributes-item__label" scope="row"><?php echo wp_kses_post( $viora_attribute['label'] ); ?></th>
				<?php
				/*
				 * The value can contain term links, so it is printed as-is:
				 * running viora_num() over it would localise digits inside
				 * href attributes and break the links.
				 */
				?>
				<td class="woocommerce-product-attributes-item__value"><?php echo wp_kses_post( $viora_attribute['value'] ); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
