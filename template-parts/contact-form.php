<?php
/**
 * Displays contact form
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

?>
<div class="form-wrapper">
	<form id="osomform" class="contact-form" action="#">
		<div class="contact-form-area-wrapper">
			<p>
				<label>
					<span><?php _e( 'First name:', 'osomform' ) ?></span>
					<input type="text" id="first_name" name="first_name" aria-required="true" aria-invalid="false">
				</label>
			</p>
			<p>
				<label>
					<span><?php _e( 'Last name:', 'osomform' ) ?></span>
					<input type="text" id="last_name" name="last_name" aria-required="true" aria-invalid="false">
				</label>
			</p>
			<p>
				<label>
					<span><?php _e( 'Login:', 'osomform' ) ?></span>
					<input type="text" id="login" name="login" aria-required="true" aria-invalid="false">
				</label>
			</p>
		</div>
		<div class="contact-form-area-wrapper">
			<p>
				<label>
					<span><?php _e( 'User e-mail:', 'osomform' ) ?></span>
					<input type="email" id="email" name="email" aria-required="true" aria-invalid="false">
				</label>
			</p>
			<p>
				<label>
					<span><?php _e( 'City:', 'osomform' ) ?></span>
					<select id="city" name="city" aria-required="true" aria-invalid="false">
					  <option value="<?php esc_attr_e( 'Łódź' ) ?>"><?php _e( 'Łódź', 'osomform' ) ?></option>
					  <option value="<?php esc_attr_e( 'Warszawa' ) ?>"><?php _e( 'Warszawa', 'osomform' ) ?></option>
					  <option value="<?php esc_attr_e( 'Poznań' ) ?>"><?php _e( 'Poznań', 'osomform' ) ?></option>
					  <option value="<?php esc_attr_e( 'Kraków' ) ?>"><?php _e( 'Kraków', 'osomform' ) ?></option>
					</select>
				</label>
			</p>
			<p class="contact-form-button-wrapper">
				<input class="button" id="osomform-send" type="submit" value="<?php esc_attr_e( 'Wyślij', 'osomform' ) ?>" disabled>
			</p>
		</div>
	</form>
	<div class="consent">
		<p>
		<?php _e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'osomform' ) ?>
		</p>
		<label class="consent-checkbox-wrapper">
			<input type="checkbox" id="consent" name="consent" aria-required="true" value="agree">
			<span><?php _e( 'Agree', 'osomform' ) ?></span>
		</label>
	</div>

</div><!-- .custom-header -->