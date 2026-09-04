<?php
/**
 * My Account dashboard — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 4.4.0
 *
 * @var WP_User $current_user
 */

defined( 'ABSPATH' ) || exit;

$viora_customer_id = get_current_user_id();
$viora_orders      = wc_get_orders(
	array(
		'customer_id' => $viora_customer_id,
		'limit'       => -1,
		'return'      => 'ids',
	)
);
$viora_wishlist    = function_exists( 'viora_wishlist_count' ) ? viora_wishlist_count() : 0;
?>
<div class="viora-dashboard">
	<p class="viora-dashboard__hello">
		سلام <strong><?php echo esc_html( $current_user->display_name ); ?></strong> 👋
		<a class="viora-dashboard__logout" href="<?php echo esc_url( wc_logout_url() ); ?>">خروج از حساب</a>
	</p>

	<div class="viora-dashboard__stats">
		<a class="viora-dashboard__stat" href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>">
			<?php viora_icon( 'bag', array( 'size' => 22 ) ); ?>
			<strong><?php echo esc_html( viora_num( count( $viora_orders ) ) ); ?></strong>
			<span>سفارش</span>
		</a>

		<a class="viora-dashboard__stat" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>">
			<?php viora_icon( 'location', array( 'size' => 22 ) ); ?>
			<strong>نشانی‌ها</strong>
			<span>مدیریت نشانی ارسال</span>
		</a>

		<a class="viora-dashboard__stat" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>">
			<?php viora_icon( 'user', array( 'size' => 22 ) ); ?>
			<strong>حساب من</strong>
			<span>ویرایش اطلاعات و رمز عبور</span>
		</a>

		<?php if ( $viora_wishlist > 0 ) : ?>
			<span class="viora-dashboard__stat">
				<?php viora_icon( 'heart', array( 'size' => 22 ) ); ?>
				<strong><?php echo esc_html( viora_num( $viora_wishlist ) ); ?></strong>
				<span>علاقه‌مندی</span>
			</span>
		<?php endif; ?>
	</div>
</div>

<?php
/**
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );
