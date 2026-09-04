<?php
/**
 * Home: best sellers.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'best_enable' ) || ! function_exists( 'viora_products_query' ) ) {
	return;
}

$viora_count = max( 4, (int) viora_option( 'best_count' ) );
$viora_query = viora_products_query( 'best', $viora_count );

if ( ! $viora_query->have_posts() ) {
	wp_reset_postdata();

	return;
}
?>
<section class="viora-section" aria-labelledby="viora-best-title">
	<span class="viora-orb viora-orb--pink" style="inset-inline-end:-160px;inset-block-start:20%;width:420px;height:420px" aria-hidden="true"></span>

	<div class="viora-container">

		<header class="viora-section__head">
			<div class="viora-section__titles">
				<span class="viora-eyebrow"<?php echo viora_reveal( 0, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php viora_icon( 'star-fill', array( 'size' => 15 ) ); ?>
					انتخاب مشتریان
				</span>
				<h2 class="viora-section__title" id="viora-best-title"<?php echo viora_reveal( 60, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php echo esc_html( (string) viora_option( 'best_title' ) ); ?>
				</h2>
				<?php if ( viora_option( 'best_subtitle' ) ) : ?>
					<p class="viora-section__subtitle"<?php echo viora_reveal( 120, 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php echo esc_html( (string) viora_option( 'best_subtitle' ) ); ?>
					</p>
				<?php endif; ?>
			</div>

			<a class="viora-btn viora-btn--outline" href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', viora_shop_url() ) ); ?>">
				<span class="viora-btn__label">پرفروش‌ترین‌ها</span>
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
