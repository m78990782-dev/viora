<?php
/**
 * Product share row — VIORA.
 *
 * Native share where available, with copy-link and the brand social channels as
 * the fallback. `woocommerce_share` is still fired so sharing plugins keep
 * working.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$viora_url   = get_permalink();
$viora_title = get_the_title();

$viora_targets = array(
	'telegram' => 'https://t.me/share/url?url=' . rawurlencode( (string) $viora_url ) . '&text=' . rawurlencode( (string) $viora_title ),
	'whatsapp' => 'https://wa.me/?text=' . rawurlencode( $viora_title . ' ' . $viora_url ),
	'x'        => 'https://twitter.com/intent/tweet?url=' . rawurlencode( (string) $viora_url ) . '&text=' . rawurlencode( (string) $viora_title ),
	'mail'     => 'mailto:?subject=' . rawurlencode( (string) $viora_title ) . '&body=' . rawurlencode( (string) $viora_url ),
);

$viora_labels = array(
	'telegram' => 'اشتراک‌گذاری در تلگرام',
	'whatsapp' => 'اشتراک‌گذاری در واتساپ',
	'x'        => 'اشتراک‌گذاری در ایکس',
	'mail'     => 'ارسال با ایمیل',
);
?>
<div class="viora-share">
	<span class="viora-share__label">اشتراک‌گذاری:</span>

	<?php foreach ( $viora_targets as $viora_key => $viora_href ) : ?>
		<a
			class="viora-share__btn"
			href="<?php echo esc_url( $viora_href ); ?>"
			target="_blank"
			rel="noopener nofollow"
			aria-label="<?php echo esc_attr( $viora_labels[ $viora_key ] ); ?>"
		>
			<?php viora_icon( $viora_key, array( 'size' => 17 ) ); ?>
		</a>
	<?php endforeach; ?>
</div>

<?php
// Sharing plugins can still hook in here.
do_action( 'woocommerce_share' );
