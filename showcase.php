<?php
/**
 * Home: interactive pseudo-3D product showcase.
 *
 * Drag / pointer move rotates the product, the colour selector cross-fades to an
 * alternate gallery image, and product-rotation.mp4 is used as a turntable layer
 * where the browser can play it.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'showcase_enable' ) ) {
	return;
}

$viora_product  = null;
$viora_views    = array();
$viora_colors   = array();
$viora_cta_url  = viora_link( 'showcase_cta_url' );

if ( function_exists( 'wc_get_product' ) ) {
	$viora_query = viora_products_query( 'featured', 12 );

	if ( ! $viora_query->have_posts() ) {
		$viora_query = viora_products_query( 'new', 12 );
	}

	if ( $viora_query->have_posts() ) {
		$viora_product = wc_get_product( $viora_query->posts[0] );

		// Prefer a hoodie so the turntable video matches the shown product.
		foreach ( $viora_query->posts as $viora_post ) {
			if ( false !== mb_strpos( $viora_post->post_title, 'هودی' ) ) {
				$viora_product = wc_get_product( $viora_post );
				break;
			}
		}
	}

	wp_reset_postdata();
}

if ( $viora_product instanceof WC_Product ) {
	$viora_cta_url = (string) get_permalink( $viora_product->get_id() );

	$viora_ids = array_filter( array_merge( array( (int) $viora_product->get_image_id() ), $viora_product->get_gallery_image_ids() ) );

	foreach ( $viora_ids as $viora_image_id ) {
		$viora_src = wp_get_attachment_image_url( (int) $viora_image_id, 'large' );

		if ( $viora_src ) {
			$viora_views[] = $viora_src;
		}
	}

	$viora_colors = viora_product_colors( $viora_product );
}

// Fallback to the bundled cutout when the shop is still empty.
if ( ! $viora_views ) {
	$viora_views = array( viora_asset( 'assets/img/purple-hoodie.webp' ) );
}

if ( ! $viora_colors ) {
	$viora_colors = array(
		array( 'name' => 'بنفش', 'slug' => 'banafsh', 'hex' => '#6C45C7' ),
		array( 'name' => 'یاسی', 'slug' => 'yasi', 'hex' => '#B9A5F5' ),
		array( 'name' => 'سفید', 'slug' => 'sefid', 'hex' => '#FFFFFF' ),
		array( 'name' => 'مشکی', 'slug' => 'meshki', 'hex' => '#17131F' ),
	);
}

$viora_features = array(
	array( 'shield', 'پارچه پرمیوم با دوخت تقویت‌شده' ),
	array( 'ruler', 'برش اورسایز با راهنمای سایز دقیق' ),
	array( 'refresh', 'هفت روز مهلت تعویض یا بازگشت' ),
);
?>
<section class="viora-section" aria-labelledby="viora-showcase-title">
	<div class="viora-container">
		<div class="viora-showcase">
			<div class="viora-showcase__grid">

				<div class="viora-showcase__content">
					<span class="viora-eyebrow"<?php echo viora_reveal( 0, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php viora_icon( 'grid', array( 'size' => 15 ) ); ?>
						نمای سه‌بعدی محصول
					</span>

					<h2 class="viora-section__title" id="viora-showcase-title"<?php echo viora_reveal( 70, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo esc_html( (string) viora_option( 'showcase_title' ) ); ?>
					</h2>

					<p class="viora-section__subtitle"<?php echo viora_reveal( 130, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo esc_html( (string) viora_option( 'showcase_subtitle' ) ); ?>
					</p>

					<div class="viora-showcase__features"<?php echo viora_reveal( 190, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php foreach ( $viora_features as $viora_feature ) : ?>
							<p class="viora-showcase__feature">
								<?php viora_icon( $viora_feature[0], array( 'size' => 18 ) ); ?>
								<span><?php echo esc_html( $viora_feature[1] ); ?></span>
							</p>
						<?php endforeach; ?>
					</div>

					<div class="viora-colors" role="group" aria-label="انتخاب رنگ"<?php echo viora_reveal( 240, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php foreach ( array_values( $viora_colors ) as $viora_i => $viora_color ) : ?>
							<button
								type="button"
								class="viora-color<?php echo 0 === $viora_i ? ' is-active' : ''; ?>"
								data-viora-showcase-color="<?php echo esc_url( $viora_views[ $viora_i ] ?? $viora_views[0] ); ?>"
								aria-pressed="<?php echo 0 === $viora_i ? 'true' : 'false'; ?>"
								title="<?php echo esc_attr( $viora_color['name'] ); ?>">
								<span style="background:<?php echo esc_attr( $viora_color['hex'] ); ?>"></span>
								<span class="viora-color__label"><?php echo esc_html( $viora_color['name'] ); ?></span>
							</button>
						<?php endforeach; ?>
					</div>

					<?php if ( $viora_product instanceof WC_Product ) : ?>
						<p class="viora-price" style="margin-top:.25rem">
							<?php echo wp_kses_post( $viora_product->get_price_html() ); ?>
						</p>
					<?php endif; ?>

					<a class="viora-btn viora-btn--primary viora-btn--lg viora-btn--magnetic" href="<?php echo esc_url( $viora_cta_url ); ?>"<?php echo viora_reveal( 300, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<span class="viora-btn__label"><?php echo esc_html( (string) viora_option( 'showcase_cta_label' ) ); ?></span>
						<?php viora_icon( 'arrow-left', array( 'size' => 19 ) ); ?>
					</a>
				</div>

				<div
					class="viora-showcase__stage"
					data-viora-showcase
					role="img"
					aria-label="<?php echo esc_attr( $viora_product instanceof WC_Product ? sprintf( 'نمای چرخشی %s', $viora_product->get_name() ) : 'نمای چرخشی محصول' ); ?>">

					<span class="viora-showcase__glow" aria-hidden="true"></span>
					<span class="viora-showcase__disc" aria-hidden="true"></span>

					<div class="viora-showcase__product is-floating" data-viora-showcase-product>
						<img
							src="<?php echo esc_url( $viora_views[0] ); ?>"
							alt=""
							width="900"
							height="1200"
							loading="lazy"
							decoding="async"
							data-viora-showcase-img>

					<?php
					/*
					 * Turntable layer: preloaded on approach, but it only takes
					 * over from the still image while the visitor keeps the
					 * pointer pressed (see the showcase module in viora.js).
					 */
					viora_video(
						array(
							'name'   => 'product-rotation',
							'class'  => 'viora-showcase__rotation',
							'mobile' => true,
							'chroma' => true,
							'manual' => true,
						)
					);
					?>
					</div>

					<span class="viora-showcase__hint" aria-hidden="true">
						<?php viora_icon( 'refresh', array( 'size' => 15 ) ); ?>
						<span>برای چرخش، محصول را بکشید</span>
					</span>
				</div>

			</div>
		</div>
	</div>
</section>
