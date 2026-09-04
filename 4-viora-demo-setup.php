<?php
/**
 * VIORA demo deploy — one-shot domain rewrite.
 *
 * Run this ONCE after importing viora-demo.sql on the new host, then delete it.
 *
 * The exported database still carries the local development domain in
 * wp_options, post content, WooCommerce lookup tables and — critically — inside
 * PHP-serialized arrays (widgets, Customizer settings, WooCommerce settings).
 * A plain SQL "REPLACE" corrupts serialized data because the embedded string
 * lengths (s:22:"...") stop matching, so every value is unserialized, walked
 * recursively, rewritten and re-serialized here.
 *
 * Usage:
 *   1. Upload to the site root (next to wp-config.php).
 *   2. Open  https://YOUR-DOMAIN/viora-demo-setup.php?run=1
 *   3. Delete the file when the report says DONE.
 *
 * @package VIORA
 */

declare( strict_types=1 );

// The domain used while building the demo. Change only if you exported from
// somewhere else.
const VIORA_OLD_URL = 'http://nova-poshak.test';

/**
 * Guess the current site URL from the request.
 */
function viora_deploy_target_url(): string {
	$https  = ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== strtolower( (string) $_SERVER['HTTPS'] ) )
		|| ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === strtolower( (string) $_SERVER['HTTP_X_FORWARDED_PROTO'] ) );
	$scheme = $https ? 'https' : 'http';
	$host   = isset( $_SERVER['HTTP_HOST'] ) ? (string) $_SERVER['HTTP_HOST'] : 'localhost';

	return $scheme . '://' . rtrim( $host, '/' );
}

/**
 * Recursively replace inside any value, keeping serialized data valid.
 *
 * @param mixed  $value Value to walk.
 * @param string $from  Needle.
 * @param string $to    Replacement.
 * @return mixed
 */
