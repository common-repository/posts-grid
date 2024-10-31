<?php 


require_once GSWPPOSTS_FILES_DIR . '/includes/gs_wpposts_shortcode.php';
require_once GSWPPOSTS_FILES_DIR . '/gs_wpposts_scripts.php';
require_once GSWPPOSTS_FILES_DIR . '/admin/class.settings-api.php';
require_once GSWPPOSTS_FILES_DIR . '/admin/gs_wpposts_options_config.php';
require_once GSWPPOSTS_FILES_DIR . '/gs-common-pages/gs-grid-common-pages.php';

if( !function_exists( 'remove_post_grid_admin_notices' ) ) {
    function remove_post_grid_admin_notices( ) {
        if ( isset( $_GET['page'] ) && in_array( $_GET['page'], ['gs-posts-grid-settings', 'gs-grid-plugins-premium', 'gs-grid-plugins-lite', 'gs-grid-plugins-help'] ) ) {
            remove_all_actions( 'network_admin_notices' );
            remove_all_actions( 'user_admin_notices' );
            remove_all_actions( 'admin_notices' );
            remove_all_actions( 'all_admin_notices' );
        }
    }
}

add_action( 'in_admin_header',  'remove_post_grid_admin_notices' );


// Add new image sizes
add_image_size( 'gs-square-thumb', 420, 420, true );
add_image_size( 'gs-masonry-thumb', 420, 0, true );

if ( ! function_exists('gs_posts_grid_pro_link') ) {
	function gs_posts_grid_pro_link( $gsPostGrid_links ) {
		$gsPostGrid_links[] = '<a class="gs-pro-link" href="https://www.gsplugins.com/product/wordpress-posts-grid" target="_blank">Go Pro!</a>';
		$gsPostGrid_links[] = '<a href="https://www.gsplugins.com/wordpress-plugins" target="_blank">GS Plugins</a>';
		return $gsPostGrid_links;
	}
	add_filter( 'plugin_action_links_' .plugin_basename(__FILE__), 'gs_posts_grid_pro_link' );
}

/**
 * @gswpposts_review_dismiss()
 * @gswpposts_review_pending()
 * @gswpposts_review_notice_message()
 * Make all the above functions working.
 */
