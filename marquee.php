<?php
/**
 * Home: infinite brand-promise strip.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_items = array(
	array( 'sparkle', 'طراحی اورجینال VIORA' ),
	array( 'truck', 'ارسال سریع به سراسر ایران' ),
	array( 'shield', 'ضمانت اصالت و کیفیت' ),
	array( 'refresh', 'تعویض آسان تا ۷ روز' ),
	array( 'card', 'پرداخت امن بانکی' ),
	array( 'gift', 'بسته‌بندی هدیه رایگان' ),
);
?>
<div class="viora-marquee" aria-hidden="true">
	<div class="viora-marquee__track">
		<?php
		// Rendered twice so the -50% keyframe loops seamlessly.
		for ( $viora_pass = 0; $viora_pass < 2; $viora_pass++ ) :
			foreach ( $viora_items as $viora_item ) :
				?>
				<span class="viora-marquee__item">
					<?php viora_icon( $viora_item[0], array( 'size' => 18 ) ); ?>
					<span><?php echo esc_html( $viora_item[1] ); ?></span>
				</span>
				<?php
			endforeach;
		endfor;
		?>
	</div>
</div>
