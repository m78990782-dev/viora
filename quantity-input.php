<?php
/**
 * Product quantity input — VIORA stepper.
 *
 * Wraps the native number field in the theme's minus/plus stepper. The markup
 * contract is read by assets/js/viora.js:
 *   [data-viora-qty]        wrapper
 *   [data-viora-qty-down]   decrement button
 *   [data-viora-qty-input]  the field itself
 *   [data-viora-qty-up]     increment button
 *
 * The `quantity` class is kept so WooCommerce core JS (variation forms, cart
 * table) keeps working, and `.qty` is kept for the same reason.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 10.1.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

defined( 'ABSPATH' ) || exit;

$viora_label = ! empty( $args['product_name'] )
	? sprintf( 'تعداد %s', wp_strip_all_tags( $args['product_name'] ) )
	: 'تعداد';

// A read-only quantity (single-item grouped rows) needs no stepper buttons.
if ( $readonly ) {
	?>
	<div class="quantity viora-qty viora-qty--static">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>

		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $viora_label ); ?></label>

		<input
			type="<?php echo esc_attr( $type ); ?>"
			readonly="readonly"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			aria-label="<?php echo esc_attr( $viora_label ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			<?php if ( 0 < $max_value ) : ?>
				max="<?php echo esc_attr( $max_value ); ?>"
			<?php endif; ?>
			data-viora-qty-input
		/>

		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php

	return;
}
?>
<div class="quantity viora-qty" data-viora-qty>
	<?php
	/**
	 * Hook to output something before the quantity input field.
	 *
	 * @since 7.2.0
	 */
	do_action( 'woocommerce_before_quantity_input_field' );
	?>

	<button type="button" class="viora-qty__btn" data-viora-qty-down aria-label="کاهش تعداد" tabindex="-1">
		<?php viora_icon( 'minus', array( 'size' => 16 ) ); ?>
	</button>

	<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $viora_label ); ?></label>

	<input
		type="<?php echo esc_attr( $type ); ?>"
		id="<?php echo esc_attr( $input_id ); ?>"
		class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		aria-label="<?php echo esc_attr( $viora_label ); ?>"
		<?php if ( in_array( $type, array( 'text', 'search', 'tel', 'url', 'email', 'password' ), true ) ) : ?>
			size="4"
		<?php endif; ?>
		min="<?php echo esc_attr( $min_value ); ?>"
		<?php if ( 0 < $max_value ) : ?>
			max="<?php echo esc_attr( $max_value ); ?>"
		<?php endif; ?>
		step="<?php echo esc_attr( $step ); ?>"
		placeholder="<?php echo esc_attr( $placeholder ); ?>"
		inputmode="<?php echo esc_attr( $inputmode ); ?>"
		autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'off' ); ?>"
		data-viora-qty-input
	/>

	<button type="button" class="viora-qty__btn" data-viora-qty-up aria-label="افزایش تعداد" tabindex="-1">
		<?php viora_icon( 'plus', array( 'size' => 16 ) ); ?>
	</button>

	<?php
	/**
	 * Hook to output something after quantity input field.
	 *
	 * @since 3.6.0
	 */
	do_action( 'woocommerce_after_quantity_input_field' );
	?>
</div>
