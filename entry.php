<?php
/**
 * Blog post card used by the blog index, archives and search results.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_index                  = (int) ( $GLOBALS['viora_entry_index'] ?? 0 );
$GLOBALS['viora_entry_index'] = $viora_index + 1;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'viora-entry' ); ?><?php echo viora_reveal( min( 420, $viora_index * 70 ), 'up' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a class="viora-entry__thumb" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php
			the_post_thumbnail(
				'viora-wide',
				array(
					'alt'      => '',
					'loading'  => 'lazy',
					'decoding' => 'async',
					'sizes'    => '(max-width: 620px) 100vw, (max-width: 820px) 46vw, 30vw',
				)
			);
			?>
		</a>
	<?php endif; ?>

	<div class="viora-entry__body">
		<div class="viora-entry__meta">
			<time datetime="<?php echo esc_attr( (string) get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( viora_num( (string) get_the_date() ) ); ?>
			</time>

			<?php
			$viora_cats = get_the_category_list( '، ' );

			if ( $viora_cats ) :
				?>
				<span><?php echo wp_kses_post( $viora_cats ); ?></span>
			<?php endif; ?>

			<span><?php echo esc_html( sprintf( '%s دقیقه مطالعه', viora_num( max( 1, (int) round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 180 ) ) ) ) ); ?></span>
		</div>

		<h2 class="viora-entry__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>

		<a class="viora-btn viora-btn--ghost" href="<?php the_permalink(); ?>" style="justify-self:start;padding-inline:0">
			<span class="viora-btn__label">ادامه مطلب</span>
			<?php viora_icon( 'arrow-left', array( 'size' => 17 ) ); ?>
		</a>
	</div>
</article>