function gswpposts_review_notice(){

	gswpposts_review_dismiss();
	gswpposts_review_pending();
  
	$activation_time    = get_site_option( 'gswpposts_active_time' );
	$review_dismissal   = get_site_option( 'gswpposts_review_dismiss' );
	$maybe_later        = get_site_option( 'gswpposts_maybe_later' );
  
	if ( 'yes' == $review_dismissal ) {
		return;
	}
  
	if ( ! $activation_time ) {
		add_site_option( 'gswpposts_active_time', time() );
	}
	
	$daysinseconds = 259200; // 3 Days in seconds.
   
	if( 'yes' == $maybe_later ) {
		$daysinseconds = 604800 ; // 7 Days in seconds.
	}
  
	if ( time() - $activation_time > $daysinseconds ) {
		add_action( 'admin_notices' , 'gswpposts_review_notice_message' );
	}
  }
  add_action( 'admin_init', 'gswpposts_review_notice' );
  
  /**
  * For the notice preview.
  */
  function gswpposts_review_notice_message(){
	$scheme      = (parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY )) ? '&' : '?';
	$url         = $_SERVER['REQUEST_URI'] . $scheme . 'gswpposts_review_dismiss=yes';
	$dismiss_url = wp_nonce_url( $url, 'gswpposts-review-nonce' );
  
	$_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'gswpposts_review_later=yes';
	$later_url   = wp_nonce_url( $_later_link, 'gswpposts-review-nonce' );
	?>
	
	<div class="gslogo-review-notice">
		<div class="gslogo-review-thumbnail">
			<img src="<?php echo GSWPPOSTS_FILES_URI .'/assets/img/icon-128x128.png'; ?>" alt="">
		</div>
		<div class="gslogo-review-text">
			<h3><?php _e( 'Leave A Review?', 'gswpposts' ) ?></h3>
			<p><?php _e( 'We hope you\'ve enjoyed using <b>GS Posts Grid Lite</b>! Would you consider leaving us a review on WordPress.org?', 'gswpposts' ) ?></p>
			<ul class="gslogo-review-ul">
				<li>
					<a href="https://wordpress.org/support/plugin/posts-grid/reviews/" target="_blank">
						<span class="dashicons dashicons-external"></span>
						<?php _e( 'Sure! I\'d love to!', 'gswpposts' ) ?>
					</a>
				</li>
				<li>
					<a href="<?php echo $dismiss_url ?>">
						<span class="dashicons dashicons-smiley"></span>
						<?php _e( 'I\'ve already left a review', 'gswpposts' ) ?>
					</a>
				</li>
				<li>
					<a href="<?php echo $later_url ?>">
						<span class="dashicons dashicons-calendar-alt"></span>
						<?php _e( 'Maybe Later', 'gswpposts' ) ?>
					</a>
				</li>
				<li>
					<a href="https://www.gsplugins.com/contact/" target="_blank">
						<span class="dashicons dashicons-sos"></span>
						<?php _e( 'I need help!', 'gswpposts' ) ?>
					</a>
				</li>
				<li>
					<a href="<?php echo $dismiss_url ?>">
						<span class="dashicons dashicons-dismiss"></span>
						<?php _e( 'Never show again', 'gswpposts' ) ?>
					</a>
				</li>
			</ul>
		</div>
	</div>
	
	<?php
  }
  
  /**
  * For Dismiss! 
  */
  function gswpposts_review_dismiss(){
  
	if ( ! is_admin() ||
		! current_user_can( 'manage_options' ) ||
		! isset( $_GET['_wpnonce'] ) ||
		! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'gswpposts-review-nonce' ) ||
		! isset( $_GET['gswpposts_review_dismiss'] ) ) {
  
		return;
	}
  
	add_site_option( 'gswpposts_review_dismiss', 'yes' );   
  }
  
  /**
  * For Maybe Later Update.
  */
  function gswpposts_review_pending() {
  
	if ( ! is_admin() ||
		! current_user_can( 'manage_options' ) ||
		! isset( $_GET['_wpnonce'] ) ||
		! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'gswpposts-review-nonce' ) ||
		! isset( $_GET['gswpposts_review_later'] ) ) {
  
		return;
	}
	// Reset Time to current time.
	update_site_option( 'gswpposts_active_time', time() );
	update_site_option( 'gswpposts_maybe_later', 'yes' );
  
  }
  
  /**
  * Remove Reviews Metadata on plugin Deactivation.
  */
  function gswpposts_deactivate() {
	delete_option('gswpposts_active_time');
	delete_option('gswpposts_maybe_later');
  }
  register_deactivation_hook(__FILE__, 'gswpposts_deactivate');

/**
  *  Reviews Metadata on plugin activation.
*/
if ( ! function_exists('gswpposts_row_meta') ) {
    function gswpposts_row_meta( $meta_fields, $file ) {
  
		if ( $file != 'posts-grid/gs_wpposts.php' ) {
			return $meta_fields;
		}
    
        echo "<style>.gswpposts-rate-stars { display: inline-block; color: #ffb900; position: relative; top: 3px; }.gswpposts-rate-stars svg{ fill:#ffb900; } .gswpposts-rate-stars svg:hover{ fill:#ffb900 } .gswpposts-rate-stars svg:hover ~ svg{ fill:none; } </style>";
  
        $plugin_rate   = "https://wordpress.org/support/plugin/posts-grid/reviews/?rate=5#new-post";
        $plugin_filter = "https://wordpress.org/support/plugin/posts-grid/reviews/?filter=5";
        $svg_xmlns     = "https://www.w3.org/2000/svg";
        $svg_icon      = '';
  
        for ( $i = 0; $i < 5; $i++ ) {
          $svg_icon .= "<svg xmlns='" . esc_url( $svg_xmlns ) . "' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>";
        }
  
        // Set icon for thumbsup.
        $meta_fields[] = '<a href="' . esc_url( $plugin_filter ) . '" target="_blank"><span class="dashicons dashicons-thumbs-up"></span>' . __( 'Vote!', 'gscs' ) . '</a>';
  
        // Set icon for 5-star reviews. v1.1.22
        $meta_fields[] = "<a href='" . esc_url( $plugin_rate ) . "' target='_blank' title='" . esc_html__( 'Rate', 'gscs' ) . "'><i class='gswpposts-rate-stars'>" . $svg_icon . "</i></a>";
  
        return $meta_fields;
    }
    add_filter( 'plugin_row_meta','gswpposts_row_meta', 10, 2 );
}