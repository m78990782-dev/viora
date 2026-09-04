<?php
/**
 * Mobile navigation panel.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
?>
<nav class="viora-mobile-nav" id="viora-mobile-nav" data-viora-panel="mobile-nav" aria-label="فهرست موبایل" hidden>

	<div class="viora-mobile-nav__head">
		<a class="viora-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<span class="viora-logo__mark" aria-hidden="true">V</span>
			<span class="viora-logo__text">VIORA</span>
		</a>

		<button type="button" class="viora-action" data-viora-close aria-label="بستن فهرست">
			<?php viora_icon( 'close' ); ?>
		</button>
	</div>

	<?php viora_mobile_nav(); ?>

	<div class="viora-mobile-nav__foot">
		<div class="viora-theme-toggle" role="group" aria-label="حالت نمایش">
			<button type="button" class="viora-theme-toggle__btn" data-viora-theme-set="light">
				<?php viora_icon( 'sun', array( 'size' => 16 ) ); ?>
				<span>روشن</span>
			</button>
			<button type="button" class="viora-theme-toggle__btn" data-viora-theme-set="dark">
				<?php viora_icon( 'moon', array( 'size' => 16 ) ); ?>
				<span>تاریک</span>
			</button>
		</div>

		<a class="viora-btn viora-btn--primary viora-btn--block" href="<?php echo esc_url( $viora_account_url ); ?>">
			<?php viora_icon( 'user', array( 'size' => 18 ) ); ?>
			<span>حساب کاربری</span>
		</a>

		<p class="viora-mobile-nav__contact">
			پشتیبانی: <?php echo esc_html( (string) viora_option( 'footer_phone' ) ); ?>
		</p>
	</div>
</nav>
