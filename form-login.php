<?php
/**
 * My Account login / register — VIORA.
 *
 * Login and registration sit side by side in `.viora-auth-grid`.
 * Field names, IDs and nonces are unchanged so WooCommerce processes both
 * forms exactly as it does with the core template.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package VIORA
 * @version 9.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );

$viora_registration = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );
?>
<div class="<?php echo $viora_registration ? 'viora-auth-grid u-columns col2-set' : 'viora-auth-single'; ?>" id="customer_login">

	<div class="u-column1 col-1">
		<h2 class="viora-auth__title">
			<?php viora_icon( 'user', array( 'size' => 20 ) ); ?>
			<span>ورود به حساب کاربری</span>
		</h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post" novalidate>

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username">نام کاربری یا ایمیل&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">الزامی</span></label>
				<input
					type="text"
					class="woocommerce-Input woocommerce-Input--text input-text"
					name="username"
					id="username"
					autocomplete="username"
					value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification ?>"
					required
					aria-required="true"
				/>
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password">رمز عبور&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">الزامی</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
					<span>مرا به خاطر بسپار</span>
				</label>

				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

				<button type="submit" class="viora-btn viora-btn--primary woocommerce-button button woocommerce-form-login__submit" name="login" value="ورود">
					<span class="viora-btn__label">ورود</span>
				</button>
			</p>

			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">رمز عبور را فراموش کرده‌اید؟</a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>
		</form>
	</div>

	<?php if ( $viora_registration ) : ?>
		<div class="u-column2 col-2">
			<h2 class="viora-auth__title">
				<?php viora_icon( 'sparkle', array( 'size' => 20 ) ); ?>
				<span>ساخت حساب جدید</span>
			</h2>

			<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

				<?php do_action( 'woocommerce_register_form_start' ); ?>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_username">نام کاربری&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">الزامی</span></label>
						<input
							type="text"
							class="woocommerce-Input woocommerce-Input--text input-text"
							name="username"
							id="reg_username"
							autocomplete="username"
							value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification ?>"
							required
							aria-required="true"
						/>
					</p>
				<?php endif; ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_email">نشانی ایمیل&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">الزامی</span></label>
					<input
						type="email"
						class="woocommerce-Input woocommerce-Input--text input-text"
						name="email"
						id="reg_email"
						autocomplete="email"
						value="<?php echo ( ! empty( $_POST['email'] ) && is_string( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification ?>"
						required
						aria-required="true"
					/>
				</p>

				<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_password">رمز عبور&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">الزامی</span></label>
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
					</p>
				<?php else : ?>
					<p>پیوند تعیین رمز عبور به نشانی ایمیل شما ارسال می‌شود.</p>
				<?php endif; ?>

				<?php do_action( 'woocommerce_register_form' ); ?>

				<p class="woocommerce-form-row form-row">
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

					<button type="submit" class="viora-btn viora-btn--outline woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="ثبت‌نام">
						<span class="viora-btn__label">ثبت‌نام</span>
					</button>
				</p>

				<?php do_action( 'woocommerce_register_form_end' ); ?>
			</form>
		</div>
	<?php endif; ?>
</div>
<?php
do_action( 'woocommerce_after_customer_login_form' );
