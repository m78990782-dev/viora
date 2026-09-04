<?php
/**
 * Product card — the premium 3D card used by every grid on the site.
 *
 * Overrides woocommerce/content-product.php, so it is also what the shop
 * archive, related products and the AJAX filter endpoint render.
 *
 * @package VIORA
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
	return;
}

$viora_id       = $product->get_id();
$viora_permalink = get_permalink( $viora_id );
$viora_percent  = function_exists( 'viora_discount_percent' ) ? viora_discount_percent( $product ) : 0;
$viora_colors   = function_exists( 'viora_product_colors' ) ? viora_product_colors( $product ) : array();
$viora_sizes    = function_exists( 'viora_product_sizes' ) ? viora_product_sizes( $product ) : array();
$viora_in_list  = function_exists( 'viora_wishlist_has' ) && viora_wishlist_has( $viora_id );
$viora_is_new   = ( time() - (int) get_post_time( 'U', true, $viora_id ) ) < ( 30 * DAY_IN_SECONDS );
$viora_rating   = (float) $product->get_average_rating();
$viora_reviews  = (int) $product->get_review_count();
$viora_cats     = get_the_terms( $viora_id, 'product_cat' );
$viora_cat_name = ( $viora_cats && ! is_wp_error( $viora_cats ) ) ? $viora_cats[0]->name : '';

// Gallery image used for the hover cross-fade.
$viora_gallery  = $product->get_gallery_image_ids();
$viora_hover_id = $viora_gallery ? (int) $viora_gallery[0] : 0;

$viora_classes = array( 'viora-product-card' );

if ( ! $product->is_in_stock() ) {
	$viora_classes[] = 'viora-product-card--out';
}

/*
 * Staggered scroll reveal. Templates that open a grid reset
 * $GLOBALS['viora_card_index'] so each section starts from zero.
 */
