<?php
/**
 * Home: popular product categories as a one-card slider.
 *
 * A single prominent card is shown at a time; visitors switch with the
 * prev/next controls, the dots, a swipe, or the automatic rotation.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'cats_enable' ) || ! function_exists( 'viora_home_categories' ) ) {
	return;
}

$viora_cats = viora_home_categories( 8 );

if ( count( $viora_cats ) < 2 ) {
	return;
}

/*
 * Theme fallbacks: transparent product cutouts get a "--object" card (contained,
 * padded, gradient surface); editorial photography fills the whole frame.
 */
$viora_cat_fallbacks = array(
	'women'       => array( 'lookbook-woman', false ),
	'men'         => array( 'lookbook-man', false ),
	'streetwear'  => array( 'fashion-banner', false ),
	'accessories' => array( 'floating-bag', true ),
	'collections' => array( 'fashion-model-purple', true ),
);

$viora_cat_delay = 0;
?>
<section class="viora-section viora-cats" aria-labelledby="viora-cats-title">
	<div class="viora-container">

		<header class="viora-section__head">
			<div class="viora-section__titles">
				<h2 class="viora-section__title" id="viora-cats-title"<?php echo viora_reveal( 0, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php echo esc_html( (string) viora_option( 'cats_title' ) ); ?>
				</h2>
				<?php if ( viora_option( 'cats_subtitle' ) ) : ?>
					<p class="viora-section__subtitle"<?php echo viora_reveal( 60, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo esc_html( (string) viora_option( 'cats_subtitle' ) ); ?>
					</p>
				<?php endif; ?>
			</div>

			<div class="viora-cats__controls">
				<div class="viora-slider__nav">
					<button type="button" class="viora-slider__btn" data-viora-slider-prev aria-label="دسته‌بندی قبلی">
						<?php viora_icon( 'chev-right', array( 'size' => 19 ) ); ?>
					</button>
					<button type="button" class="viora-slider__btn" data-viora-slider-next aria-label="دسته‌بندی بعدی">
						<?php viora_icon( 'chev-left', array( 'size' => 19 ) ); ?>
					</button>
				</div>

				<a class="viora-btn viora-btn--ghost" href="<?php echo esc_url( viora_shop_url() ); ?>">
					<span class="viora-btn__label">همه دسته‌بندی‌ها</span>
					<?php viora_icon( 'arrow-left', array( 'size' => 18 ) ); ?>
				</a>
			</div>
		</header>

		<div class="viora-slider viora-cats__slider" data-viora-slider data-viora-autoplay="5000"<?php echo viora_reveal( 120, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<ul class="viora-slider__track viora-cats__track" data-viora-slider-track>
				<?php
				foreach ( $viora_cats as $viora_cat ) :
					$viora_cat_link = get_term_link( $viora_cat );

					if ( is_wp_error( $viora_cat_link ) ) {
						continue;
					}

					$viora_thumb_id = (int) get_term_meta( $viora_cat->term_id, 'thumbnail_id', true );
					$viora_fallback = $viora_cat_fallbacks[ $viora_cat->slug ] ?? array( 'fashion-banner', false );

					/*
					 * Reusable sizing rule: landscape photography fills the card
					 * (cover), while square/portrait sources — typically product
					 * cutouts — get the contained "--object" treatment so the
					 * subject is never zoom-cropped to death.
					 */
					$viora_is_obj = (bool) $viora_fallback[1];

					if ( $viora_thumb_id ) {
						$viora_meta = wp_get_attachment_metadata( $viora_thumb_id );
						$viora_w    = (float) ( $viora_meta['width'] ?? 0 );
						$viora_h    = (float) ( $viora_meta['height'] ?? 0 );

						if ( $viora_w > 0 && $viora_h > 0 && ( $viora_w / $viora_h ) < 1.25 ) {
							$viora_is_obj = true;
						}
					}
					?>
					<li class="viora-cats__slide">
						<a
							class="viora-cat-card<?php echo $viora_is_obj ? ' viora-cat-card--object' : ''; ?>"
							href="<?php echo esc_url( $viora_cat_link ); ?>"
							<?php echo viora_reveal( $viora_cat_delay, 'zoom' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>

							<span class="viora-cat-card__img">
								<?php
								if ( $viora_thumb_id ) {
									echo wp_get_attachment_image(
										$viora_thumb_id,
										'viora-wide',
										false,
										array(
											'alt'      => '',
											'loading'  => 'lazy',
											'decoding' => 'async',
											'sizes'    => '(max-width: 900px) 92vw, 760px',
										)
									);
								} else {
									viora_picture(
										array(
											'name'       => $viora_fallback[0],
											'alt'        => '',
											'decorative' => true,
											'sizes'      => '(max-width: 900px) 92vw, 760px',
											'max'        => 1080,
										)
									);
								}
								?>
							</span>

							<span class="viora-cat-card__arrow" aria-hidden="true">
								<?php viora_icon( 'arrow-left', array( 'size' => 19 ) ); ?>
							</span>

							<span class="viora-cat-card__body">
								<span class="viora-cat-card__title"><?php echo esc_html( $viora_cat->name ); ?></span>
								<span class="viora-cat-card__count">
									<?php echo esc_html( sprintf( '%s محصول', viora_num( (string) $viora_cat->count ) ) ); ?>
								</span>
							</span>
						</a>
					</li>
					<?php
					$viora_cat_delay += 90;
				endforeach;
				?>
			</ul>

			<div class="viora-slider__dots" data-viora-slider-dots role="tablist" aria-label="انتخاب دسته‌بندی"></div>
		</div>
	</div>
</section>
