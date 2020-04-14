<?php
/**
 * Osom Form functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

/**
 * Enqueue scripts and styles.
 */
function osomform_scripts() {

	wp_enqueue_script( 'osomform-app', get_theme_file_uri( 'assets/js/osomform-app.min.js' ), array('jquery', 'wp-api-request'), '20200412', true );
	wp_enqueue_style( 'osomform-style', get_theme_file_uri('assets/css/style.min.css'), array(), wp_get_theme()->get( 'Version' ) );

}
add_action( 'wp_enqueue_scripts', 'osomform_scripts' );