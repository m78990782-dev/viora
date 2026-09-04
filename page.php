<?php
/**
 * Static page.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

get_header();

// WooCommerce pages (cart, checkout) carry a two-column layout that needs
// the wide container; regular pages keep the narrow reading column.
$viora_wc_page = class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() );

while ( have_posts() ) :
	the_post();
	?>
	<main id="viora-main" class="viora-main">
		<div class="viora-container">

			<?php viora_page_head( get_the_title() ); ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<div style="border-radius:var(--v-r-xl);overflow:hidden;margin-bottom:2.5rem"<?php echo viora_reveal( 0, 'zoom' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
					<?php the_post_thumbnail( 'viora-wide', array( 'alt' => '', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="viora-container--<?php echo $viora_wc_page ? 'wide' : 'narrow'; ?> viora-content" <?php echo $viora_wc_page ? '' : 'style="padding-inline:0;margin-inline:auto"'; ?>>
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<nav class="viora-pagination" aria-label="صفحه‌بندی نوشته">',
						'after'  => '</nav>',
					)
				);

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div>

		</div>
	</main>
	<?php
endwhile;

get_footer();
