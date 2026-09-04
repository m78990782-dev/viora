<?php
/**
 * Mini-cart (core cart widget / block fallback) — VIORA.
 *
 * The theme's own slide-in drawer lives in template-parts/cart/drawer-content.php.
 * This template only runs when the WooCommerce cart widget is placed in a
 * sidebar, so it mirrors the drawer styling and keeps the core classes
 * (`remove_from_cart_button`, `mini_cart_item`) that WooCommerce JS binds to.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 11.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' );

if ( ! WC()->cart || WC()->cart->is_empty() ) :
	?>
	<p class="woocommerce-mini-cart__empty-message">سبد خرید شما خالی است.</p>
	<?php
	do_action( 'woocommerce_after_mini_cart' );

	return;
endif;
?>
<ul class="woocommerce-mini-cart cart_list product_list_widget viora-mini-cart <?php echo esc_attr( $args['list_class'] ); ?>">
	<?php
	do_action( 'woocommerce_before_mini_cart_contents' );

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$visible    = apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key );

		if ( ! $_product instanceof WC_Product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! $visible ) {
			continue;
		}

		$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
		$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'viora-thumb' ), $cart_item, $cart_item_key );
		$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		?>
		<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
			<?php
			echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput
				'woocommerce_cart_item_remove_link',
				sprintf(
					'<a role="button" href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" data-success_message="%s">&times;</a>',
					esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
					esc_attr( sprintf( 'حذف %s از سبد خرید', wp_strip_all_tags( $product_name ) ) ),
					esc_attr( $product_id ),
					esc_attr( $cart_item_key ),
					esc_attr( $_product->get_sku() ),
					esc_attr( sprintf( '«%s» از سبد خرید حذف شد.', wp_strip_all_tags( $product_name ) ) )
				),
				$cart_item_key
			);
			?>

			<?php if ( empty( $product_permalink ) ) : ?>
				<?php echo $thumbnail . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php else : ?>
				<a href="<?php echo esc_url( $product_permalink ); ?>">
					<?php echo $thumbnail . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</a>
			<?php endif; ?>

			<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput ?>

			<?php
			echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput
				'woocommerce_widget_cart_item_quantity',
				'<span class="quantity">' . sprintf( '%s × %s', esc_html( viora_num( $cart_item['quantity'] ) ), $product_price ) . '</span>',
				$cart_item,
				$cart_item_key
			);
			?>
		</li>
		<?php
	}

	do_action( 'woocommerce_mini_cart_contents' );
	?>
</ul>

<p class="woocommerce-mini-cart__total total">
	<?php
	/**
	 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
	 */
	do_action( 'woocommerce_widget_shopping_cart_total' );
	?>
</p>

<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
