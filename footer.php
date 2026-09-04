<?php
/**
 * Site footer: link columns, contact block, bottom bar, mobile bottom nav.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_shop_url     = viora_shop_url();
$viora_account_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
$viora_cart_url     = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' );
$viora_wishlist_url = $viora_account_url ? trailingslashit( $viora_account_url ) . 'wishlist/' : home_url( '/' );

$viora_socials = array(
	'instagram' => array( 'label' => 'اینستاگرام', 'icon' => 'instagram' ),
	'telegram'  => array( 'label' => 'تلگرام', 'icon' => 'telegram' ),
	'whatsapp'  => array( 'label' => 'واتساپ', 'icon' => 'whatsapp' ),
	'pinterest' => array( 'label' => 'پینترست', 'icon' => 'pinterest' ),
);

/**
 * Footer column: a registered menu when available, otherwise a Persian fallback.
 *
 * @param string $location Menu location.
 * @param array  $fallback Fallback items (label => url).
 */
$viora_footer_column = static function ( string $location, array $fallback ): void {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => 'viora-footer__list',
				'depth'          => 1,
			)
		);

		return;
	}

	echo '<ul class="viora-footer__list">';
	foreach ( $fallback as $label => $url ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
};
?>

	<footer class="viora-footer" role="contentinfo">
		<span class="viora-orb viora-orb--lavender" style="inset-inline-start:-140px;inset-block-start:-80px;width:360px;height:360px" aria-hidden="true"></span>
		<span class="viora-orb viora-orb--primary" style="inset-inline-end:-120px;inset-block-end:-120px;width:300px;height:300px" aria-hidden="true"></span>

		<div class="viora-container">
			<div class="viora-footer__top">

				<div class="viora-footer__col viora-footer__col--brand">
					<?php if ( has_custom_logo() ) : ?>
						<div class="viora-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<a class="viora-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<span class="viora-logo__mark" aria-hidden="true">V</span>
							<span class="viora-logo__text">VIORA</span>
						</a>
					<?php endif; ?>

					<p class="viora-footer__about"><?php echo esc_html( (string) viora_option( 'footer_about' ) ); ?></p>

					<div class="viora-socials">
						<?php
						foreach ( $viora_socials as $viora_key => $viora_social ) :
							$viora_url = (string) viora_option( 'social_' . $viora_key );

							if ( ! $viora_url ) {
								continue;
							}
							?>
							<a
								class="viora-social"
								href="<?php echo esc_url( $viora_url ); ?>"
								target="_blank"
								rel="noopener noreferrer"
								aria-label="<?php echo esc_attr( $viora_social['label'] . ' VIORA' ); ?>">
								<?php viora_icon( $viora_social['icon'], array( 'size' => 19 ) ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="viora-footer__col">
					<h2 class="viora-footer__title">خدمات مشتریان</h2>
					<?php
					$viora_footer_column(
						'footer-service',
						array(
							'حساب کاربری'   => $viora_account_url,
							'سبد خرید'      => $viora_cart_url,
							'علاقه‌مندی‌ها' => $viora_wishlist_url,
							'پیگیری سفارش'  => $viora_account_url ? trailingslashit( $viora_account_url ) . 'orders/' : $viora_shop_url,
							'تماس با ما'    => home_url( '/contact/' ),
						)
					);
					?>
				</div>

				<div class="viora-footer__col">
					<h2 class="viora-footer__title">راهنمای خرید</h2>
					<?php
					$viora_footer_column(
						'footer-guide',
						array(
							'راهنمای سایزبندی'    => home_url( '/size-guide/' ),
							'شرایط ارسال'         => home_url( '/shipping/' ),
							'بازگشت کالا'         => home_url( '/returns/' ),
							'سوالات متداول'       => home_url( '/faq/' ),
							'قوانین و مقررات'     => home_url( '/terms/' ),
						)
					);
					?>
				</div>

				<div class="viora-footer__col">
					<h2 class="viora-footer__title">دسته‌بندی‌ها</h2>
					<?php
					$viora_fallback_cats = array();

					if ( taxonomy_exists( 'product_cat' ) ) {
						$viora_cat_terms = get_terms(
							array(
								'taxonomy'   => 'product_cat',
								'hide_empty' => false,
								'number'     => 5,
								'parent'     => 0,
								'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
							)
						);

						if ( is_array( $viora_cat_terms ) ) {
							foreach ( $viora_cat_terms as $viora_cat_term ) {
								$viora_cat_link = get_term_link( $viora_cat_term );
								if ( ! is_wp_error( $viora_cat_link ) ) {
									$viora_fallback_cats[ $viora_cat_term->name ] = $viora_cat_link;
								}
							}
						}
					}

					if ( ! $viora_fallback_cats ) {
						$viora_fallback_cats = array(
							'زنانه'     => $viora_shop_url,
							'مردانه'    => $viora_shop_url,
							'استریت‌ور' => $viora_shop_url,
							'اکسسوری'   => $viora_shop_url,
						);
					}

					$viora_footer_column( 'footer-categories', $viora_fallback_cats );
					?>
				</div>

				<div class="viora-footer__col viora-footer__col--contact">
					<h2 class="viora-footer__title">تماس با ما</h2>

					<div class="viora-footer__contact">
						<?php if ( viora_option( 'footer_phone' ) ) : ?>
							<p class="viora-footer__contact-item">
								<?php viora_icon( 'phone', array( 'size' => 18 ) ); ?>
								<span><?php echo esc_html( (string) viora_option( 'footer_phone' ) ); ?></span>
							</p>
						<?php endif; ?>

						<?php if ( viora_option( 'footer_email' ) ) : ?>
							<p class="viora-footer__contact-item">
								<?php viora_icon( 'mail', array( 'size' => 18 ) ); ?>
								<a href="mailto:<?php echo esc_attr( (string) viora_option( 'footer_email' ) ); ?>" dir="ltr">
									<?php echo esc_html( (string) viora_option( 'footer_email' ) ); ?>
								</a>
							</p>
						<?php endif; ?>

						<?php if ( viora_option( 'footer_address' ) ) : ?>
							<p class="viora-footer__contact-item">
								<?php viora_icon( 'location', array( 'size' => 18 ) ); ?>
								<span><?php echo esc_html( (string) viora_option( 'footer_address' ) ); ?></span>
							</p>
						<?php endif; ?>

					<p class="viora-footer__contact-item">
						<?php viora_icon( 'headset', array( 'size' => 18 ) ); ?>
						<span>پاسخگویی: شنبه تا پنجشنبه، ۹ تا ۲۱</span>
					</p>
					</div>

					<div class="viora-footer__trust">
						<h2 class="viora-footer__title">نماد اعتماد</h2>
						<?php
						$viora_trust_url = (string) viora_option( 'footer_trust_url' );

						if ( $viora_trust_url ) :
							?>
							<a
								class="viora-footer__trust-link"
								href="<?php echo esc_url( $viora_trust_url ); ?>"
								target="_blank"
								rel="noopener noreferrer"
								aria-label="مشاهده صفحه‌ی تأیید نماد اعتماد VIORA">
								<img
									class="viora-footer__trust-img"
									src="<?php echo esc_url( viora_asset( 'assets/img/enamad.webp' ) ); ?>"
									alt="نماد اعتماد الکترونیکی VIORA"
									width="498"
									height="498"
									loading="lazy"
									decoding="async">
							</a>
						<?php else : ?>
							<img
								class="viora-footer__trust-img"
								src="<?php echo esc_url( viora_asset( 'assets/img/enamad.webp' ) ); ?>"
								alt="نماد اعتماد الکترونیکی VIORA"
								width="498"
								height="498"
								loading="lazy"
								decoding="async">
						<?php endif; ?>
					</div>
				</div>

			</div>

			<div class="viora-footer__bottom">
				<p class="viora-footer__copy">
					© <?php echo esc_html( viora_num( (string) wp_date( 'Y' ) ) ); ?> —
					<?php echo esc_html( (string) viora_option( 'footer_copyright' ) ); ?>
				</p>

				<p class="viora-footer__payments">
					<?php viora_icon( 'card', array( 'size' => 18 ) ); ?>
					<span>پرداخت امن از طریق درگاه‌های بانکی معتبر</span>
					<?php viora_icon( 'shield', array( 'size' => 18 ) ); ?>
				</p>
			</div>
		</div>
	</footer>

	<nav class="viora-bottom-nav" aria-label="فهرست پایین صفحه">
		<ul class="viora-bottom-nav__list">
			<li>
				<a class="viora-bottom-nav__link<?php echo is_front_page() ? ' is-current' : ''; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="viora-bottom-nav__icon">
						<?php viora_icon( 'home', array( 'size' => 21 ) ); ?>
					</span>
					<span>خانه</span>
				</a>
			</li>
			<li>
				<a class="viora-bottom-nav__link<?php echo ( function_exists( 'is_shop' ) && is_shop() ) ? ' is-current' : ''; ?>" href="<?php echo esc_url( $viora_shop_url ); ?>">
					<span class="viora-bottom-nav__icon">
						<?php viora_icon( 'shop', array( 'size' => 21 ) ); ?>
					</span>
					<span>فروشگاه</span>
				</a>
			</li>
			<li>
				<button type="button" class="viora-bottom-nav__link" data-viora-open="search" aria-controls="viora-search" aria-expanded="false">
					<span class="viora-bottom-nav__icon">
						<?php viora_icon( 'search', array( 'size' => 21 ) ); ?>
					</span>
					<span>جستجو</span>
				</button>
			</li>
			<li>
				<a class="viora-bottom-nav__link" href="<?php echo esc_url( $viora_wishlist_url ); ?>">
					<span class="viora-bottom-nav__icon">
						<?php viora_icon( 'heart', array( 'size' => 21 ) ); ?>
						<span class="viora-action__count<?php echo viora_wishlist_count() ? ' is-filled' : ''; ?>" data-viora-wishlist-count>
							<?php echo esc_html( viora_num( viora_wishlist_count() ) ); ?>
						</span>
					</span>
					<span>علاقه‌مندی</span>
				</a>
			</li>
			<li>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<button type="button" class="viora-bottom-nav__link" data-viora-open="cart" aria-controls="viora-cart-drawer" aria-expanded="false">
						<span class="viora-bottom-nav__icon">
							<?php viora_icon( 'bag', array( 'size' => 21 ) ); ?>
							<?php viora_cart_bubble(); ?>
						</span>
						<span>سبد</span>
					</button>
				<?php else : ?>
					<a class="viora-bottom-nav__link" href="<?php echo esc_url( $viora_cart_url ); ?>">
						<span class="viora-bottom-nav__icon">
							<?php viora_icon( 'bag', array( 'size' => 21 ) ); ?>
						</span>
						<span>سبد</span>
					</a>
				<?php endif; ?>
			</li>
		</ul>
	</nav>

</div><!-- /.viora-site -->

<?php wp_footer(); ?>
</body>
</html>
