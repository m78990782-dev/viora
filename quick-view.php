<?php
/**
 * Quick view modal body.
 *
 * Rendered by viora_ajax_quick_view() with $GLOBALS['product'] already set.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product ) {
	return;
}

$viora_id      = $product->get_id();
$viora_percent = viora_discount_percent( $product );
$viora_colors  = viora_product_colors( $product );
$viora_sizes   = viora_product_sizes( $product );
$viora_in_list = viora_wishlist_has( $viora_id );
$viora_cats    = get_the_terms( $viora_id, 'product_cat' );
?>
<div class="viora-quickview">

	<div class="viora-quickview__media">
		<?php
		echo $product->get_image( // phpcs:ignore WordPress.Security.EscapeOutput -- WooCommerce escapes.
			'large',
			array(
				'loading'  => 'eager',
				'decoding' => 'async',
			)
		);
		?>
	</div>

	<div class="viora-single__summary">
		<div class="viora-single__meta-top">
			<?php if ( $viora_cats && ! is_wp_error( $viora_cats ) ) : ?>
				<a class="viora-badge viora-badge--soft" href="<?php echo esc_url( (string) get_term_link( $viora_cats[0] ) ); ?>">
					<?php echo esc_html( $viora_cats[0]->name ); ?>
				</a>
			<?php endif; ?>

			<?php if ( $viora_percent ) : ?>
				<span class="viora-badge viora-badge--sale"><?php echo esc_html( viora_num( $viora_percent ) ); ?>٪ تخفیف</span>
			<?php endif; ?>

			<span class="viora-badge<?php echo $product->is_in_stock() ? '' : ' viora-badge--out'; ?>">
				<?php echo esc_html( $product->is_in_stock() ? 'موجود در انبار' : 'ناموجود' ); ?>
			</span>
		</div>

		<h2 class="viora-quickview__title"><?php echo esc_html( $product->get_name() ); ?></h2>

		<?php if ( $product->get_review_count() ) : ?>
			<?php echo viora_get_stars( (float) $product->get_average_rating(), (int) $product->get_review_count() ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped internally. ?>
		<?php endif; ?>

		<p class="viora-single__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>

		<?php if ( $product->get_short_description() ) : ?>
			<div class="viora-single__excerpt"><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></div>
		<?php endif; ?>

		<?php if ( $viora_colors ) : ?>
			<div>
				<p class="viora-label" style="margin-bottom:.5rem">رنگ</p>
				<div class="viora-colors">
					<?php foreach ( $viora_colors as $viora_color ) : ?>
						<span class="viora-color" title="<?php echo esc_attr( $viora_color['name'] ); ?>">
							<span style="background:<?php echo esc_attr( $viora_color['hex'] ); ?>"></span>
							<span class="viora-color__label"><?php echo esc_html( $viora_color['name'] ); ?></span>
						</span>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $viora_sizes ) : ?>
			<div>
				<p class="viora-label" style="margin-bottom:.5rem">سایز</p>
				<div class="viora-size-picker">
					<?php foreach ( $viora_sizes as $viora_size ) : ?>
						<span class="viora-size-picker__btn"><?php echo esc_html( $viora_size['name'] ); ?></span>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="viora-single__cart-row">
			<?php if ( ! $product->is_in_stock() ) : ?>
				<a class="viora-btn viora-btn--outline" href="<?php echo esc_url( (string) get_permalink( $viora_id ) ); ?>">
					<span class="viora-btn__label">اطلاع از موجودی</span>
				</a>
			<?php elseif ( $product->is_type( 'variable' ) ) : ?>
				<a class="viora-btn viora-btn--primary" href="<?php echo esc_url( (string) get_permalink( $viora_id ) ); ?>">
					<span class="viora-btn__label">انتخاب سایز و رنگ</span>
					<?php viora_icon( 'arrow-left', array( 'size' => 18 ) ); ?>
				</a>
			<?php else : ?>
				<div class="viora-qty" data-viora-qty>
					<button type="button" data-viora-qty-down aria-label="کاهش تعداد"><?php viora_icon( 'minus', array( 'size' => 15 ) ); ?></button>
					<input type="number" min="1" step="1" value="1" aria-label="تعداد" data-viora-qty-input data-viora-quickview-qty>
					<button type="button" data-viora-qty-up aria-label="افزایش تعداد"><?php viora_icon( 'plus', array( 'size' => 15 ) ); ?></button>
				</div>

				<button
					type="button"
					class="viora-btn viora-btn--primary"
					data-viora-add-to-cart="<?php echo esc_attr( (string) $viora_id ); ?>"
					data-viora-qty-source="[data-viora-quickview-qty]">
					<span class="viora-btn__spinner" aria-hidden="true"></span>
					<span class="viora-btn__label">افزودن به سبد خرید</span>
					<?php viora_icon( 'bag', array( 'size' => 18 ) ); ?>
				</button>
			<?php endif; ?>

			<button
				type="button"
				class="viora-btn viora-btn--icon viora-btn--outline<?php echo $viora_in_list ? ' is-active' : ''; ?>"
				data-viora-wishlist="<?php echo esc_attr( (string) $viora_id ); ?>"
				aria-pressed="<?php echo $viora_in_list ? 'true' : 'false'; ?>"
				aria-label="افزودن به علاقه‌مندی‌ها">
				<?php viora_icon( $viora_in_list ? 'heart-fill' : 'heart', array( 'size' => 19 ) ); ?>
			</button>
		</div>

		<a class="viora-btn viora-btn--ghost" href="<?php echo esc_url( (string) get_permalink( $viora_id ) ); ?>" style="justify-self:start;padding-inline:0">
			<span class="viora-btn__label">مشاهده صفحه کامل محصول</span>
			<?php viora_icon( 'arrow-left', array( 'size' => 17 ) ); ?>
		</a>
	</div>
</div>
