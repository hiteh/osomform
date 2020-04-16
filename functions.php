<?php
/**
 * Osom Form Theme 
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

// Load theme setup.
require get_template_directory() . '/inc/setup.php';
 // Load theme scripts and styles.
require get_template_directory() . '/inc/scripts.php';
// Load theme admin settings.
require get_template_directory() . '/inc/admin/settings.php';
// Load repository interface
require get_template_directory() . '/inc/repositories/interfaces/interface-osomform-repository.php';
// Load database repository
require get_template_directory() . '/inc/repositories/class-osomform-db.php';
// Load file repository
require get_template_directory() . '/inc/repositories/class-osomform-file.php';
// Load rest controller
require get_template_directory() . '/inc/api/class-osomform-rest-controller.php';

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

// Theme setup.
add_action( 'after_setup_theme', 'osomform_setup' );

// Enqueue scripts and styles.
add_action( 'wp_enqueue_scripts', 'osomform_scripts' );

// Repository retup.
	// Get admin page option.
$remove_data = get_option( 'osomform_remove_store' );
	// Theme functions attached to this hook are only triggered in the theme (and/or child theme) being activated.
add_action('after_switch_theme', 'OsomformDBRepository::storage_setup' );
add_action('after_switch_theme', 'OsomformFileRepository::storage_setup' );

if( 'yes' === $remove_data ) {
	// Theme functions attached to this hook are only triggered in the theme being deactivated
	add_action('switch_theme', 'OsomformDBRepository::storage_remove' );
	add_action('switch_theme', 'OsomformFileRepository::storage_remove' );
}
	// Register api controller.
add_action( 'rest_api_init', 'osomform_register_rest_routes' );

//Theme admin page.
add_action( 'admin_menu', 'osomfom_register_custom_menu_page' );
add_action( 'admin_menu', 'osomform_register_settings_page' );
add_action( 'admin_init', 'osomform_register_settings' );
