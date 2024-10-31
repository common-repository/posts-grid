<?php

if ( ! function_exists('gs_wpposts_enqueue_front_scripts') ) {
    function gs_wpposts_enqueue_front_scripts() {
        if (!is_admin()) {
            $media = 'all';

            wp_register_style('gspostsbootstrap-css', GSWPPOSTS_FILES_URI . '/assets/css/gswpposts_custom_bootstrap.css','', GSWPPOSTS_VERSION , $media );
            wp_enqueue_style('gspostsbootstrap-css');

            wp_register_style('gsposts-gswppost-custom-css', GSWPPOSTS_FILES_URI . '/assets/css/gswpposts_custom.css','', GSWPPOSTS_VERSION , $media );
            wp_enqueue_style('gsposts-gswppost-custom-css');

            wp_enqueue_style('dashicons');
        }
    }
    add_action( 'wp_enqueue_scripts', 'gs_wpposts_enqueue_front_scripts' );
}

if ( !function_exists('gs_wpposts_enqueue_admin_styles') ) {
    function gs_wpposts_enqueue_admin_styles() {
        $media = 'all';
        wp_register_style('gswppost_switchButton_css', GSWPPOSTS_FILES_URI . '/admin/css/gswppost.jquery.switchButton.css','', GSWPPOSTS_VERSION);
        wp_enqueue_style('gswppost_switchButton_css');

        wp_register_style('gswppost_admin_css', GSWPPOSTS_FILES_URI . '/admin/css/gswpposts_admin.css','', GSWPPOSTS_VERSION);
        wp_enqueue_style('gswppost_admin_css');

        wp_register_style('gswppost_free_plugin_css', GSWPPOSTS_FILES_URI . '/admin/css/gs_free_plugins.css','', GSWPPOSTS_VERSION);
        wp_enqueue_style('gswppost_free_plugin_css');

        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-effects-core');

        wp_register_script( 'gs_wppost_SwitchButtonJs', GSWPPOSTS_FILES_URI . '/admin/js/gswppost.jquery.switchButton.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-effects-core' ), GSWPPOSTS_VERSION, false );
        wp_enqueue_script('gs_wppost_SwitchButtonJs');
    }
    add_action( 'admin_enqueue_scripts', 'gs_wpposts_enqueue_admin_styles' );
}