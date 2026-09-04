<?php
/**
 * Review meta (author, verified badge, date) — VIORA.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;

if ( '0' === $comment->comment_approved ) {
	?>
	<p class="meta">
		<em class="woocommerce-review__awaiting-approval">نظر شما در انتظار تأیید است.</em>
	</p>
	<?php

	return;
}

$viora_verified = wc_review_is_from_verified_owner( $comment->comment_ID );
?>
<p class="meta">
	<strong class="woocommerce-review__author"><?php comment_author(); ?></strong>

	<?php if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $viora_verified ) : ?>
		<em class="woocommerce-review__verified verified">
			<?php viora_icon( 'check', array( 'size' => 13 ) ); ?>خریدار محصول
		</em>
	<?php endif; ?>

	<span class="woocommerce-review__dash" aria-hidden="true">–</span>

	<time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>">
		<?php echo esc_html( viora_num( get_comment_date( wc_date_format() ) ) ); ?>
	</time>
</p>
