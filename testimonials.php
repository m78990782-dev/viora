<?php
/**
 * Home: customer testimonials.
 *
 * Real WooCommerce reviews when the shop has them, otherwise the curated demo
 * set from inc/demo-data.php.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'testi_enable' ) ) {
	return;
}

$viora_items = array();

if ( post_type_exists( 'product' ) ) {
	$viora_reviews = get_comments(
		array(
			'post_type' => 'product',
			'status'    => 'approve',
			'number'    => 8,
			'orderby'   => 'comment_date_gmt',
			'order'     => 'DESC',
			'meta_key'  => 'rating', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'type'      => 'review',
		)
	);

	foreach ( (array) $viora_reviews as $viora_review ) {
		$viora_text = wp_strip_all_tags( (string) $viora_review->comment_content );

		if ( mb_strlen( $viora_text ) < 30 ) {
			continue;
		}

		$viora_items[] = array(
			'name'   => (string) $viora_review->comment_author,
			'role'   => sprintf( 'خرید %s', get_the_title( (int) $viora_review->comment_post_ID ) ),
			'rating' => (int) get_comment_meta( (int) $viora_review->comment_ID, 'rating', true ),
			'text'   => $viora_text,
		);
	}
}

if ( count( $viora_items ) < 3 && function_exists( 'viora_demo_testimonials' ) ) {
	$viora_items = viora_demo_testimonials();
}

if ( ! $viora_items ) {
	return;
}

$viora_items = array_slice( $viora_items, 0, 8 );
?>
<section class="viora-section viora-testimonials" aria-labelledby="viora-testi-title">
	<span class="viora-orb viora-orb--lavender" style="inset-inline-start:-140px;inset-block-end:0;width:380px;height:380px" aria-hidden="true"></span>

	<div class="viora-container">

		<header class="viora-section__head">
			<div class="viora-section__titles">
				<h2 class="viora-section__title" id="viora-testi-title"<?php echo viora_reveal( 0, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php echo esc_html( (string) viora_option( 'testi_title' ) ); ?>
				</h2>
				<?php if ( viora_option( 'testi_subtitle' ) ) : ?>
					<p class="viora-section__subtitle"<?php echo viora_reveal( 60, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo esc_html( (string) viora_option( 'testi_subtitle' ) ); ?>
					</p>
				<?php endif; ?>
			</div>

			<div class="viora-slider__nav">
				<button type="button" class="viora-slider__btn" data-viora-slider-prev aria-label="نظر قبلی">
					<?php viora_icon( 'chev-right', array( 'size' => 19 ) ); ?>
				</button>
				<button type="button" class="viora-slider__btn" data-viora-slider-next aria-label="نظر بعدی">
					<?php viora_icon( 'chev-left', array( 'size' => 19 ) ); ?>
				</button>
			</div>
		</header>

		<div class="viora-slider" data-viora-slider>
			<ul class="viora-slider__track" data-viora-slider-track>
				<?php foreach ( $viora_items as $viora_index => $viora_item ) : ?>
					<li class="viora-testimonial"<?php echo viora_reveal( min( 320, $viora_index * 80 ), 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo viora_get_stars( (float) ( $viora_item['rating'] ?: 5 ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped internally. ?>

						<p class="viora-testimonial__text">«<?php echo esc_html( $viora_item['text'] ); ?>»</p>

						<div class="viora-testimonial__person">
							<span class="viora-testimonial__avatar" aria-hidden="true">
								<?php echo esc_html( mb_substr( $viora_item['name'], 0, 1 ) ); ?>
							</span>
							<span>
								<span class="viora-testimonial__name"><?php echo esc_html( $viora_item['name'] ); ?></span>
								<span class="viora-testimonial__role"><?php echo esc_html( $viora_item['role'] ); ?></span>
							</span>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="viora-slider__dots" data-viora-slider-dots role="tablist" aria-label="حرکت بین نظرات"></div>
		</div>
	</div>
</section>
