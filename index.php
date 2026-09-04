<?php
/**
 * Blog index / fallback archive.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

get_header();

$viora_title = 'وبلاگ';
$viora_desc  = 'الهام، راهنمای استایل و تازه‌های دنیای مد از تیم VIORA.';

if ( is_home() && (int) get_option( 'page_for_posts' ) ) {
	$viora_title = get_the_title( (int) get_option( 'page_for_posts' ) );
}
?>
<main id="viora-main" class="viora-main">
	<div class="viora-container">

		<?php viora_page_head( $viora_title, $viora_desc ); ?>

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
					'title'     => 'هنوز نوشته‌ای منتشر نشده است.',
					'text'      => 'به‌زودی مطالب تازه‌ای در وبلاگ VIORA منتشر می‌شود.',
					'cta_label' => 'مشاهده فروشگاه',
				)
			);
			?>
		<?php endif; ?>

	</div>
</main>
<?php
get_footer();
