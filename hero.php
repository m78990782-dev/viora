<?php
/**
 * Home: hero section.
 *
 * Floating 3D cutout model, decorative objects, cinematic video backdrop and a
 * live "featured product" glass tag pulled from WooCommerce.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'hero_enable' ) ) {
	return;
}

$viora_hero_video = (int) viora_option( 'hero_video' );

// Glass price tag: newest sale product, falling back to the newest product.
$viora_tag_product = null;

if ( function_exists( 'wc_get_product' ) ) {
	$viora_tag_query = viora_products_query( 'sale', 1 );

	if ( ! $viora_tag_query->have_posts() ) {
		$viora_tag_query = viora_products_query( 'new', 1 );
	}

	if ( $viora_tag_query->have_posts() ) {
		$viora_tag_product = wc_get_product( $viora_tag_query->posts[0] );
	}
}

$viora_stats = array(
	array( viora_option( 'hero_stat1_value' ), viora_option( 'hero_stat1_label' ) ),
	array( viora_option( 'hero_stat2_value' ), viora_option( 'hero_stat2_label' ) ),
	array( viora_option( 'hero_stat3_value' ), viora_option( 'hero_stat3_label' ) ),
);
?>
<section class="viora-hero" aria-labelledby="viora-hero-title" data-viora-parallax-scene>

	<div class="viora-hero__bg" aria-hidden="true">
		<?php
		if ( $viora_hero_video ) {
			printf(
				'<video class="viora-hero__video viora-video" muted loop playsinline preload="none" data-viora-video="lazy" aria-hidden="true"><source data-src="%s" type="%s"></video>',
				esc_url( (string) wp_get_attachment_url( $viora_hero_video ) ),
				esc_attr( (string) get_post_mime_type( $viora_hero_video ) )
			);
		} else {
			viora_video(
				array(
					'name'   => 'hero-fashion-loop',
					'class'  => 'viora-hero__video',
					'mobile' => true,
				)
			);
		}
		?>
	</div>

	<div class="viora-container">
		<div class="viora-hero__grid">

			<div class="viora-hero__content">
				<?php if ( viora_option( 'hero_eyebrow' ) ) : ?>
					<span class="viora-eyebrow"<?php echo viora_reveal( 0, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php viora_icon( 'sparkle', array( 'size' => 15 ) ); ?>
						<?php echo esc_html( (string) viora_option( 'hero_eyebrow' ) ); ?>
					</span>
				<?php endif; ?>

				<h1 class="viora-hero__title" id="viora-hero-title"<?php echo viora_reveal( 80, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php
					echo viora_get_headline( // phpcs:ignore WordPress.Security.EscapeOutput -- escaped internally.
						(string) viora_option( 'hero_title' ),
						(string) viora_option( 'hero_highlight' )
					);
					?>
				</h1>

				<p class="viora-hero__text"<?php echo viora_reveal( 160, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php echo esc_html( (string) viora_option( 'hero_text' ) ); ?>
				</p>

				<div class="viora-hero__actions"<?php echo viora_reveal( 240, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<a class="viora-btn viora-btn--primary viora-btn--lg viora-btn--magnetic" href="<?php echo esc_url( viora_link( 'hero_cta_url' ) ); ?>">
						<span class="viora-btn__label"><?php echo esc_html( (string) viora_option( 'hero_cta_label' ) ); ?></span>
						<?php viora_icon( 'arrow-left', array( 'size' => 19 ) ); ?>
					</a>

					<a class="viora-btn viora-btn--glass viora-btn--lg" href="<?php echo esc_url( viora_link( 'hero_cta2_url' ) ); ?>">
						<span class="viora-btn__label"><?php echo esc_html( (string) viora_option( 'hero_cta2_label' ) ); ?></span>
					</a>
				</div>

				<dl class="viora-hero__stats"<?php echo viora_reveal( 320, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php foreach ( $viora_stats as $viora_stat ) : ?>
						<?php if ( ! $viora_stat[0] ) { continue; } ?>
						<div>
							<dt class="viora-visually-hidden"><?php echo esc_html( (string) $viora_stat[1] ); ?></dt>
							<dd>
								<span class="viora-hero__stat-value"><?php echo esc_html( viora_num( (string) $viora_stat[0] ) ); ?></span>
								<span class="viora-hero__stat-label"><?php echo esc_html( (string) $viora_stat[1] ); ?></span>
							</dd>
						</div>
					<?php endforeach; ?>
				</dl>
			</div>

		<div class="viora-hero__visual" aria-hidden="true">
			<div class="viora-hero__stage">
				<span class="viora-hero__halo"></span>
				<span class="viora-hero__ring viora-float"></span>

				<div class="viora-hero__object viora-hero__object--bag" data-viora-parallax="0.9">
					<?php
					viora_picture(
						array(
							'name'       => 'floating-bag',
							'alt'        => '',
							'decorative' => true,
							'sizes'      => '205px',
							'max'        => 480,
						)
					);
					?>
				</div>

				<div class="viora-hero__object viora-hero__object--shoe" data-viora-parallax="1.2">
					<?php
					viora_picture(
						array(
							'name'       => 'floating-shoe',
							'alt'        => '',
							'decorative' => true,
							'sizes'      => '235px',
							'max'        => 480,
						)
					);
					?>
				</div>

				<div class="viora-hero__object viora-hero__object--sunglasses" data-viora-parallax="1.5">
					<?php
					viora_picture(
						array(
							'name'       => 'floating-sunglasses',
							'alt'        => '',
							'decorative' => true,
							'sizes'      => '185px',
							'max'        => 480,
						)
					);
					?>
				</div>
			</div>

			<?php if ( $viora_tag_product instanceof WC_Product ) : ?>
				<a class="viora-hero__tag viora-float" href="<?php echo esc_url( (string) get_permalink( $viora_tag_product->get_id() ) ); ?>">
					<?php
					// Uncropped size: landscape cutouts (e.g. sunglasses) stay complete.
					$viora_tag_thumb = get_the_post_thumbnail_url( $viora_tag_product->get_id(), 'large' );

					if ( $viora_tag_thumb ) :
						?>
						<img src="<?php echo esc_url( $viora_tag_thumb ); ?>" alt="" width="54" height="42" loading="lazy" decoding="async">
					<?php endif; ?>

					<span>
						<span class="viora-hero__tag-name"><?php echo esc_html( $viora_tag_product->get_name() ); ?></span>
						<span class="viora-hero__tag-price"><?php echo wp_kses_post( $viora_tag_product->get_price_html() ); ?></span>
					</span>
				</a>
			<?php endif; ?>
			</div>

		</div>
	</div>

	<span class="viora-hero__scroll" aria-hidden="true">
		<?php viora_icon( 'chevron', array( 'size' => 18 ) ); ?>
		<span>برای دیدن کالکشن پایین بروید</span>
	</span>
</section>
<?php
wp_reset_postdata();
