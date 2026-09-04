<?php
/**
 * VIORA theme bootstrap.
 *
 * Loads every module of the theme. Keep this file free of output and logic:
 * each concern lives in its own file under /inc.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

define( 'VIORA_VERSION', '1.7.1' );
define( 'VIORA_DIR', get_template_directory() );
define( 'VIORA_URI', get_template_directory_uri() );

/*
 * RTL-Theme (راست‌چین) license.
 *
 * The marketplace license class sits next to THIS file:
 *
 *     wp-content/themes/viora/RTL_License_6392c4291d4c7ca0.php
 *
 * so the verification snippet has to run from the theme root where __DIR__
 * resolves there. inc/license.php is plain PHP and is loaded first: it supplies
 * the hash check and the ionCube Loader probe. Both are required before the
 * class is included, because the encoded file aborts the request with
 * exit(199) when the loader is missing — which would take wp-admin down too.
 *
 * The outcome is frozen into VIORA_LICENSED and inc/license.php turns it into
 * behaviour: front-end gate, dashboard notice, demo importer guard.
 *
 * Local development: define VIORA_LICENSE_BYPASS as true in wp-config.php.
 * That constant lives outside the theme, so it never ships to a buyer.
 */
require_once VIORA_DIR . '/inc/license.php';

$viora_licensed = viora_license_bypassed();

if ( ! $viora_licensed && viora_license_file_ok() && extension_loaded( 'ionCube Loader' ) ) {
	// --------------------------------------------------------------------------------------------------- Start RTL License
	$rtlLicenseClassName  = 'RTL_License_6392c4291d4c7ca0';
	$rtlLicenseFilePath   = __DIR__ . DIRECTORY_SEPARATOR . $rtlLicenseClassName . '.php';
	$rtlLicenseFileHash   = @sha1_file($rtlLicenseFilePath);

	if ( $rtlLicenseFileHash === '620c13cd557ffba033e9ca656f280038b367cdb2' && file_exists($rtlLicenseFilePath) ) {
		require_once $rtlLicenseFilePath;

		if ( class_exists($rtlLicenseClassName) && method_exists($rtlLicenseClassName, 'isActive') ) {
			$rtlLicenseClass = new $rtlLicenseClassName();

			if ( $rtlLicenseClass->{'isActive'}() === true ) {
				// Product is Active Now, Enable Pro Features
				$viora_licensed = true;
			}
		}
	}
	// ----------------------------------------------------------------------------------------------------- End RTL License

	unset( $rtlLicenseClassName, $rtlLicenseFilePath, $rtlLicenseFileHash, $rtlLicenseClass );
}

define( 'VIORA_LICENSED', (bool) $viora_licensed );
unset( $viora_licensed );

/**
 * Theme modules.
 *
 * setup          Theme supports, menus, image sizes, sidebars.
 * template-tags  Reusable output helpers (responsive picture, video, icons, prices).
 * enqueue        Styles, scripts and inline design tokens.
 * customizer     Every visual/text option exposed to the site owner.
 * wishlist       Cookie + user-meta backed wishlist.
 * ajax           Live search, cart drawer, shop filters, quick view, newsletter.
 * nav-walker     Nav menu walker with mega-menu / badge support.
 * woocommerce    WooCommerce hook surgery and template glue.
 * demo-content   One-command demo import (WP-CLI or admin screen).
 */
if ( ! viora_license_loader_ready() ) {
	viora_license_loader_halt();

	return;
}

require_once VIORA_DIR . '/inc/setup.php';
require_once VIORA_DIR . '/inc/template-tags.php';
require_once VIORA_DIR . '/inc/enqueue.php';
require_once VIORA_DIR . '/inc/customizer.php';
require_once VIORA_DIR . '/inc/nav-walker.php';
require_once VIORA_DIR . '/inc/wishlist.php';
require_once VIORA_DIR . '/inc/ajax.php';
require_once VIORA_DIR . '/inc/demo-content.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once VIORA_DIR . '/inc/woocommerce.php';
}
