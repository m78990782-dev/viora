<?php
/**
 * Home: story strip with an in-page story viewer.
 *
 * Tapping a bubble opens the story in a lightbox overlay (never a redirect):
 * each story shows its own image or plays its own video, with prev/next
 * navigation, keyboard and swipe support, and locked background scrolling.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'story_enable' ) ) {
	return;
}

/**
 * Resolve a story destination: product-type search, category link or fallback.
 *
 * @param string $search    Persian search term.
 * @param string $term_slug Product category slug.
 * @param string $fallback  URL used when the term does not exist.
 * @return string
 */
$viora_story_url = static function ( string $search, string $term_slug, string $fallback ): string {
	if ( taxonomy_exists( 'product_cat' ) && $term_slug ) {
		$viora_term = get_term_by( 'slug', $term_slug, 'product_cat' );

		if ( $viora_term instanceof WP_Term && $viora_term->count > 0 ) {
			$viora_link = get_term_link( $viora_term );

			if ( ! is_wp_error( $viora_link ) ) {
				return (string) $viora_link;
			}
		}
	}

	if ( $search ) {
		return add_query_arg(
			array(
				's'         => $search,
				'post_type' => 'product',
			),
			home_url( '/' )
		);
	}

	return $fallback;
};

$viora_shop = function_exists( 'viora_shop_url' ) ? viora_shop_url() : home_url( '/' );

/**
 * Each story carries the media shown in BOTH the bubble and the viewer:
 * 'image' (theme asset file) or 'video' (theme video stem, webm + mp4).
 */
$viora_stories = array(
	array(
		'label' => 'تازه‌ها',
		'video' => 'floating-clothes',
		'url'   => add_query_arg( 'orderby', 'date', $viora_shop ),
	),
	array(
		'label'  => 'هودی‌ها',
		'video'  => 'product-rotation',
		'chroma' => true,
		'url'    => $viora_story_url( 'هودی', '', $viora_shop ),
	),
	array(
		'label' => 'استریت‌ور',
		'image' => 'fashion-model-purple.webp',
		'url'   => $viora_story_url( '', 'streetwear', $viora_shop ),
	),
	array(
		'label' => 'کفش‌ها',
		'video' => 'shoe-floating',
		'url'   => $viora_story_url( 'کفش', '', $viora_shop ),
	),
	array(
		'label' => 'کیف‌ها',
		'image' => 'floating-bag.webp',
		'url'   => $viora_story_url( 'کیف', '', $viora_shop ),
	),
	array(
		'label' => 'عینک‌ها',
		'image' => 'floating-sunglasses.webp',
		'url'   => $viora_story_url( 'عینک', '', $viora_shop ),
	),
	array(
		'label' => 'شلوارها',
		'image' => 'cargo-pants.webp',
		'url'   => $viora_story_url( 'شلوار', '', $viora_shop ),
	),
	array(
		'label' => 'لوک‌بوک',
		'image' => 'lookbook-woman.webp',
		'url'   => home_url( '/#viora-look-title' ),
	),
);

/**
 * Build the data-* payload a story button carries into the viewer.
 *
 * @param array $story Story record.
 * @return array
 */
$viora_story_attrs = static function ( array $story ): array {
	$attrs = array( 'data-story-label' => $story['label'] );

	if ( ! empty( $story['video'] ) ) {
		$attrs['data-story-type'] = 'video';
		$attrs['data-story-webm'] = viora_asset( 'assets/video/' . $story['video'] . '.webm' );
		$attrs['data-story-mp4']  = viora_asset( 'assets/video/' . $story['video'] . '.mp4' );

		if ( ! empty( $story['chroma'] ) ) {
			$attrs['data-story-chroma'] = '1';
		}
	} else {
		$attrs['data-story-type'] = 'image';
		$attrs['data-story-src']  = viora_asset( 'assets/img/' . $story['image'] );
	}

	return $attrs;
};
?>
<nav class="viora-story" aria-label="دسترسی سریع دسته‌بندی‌ها">
	<ul class="viora-story__track">
		<?php foreach ( $viora_stories as $viora_i => $viora_story ) : ?>
			<li class="viora-story__item">
				<button
					type="button"
					class="viora-story__link"
					data-viora-story-open
					aria-haspopup="dialog"
					aria-label="<?php echo esc_attr( 'مشاهده استوری ' . $viora_story['label'] ); ?>"
					<?php
					foreach ( $viora_story_attrs( $viora_story ) as $viora_attr => $viora_val ) {
						printf( '%s="%s" ', esc_attr( $viora_attr ), esc_attr( $viora_val ) );
					}
					?>>
					<span class="viora-story__ring<?php echo $viora_i % 2 ? ' viora-story__ring--alt' : ''; ?>">
						<span class="viora-story__bubble">
							<?php if ( ! empty( $viora_story['video'] ) ) : ?>
								<?php
								viora_video(
									array(
										'name'   => $viora_story['video'],
										'chroma' => ! empty( $viora_story['chroma'] ),
										'mobile' => false,
									)
								);
								?>
							<?php else : ?>
								<img
									src="<?php echo esc_url( viora_asset( 'assets/img/' . $viora_story['image'] ) ); ?>"
									alt=""
									width="56"
									height="56"
									loading="lazy"
									decoding="async">
							<?php endif; ?>
						</span>
					</span>
					<span class="viora-story__label"><?php echo esc_html( $viora_story['label'] ); ?></span>
				</button>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<div class="viora-story-viewer" data-viora-story-viewer role="dialog" aria-modal="true" aria-label="نمایش استوری" hidden>
	<div class="viora-story-viewer__backdrop" data-viora-story-close></div>

	<button type="button" class="viora-story-viewer__close" data-viora-story-close aria-label="بستن استوری">
		<?php viora_icon( 'close', array( 'size' => 20 ) ); ?>
	</button>

	<div class="viora-story-viewer__stage">
		<button type="button" class="viora-story-viewer__nav viora-story-viewer__nav--prev" data-viora-story-prev aria-label="استوری قبلی">
			<?php viora_icon( 'chev-right', array( 'size' => 22 ) ); ?>
		</button>

		<div class="viora-story-viewer__frame">
			<div class="viora-story-viewer__media" data-viora-story-media></div>
			<p class="viora-story-viewer__caption" data-viora-story-caption></p>
		</div>

		<button type="button" class="viora-story-viewer__nav viora-story-viewer__nav--next" data-viora-story-next aria-label="استوری بعدی">
			<?php viora_icon( 'chev-left', array( 'size' => 22 ) ); ?>
		</button>
	</div>
</div>
