<?php
/**
 * My Account navigation — VIORA.
 *
 * Adds an icon per endpoint. Labels come from
 * `woocommerce_account_menu_items`, so translations still apply.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_navigation' );

$viora_icons = array(
	'dashboard'       => 'home',
	'orders'          => 'bag',
	'downloads'       => 'gift',
	'edit-address'    => 'location',
	'edit-account'    => 'user',
	'payment-methods' => 'card',
	'wishlist'        => 'heart',
	'customer-logout' => 'arrow-left',
);
?>
<nav class="woocommerce-MyAccount-navigation" aria-label="صفحه‌های حساب کاربری">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $viora_endpoint => $viora_label ) : ?>
			<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $viora_endpoint ) ); ?>">
				<a
					href="<?php echo esc_url( wc_get_account_endpoint_url( $viora_endpoint ) ); ?>"
					<?php echo wc_is_current_account_menu_item( $viora_endpoint ) ? 'aria-current="page"' : ''; ?>
				>
					<?php viora_icon( $viora_icons[ $viora_endpoint ] ?? 'chevron', array( 'size' => 18 ) ); ?>
					<span><?php echo esc_html( $viora_label ); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
<?php
do_action( 'woocommerce_after_account_navigation' );
