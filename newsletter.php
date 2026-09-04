<?php
/**
 * Home: newsletter sign-up.
 *
 * @package VIORA
 */

defined( 'ABSPATH' ) || exit;

if ( ! viora_enabled( 'news_enable' ) ) {
	return;
}
?>
<section class="viora-section" aria-labelledby="viora-news-title">
	<div class="viora-container">
		<div class="viora-newsletter"<?php echo viora_reveal( 0, 'zoom' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<div class="viora-newsletter__inner">

				<div>
					<h2 class="viora-newsletter__title" id="viora-news-title">
						<?php echo esc_html( (string) viora_option( 'news_title' ) ); ?>
					</h2>
					<p class="viora-newsletter__text"><?php echo esc_html( (string) viora_option( 'news_text' ) ); ?></p>
				</div>

				<div class="viora-newsletter__side">
					<form class="viora-newsletter__form" data-viora-newsletter novalidate>
						<label class="viora-visually-hidden" for="viora-newsletter-email">ایمیل شما</label>
						<input
							type="email"
							id="viora-newsletter-email"
							class="viora-newsletter__input"
							name="email"
							placeholder="<?php echo esc_attr( (string) viora_option( 'news_placeholder' ) ); ?>"
							autocomplete="email"
							required
							dir="ltr">

						<button type="submit" class="viora-btn viora-btn--deep">
							<span class="viora-btn__spinner" aria-hidden="true"></span>
							<span class="viora-btn__label"><?php echo esc_html( (string) viora_option( 'news_button' ) ); ?></span>
						</button>
					</form>

					<p class="viora-newsletter__message" data-viora-newsletter-message role="status" aria-live="polite"></p>

					<p class="viora-newsletter__note">
						با عضویت، پیشنهادهای ویژه را زودتر از دیگران دریافت می‌کنید. هر زمان بخواهید می‌توانید لغو عضویت کنید.
					</p>
				</div>

			</div>
		</div>
	</div>
</section>
