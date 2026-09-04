<?php
/**
 * Cart totals — VIORA.
 *
 * Same structure and hooks as core, with Persian labels and the free-shipping
 * hint under the order total.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="cart_totals <?php echo WC()->customer->has_calculated_shipping() ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2>جمع سبد خرید</h2>

	<table cellspacing="0" class="shop_table shop_table_responsive">

		<tr class="cart-subtotal">
			<th>جمع جزء</th>
			<td data-title="جمع جزء"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $viora_code => $viora_coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $viora_code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $viora_coupon ); ?></th>
				<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $viora_coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $viora_coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<tr class="shipping">
				<th>ارسال</th>
				<td data-title="ارسال"><?php woocommerce_shipping_calculator(); ?></td>
			</tr>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $viora_fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $viora_fee->name ); ?></th>
				<td data-title="<?php echo esc_attr( $viora_fee->name ); ?>"><?php wc_cart_totals_fee_html( $viora_fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$viora_estimated = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				$viora_address   = WC()->customer->get_taxable_address();
				$viora_estimated = sprintf(
					' <small>(برآورد برای %s)</small>',
					esc_html( WC()->countries->countries[ $viora_address[0] ] ?? '' )
				);
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $viora_tax_code => $viora_tax ) {
					?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $viora_tax_code ) ); ?>">
						<th><?php echo esc_html( $viora_tax->label ) . $viora_estimated; // phpcs:ignore WordPress.Security.EscapeOutput ?></th>
						<td data-title="<?php echo esc_attr( $viora_tax->label ); ?>"><?php echo wp_kses_post( $viora_tax->formatted_amount ); ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr class="tax-total">
					<th>مالیات بر ارزش افزوده<?php echo $viora_estimated; // phpcs:ignore WordPress.Security.EscapeOutput ?></th>
					<td data-title="مالیات"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<tr class="order-total">
			<th>مبلغ قابل پرداخت</th>
			<td data-title="مبلغ قابل پرداخت"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<p class="viora-cart-totals__note">
		<?php viora_icon( 'shield', array( 'size' => 17 ) ); ?>
		<span>پرداخت از طریق درگاه امن بانکی انجام می‌شود.</span>
	</p>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>
