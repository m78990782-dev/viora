<?php
/**
 * Home: new collection product grid.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'new_enable' ) || ! function_exists( 'viora_products_query' ) ) {
	return;
}

$viora_count = max( 4, (int) viora_option( 'new_count' ) );
$viora_query = viora_products_query( 'new', $viora_count );

if ( ! $viora_query->have_posts() ) {
	wp_reset_postdata();

	return;
}
?>
<section class="viora-section" aria-labelledby="viora-new-title">
	<div class="viora-container">

		<header class="viora-section__head">
			<div class="viora-section__titles">
				<span class="viora-eyebrow"<?php echo viora_reveal( 0, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php viora_icon( 'sparkle', array( 'size' => 15 ) ); ?>
					تازه رسیده‌ها
				</span>
				<h2 class="viora-section__title" id="viora-new-title"<?php echo viora_reveal( 60, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php echo esc_html( (string) viora_option( 'new_title' ) ); ?>
				</h2>
				<?php if ( viora_option( 'new_subtitle' ) ) : ?>
					<p class="viora-section__subtitle"<?php echo viora_reveal( 120, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo esc_html( (string) viora_option( 'new_subtitle' ) ); ?>
					</p>
				<?php endif; ?>
			</div>

			<a class="viora-btn viora-btn--outline" href="<?php echo esc_url( viora_shop_url() ); ?>">
				<span class="viora-btn__label">مشاهده همه محصولات</span>
				<?php viora_icon( 'arrow-left', array( 'size' => 18 ) ); ?>
			</a>
		</header>

		<ul class="viora-products">
			<?php
			$GLOBALS['viora_card_index'] = 0;

			while ( $viora_query->have_posts() ) :
				$viora_query->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
			?>
		</ul>
	</div>
</section>
<?php
wp_reset_postdata();
