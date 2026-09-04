<?php
/**
 * Announcement bar.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'topbar_enable' ) ) {
	return;
}

$viora_text  = (string) viora_option( 'topbar_text' );
$viora_label = (string) viora_option( 'topbar_link_label' );
$viora_url   = (string) viora_option( 'topbar_link_url' );

if ( ! $viora_text ) {
	return;
}
?>
<div class="viora-topbar" data-viora-topbar hidden>
	<div class="viora-container">
		<div class="viora-topbar__inner">
			<?php viora_icon( 'sparkle', array( 'size' => 16 ) ); ?>
			<p class="viora-topbar__text"><?php echo esc_html( $viora_text ); ?></p>

			<?php if ( $viora_label ) : ?>
				<a class="viora-topbar__link" href="<?php echo esc_url( $viora_url ?: viora_shop_url() ); ?>">
					<?php echo esc_html( $viora_label ); ?>
				</a>
			<?php endif; ?>

			<button type="button" class="viora-topbar__close" data-viora-topbar-close aria-label="بستن نوار اعلان">
				<?php viora_icon( 'close', array( 'size' => 16 ) ); ?>
			</button>
		</div>
	</div>
</div>
