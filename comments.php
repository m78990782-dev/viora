<?php
/**
 * Comments template.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="viora-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="viora-section__title" style="font-size:1.35rem">
			<?php
			$viora_count = (int) get_comments_number();

			echo esc_html(
				1 === $viora_count
					? 'یک نظر'
					: sprintf( '%s نظر', viora_num( (string) $viora_count ) )
			);
			?>
		</h2>

		<ol class="viora-comments__list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 44,
					'callback'    => 'viora_comment_callback',
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => viora_get_icon( 'chev-right', array( 'size' => 18 ) ),
				'next_text' => viora_get_icon( 'chev-left', array( 'size' => 18 ) ),
			)
		);
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="viora-notice">امکان ارسال نظر برای این مطلب بسته شده است.</p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'          => 'نظر خود را بنویسید',
			'title_reply_to'       => 'پاسخ به %s',
			'cancel_reply_link'    => 'لغو پاسخ',
			'label_submit'         => 'ارسال نظر',
			'class_submit'         => 'viora-btn viora-btn--primary',
			'comment_notes_before' => '<p class="viora-newsletter__note" style="color:var(--v-text-muted)">نشانی ایمیل شما منتشر نمی‌شود.</p>',
			'comment_field'        => '<p class="viora-field"><label for="comment">نظر شما</label><textarea id="comment" name="comment" class="viora-input" rows="5" required></textarea></p>',
			'fields'               => array(
				'author' => '<p class="viora-field"><label for="author">نام</label><input id="author" name="author" type="text" class="viora-input" required></p>',
				'email'  => '<p class="viora-field"><label for="email">ایمیل</label><input id="email" name="email" type="email" class="viora-input" dir="ltr" required></p>',
			),
		)
	);
	?>
</section>
