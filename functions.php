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
 * Basic template setup.
 */
if ( ! function_exists( 'osomform_setup' ) ) {
	
	function osomform_setup() {
		/*
		 * Switch default core markup for scripts and styles
		 * to output valid HTML5 (removes type="text/css" and type="text/javascript").
		 */
		add_theme_support(
			'html5',
			array(
				'script',
				'style',
			)
		);
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Because I don't have a logo file and I don't have permission to use it, I set the option to add any logo.
		 * I assume we all know how it works.
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 190,
				'width'       => 190,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
}

add_action( 'after_setup_theme', 'osomform_setup' );


/**
 * Enqueue scripts and styles.
 */
function osomform_scripts() {

	wp_enqueue_script( 'osomform-app', get_theme_file_uri( 'assets/js/osomform-app.min.js' ), array('jquery', 'wp-api-request'), '20200412', true );
	wp_enqueue_style( 'osomform-style', get_theme_file_uri('assets/css/style.min.css'), array(), wp_get_theme()->get( 'Version' ) );

}

add_action( 'wp_enqueue_scripts', 'osomform_scripts' );

/**
 * Remove unnecessary items from the header.
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
remove_action( 'template_redirect', 'rest_output_link_header', 11 );