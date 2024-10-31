<?php

// -- Getting values from setting panel
function gs_wpposts_getoption( $option, $section, $default = '' ) {
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}

//-- Shortcode [gs_wpposts]
//-- shortcode with theme: [gs_wpposts theme="gs_wppost_theme1" cols="2"]

add_shortcode('gs_wpposts','gs_wpposts_shortcode');
function gs_wpposts_shortcode( $atts ) {
    $gswppost_op_wpposts_cols        = gs_wpposts_getoption('gs_wpposts_cols', 'gs_wpposts_option_01_settings', 3);
    $gswppost_op_wpposts_theme       = gs_wpposts_getoption('gs_wpposts_theme', 'gs_wpposts_option_01_settings', 'gs_wppost_grid_1');
    $gswppost_op_wppost_title         = gs_wpposts_getoption('gs_wppost_title', 'gs_wpposts_option_02_settings', 'on');
    $gswppost_op_wppost_details       = gs_wpposts_getoption('gs_wppost_details', 'gs_wpposts_option_02_settings', 'on');
    $gswppost_op_wppost_link_tar      = gs_wpposts_getoption('gs_wppost_link_tar', 'gs_wpposts_option_01_settings', '_blank');
    $gswppost_op_wppost_details_contl = gs_wpposts_getoption('gs_wppost_details_contl', 'gs_wpposts_option_01_settings', 100);
    $gswppost_op_wppost_details_readmore = gs_wpposts_getoption('gs_wppost_details_readmore', 'gs_wpposts_option_01_settings', 'Read More');
    //taxonomy & others
    $gswppost_op_author        = gs_wpposts_getoption('gs_wppost_author', 'gs_wpposts_option_02_settings', 'on');
    $gswppost_op_date          = gs_wpposts_getoption('gs_wppost_date', 'gs_wpposts_option_02_settings', 'on');
    $gswppost_op_category      = gs_wpposts_getoption('gs_wppost_category', 'gs_wpposts_option_02_settings', 'on');
    $gswppost_op_tag           = gs_wpposts_getoption('gs_wppost_tag', 'gs_wpposts_option_02_settings', 'on');
    $gswppost_op_pagination    = gs_wpposts_getoption('gs_wppost_pagination', 'gs_wpposts_option_02_settings', 'on');

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    extract(shortcode_atts(
        array(
        'num'           => -1,
        'order'         => 'DESC',
        'orderby'       => 'date',
        'theme'         => $gswppost_op_wpposts_theme,
        'cols'          => $gswppost_op_wpposts_cols,
        'desc_limit'    => $gswppost_op_wppost_details_contl,
        'group'         => '',
        'cats_name'     => '',
        'pagination'    => $gswppost_op_pagination
        ), $atts
    ));

    $GLOBALS['gs_wpposts_loop'] = new WP_Query(
        array(
        'post_type'        => 'post',
        'order'            => $order,
        'orderby'          => $orderby,
        'posts_per_page'   => $num,
        // 'wpposts_group'    => $group,
        'category_name'    => $group,
        'paged'            => $paged
    ));


        $output = '';
        $output = '<div class="wrap gs_wpposts_area '.$theme.'">';
        
            if ( $theme == 'gs_wppost_grid_1' ) {
                include GSWPPOSTS_FILES_DIR . '/includes/templates/gs_wpposts_structure_grid_1_square_overlay.php';
            } elseif ( $theme == 'gs_wppost_grid_2' ) {
                include GSWPPOSTS_FILES_DIR . '/includes/templates/gs_wpposts_structure_grid_2_square_halfoverlay.php';
            } else {
                $output = '<h4 style="text-align: center;">Select correct Theme or Upgrade to <a href="https://www.gsplugins.com/product/wordpress-posts-grid" target="_blank">Pro version</a><br>For more Options <a href="http://posts-grid.gsplugins.com" target="_blank">Chcek available demos</a></h4>';
            }
        
        $output .= '</div>'; // end wrap
    return $output;
}