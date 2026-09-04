<?php
/**
 * Home: editorial lookbook.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'look_enable' ) ) {
	return;
}

$viora_looks = array(
	array(
		'image'   => 'lookbook-woman',
		'number'  => (string) viora_option( 'look1_number' ),
		'title'   => (string) viora_option( 'look1_title' ),
		'text'    => (string) viora_option( 'look1_text' ),
		'url'     => viora_link( 'look1_url' ),
		'classes' => 'viora-look--tall',
		'sizes'   => '(max-width: 900px) 92vw, 54vw',
		'reveal'  => 'up',
	),
	array(
		'image'   => 'lookbook-man',
		'number'  => (string) viora_option( 'look2_number' ),
		'title'   => (string) viora_option( 'look2_title' ),
		'text'    => (string) viora_option( 'look2_text' ),
		'url'     => viora_link( 'look2_url' ),
		'classes' => 'viora-look--offset',
		'sizes'   => '(max-width: 900px) 92vw, 40vw',
		'reveal'  => 'up',
	),
);
?>
<section class="viora-section viora-lookbook" aria-labelledby="viora-look-title">
	<div class="viora-container">

		<header class="viora-section__head">
			<div class="viora-section__titles">
				<span class="viora-eyebrow"<?php echo viora_reveal( 0, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php viora_icon( 'sparkle', array( 'size' => 15 ) ); ?>
					لوک‌بوک VIORA
				</span>
				<h2 class="viora-section__title" id="viora-look-title"<?php echo viora_reveal( 60, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php echo esc_html( (string) viora_option( 'look_title' ) ); ?>
				</h2>
				<?php if ( viora_option( 'look_subtitle' ) ) : ?>
					<p class="viora-section__subtitle"<?php echo viora_reveal( 120, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo esc_html( (string) viora_option( 'look_subtitle' ) ); ?>
					</p>
				<?php endif; ?>
			</div>
		</header>

		<div class="viora-lookbook__grid">
			<?php foreach ( $viora_looks as $viora_index => $viora_look ) : ?>
				<article class="viora-look <?php echo esc_attr( $viora_look['classes'] ); ?>"<?php echo viora_reveal( $viora_index * 140, $viora_look['reveal'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<span class="viora-look__img">
						<?php
						viora_picture(
							array(
								'name'       => $viora_look['image'],
								'alt'        => '',
								'decorative' => true,
								'sizes'      => $viora_look['sizes'],
								'max'        => 1440,
							)
						);
						?>
					</span>

					<div class="viora-look__body">
						<span class="viora-look__number"><?php echo esc_html( $viora_look['number'] ); ?></span>
						<h3 class="viora-look__title"><?php echo esc_html( $viora_look['title'] ); ?></h3>
						<p class="viora-look__text"><?php echo esc_html( $viora_look['text'] ); ?></p>

						<a class="viora-btn viora-btn--light" href="<?php echo esc_url( $viora_look['url'] ); ?>">
							<span class="viora-btn__label">مشاهده استایل</span>
							<?php viora_icon( 'arrow-left', array( 'size' => 18 ) ); ?>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
