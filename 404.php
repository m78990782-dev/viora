<?php
/**
 * 404.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="viora-main" class="viora-main">
	<div class="viora-container">

		<div class="viora-empty" style="min-height:52vh">
			<span class="viora-empty__icon" aria-hidden="true"><?php viora_icon( 'sparkle', array( 'size' => 46 ) ); ?></span>

			<p class="viora-gradient-text" style="font-size:clamp(3.5rem,12vw,7rem);font-weight:800;line-height:1">۴۰۴</p>

			<h1>این صفحه پیدا نشد.</h1>
			<p>ممکن است نشانی تغییر کرده باشد یا محصول از کالکشن حذف شده باشد.</p>

			<div class="viora-row" style="justify-content:center">
				<a class="viora-btn viora-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="viora-btn__label">بازگشت به خانه</span>
				</a>
				<a class="viora-btn viora-btn--outline" href="<?php echo esc_url( viora_shop_url() ); ?>">
					<span class="viora-btn__label">مشاهده فروشگاه</span>
				</a>
			</div>

			<div style="max-width:520px;width:100%;margin-top:1.5rem">
				<?php get_search_form(); ?>
			</div>
		</div>

		<?php
		if ( function_exists( 'viora_products_query' ) ) :
			$viora_query = viora_products_query( 'best', 4 );

			if ( $viora_query->have_posts() ) :
				?>
				<section class="viora-section viora-section--tight" aria-labelledby="viora-404-suggest">
					<header class="viora-section__head">
						<div class="viora-section__titles">
							<h2 class="viora-section__title" id="viora-404-suggest" style="font-size:1.5rem">شاید این‌ها را بخواهید</h2>
						</div>
					</header>

					<ul class="viora-products">
						<?php
						$GLOBALS['viora_card_index'] = 0;

						while ( $viora_query->have_posts() ) :
							$viora_query->the_post();
							wc_get_template_part( 'content', 'product' );
						endwhile;
						?>
					</ul>
				</section>
				<?php
			endif;

			wp_reset_postdata();
		endif;
		?>

	</div>
</main>
<?php
get_footer();
