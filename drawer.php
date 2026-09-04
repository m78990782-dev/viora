<?php
/**
 * Cart drawer shell. The body is replaced by AJAX/cart fragments.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;
?>
<aside class="viora-drawer" id="viora-cart-drawer" data-viora-panel="cart" role="dialog" aria-modal="true" aria-label="سبد خرید" hidden>

	<div class="viora-drawer__head">
		<h2 class="viora-drawer__title">
			<?php viora_icon( 'bag', array( 'size' => 20 ) ); ?>
			<span>سبد خرید</span>
		</h2>

		<button type="button" class="viora-action" data-viora-close aria-label="بستن سبد خرید">
			<?php viora_icon( 'close' ); ?>
		</button>
	</div>

	<div class="viora-drawer__body" data-viora-drawer-body>
		<?php get_template_part( 'template-parts/cart/drawer-content' ); ?>
	</div>

	<div class="viora-drawer__foot" data-viora-drawer-foot>
		<a class="viora-btn viora-btn--outline viora-btn--block" href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' ) ); ?>">
			مشاهده سبد خرید
		</a>
		<a class="viora-btn viora-btn--primary viora-btn--block" href="<?php echo esc_url( function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' ) ); ?>">
			تسویه حساب
			<?php viora_icon( 'arrow-left', array( 'size' => 18 ) ); ?>
		</a>
	</div>
</aside>
