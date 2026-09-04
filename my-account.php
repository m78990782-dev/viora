<?php
/**
 * My Account page: navigation + content side by side.
 *
 * @package VIORA
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Notices.
 */
do_action( 'woocommerce_before_account_content' );
?>
<div class="viora-account-layout">
	<?php do_action( 'woocommerce_account_navigation' ); ?>

	<div class="woocommerce-MyAccount-content">
		<?php do_action( 'woocommerce_account_content' ); ?>
	</div>
</div>
<?php
do_action( 'woocommerce_after_account_content' );
