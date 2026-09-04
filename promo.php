<?php
/**
 * Home: promotional banner with a live countdown.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'promo_enable' ) ) {
	return;
}

$viora_deadline = viora_promo_deadline();

$viora_units = array(
	'days'    => 'روز',
	'hours'   => 'ساعت',
	'minutes' => 'دقیقه',
	'seconds' => 'ثانیه',
);
?>
<section class="viora-section" aria-labelledby="viora-promo-title">
	<div class="viora-container">
		<div class="viora-promo"<?php echo viora_reveal( 0, 'zoom' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>

			<div class="viora-promo__video" aria-hidden="true">
				<?php
				viora_video(
					array(
						'name'   => 'floating-clothes',
						'mobile' => false,
					)
				);
				?>
			</div>

			<div class="viora-promo__inner">
				<div class="viora-promo__content">
					<?php if ( viora_option( 'promo_badge' ) ) : ?>
						<span class="viora-promo__badge"><?php echo esc_html( (string) viora_option( 'promo_badge' ) ); ?></span>
					<?php endif; ?>

					<h2 class="viora-promo__title" id="viora-promo-title">
						<?php echo esc_html( (string) viora_option( 'promo_title' ) ); ?>
					</h2>

					<p class="viora-promo__text"><?php echo esc_html( (string) viora_option( 'promo_text' ) ); ?></p>

					<a class="viora-btn viora-btn--light viora-btn--lg viora-btn--magnetic" href="<?php echo esc_url( viora_link( 'promo_cta_url' ) ); ?>">
						<span class="viora-btn__label"><?php echo esc_html( (string) viora_option( 'promo_cta_label' ) ); ?></span>
						<?php viora_icon( 'arrow-left', array( 'size' => 19 ) ); ?>
					</a>
				</div>

				<div
					class="viora-countdown"
					data-viora-countdown="<?php echo esc_attr( $viora_deadline ); ?>"
					role="timer"
					aria-label="زمان باقی‌مانده تا پایان تخفیف">
					<?php foreach ( $viora_units as $viora_unit => $viora_label ) : ?>
						<div class="viora-countdown__box">
							<span class="viora-countdown__value" data-viora-countdown-<?php echo esc_attr( $viora_unit ); ?>>۰۰</span>
							<span class="viora-countdown__label"><?php echo esc_html( $viora_label ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
