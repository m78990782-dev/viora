<?php
/**
 * Blog sidebar.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>
<aside class="viora-sidebar" aria-label="نوار کناری وبلاگ">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside>
