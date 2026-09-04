<?php
/**
 * Template Name: صفحه اصلی VIORA
 * Template Post Type: page
 *
 * Lets the owner use the full home layout on any page, not only the front page.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="viora-main" class="viora-main viora-main--home">
	<?php
	get_template_part( 'template-parts/home/hero' );
	get_template_part( 'template-parts/home/marquee' );
	get_template_part( 'template-parts/home/categories' );
	get_template_part( 'template-parts/home/collection' );
	get_template_part( 'template-parts/home/showcase' );
	get_template_part( 'template-parts/home/video' );
	get_template_part( 'template-parts/home/bestsellers' );
	get_template_part( 'template-parts/home/lookbook' );
	get_template_part( 'template-parts/home/promo' );
	get_template_part( 'template-parts/home/features' );
	get_template_part( 'template-parts/home/testimonials' );
	get_template_part( 'template-parts/home/newsletter' );
	?>
</main>
<?php
get_footer();
