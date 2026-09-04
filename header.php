<?php
/**
 * Site header: announcement bar, floating glass header, overlays.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_wishlist_count = viora_wishlist_count();
$viora_account_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
$viora_wishlist_url   = $viora_account_url ? trailingslashit( $viora_account_url ) . 'wishlist/' : home_url( '/' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="viora-skip-link" href="#viora-main">پرش به محتوای اصلی</a>

<div class="viora-site" id="viora-site">

	<?php get_template_part( 'template-parts/header/topbar' ); ?>

	<header class="viora-header" data-viora-header>
		<div class="viora-container">
			<div class="viora-header__inner">

				<div class="viora-header__brand">
					<button
						type="button"
						class="viora-action viora-burger"
						data-viora-open="mobile-nav"
						aria-expanded="false"
						aria-controls="viora-mobile-nav"
						aria-label="نمایش فهرست">
						<span class="viora-burger__bars" aria-hidden="true"><span></span><span></span><span></span></span>
					</button>

					<?php if ( has_custom_logo() ) : ?>
						<div class="viora-logo"><?php the_custom_logo(); ?></div>
					<?php else : ?>
						<a class="viora-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<span class="viora-logo__mark" aria-hidden="true">V</span>
							<span>
								<span class="viora-logo__text">VIORA</span>
								<?php if ( get_bloginfo( 'description' ) ) : ?>
									<span class="viora-logo__tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></span>
								<?php endif; ?>
							</span>
						</a>
					<?php endif; ?>
				</div>

				<nav class="viora-nav" aria-label="فهرست اصلی">
					<?php viora_primary_nav(); ?>
				</nav>

			<div class="viora-header__actions">
				<button
					type="button"
					class="viora-action viora-action--search"
					data-viora-open="search"
					aria-label="جستجوی محصول"
					aria-expanded="false"
					aria-controls="viora-search">
					<?php viora_icon( 'search' ); ?>
				</button>

				<button
					type="button"
					class="viora-action viora-action--theme"
					data-viora-theme-toggle
					aria-pressed="false"
					aria-label="تغییر به حالت تاریک"
					title="حالت تاریک">
					<span class="viora-action__sun"><?php viora_icon( 'sun' ); ?></span>
					<span class="viora-action__moon viora-visually-hidden"><?php viora_icon( 'moon' ); ?></span>
				</button>

				<a class="viora-action viora-action--account" href="<?php echo esc_url( $viora_account_url ); ?>" aria-label="حساب کاربری">
					<?php viora_icon( 'user' ); ?>
				</a>

				<a class="viora-action viora-action--wishlist" href="<?php echo esc_url( $viora_wishlist_url ); ?>" aria-label="علاقه‌مندی‌ها">
					<?php viora_icon( 'heart' ); ?>
					<span class="viora-action__count<?php echo $viora_wishlist_count ? ' is-filled' : ''; ?>" data-viora-wishlist-count>
						<?php echo esc_html( viora_num( $viora_wishlist_count ) ); ?>
					</span>
				</a>

				<button
					type="button"
					class="viora-action viora-action--cta viora-action--cart"
					data-viora-open="cart"
					aria-label="سبد خرید"
					aria-expanded="false"
					aria-controls="viora-cart-drawer">
					<?php viora_icon( 'bag' ); ?>
					<?php if ( function_exists( 'viora_cart_bubble' ) ) : ?>
						<?php viora_cart_bubble(); ?>
					<?php endif; ?>
				</button>
			</div>

			</div>
		</div>
	</header>

	<?php
	get_template_part( 'template-parts/header/mobile-nav' );
	get_template_part( 'template-parts/header/search' );

	if ( class_exists( 'WooCommerce' ) ) {
		get_template_part( 'template-parts/cart/drawer' );
	}
	?>

	<div class="viora-overlay" data-viora-overlay hidden></div>

	<div class="viora-modal" id="viora-modal" data-viora-modal role="dialog" aria-modal="true" aria-label="مشاهده سریع محصول" hidden>
		<div class="viora-modal__backdrop" data-viora-close></div>
		<div class="viora-modal__panel">
			<button type="button" class="viora-modal__close" data-viora-close aria-label="بستن">
				<?php viora_icon( 'close' ); ?>
			</button>
			<div class="viora-modal__body" data-viora-modal-body></div>
		</div>
	</div>

	<div class="viora-toasts" data-viora-toasts role="status" aria-live="polite" aria-atomic="true"></div>
