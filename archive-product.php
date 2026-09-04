<?php
/**
 * Shop / product archive.
 *
 * @package VIORA
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$viora_title = woocommerce_page_title( false );
$viora_desc  = '';

if ( is_product_category() || is_product_tag() ) {
	$viora_term = get_queried_object();
	$viora_desc = ( $viora_term instanceof WP_Term ) ? wpautop( wp_kses_post( $viora_term->description ) ) : '';
} elseif ( is_shop() ) {
	$viora_shop_page = (int) get_option( 'woocommerce_shop_page_id' );
	$viora_desc      = $viora_shop_page ? wpautop( wp_kses_post( (string) get_post_field( 'post_content', $viora_shop_page ) ) ) : '';
}

/**
 * Opens the shop main wrapper (see inc/woocommerce.php).
 */
do_action( 'woocommerce_before_main_content' );
?>
	<div class="viora-container">

		<?php viora_page_head( (string) $viora_title, (string) $viora_desc ); ?>

		<?php
		/**
		 * Category thumbnails / subcategory chips.
		 */
		do_action( 'woocommerce_archive_description' );
		?>

		<div class="viora-shop-layout">

			<?php get_template_part( 'template-parts/shop/filters' ); ?>

			<div class="viora-shop-main" data-viora-shop>

				<?php get_template_part( 'template-parts/shop/toolbar' ); ?>

				<div data-viora-shop-results>
					<?php if ( woocommerce_product_loop() ) : ?>

						<?php
						woocommerce_product_loop_start();

						$GLOBALS['viora_card_index'] = 0;

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();

								/**
								 * Keeps third-party integrations working.
								 */
								do_action( 'woocommerce_shop_loop' );

								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();
						?>

						<?php
						/**
						 * Pagination.
						 */
						do_action( 'woocommerce_after_shop_loop' );
						?>
					<?php else : ?>
						<?php get_template_part( 'template-parts/shop/no-products' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