function viora_deploy_replace( $value, string $from, string $to ) {
	if ( is_string( $value ) ) {
		// Nested serialized string: unserialize, rewrite, re-serialize.
		$data = @unserialize( $value ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		if ( false !== $data || 'b:0;' === $value ) {
			return serialize( viora_deploy_replace( $data, $from, $to ) );
		}

		return str_replace( $from, $to, $value );
	}

	if ( is_array( $value ) ) {
		$out = array();
		foreach ( $value as $k => $v ) {
			$key       = is_string( $k ) ? str_replace( $from, $to, $k ) : $k;
			$out[$key] = viora_deploy_replace( $v, $from, $to );
		}

		return $out;
	}

	if ( is_object( $value ) ) {
		$clone = clone $value;
		foreach ( get_object_vars( $clone ) as $k => $v ) {
			$clone->$k = viora_deploy_replace( $v, $from, $to );
		}

		return $clone;
	}

	return $value;
}

/**
 * Rewrite every text column of one table.
 *
 * @param wpdb   $db    Database handle.
 * @param string $table Table name.
 * @param string $from  Needle.
 * @param string $to    Replacement.
 * @return int Rows changed.
 */
function viora_deploy_table( $db, string $table, string $from, string $to ): int {
	$columns = $db->get_results( "DESCRIBE `{$table}`" ); // phpcs:ignore WordPress.DB
	if ( empty( $columns ) ) {
		return 0;
	}

	$keys = array();
	$text = array();

	foreach ( $columns as $col ) {
		if ( 'PRI' === $col->Key ) {
			$keys[] = $col->Field;
		}

		if ( preg_match( '/(char|text|blob|json)/i', (string) $col->Type ) ) {
			$text[] = $col->Field;
		}
	}

	if ( empty( $keys ) || empty( $text ) ) {
		return 0;
	}

	$changed = 0;
	$select  = array_unique( array_merge( $keys, $text ) );
	$list    = '`' . implode( '`,`', $select ) . '`';
	$where   = array();

	foreach ( $text as $column ) {
		$where[] = "`{$column}` LIKE '%" . $db->esc_like( $from ) . "%'";
	}

	$rows = $db->get_results(
		"SELECT {$list} FROM `{$table}` WHERE " . implode( ' OR ', $where ), // phpcs:ignore WordPress.DB
		ARRAY_A
	);

	if ( empty( $rows ) ) {
		return 0;
	}

	foreach ( $rows as $row ) {
		$update = array();

		foreach ( $text as $column ) {
			if ( ! isset( $row[$column] ) || '' === $row[$column] ) {
				continue;
			}

			$new = viora_deploy_replace( $row[$column], $from, $to );

			if ( $new !== $row[$column] ) {
				$update[$column] = $new;
			}
		}

		if ( empty( $update ) ) {
			continue;
		}

		$key_where = array();
		foreach ( $keys as $key ) {
			$key_where[$key] = $row[$key];
		}

		if ( false !== $db->update( $table, $update, $key_where ) ) {
			$changed++;
		}
	}

	return $changed;
}

// ---------------------------------------------------------------------------

header( 'Content-Type: text/html; charset=utf-8' );

$new_url = viora_deploy_target_url();
$run     = isset( $_GET['run'] ) && '1' === $_GET['run'];

?>
<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title>راه‌اندازی دموی VIORA</title>
	<style>
		body { background: #f7f5ff; color: #1a1524; font-family: Tahoma, system-ui, sans-serif; line-height: 1.9; margin: 0; padding: 2rem 1rem; }
		main { background: #fff; border: 1px solid #e4dff2; border-radius: 16px; margin-inline: auto; max-width: 760px; padding: 1.75rem; }
		h1 { font-size: 1.25rem; margin: 0 0 1rem; }
		code { background: #f2eefc; border-radius: 5px; padding: 0.1rem 0.35rem; }
		pre { background: #14101f; border-radius: 10px; color: #e8e3f5; direction: ltr; font-size: 0.82rem; max-height: 380px; overflow: auto; padding: 1rem; text-align: left; }
		.btn { background: linear-gradient(135deg, #6c45c7, #3d237a); border-radius: 999px; color: #fff; display: inline-block; font-weight: 700; padding: 0.8rem 1.8rem; text-decoration: none; }
		.warn { background: #fff6e5; border: 1px solid #f0d9a8; border-radius: 10px; padding: 0.85rem 1rem; }
		.ok { background: #e8f8ee; border: 1px solid #b6e3c6; border-radius: 10px; padding: 0.85rem 1rem; }
		table { border-collapse: collapse; width: 100%; }
		td, th { border-bottom: 1px solid #eee7fb; padding: 0.45rem 0.3rem; text-align: start; }
	</style>
</head>
<body>
<main>
	<h1>راه‌اندازی دموی VIORA</h1>

	<table>
		<tr><th>آدرس قدیمی (لوکال)</th><td><code><?php echo htmlspecialchars( VIORA_OLD_URL, ENT_QUOTES, 'UTF-8' ); ?></code></td></tr>
		<tr><th>آدرس جدید (این سایت)</th><td><code><?php echo htmlspecialchars( $new_url, ENT_QUOTES, 'UTF-8' ); ?></code></td></tr>
	</table>

<?php
if ( ! $run ) {
	?>
	<p class="warn">
		این ابزار آدرس سایت را در تمام جدول‌های دیتابیس (شامل داده‌های سریالایزشده)
		جایگزین می‌کند. قبل از اجرا از دیتابیس نسخه پشتیبان بگیرید.
	</p>
	<p><a class="btn" href="?run=1">اجرای جایگزینی</a></p>
	<?php
} else {
	require_once __DIR__ . '/wp-load.php';

	global $wpdb;

	$log    = array();
	$total  = 0;
	$tables = $wpdb->get_col( 'SHOW TABLES' ); // phpcs:ignore WordPress.DB

	foreach ( $tables as $table ) {
		$n = viora_deploy_table( $wpdb, $table, VIORA_OLD_URL, $new_url );

		if ( $n > 0 ) {
			$total += $n;
			$log[]  = sprintf( '%-34s %d rows', $table, $n );
		}
	}

	// Core URLs, explicit and last.
	update_option( 'siteurl', $new_url );
	update_option( 'home', $new_url );
	$log[] = sprintf( '%-34s %s', 'siteurl + home', $new_url );

	// Fresh permalinks and caches.
	flush_rewrite_rules();
	wp_cache_flush();
	$log[] = 'permalinks flushed';

	// WooCommerce lookup tables reference product permalinks.
	if ( class_exists( 'WooCommerce' ) ) {
		delete_transient( 'wc_products_onsale' );
		delete_transient( 'wc_featured_products' );
		if ( function_exists( 'wc_delete_product_transients' ) ) {
			wc_delete_product_transients();
		}
		$log[] = 'WooCommerce transients cleared';
	}

	$remaining = 0;
	foreach ( $tables as $table ) {
		$cols = $wpdb->get_results( "DESCRIBE `{$table}`" ); // phpcs:ignore WordPress.DB
		foreach ( $cols as $col ) {
			if ( preg_match( '/(char|text|blob|json)/i', (string) $col->Type ) ) {
				$remaining += (int) $wpdb->get_var(
					"SELECT COUNT(*) FROM `{$table}` WHERE `{$col->Field}` LIKE '%" . $wpdb->esc_like( VIORA_OLD_URL ) . "%'" // phpcs:ignore WordPress.DB
				);
			}
		}
	}
	?>
	<p class="ok">
		<strong>DONE</strong> — <?php echo (int) $total; ?> ردیف به‌روزرسانی شد.
		ردیف‌های باقی‌مانده با آدرس قدیمی: <strong><?php echo (int) $remaining; ?></strong>
	</p>

	<pre><?php echo htmlspecialchars( implode( "\n", $log ), ENT_QUOTES, 'UTF-8' ); ?></pre>

	<p class="warn">
		<strong>حالا این فایل را حذف کنید</strong> (<code>viora-demo-setup.php</code>)
		و سپس در پیشخوان به «تنظیمات ← پیوندهای یکتا» رفته و یک‌بار ذخیره را بزنید.
	</p>
	<?php
}
?>
</main>
</body>
</html>
