<?php
/**
 * Home: cinematic video section.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'video_enable' ) ) {
	return;
}
?>
<section class="viora-section" aria-labelledby="viora-video-title">
	<div class="viora-container">
		<div class="viora-videoshow"<?php echo viora_reveal( 0, 'zoom' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>

			<div class="viora-videoshow__media">
				<?php
				viora_video(
					array(
						'name'   => 'fashion-showcase',
						'mobile' => true,
					)
				);
				?>

				<button
					type="button"
					class="viora-videoshow__play"
					data-viora-video-toggle
					aria-label="پخش یا توقف ویدیو">
					<?php viora_icon( 'play', array( 'size' => 26 ) ); ?>
				</button>
			</div>

			<div class="viora-videoshow__inner">
				<div class="viora-videoshow__card">
					<h2 class="viora-section__title" id="viora-video-title">
						<?php echo viora_get_headline( (string) viora_option( 'video_title' ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped internally. ?>
					</h2>

					<p><?php echo esc_html( (string) viora_option( 'video_text' ) ); ?></p>

					<a class="viora-btn viora-btn--light viora-btn--lg" href="<?php echo esc_url( viora_link( 'video_cta_url' ) ); ?>">
						<span class="viora-btn__label"><?php echo esc_html( (string) viora_option( 'video_cta_label' ) ); ?></span>
						<?php viora_icon( 'arrow-left', array( 'size' => 19 ) ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
