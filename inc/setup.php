<?php
/**
 * Theme setup
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */


if ( ! function_exists( 'osomform_setup' ) ) {
	
	/**
 	* Basic theme setup. Only the esential this.
 	*/
	function osomform_setup() {

		add_theme_support(
			'html5',
			array(
				'script',
				'style',
			)
		);

		add_theme_support( 'title-tag' );

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
