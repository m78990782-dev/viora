<?php
/**
 * Live search overlay.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

$viora_suggestions = array();

if ( taxonomy_exists( 'product_cat' ) ) {
	$viora_terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'number'     => 5,
			'orderby'    => 'count',
			'order'      => 'DESC',
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
		)
	);

	if ( is_array( $viora_terms ) ) {
		$viora_suggestions = $viora_terms;
	}
}
?>
<div class="viora-search" id="viora-search" data-viora-panel="search" role="dialog" aria-modal="true" aria-label="جستجوی محصول" hidden>
	<div class="viora-search__backdrop" data-viora-close></div>

	<div class="viora-search__panel">
		<form class="viora-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" data-viora-search-form>
			<label class="viora-visually-hidden" for="viora-search-input">جستجوی محصول</label>
			<?php viora_icon( 'search', array( 'size' => 20 ) ); ?>
			<input
				type="search"
				id="viora-search-input"
				class="viora-search__input"
				name="s"
				value=""
				placeholder="جستجوی محصول..."
				autocomplete="off"
				data-viora-search-input>
			<input type="hidden" name="post_type" value="product">
			<button type="button" class="viora-action" data-viora-close aria-label="بستن جستجو">
				<?php viora_icon( 'close' ); ?>
			</button>
		</form>

		<p class="viora-search__hint" data-viora-search-hint>برای جستجو حداقل دو حرف وارد کنید.</p>

		<div class="viora-search__results" data-viora-search-results></div>

		<?php if ( $viora_suggestions ) : ?>
			<div class="viora-search__suggestions">
				<?php foreach ( $viora_suggestions as $viora_term ) : ?>
					<a class="viora-chip" href="<?php echo esc_url( (string) get_term_link( $viora_term ) ); ?>">
						<?php echo esc_html( $viora_term->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
