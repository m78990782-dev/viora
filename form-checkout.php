<?php
/**
 * Checkout form: customer details and order review side by side.
 *
 * @package VIORA
 * @version 9.4.0
 * @var WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// Guests may need to log in first.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', 'برای تسویه حساب باید وارد حساب کاربری خود شوید.' ) );

	return;
}
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout viora-checkout-layout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="فرم تسویه حساب">

	<?php if ( $checkout->get_checkout_fields() ) : ?>
		<div id="customer_details">
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<?php do_action( 'woocommerce_checkout_billing' ); ?>
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		</div>
	<?php endif; ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<h3 id="order_review_heading">سفارش شما</h3>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<?php do_action( 'woocommerce_checkout_order_review' ); ?>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>
</form>
<?php
do_action( 'woocommerce_after_checkout_form', $checkout );
