<?php
/**
 * Home: service features.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'features_enable' ) ) {
	return;
}

$viora_features = array(
	array( 'truck', (string) viora_option( 'feature1_title' ), (string) viora_option( 'feature1_text' ) ),
	array( 'shield', (string) viora_option( 'feature2_title' ), (string) viora_option( 'feature2_text' ) ),
	array( 'card', (string) viora_option( 'feature3_title' ), (string) viora_option( 'feature3_text' ) ),
	array( 'headset', (string) viora_option( 'feature4_title' ), (string) viora_option( 'feature4_text' ) ),
);
?>
<section class="viora-section viora-section--tight" aria-label="خدمات VIORA">
	<div class="viora-container">
		<div class="viora-grid viora-features">
			<?php foreach ( $viora_features as $viora_index => $viora_feature ) : ?>
				<?php if ( ! $viora_feature[1] ) { continue; } ?>
				<article class="viora-feature"<?php echo viora_reveal( $viora_index * 90, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<span class="viora-feature__icon" aria-hidden="true">
						<?php viora_icon( $viora_feature[0], array( 'size' => 26 ) ); ?>
					</span>
					<h3 class="viora-feature__title"><?php echo esc_html( $viora_feature[1] ); ?></h3>
					<p class="viora-feature__text"><?php echo esc_html( $viora_feature[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
