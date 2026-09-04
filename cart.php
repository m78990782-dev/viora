<?php
/**
 * Cart page — VIORA.
 *
 * Keeps every WooCommerce class and hook (core cart JS depends on
 * `.woocommerce-cart-form`, `.cart_item`, `a.remove` and the nonce field) and
 * layers the theme contract on top:
 *   data-viora-cart-item="<key>"  → AJAX line quantity + removal (assets/js/viora.js)
 *   data-viora-cart-remove        → instant removal without a page reload
 *
 * The classic "Update cart" submit stays in the markup as a no-JS fallback.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 11.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>
<form class="woocommerce-cart-form viora-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="product-remove"><span class="screen-reader-text">حذف</span></th>
				<th scope="col" class="product-thumbnail"><span class="screen-reader-text">تصویر</span></th>
				<th scope="col" class="product-name">محصول</th>
				<th scope="col" class="product-price">قیمت</th>
				<th scope="col" class="product-quantity">تعداد</th>
				<th scope="col" class="product-subtotal">جمع</th>
			</tr>
		</thead>

		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				$visible    = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

				if ( ! $_product instanceof WC_Product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! $visible ) {
					continue;
				}

				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr
					class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>"
					data-viora-cart-item="<?php echo esc_attr( $cart_item_key ); ?>"
				>
					<td class="product-remove">
						<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-viora-cart-remove>&times;</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr( sprintf( 'حذف %s از سبد خرید', wp_strip_all_tags( $product_name ) ) ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
						?>
					</td>

					<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput
						}
						?>
					</td>

					<td role="rowheader" class="product-name" data-title="محصول">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( $product_name . '&nbsp;' );
						} else {
							echo wp_kses_post(
								apply_filters(
									'woocommerce_cart_item_name',
									sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ),
									$cart_item,
									$cart_item_key
								)
							);
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Variation / add-on meta.
						echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput

						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post(
								apply_filters(
									'woocommerce_cart_item_backorder_notification',
									'<p class="backorder_notification">پس از تأمین موجودی ارسال می‌شود.</p>',
									$product_id
								)
							);
						}
						?>
					</td>

					<td class="product-price" data-title="قیمت">
						<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</td>

					<td class="product-quantity" data-title="تعداد">
						<?php
						if ( $_product->is_sold_individually() ) {
							$min_quantity = 1;
							$max_quantity = 1;
						} else {
							$min_quantity = 0;
							$max_quantity = $_product->get_max_purchase_quantity();
						}

						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $max_quantity,
								'min_value'    => $min_quantity,
								'product_name' => $product_name,
							),
							$_product,
							false
						);

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>

					<td class="product-subtotal" data-title="جمع">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</td>
				</tr>
				<?php
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">
					<?php if ( wc_coupons_enabled() ) : ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text">کد تخفیف</label>
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="کد تخفیف" />

							<button type="submit" class="button" name="apply_coupon" value="اعمال کد تخفیف">اعمال کد تخفیف</button>

							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php endif; ?>

					<button type="submit" class="button viora-cart-form__update" name="update_cart" value="به‌روزرسانی سبد خرید">به‌روزرسانی سبد خرید</button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
	/**
	 * @hooked woocommerce_cross_sell_display
	 * @hooked woocommerce_cart_totals - 10
	 */
	do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
