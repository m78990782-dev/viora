<?php
/**
 * Search form.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_form_id = 'viora-searchform-' . wp_unique_id();
?>
<form role="search" method="get" class="viora-search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="viora-visually-hidden" for="<?php echo esc_attr( $viora_form_id ); ?>">جستجو در سایت</label>

	<?php viora_icon( 'search', array( 'size' => 20 ) ); ?>

	<input
		type="search"
		id="<?php echo esc_attr( $viora_form_id ); ?>"
		class="viora-search__input"
		name="s"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="جستجوی محصول..."
		autocomplete="off">

	<button type="submit" class="viora-btn viora-btn--primary viora-btn--sm">
		<span class="viora-btn__label">جستجو</span>
	</button>
</form>
