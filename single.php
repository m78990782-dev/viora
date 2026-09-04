<?php
/**
 * Single blog post.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="viora-main" class="viora-main">
		<div class="viora-container">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="viora-page-head">
					<nav class="viora-breadcrumb" aria-label="مسیر صفحه">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a>
						<span class="viora-breadcrumb__sep" aria-hidden="true">/</span>
						<a href="<?php echo esc_url( viora_blog_url() ); ?>">وبلاگ</a>
						<span class="viora-breadcrumb__sep" aria-hidden="true">/</span>
						<span><?php the_title(); ?></span>
					</nav>

					<h1 class="viora-page-head__title"><?php the_title(); ?></h1>

					<div class="viora-entry__meta" style="justify-content:center">
						<time datetime="<?php echo esc_attr( (string) get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( viora_num( (string) get_the_date() ) ); ?>
						</time>
						<span><?php echo esc_html( get_the_author() ); ?></span>
						<?php if ( get_the_category_list() ) : ?>
							<span><?php echo wp_kses_post( get_the_category_list( '، ' ) ); ?></span>
						<?php endif; ?>
						<span><?php echo esc_html( sprintf( '%s نظر', viora_num( (string) get_comments_number() ) ) ); ?></span>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div style="border-radius:var(--v-r-xl);overflow:hidden;margin-bottom:2.5rem"<?php echo viora_reveal( 0, 'zoom' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<?php the_post_thumbnail( 'viora-wide', array( 'alt' => '', 'loading' => 'eager', 'decoding' => 'async' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="viora-container--narrow viora-content" style="padding-inline:0;margin-inline:auto">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<nav class="viora-pagination" aria-label="صفحه‌بندی نوشته">',
							'after'  => '</nav>',
						)
					);

					if ( has_tag() ) {
						echo '<p class="viora-row" style="margin-top:2.5rem">';
						foreach ( (array) get_the_tags() as $viora_tag ) {
							printf(
								'<a class="viora-chip" href="%s">%s</a>',
								esc_url( (string) get_tag_link( $viora_tag->term_id ) ),
								esc_html( $viora_tag->name )
							);
						}
						echo '</p>';
					}
					?>
				</div>
			</article>

			<div class="viora-container--narrow" style="padding-inline:0;margin-inline:auto">
				<?php
				the_post_navigation(
					array(
						'prev_text' => '<span class="viora-entry__meta">نوشته قبلی</span><span class="viora-entry__title">%title</span>',
						'next_text' => '<span class="viora-entry__meta">نوشته بعدی</span><span class="viora-entry__title">%title</span>',
						'class'     => 'viora-grid',
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
