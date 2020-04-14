<?php
/**
 * Theme sripts and styles
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

if ( ! function_exists( 'osomform_scripts' ) ) {

	/**
	 * Enqueue scripts and styles.
	 */
	function osomform_scripts() {
		wp_enqueue_script( 'osomform-app', get_theme_file_uri( 'assets/js/osomform-app.min.js' ), array('jquery', 'wp-api-request'), '20200412', true );
		wp_enqueue_style( 'osomform-style', get_theme_file_uri('assets/css/style.min.css'), array(), wp_get_theme()->get( 'Version' ) );
	}
}

