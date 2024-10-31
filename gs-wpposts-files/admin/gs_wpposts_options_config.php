<?php

if ( !class_exists('gs_Wpposts_Settings_Config' ) ):
class gs_Wpposts_Settings_Config {

    private $settings_api;

    function __construct() {
        $this->settings_api = new gs_Wpposts_WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') ); //display options
        add_action( 'admin_menu', array($this, 'admin_menu') ); //display the page of options.
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_menu_page( 'Posts Grid Settings', 'Posts Grid', 'delete_posts', 'gs-posts-grid-settings', array($this, 'plugin_page'), 'dashicons-grid-view', 5 ); 
    }


    function get_settings_sections() {
        $sections = array(
            array(
                'id'     => 'gs_wpposts_option_01_settings',
                'title' => __( 'General Settings', 'gswpposts' )
            ),
            array(
                'id'     => 'gs_wpposts_option_02_settings',
                'title' => __( 'Post Settings', 'gswpposts' )
            ),
            array(
                'id'    => 'gs_wpposts_style_settings',
                'title' => __( 'Style Settings', 'gswpposts' )
            )
        );
        return $sections;
    }

    //start all options of "GS wppost settings" and "Style Settings" under nav
    /*
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'gs_wpposts_option_01_settings' => array(
                // Front page display Columns
                array(
                    'name'      => 'gs_wpposts_cols',
                    'label'     => __( 'Page Columns', 'gswpposts' ),
                    'desc'      => __( 'Select number of Post Showcase columns', 'gswpposts' ),
                    'type'      => 'select',
                    'default'   => '3',
                    'options'   => array(
                        '6'    => '2 Columns',
                        '4'      => '3 Columns',
                        '3'      => '4 Columns',
                    )
                ),
                // wpposts theme
                array(
                    'name'  => 'gs_wpposts_theme',
                    'label' => __( 'Style & Theming', 'gswpposts' ),
                    'desc'  => __( 'Select preferred Style & Theme', 'gswpposts' ),
                    'type'  => 'select',
                    'default'   => 'gs_wppost_grid_1',
                    'options'   => array(
                        'gs_wppost_grid_1'           => 'Grid 1 (Full Overlay)',
                        'gs_wppost_grid_2'           => 'Grid 2 (Half Overlay)',
                        'gs_wppost_grid_3'           => 'Grid 3 : Bottom Info (Pro)',
                        'gs_wppost_horizontal_1'     => 'Horizontal 1 : Square Right Info (Pro)',
                        'gs_wppost_horizontal_2'     => 'Horizontal 2 : Square Left Info (Pro)',
                        'gs_wppost_horizontal_3'     => 'Horizontal 3 : Round Right Info (Pro)',
                        'gs_wppost_horizontal_4'     => 'Horizontal 4 : Round Left Info (Pro)',
                        'gs_wppost_horizontal_5'     => 'Horizontal 5 : Box Square Right Info (Pro)',
                        'gs_wppost_horizontal_6'     => 'Horizontal 6 : Box Round Right Info (Pro)',
                        'gs_wppost_list_1'           => 'List 1 : Square Right Info (Pro)',
                        'gs_wppost_list_2'           => 'List 2 : Square Left Info (Pro)',
                        'gs_wppost_list_3'           => 'List 3 : Circle Right Info (Pro)',
                        'gs_wppost_list_4'           => 'List 4 : Circle Left Info (Pro)',
                        'gs_wppost_card_1'           => 'Card 1 : Square Bottom Info (Pro)',
                        'gs_wppost_card_2'           => 'Card 2 : Circle Bottom Info (Pro)',
                        'gs_wppost_table_1'          => 'Table 1 : Underline (Pro)',
                        'gs_wppost_table_2'          => 'Table 2 : Box Border (Pro)',
                        'gs_wppost_table_3'          => 'Table 3 : Odd Even (Pro)',
                        'gs_wppost_grey_1'           => 'Gray 1 : Square (Pro)',
                        'gs_wppost_grey_2'           => 'Gray 2 : Round (Pro)',
                        'gs_wppost_slider_1'         => 'Slider 1 : Zoom (Pro)',
                        'gs_wppost_slider_2'         => 'Slider 2 : Hover (Pro)',
                        'gs_wppost_slider_3'         => 'Slider 3 : Hover 2 (Pro)',
                        'gs_wppost_popup_1'          => 'Popup 1 : (Pro)',
                        'gs_wppost_popup_2'          => 'Popup 2 : (Pro)',
                        'gs_wppost_filter_1'         => 'Filter 1 : Hover & Pop (Pro)',
                        'gs_wppost_filter_2'         => 'Filter 2 : Link & Pop (Pro)',
                        'gs_wppost_masonry1'         => 'Masonry 1 : Details (Pro)',
                        'gs_wppost_masonry2'         => 'Masonry 2 : Title (Pro)',
                        'gs_wppost_masonry3'         => 'Masonry 3 : Gallery (Pro)',
                        'gs_wppost_justified1'       => 'Justified : Gallery (Pro)',
                    )
                ),
                // wppost Link Target
                array(
                    'name'      => 'gs_wppost_link_tar',
                    'label'     => __( 'Post Link Target', 'gswpposts' ),
                    'desc'      => __( 'Specify target to load the Links, Default New Tab ', 'gswpposts' ),
                    'type'      => 'select',
                    'default'   => '_blank',
                    'options'   => array(
                        '_blank'    => 'New Tab',
                        '_self'     => 'Same Window'
                    )
                ),
                // wppost Detail Description character control
                array(
                    'name'  => 'gs_wppost_details_contl',
                    'label' => __( 'Details Character Control', 'gswpposts' ),
                    'desc'  => __( 'Set max number of characters in Post details. Default 100 & Max 300', 'gswpposts' ),
                    'type'  => 'number',
                    'min'   => 1,
                    'max'   => 300,
                    'default' => 100
                ),
                // Read More Name
                array(
                   'name'    => 'gs_wppost_details_readmore',
                   'label'   => __( 'Read More Button Text', 'gswpposts' ),
                   'desc'    => __( 'Read More text for post details', 'gswpposts' ),
                    'default'   => 'Read More',
                    'type'    => 'text'
                )
            ), // end of wppost Settings nav, 'gs_wpposts_option_01_settings'
            // Start of wppost settings nav, 'gs_wpposts_option_02_settings'
            'gs_wpposts_option_02_settings' => array(
                // wppost Name
                array(
                    'name'      => 'gs_wppost_title',
                    'label'     => __( 'Post Name', 'gswpposts' ),
                    'desc'      => __( 'Show or Hide All Posts Name', 'gswpposts' ),
                    'type'      => 'switch',
                    'switch_default' => 'ON'
                ),
                // wppost Description/Details
                array(
                    'name'      => 'gs_wppost_details',
                    'label'     => __( 'Post Details', 'gswpposts' ),
                    'desc'      => __( 'Show or Hide All Posts Details', 'gswpposts' ),
                    'type'      => 'switch',
                    'switch_default' => 'ON'
                ),
                // wppost Description/Details
                array(
                    'name'      => 'gs_wppost_author',
                    'label'     => __( 'Post Author', 'gswpposts' ),
                    'desc'      => __( 'Show or Hide All Posts Author', 'gswpposts' ),
                    'type'      => 'switch',
                    'switch_default' => 'ON'
                ),
                // wppost Description/Details
                array(
                    'name'      => 'gs_wppost_date',
                    'label'     => __( 'Post Date', 'gswpposts' ),
                    'desc'      => __( 'Show or Hide All Posts Date', 'gswpposts' ),
                    'type'      => 'switch',
                    'switch_default' => 'ON'
                ),
                array(
                    'name'      => 'gs_wppost_category',
                    'label'     => __( 'Post Category', 'gswpposts' ),
                    'desc'      => __( 'Show or Hide All Posts Category', 'gswpposts' ),
                    'type'      => 'switch',
                    'switch_default' => 'ON'
                ),
                array(
                    'name'      => 'gs_wppost_tag',
                    'label'     => __( 'Post Tag', 'gswpposts' ),
                    'desc'      => __( 'Show or Hide All Posts Tag', 'gswpposts' ),
                    'type'      => 'switch',
                    'switch_default' => 'ON'
                ),
                array(
                    'name'      => 'gs_wppost_pagination',
                    'label'     => __( 'Post Pagination', 'gswpposts' ),
                    'desc'      => __( 'Show or Hide Post Pagination' , 'gswpposts' ),
                    'type'      => 'switch',
                    'switch_default' => 'ON'
                )

            ), // end of wppost Settings nav, 'gs_wpposts_option_02_settings'

            // start of Style Settings nav array, 'gs_wpposts_style_settings'
            'gs_wpposts_style_settings' => array(
                array(
                    'name'      => 'gs_posts_grid_setting_banner',
                    'label'     => __( '', 'gswpposts' ),
                    'desc'      => __( '<p class="gspost_grid_pro">Available at <a href="https://www.gsplugins.com/product/wordpress-posts-grid/" target="_blank">PRO</a> version.</p>', 'gswpposts' ),
                    'row_classes' => 'gsptgd_banner'
                ),
                // Font Size
                array(
                    'name'      => 'gs_wppost_fz',
                    'label'     => __( 'Font Size', 'gswpposts' ),
                    'desc'      => __( 'Set Font Size for <b>Post Title</b>', 'gswpposts' ),
                    'type'      => 'number',
                    'default'   => '18',
                    'options'   => array(
                        'min'   => 1,
                        'max'   => 30,
                        'default' => 18
                    )
                ),
                // Font weight
                array(
                    'name'      => 'gs_wppost_fntw',
                    'label'     => __( 'Font Weight', 'gswpposts' ),
                    'desc'      => __( 'Select Font Weight for <b>Post Title</b>', 'gswpposts' ),
                    'type'      => 'select',
                    'default'   => 'normal',
                    'options'   => array(
                        'normal'    => 'Normal',
                        'bold'      => 'Bold',
                        'lighter'   => 'Lighter'
                    )
                ),
                // Font style
                array(
                    'name'      => 'gs_wppost_fnstyl',
                    'label'     => __( 'Font Style', 'gswpposts' ),
                    'desc'      => __( 'Select Font Weight for <b>Post Title</b>', 'gswpposts' ),
                    'type'      => 'select',
                    'default'   => 'normal',
                    'options'   => array(
                        'normal'    => 'Normal',
                        'italic'      => 'Italic'
                    )
                ),
                // Font Color of wppost Name
                // array(
                //     'name'    => 'gs_wppost_name_color',
                //     'label'   => __( 'Font Color', 'gswpposts' ),
                //     'desc'    => __( 'Select color for <b>Post Title</b>.', 'gswpposts' ),
                //     'type'    => 'color',
                //     'default' => '#141412'
                // ),
                // Label Font Size
                // array(
                //     'name'      => 'gs_wppost_label_fz',
                //     'label'     => __( 'Label Font Size', 'gswpposts' ),
                //     'desc'      => __( 'Set Font Size for <b>Post Label</b>', 'gswpposts' ),
                //     'type'      => 'number',
                //     'default'   => '18',
                //     'options'   => array(
                //         'min'   => 1,
                //         'max'   => 30,
                //         'default' => 18
                //     )
                // ),
                // Label Font Color
                array(
                   'name'    => 'gs_wppost_label_color',
                   'label'   => __( 'Label Font Color', 'gswpposts' ),
                   'desc'    => __( 'Select color for <b>Post Label</b>.', 'gswpposts' ),
                   'type'    => 'color',
                   'default' => '#0BF'
                ),
                // Filter name Align
                array(
                   'name'    => 'gs_wppost_filter_align',
                   'label'   => __( 'Filter Name Align', 'gswpposts' ),
                   'desc'    => __( 'Filter name alignment for <b> Filter Theme</b>.', 'gswpposts' ),
                   'type'      => 'select',
                    'default'   => 'center',
                    'options'   => array(
                        'center'    => 'Center',
                        'left'  => 'Left',
                        'right' => 'Right'
                    )
                ),
                // All filter Name
                array(
                   'name'    => 'gs_wppost_filter_name',
                   'label'   => __( 'All Filter Name', 'gswpposts' ),
                   'desc'    => __( 'Replace <b>All</b> to your desired word for filter theme', 'gswpposts' ),
                    'default'   => 'All',
                    'type'    => 'text'
                ),
                // wpposts Custom CSS
                array(
                    'name'    => 'gs_wppost_custom_css',
                    'label'   => __( 'Post Custom CSS', 'gswpposts' ),
                    'desc'    => __( 'You can write your own custom css', 'gswpposts' ),
                    'type'    => 'textarea'
                ),
            ) // end of Style Settings nav array, 'gs_wpposts_style_settings'
            
        ); //end of $settings_fields
        return $settings_fields;
    } // end of function get_settings_fields()

    function plugin_page() {
        // settings_errors();
        echo '<div class="wrap gs_wpposts_wrap" style="width: 845px; float: left;">';
        // echo '<div id="post-body-content">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';

        ?>
            <div class="gswps-admin-sidebar" style="width: 277px; float: left; margin-top: 62px;">
                <div class="postbox">
                    <h3 class="hndle"><span><?php _e( 'Support / Report a bug' ) ?></span></h3>
                    <div class="inside centered">
                        <p>Please feel free to let us know if you have any bugs to report. Your report / suggestion can make the plugin awesome!</p>
                        <p style="margin-bottom: 1px! important;"><a href="https://www.gsplugins.com/contact/" target="_blank" class="button button-primary">Get Support</a></p>
                    </div>
                </div>
                <div class="postbox">
                    <h3 class="hndle"><span><?php _e( 'Buy me a coffee' ) ?></span></h3>
                    <div class="inside centered">
                        <p>If you like the plugin, please buy me a coffee to inspire me to develop further.</p>
                        <p style="margin-bottom: 1px! important;"><a href='https://www.paypal.com/donate/?hosted_button_id=K7K8YF4U3SCNQ' class="button button-primary" target="_blank">Donate</a></p>
                    </div>
                </div>

                <div class="postbox">
                    <h3 class="hndle"><span><?php _e( 'Join GS Plugins on facebook' ) ?></span></h3>
                    <div class="inside centered">
                        <iframe src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/gsplugins&amp;width&amp;height=258&amp;colorscheme=dark&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=723137171103956" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:220px;" allowTransparency="true"></iframe>
                    </div>
                </div>

                <div class="postbox">
                    <h3 class="hndle"><span><?php _e( 'Follow GS Plugins on twitter' ) ?></span></h3>
                    <div class="inside centered">
                        <a href="https://twitter.com/gsplugins" target="_blank" class="button button-secondary">Follow @gsplugins<span class="dashicons dashicons-twitter" style="position: relative; top: 3px; margin-left: 3px; color: #0fb9da;"></span></a>
                    </div>
                </div>
            </div>
        <?php
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }
}
endif;

$settings = new gs_Wpposts_Settings_Config();