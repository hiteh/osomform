<?php

/**
 * Register a custom menu page.
 */
function osomfom_register_custom_menu_page() {
    add_menu_page( 
        __( 'OSOM Contacts', 'osomform' ), // menu title
        __( 'OSOM Contacts', 'osomform' ), // html title
        'manage_options', // capability
        'osom_contacts', // menu slug
        'osomform_page', // function
        'data:image/svg+xml;base64,' . base64_encode('<svg width="20" height="20" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path fill="#eee" d="M336 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM144 32h96c8.8 0 16 7.2 16 16s-7.2 16-16 16h-96c-8.8 0-16-7.2-16-16s7.2-16 16-16zm48 128c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zm112 236.8c0 10.6-10 19.2-22.4 19.2H102.4C90 416 80 407.4 80 396.8v-19.2c0-31.8 30.1-57.6 67.2-57.6h5c12.3 5.1 25.7 8 39.8 8s27.6-2.9 39.8-8h5c37.1 0 67.2 25.8 67.2 57.6v19.2z"></path></svg>') // icon
    ); 
}
 
/**
 * Display a custom menu page
 */
function osomform_page() {
    esc_html_e( 'Admin Page Test', 'osomform' );  
}


add_action( 'admin_menu', 'osomfom_register_custom_menu_page' );






/**
 * Adds a submenu page under a custom post type parent.
 */
function osomform_register_settings_page() {
    add_submenu_page(
        'osom_contacts',
        __( 'Contacts Store Settings', 'osomform' ),
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
    ?>
    <div class="wrap">
        <h1><?php _e( 'Contacts Store Settings', 'osomform' ); ?></h1>
        <p><?php _e( 'Helpful stuff here', 'osomform' ); ?></p>
    </div>
    <?php
}

add_action( 'admin_menu', 'osomform_register_settings_page' );