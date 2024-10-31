<?php
/*
 * GS wppost - Theme Two (2)
 * @author GS Plugins <hello@gsplugins.com>
 *
 */

$output .= '<div class="container">';
$output .= '<div class="row clearfix gs_wpposts">';

    if ( $GLOBALS['gs_wpposts_loop']->have_posts() ) {
        while ( $GLOBALS['gs_wpposts_loop']->have_posts() ) {
            $GLOBALS['gs_wpposts_loop']->the_post();

            $gswppost_post_date      = get_the_date( 'M j, Y' );
            $gswppost_post_author    = get_the_author();
            $gswppost_post_tag       = get_the_tag_list();
            $gswppost_post_category  = get_the_category_list();

            $gswppost_post_id        = get_the_id();
            $gswppost_wppost_id      = get_post_thumbnail_id();
            $gswppost_wppost_url     = wp_get_attachment_image_src($gswppost_wppost_id, 'gs-square-thumb', true);
            $gswppost_wppost_thumb   = $gswppost_wppost_url[0];
            $gswppost_wppost_alt     = get_post_meta($gswppost_wppost_id,'_wp_attachment_image_alt',true);
            $gswppost_wppost_title           = get_the_title();
            $gswppost_wppost_details         = get_the_content();
            $gswppost_wppost_details_link    = get_the_permalink();
            
            $output .= '<div class="col-md-'.$cols.' col-sm-6 col-xs-6">';
                $output .= '<div class="single-wppost">'; // start single wppost
                    if ( has_post_thumbnail() )
                    $output .= '<a href='.$gswppost_wppost_details_link.' target="_self"><img src="'. $gswppost_wppost_thumb .'" alt="'. $gswppost_wppost_alt .'" /></a>';
                    else {
                        $output .= '<img src="' . GSWPPOSTS_FILES_URI . '/assets/img/no_img.png" class=""/>';
                    }
                    if ( !empty( $gswppost_post_category ) && 'on' == $gswppost_op_category ) :
                        $output.= '<div class="gs-wppost-category">'. $gswppost_post_category .'</div>';
                    endif;
                    $output .= '<div class="single-wppost-title">'; // start single wppost title
                        if ( !empty( $gswppost_wppost_title ) && 'on' ==  $gswppost_op_wppost_title) :
                            $output.= '<div class="gs-wppost-name">'. $gswppost_wppost_title .'</div>';
                        endif;
                    $output .= '</div>'; // end single wppost title

                    $output .= '<div class="single-wppost-overlayer">'; // start overlayer
                        if ( !empty( $gswppost_wppost_title ) && 'on' ==  $gswppost_op_wppost_title) :
                            $output.= '<div class="gs-wppost-name">'. $gswppost_wppost_title .'</div>';
                        endif;
                       
                        $output.= '<div class="gs-wppost-author-date">';
                            if ( !empty( $gswppost_post_author ) && 'on' ==  $gswppost_op_author ) :
                                $output.= '<span class="gs-wppost-author"><span class="dashicons dashicons-admin-users"></span> '. $gswppost_post_author.'</span>';
                            endif;
                            if ( !empty( $gswppost_post_date )  && 'on' ==  $gswppost_op_date ) :
                                $output.= '<span class="gs-wppost-date" > <span class="dashicons dashicons-calendar-alt"></span> '. $gswppost_post_date .'</span>';
                            endif;
                        $output.= '</div>';
                    $output .= '</div>'; // end overlayer

                $output .= '</div>'; // end single wppost
            $output .= '</div>'; // end col

        } // end while loop
        
    } // if loop end
    else { $output .= "No Post Added!";  }

    wp_reset_postdata();

$output .= '</div>'; // end row

if ( !empty( $pagination ) && 'on' ==  $pagination ) :

    $output .= '<div class="row clearfix">'; // start row
        $gsbig = 999999999; // need an unlikely integer
        $output .= '<div class="col-md-12 gs-pagination">';
        $output .=  paginate_links( array(
            'base' => str_replace( $gsbig, '%#%', esc_url( get_pagenum_link( $gsbig ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $GLOBALS['gs_wpposts_loop']->max_num_pages
        ) );
        $output.= '</div>';
    $output .= '</div>'; // end row

endif;

$output .= '</div>'; // end container
return $output;