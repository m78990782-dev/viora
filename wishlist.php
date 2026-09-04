<?php
/**
 * My Account → wishlist endpoint.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_ids = viora_wishlist_ids();

if ( ! $viora_ids ) {
	viora_empty_state(
		array(
			'icon'      => 'heart',
			'title'     => 'لیست علاقه‌مندی‌های شما خالی است.',
			'text'      => 'محصولاتی که دوست دارید را با زدن آیکون قلب ذخیره کنید.',
			'cta_label' => 'مشاهده فروشگاه',
		)
	);

	return;
}

$viora_query = new WP_Query(
	array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'post__in'            => $viora_ids,
		'orderby'             => 'post__in',
		'posts_per_page'      => 24,
		'ignore_sticky_posts' => true,
	)
);
?>
<div class="viora-wishlist">
	<div class="viora-wishlist__head">
		<h2 style="font-size:1.25rem">علاقه‌مندی‌ها</h2>
		<p class="viora-shop-toolbar__count">
			<?php echo esc_html( sprintf( '%s محصول ذخیره شده', viora_num( (string) $viora_query->found_posts ) ) ); ?>
		</p>
	</div>

	<?php if ( $viora_query->have_posts() ) : ?>
		<ul class="viora-products viora-products--3">
			<?php
			$GLOBALS['viora_card_index'] = 0;

			while ( $viora_query->have_posts() ) :
				$viora_query->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
			?>
		</ul>
	<?php else : ?>
		<?php
		viora_empty_state(
			array(
				'icon'      => 'heart',
				'title'     => 'محصولات ذخیره‌شده دیگر در دسترس نیستند.',
				'cta_label' => 'مشاهده فروشگاه',
			)
		);
		?>
	<?php endif; ?>
</div>
<?php
wp_reset_postdata();
