<?php
/**
 *
 * @package   GS_WPPosts
 * @author    GS Plugins <hello@gsplugins.com>
 * @license   GPL-2.0+
 * @link      https://www.gsplugins.com
 * @copyright 2016 GS Plugins
 *
 * @wordpress-plugin
 * Plugin Name:           GS Posts Grid Lite
 * Plugin URI:            https://www.gsplugins.com/wordpress-plugins
 * Description:           Best Responsive WordPress Posts Grid Plugin to display Posts elegantly. Using GS Posts Grid plugin you can present latest posts in various views like Grid, Horizontal, List, Card, Table, Gray, Slider, Popup, Filter, Masonry & Justified Gallery. Display anywhere at your site using shortcode like [gs_wpposts theme="gs_wppost_grid_1"] GS Posts Grid plugin packed with necessary controlling options & 30+ different themes to present latest posts elegantly with eye catching effects. Check <a href="https://posts-grid.gsplugins.com">GS Posts Grid PRO Demos</a> and <a href="https://docs.gsplugins.com/wordpress-posts-grid">Documentations</a>.
 * Version:               1.2.0
 * Author:                GS Plugins
 * Author URI:            https://www.gsplugins.com
 * Text Domain:           gswpposts
 * License:               GPL-2.0+
 * License URI:           http://www.gnu.org/licenses/gpl-2.0.txt
 */


if( ! defined( 'GSWPPOSTS_HACK_MSG' ) ) define( 'GSWPPOSTS_HACK_MSG', __( 'Sorry cowboy! This is not your place', 'gswppost' ) );

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( GSWPPOSTS_HACK_MSG );

/**
 * Defining constants
 */
if( ! defined( 'GSWPPOSTS_VERSION' ) ) define( 'GSWPPOSTS_VERSION', '1.2.0' );
if( ! defined( 'GSWPPOSTS_MENU_POSITION' ) ) define( 'GSWPPOSTS_MENU_POSITION', 31 );
if( ! defined( 'GSWPPOSTS_PLUGIN_DIR' ) ) define( 'GSWPPOSTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if( ! defined( 'GSWPPOSTS_PLUGIN_URI' ) ) define( 'GSWPPOSTS_PLUGIN_URI', plugins_url( '', __FILE__ ) );
if( ! defined( 'GSWPPOSTS_FILES_DIR' ) ) define( 'GSWPPOSTS_FILES_DIR', GSWPPOSTS_PLUGIN_DIR . 'gs-wpposts-files' );
if( ! defined( 'GSWPPOSTS_FILES_URI' ) ) define( 'GSWPPOSTS_FILES_URI', GSWPPOSTS_PLUGIN_URI . '/gs-wpposts-files' );

function disable_post_grid_pro() {
	if ( is_plugin_active( 'gs-posts-grid-pro/gs_wpposts.php' ) ) {
		deactivate_plugins( 'gs-posts-grid-pro/gs_wpposts.php', true );
	}
	add_option( 'gs_post_activation_redirect', true );
}

register_activation_hook( __FILE__, 'disable_post_grid_pro' );

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_posts_grid() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once GSWPPOSTS_FILES_DIR . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( 'b8072043-f4bc-4d35-8d2b-de23300a018f', 'GS Posts Grid', __FILE__ );

    // Active insights
    $client->insights()->init();

}
appsero_init_tracker_posts_grid();

/**
 * Redirect to options page
 *
 * @since v1.0.0
 */
function gspost_redirect() {
    if (get_option('gs_post_activation_redirect', false)) {
        delete_option('gs_post_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("admin.php?page=gs-grid-plugins-help");
        }
    }
}
add_action( 'admin_init', 'gspost_redirect' );

add_action( 'plugins_loaded', function() {
    require_once GSWPPOSTS_FILES_DIR . '/includes/gs-post-grid-root.php';
}, -999999 );