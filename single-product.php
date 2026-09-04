<?php
/**
 * Single product page wrapper.
 *
 * @package VIORA
 * @version 1.6.4
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );
?>
	<div class="viora-container">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php wc_get_template_part( 'content', 'single-product' ); ?>
		<?php endwhile; ?>
	</div>
<?php
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
