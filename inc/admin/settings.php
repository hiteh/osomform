<?php
/**
 * Theme admin settings
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */


/**
 * Register admin osom contacts menu page.
 */
function osomfom_register_custom_menu_page() {

    add_menu_page( 
        __( 'OSOM Contacts', 'osomform' ),
        __( 'OSOM Contacts', 'osomform' ),
        'manage_options',
        'osom_contacts',
        'osomform_page'
    ); 
}

/**
 * Display contacts table
 */
function osomform_page() {
    esc_html_e( 'Table with contacts data goes here', 'osomform' );  
}

/**
 * Adds a submenu page under the osom contacts menu page.
 */
function osomform_register_settings_page() {

    add_submenu_page(
        'osom_contacts',
        __( 'OSOM Contacts Store Settings', 'osomform' ),
        __( 'Settings', 'osomform' ),
        'manage_options',
        'osomcontact-store-settings',
        'osomform_settings_page_callback'
    );
}

/**
 * Display callback for the submenu page.
 */
function osomform_settings_page_callback() {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	} 
	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
	// add settings saved message with the class of "updated"
		add_settings_error( 'osomform_messages', 'osomform_message', __( 'Settings Saved', 'osomform' ), 'updated' );
	}
	// show error/update messages
	settings_errors( 'osomform_messages' );
	?>
	<h1><?php _e( 'Contacts Store Settings', 'osomform' ); ?></h1>
	<form action="options.php" method="post">
	<?php
	 do_settings_sections( 'osomcontact-store-settings' );
	 settings_fields( 'osomcontact-store-settings' );
	 submit_button( 'Save Settings' );
	?>
	</form>
	<?php
}

/**
 * Sanitize store type data.
 *
 * @param string $data input data.
 */
function osomform_sanitize_store_type_field ( string $data ) {

	$mask = ['database', 'file'];
	$field = array_intersect( [strtolower( $data )], $mask );
	$field = isset( $field ) && is_string( $field[0] ) ? $field[0] : $mask[0];
	return $field;
}

/**
 * Sanitize yes/no string.
 *
 * @param string $data input data.
 */
function osomform_sanitize_remove_store_field ( string $data ) {

	$mask = ['no', 'yes'];
	$field = array_intersect( [strtolower( $data )], $mask );
	$field = isset( $field )  && is_string( $field[0] ) ? $field[0] : $mask[0];
	return $field;
}

/**
 * Settings section display callback.
 *
 * @param array $args $args add_setings_field arguments.
 */
function osomform_setting_section_cb( array $args ) {
	?>
	<p><?php _e( 'Select the type of data storage and whether to delete the data after changing the theme.', 'osomform' ); ?></p>
	<?php
}

/**
 * Store type field display callback.
 *
 * @param array $args add_setings_field arguments.
 */
function osomform_store_type_field_cb( array $args ) {

	$option = get_option( 'osomform_store_type' );
 	?>
	<select id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>">
		<option value="database" <?php echo selected( $option, 'database', false ) ?>>
		<?php esc_html_e( 'Database', 'osomform' ); ?>
		</option>
		<option value="file" <?php echo selected( $option, 'file', false ) ?>>
		<?php esc_html_e( 'File', 'osomform' ); ?>
		</option>
	</select>
 	<?php
}

/**
 * Remove store field display callback.
 *
 * @param array $args add_setings_field arguments.
 */
function osomform_remove_store_field_cb( array $args ) {

	$option = get_option( 'osomform_remove_store' );
	?>
	<select id="<?php echo esc_attr( $args['label_for'] ); ?>" name="<?php echo esc_attr( $args['label_for'] ); ?>">
		<option value="yes" <?php echo selected( $option, 'yes', false ) ?>>
		<?php esc_html_e( 'Yes', 'osomform' ); ?>
		</option>
		<option value="no" <?php echo selected( $option, 'no', false ) ?>>
		<?php esc_html_e( 'No', 'osomform' ); ?>
		</option>
	</select>
	<?php
}

/**
* Register settings, fields and sections.
**/
function osomform_register_settings() {    
    
    register_setting(
    	'osomcontact-store-settings',
    	'osomform_store_type', 
    	array(
            'type' => 'string', 
            'sanitize_callback' => 'osomform_sanitize_store_type_field',
            'default' => 'database',
        )
    );

    register_setting(
    	'osomcontact-store-settings',
    	'osomform_remove_store', 
    	array(
            'type' => 'string', 
            'sanitize_callback' => 'osomform_sanitize_remove_store_field',
            'default' => 'no',
        )
    );

	add_settings_section(
	    'osomform_setting_section',
	    __( 'General settings', 'osomform' ),
	    'osomform_setting_section_cb',
	    'osomcontact-store-settings'
	);

	add_settings_field(
		 'osomform_store_type_field',
		 __( 'Storage type:', 'osomform' ),
		 'osomform_store_type_field_cb',
		 'osomcontact-store-settings',
		 'osomform_setting_section',
		 array(
			'label_for' => 'osomform_store_type',
			'class' => 'osomform_row',
		 )
	);

	add_settings_field(
		 'osomform_remove_store_field',
		 __( 'Remove stored data on template switch:', 'osomform' ),
		 'osomform_remove_store_field_cb',
		 'osomcontact-store-settings',
		 'osomform_setting_section',
		 array(
			 'label_for' => 'osomform_remove_store',
			 'class' => 'osomform_row',
		 )
	);
} 
