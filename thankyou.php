<?php
/**
 * Order received / thank-you page — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 8.1.0
 *
 * @var WC_Order|false $order
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-order viora-thankyou">

	<?php if ( ! $order ) : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php else : ?>

		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<div class="viora-thankyou__head viora-thankyou__head--failed">
				<span class="viora-thankyou__icon" aria-hidden="true"><?php viora_icon( 'close', array( 'size' => 34 ) ); ?></span>
				<h2>پرداخت ناموفق بود</h2>
				<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
					متأسفانه تراکنش شما از سوی بانک تأیید نشد و سفارش ثبت نهایی نگردید. لطفاً پرداخت را دوباره انجام دهید.
				</p>
			</div>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions viora-thankyou__actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="viora-btn viora-btn--primary pay">
					<span class="viora-btn__label">پرداخت مجدد</span>
				</a>

				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="viora-btn viora-btn--outline">
						<span class="viora-btn__label">حساب کاربری</span>
					</a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="viora-thankyou__head">
				<span class="viora-thankyou__icon" aria-hidden="true"><?php viora_icon( 'check', array( 'size' => 34 ) ); ?></span>
				<h2>سفارش شما با موفقیت ثبت شد</h2>
				<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>
			</div>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details viora-order-overview">

				<li class="woocommerce-order-overview__order order">
					<span>شماره سفارش</span>
					<strong><?php echo esc_html( viora_num( $order->get_order_number() ) ); ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<span>تاریخ</span>
					<strong><?php echo esc_html( viora_num( wc_format_datetime( $order->get_date_created() ) ) ); ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<span>ایمیل</span>
						<strong><?php echo esc_html( $order->get_billing_email() ); ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<span>مبلغ پرداختی</span>
					<strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<span>روش پرداخت</span>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>
			</ul>

			<p class="viora-thankyou__actions">
				<a class="viora-btn viora-btn--primary" href="<?php echo esc_url( viora_shop_url() ); ?>">
					<span class="viora-btn__label">ادامه خرید</span>
				</a>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php endif; ?>
</div>
