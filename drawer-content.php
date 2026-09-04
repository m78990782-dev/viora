<?php
/**
 * Cart drawer contents: shipping progress, line items, totals.
 *
 * Rendered on page load and re-rendered by the AJAX handlers, so it must be
 * self-contained.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
	return;
}

$viora_cart      = WC()->cart;
$viora_threshold = (int) viora_option( 'free_shipping_threshold' );
$viora_subtotal  = (float) $viora_cart->get_displayed_subtotal();
$viora_remaining = max( 0, $viora_threshold - $viora_subtotal );
$viora_percent   = $viora_threshold > 0 ? min( 100, (int) round( ( $viora_subtotal / $viora_threshold ) * 100 ) ) : 100;

if ( $viora_cart->is_empty() ) :
	?>
	<div class="viora-drawer__empty">
		<span class="viora-drawer__empty-icon"><?php viora_icon( 'bag', array( 'size' => 38 ) ); ?></span>
		<h3>سبد خرید شما خالی است.</h3>
		<p>هنوز محصولی انتخاب نکرده‌اید. کالکشن جدید را ببینید.</p>
		<a class="viora-btn viora-btn--primary" href="<?php echo esc_url( viora_shop_url() ); ?>">مشاهده فروشگاه</a>
	</div>
	<?php
	return;
endif;

if ( $viora_threshold > 0 ) :
	?>
	<div class="viora-shipping-progress">
		<p class="viora-shipping-progress__text">
			<?php if ( $viora_remaining > 0 ) : ?>
				با خرید <strong><?php echo wp_kses_post( viora_price( $viora_remaining, false ) ); ?> تومان</strong> دیگر، ارسال رایگان می‌شود.
			<?php else : ?>
				سفارش شما ارسال رایگان دارد.
			<?php endif; ?>
		</p>
		<div class="viora-shipping-progress__track">
			<span style="width:<?php echo (int) $viora_percent; ?>%"></span>
		</div>
	</div>
	<?php
endif;
?>

<ul class="viora-drawer__items">
	<?php
	foreach ( $viora_cart->get_cart() as $viora_key => $viora_item ) :
		$viora_product = $viora_item['data'] ?? null;

		if ( ! $viora_product instanceof WC_Product || ! $viora_product->exists() || $viora_item['quantity'] <= 0 ) {
			continue;
		}

		$viora_permalink = $viora_product->is_visible() ? $viora_product->get_permalink( $viora_item ) : '';
		$viora_thumb     = $viora_product->get_image( 'viora-thumb', array( 'class' => 'viora-drawer__thumb-img' ) );
		$viora_meta      = wc_get_formatted_cart_item_data( $viora_item, true );
		?>
		<li class="viora-drawer__item" data-viora-cart-item="<?php echo esc_attr( $viora_key ); ?>">
			<div class="viora-drawer__thumb">
				<?php if ( $viora_permalink ) : ?>
					<a href="<?php echo esc_url( $viora_permalink ); ?>" tabindex="-1" aria-hidden="true"><?php echo wp_kses_post( $viora_thumb ); ?></a>
				<?php else : ?>
					<?php echo wp_kses_post( $viora_thumb ); ?>
				<?php endif; ?>
			</div>

			<div class="viora-drawer__info">
				<?php if ( $viora_permalink ) : ?>
					<a class="viora-drawer__name" href="<?php echo esc_url( $viora_permalink ); ?>"><?php echo esc_html( $viora_product->get_name() ); ?></a>
				<?php else : ?>
					<span class="viora-drawer__name"><?php echo esc_html( $viora_product->get_name() ); ?></span>
				<?php endif; ?>

				<?php if ( $viora_meta ) : ?>
					<div class="viora-drawer__variation"><?php echo wp_kses_post( $viora_meta ); ?></div>
				<?php endif; ?>

				<div class="viora-qty" data-viora-qty>
					<button type="button" data-viora-qty-down aria-label="کاهش تعداد"><?php viora_icon( 'minus', array( 'size' => 15 ) ); ?></button>
					<input
						type="number"
						inputmode="numeric"
						min="0"
						step="1"
						value="<?php echo esc_attr( (string) $viora_item['quantity'] ); ?>"
						aria-label="تعداد <?php echo esc_attr( $viora_product->get_name() ); ?>"
						data-viora-qty-input>
					<button type="button" data-viora-qty-up aria-label="افزایش تعداد"><?php viora_icon( 'plus', array( 'size' => 15 ) ); ?></button>
				</div>
			</div>

			<div class="viora-drawer__side">
				<span class="viora-drawer__price"><?php echo wp_kses_post( $viora_cart->get_product_subtotal( $viora_product, $viora_item['quantity'] ) ); ?></span>
				<button type="button" class="viora-drawer__remove" data-viora-cart-remove aria-label="حذف <?php echo esc_attr( $viora_product->get_name() ); ?>">
					<?php viora_icon( 'trash', array( 'size' => 17 ) ); ?>
				</button>
			</div>
		</li>
		<?php
	endforeach;
	?>
</ul>

<div class="viora-drawer__totals">
	<div class="viora-drawer__total-row">
		<span>جمع سبد خرید</span>
		<strong><?php echo wp_kses_post( $viora_cart->get_cart_subtotal() ); ?></strong>
	</div>

	<?php if ( $viora_cart->get_discount_total() > 0 ) : ?>
		<div class="viora-drawer__total-row">
			<span>تخفیف</span>
			<strong>−<?php echo wp_kses_post( wc_price( $viora_cart->get_discount_total() ) ); ?></strong>
		</div>
	<?php endif; ?>

	<p class="viora-shipping-progress__text" style="margin-top:.35rem">
		هزینه ارسال در مرحله تسویه حساب محاسبه می‌شود.
	</p>
</div>
