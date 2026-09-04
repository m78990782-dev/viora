<?php
/**
 * Front page: the full VIORA demo home layout.
 *
 * Every section is a template part and can be switched off in the Customizer.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="viora-main" class="viora-main viora-main--home">

	<?php
	get_template_part( 'template-parts/home/hero' );
	get_template_part( 'template-parts/home/story' );
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

	// Anything the owner writes into the front page itself still renders.
	if ( is_page() && get_the_content() ) :
		?>
		<section class="viora-section">
			<div class="viora-container viora-container--narrow viora-content">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		</section>
		<?php
	endif;
	?>

</main>
<?php
get_footer();
