<?php
/**
 * Theme bootstrap 
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

/**
 * Includes.
 */ 

// Load theme setup.
require get_template_directory() . '/inc/setup.php';

 // Load scripts and styles.
require get_template_directory() . '/inc/scripts.php';

// Load admin settings.
require get_template_directory() . '/inc/admin/settings.php';

/**
 * Hooks.
 */ 

// Remove unnecessary things from the html head.
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

// Theme setup
add_action( 'after_setup_theme', 'osomform_setup' );

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'osomform_scripts' );

// Theme admin page
add_action( 'admin_menu', 'osomfom_register_custom_menu_page' );
add_action( 'admin_menu', 'osomform_register_settings_page' );
add_action( 'admin_init', 'osomform_register_settings' );