$viora_index                 = (int) ( $GLOBALS['viora_card_index'] ?? 0 );
$GLOBALS['viora_card_index'] = $viora_index + 1;
$viora_delay                 = min( 480, $viora_index * 70 );
?>
<li <?php wc_product_class( implode( ' ', $viora_classes ), $product ); ?> data-viora-tilt data-viora-product="<?php echo esc_attr( (string) $viora_id ); ?>"<?php echo viora_reveal( $viora_delay, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>

	<a class="viora-product-card__media" href="<?php echo esc_url( (string) $viora_permalink ); ?>" tabindex="-1" aria-hidden="true">
		<span class="viora-product-card__badges">
			<?php if ( $viora_percent ) : ?>
				<span class="viora-badge viora-badge--sale"><?php echo esc_html( viora_num( $viora_percent ) ); ?>٪ تخفیف</span>
			<?php elseif ( $product->is_on_sale() ) : ?>
				<span class="viora-badge viora-badge--sale">حراج</span>
			<?php endif; ?>

			<?php if ( $viora_is_new ) : ?>
				<span class="viora-badge viora-badge--new">جدید</span>
			<?php endif; ?>

			<?php if ( ! $product->is_in_stock() ) : ?>
				<span class="viora-badge viora-badge--out">ناموجود</span>
			<?php endif; ?>
		</span>

	<?php
	echo $product->get_image( // phpcs:ignore WordPress.Security.EscapeOutput -- WooCommerce escapes.
		'large',
		array(
			'class'    => 'viora-product-card__img viora-product-card__img--main',
			'loading'  => 'lazy',
			'decoding' => 'async',
			'sizes'    => '(max-width: 820px) 46vw, (max-width: 1180px) 30vw, 23vw',
		)
	);

	if ( $viora_hover_id ) {
		echo wp_get_attachment_image(
			$viora_hover_id,
			'large',
			false,
			array(
				'class'    => 'viora-product-card__img viora-product-card__img--hover',
				'alt'      => '',
				'loading'  => 'lazy',
				'decoding' => 'async',
				'sizes'    => '(max-width: 820px) 46vw, (max-width: 1180px) 30vw, 23vw',
			)
		);
	}
	?>

		<span class="viora-product-card__shadow"></span>
	</a>

	<div class="viora-product-card__tools">
		<button
			type="button"
			class="viora-tool<?php echo $viora_in_list ? ' is-active' : ''; ?>"
			data-viora-wishlist="<?php echo esc_attr( (string) $viora_id ); ?>"
			aria-pressed="<?php echo $viora_in_list ? 'true' : 'false'; ?>"
			aria-label="<?php echo esc_attr( sprintf( 'افزودن %s به علاقه‌مندی‌ها', $product->get_name() ) ); ?>">
			<?php viora_icon( $viora_in_list ? 'heart-fill' : 'heart', array( 'size' => 18 ) ); ?>
		</button>

		<button
			type="button"
			class="viora-tool"
			data-viora-quickview="<?php echo esc_attr( (string) $viora_id ); ?>"
			aria-label="<?php echo esc_attr( sprintf( 'مشاهده سریع %s', $product->get_name() ) ); ?>">
			<?php viora_icon( 'eye', array( 'size' => 18 ) ); ?>
		</button>

		<a
			class="viora-tool"
			href="<?php echo esc_url( (string) $viora_permalink ); ?>"
			aria-label="<?php echo esc_attr( sprintf( 'صفحه محصول %s', $product->get_name() ) ); ?>">
			<?php viora_icon( 'arrow-left', array( 'size' => 18 ) ); ?>
		</a>
	</div>

	<div class="viora-product-card__body">
		<?php if ( $viora_cat_name ) : ?>
			<span class="viora-product-card__cat"><?php echo esc_html( $viora_cat_name ); ?></span>
		<?php endif; ?>

		<h3 class="viora-product-card__title">
			<a href="<?php echo esc_url( (string) $viora_permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
		</h3>

		<?php if ( $viora_reviews > 0 ) : ?>
			<?php echo viora_get_stars( $viora_rating, $viora_reviews ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped internally. ?>
		<?php endif; ?>

		<div class="viora-price">
			<?php echo wp_kses_post( $product->get_price_html() ); ?>

			<?php if ( $viora_percent ) : ?>
				<span class="viora-price__off"><?php echo esc_html( viora_num( $viora_percent ) ); ?>٪</span>
			<?php endif; ?>
		</div>

		<?php if ( $viora_colors ) : ?>
			<div class="viora-swatches" role="list" aria-label="رنگ‌های موجود">
				<?php foreach ( array_slice( $viora_colors, 0, 5 ) as $viora_color ) : ?>
					<span
						class="viora-swatch"
						role="listitem"
						title="<?php echo esc_attr( $viora_color['name'] ); ?>"
						style="background:<?php echo esc_attr( $viora_color['hex'] ); ?>"></span>
					<span class="viora-visually-hidden"><?php echo esc_html( $viora_color['name'] ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $viora_sizes ) : ?>
			<div class="viora-sizes" aria-label="سایزهای موجود">
				<?php foreach ( array_slice( $viora_sizes, 0, 6 ) as $viora_size ) : ?>
					<span><?php echo esc_html( $viora_size['name'] ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="viora-product-card__foot">
			<?php if ( ! $product->is_in_stock() ) : ?>
				<a class="viora-btn viora-btn--outline viora-btn--sm viora-product-card__cart" href="<?php echo esc_url( (string) $viora_permalink ); ?>">
					<span class="viora-btn__label">اطلاع از موجودی</span>
				</a>
			<?php elseif ( $product->is_type( 'variable' ) ) : ?>
				<a class="viora-btn viora-btn--primary viora-btn--sm viora-product-card__cart" href="<?php echo esc_url( (string) $viora_permalink ); ?>">
					<span class="viora-btn__label">انتخاب گزینه‌ها</span>
					<?php viora_icon( 'bag', array( 'size' => 17 ) ); ?>
				</a>
			<?php else : ?>
				<button
					type="button"
					class="viora-btn viora-btn--primary viora-btn--sm viora-product-card__cart"
					data-viora-add-to-cart="<?php echo esc_attr( (string) $viora_id ); ?>">
					<span class="viora-btn__spinner" aria-hidden="true"></span>
					<span class="viora-btn__label">افزودن به سبد خرید</span>
					<?php viora_icon( 'bag', array( 'size' => 17 ) ); ?>
				</button>
			<?php endif; ?>
		</div>
	</div>
</li>
