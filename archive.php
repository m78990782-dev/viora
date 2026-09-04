<?php
/**
 * Post archives (category, tag, author, date).
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="viora-main" class="viora-main">
	<div class="viora-container">

		<?php
		viora_page_head(
			wp_strip_all_tags( (string) get_the_archive_title() ),
			(string) get_the_archive_description()
		);
		?>

		<?php if ( have_posts() ) : ?>
			<div class="viora-grid viora-grid--blog">
				<?php
				$GLOBALS['viora_entry_index'] = 0;

				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/blog/entry' );
				endwhile;
				?>
			</div>

			<?php viora_pagination(); ?>
		<?php else : ?>
			<?php
			viora_empty_state(
				array(
					'icon'      => 'sparkle',
					'title'     => 'موردی در این بخش یافت نشد.',
					'cta_label' => 'بازگشت به خانه',
					'cta_url'   => home_url( '/' ),
				)
			);
			?>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
