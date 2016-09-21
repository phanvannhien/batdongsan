<?php

/*
 * Plugin Name: Setting Option
 * Author: Phan Van Nhien
 * Author URI: antmap.net
 * Description: Setting For Social Page
  /* ------------------------------------------------------------------------ *
 * Setting Registration 
 * ------------------------------------------------------------------------ */
/**
 * Initializes the theme options page by registering the Sections, 
 * Fields, and Settings. 
 * 
 * This function is registered with the 'admin_init' hook. 
 */
add_action('admin_init', 'sandbox_initialize_theme_options');

function sandbox_initialize_theme_options() {

    // First, we register a section. This is necessary since all future options must belong to one.  

    add_settings_field(
            'name', // ID used to identify the field throughout the theme  
            'Name', // The label to the left of the option interface element  
            'sandbox_name_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'name.'
            )
    );

    add_settings_section(
            'general_settings_section', // ID used to identify this section and with which to register options  
            'Themes Options', // Title to be displayed on the administration page  
            'sandbox_general_options_callback', // Callback used to render the description of the section  
            'general'                           // Page on which to add this section of options  
    );



    add_settings_field(
            'facebook', // ID used to identify the field throughout the theme  
            'Facebook', // The label to the left of the option interface element  
            'sandbox_facebook_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Facebook social.'
            )
    );

    add_settings_field(
            'yahoo', // ID used to identify the field throughout the theme  
            'Yahoo ID', // The label to the left of the option interface element  
            'sandbox_yahoo_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Yahoo social.'
            )
    );

    add_settings_field(
            'in', // ID used to identify the field throughout the theme  
            'In', // The label to the left of the option interface element  
            'sandbox_in_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'In social.'
            )
    );

    add_settings_field(
            'youtube', // ID used to identify the field throughout the theme  
            'Youtube', // The label to the left of the option interface element  
            'sandbox_youtube_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Youtube social.'
            )
    );

    add_settings_field(
            'hotline', // ID used to identify the field throughout the theme  
            'Hotline', // The label to the left of the option interface element  
            'sandbox_hotline_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Hotline.'
            )
    );



    add_settings_field(
            'phone', // ID used to identify the field throughout the theme  
            'Phone', // The label to the left of the option interface element  
            'sandbox_phone_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Home Phone - Fax.'
            )
    );

    add_settings_field(
            'fax', // ID used to identify the field throughout the theme  
            'Fax', // The label to the left of the option interface element  
            'sandbox_fax_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Fax.'
            )
    );

    add_settings_field(
            'mail', // ID used to identify the field throughout the theme  
            'Mail', // The label to the left of the option interface element  
            'sandbox_mail_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Email.'
            )
    );





    add_settings_field(
            'address', // ID used to identify the field throughout the theme  
            'Address', // The label to the left of the option interface element  
            'sandbox_address_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Address.'
            )
    );

    add_settings_field(
            'num_post_news', // ID used to identify the field throughout the theme  
            'Number Post News', // The label to the left of the option interface element  
            'sandbox_news_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Number Post News Show on page News.'
            )
    );



    add_settings_field(
            'num_post_project', // ID used to identify the field throughout the theme  
            'Number Post Project', // The label to the left of the option interface element  
            'sandbox_project_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Number Post Project Show on page Project.'
            )
    );
    
    add_settings_field(
            'num_show_home', // ID used to identify the field throughout the theme  
            'Number Show Home Category', // The label to the left of the option interface element  
            'sandbox_num_show_home_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Number Show Home Category.'
            )
    );
    add_settings_field(
            'num_show_slide', // ID used to identify the field throughout the theme  
            'Number Show Home Slide Metro', // The label to the left of the option interface element  
            'sandbox_num_show_slide_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Number Show Home Slide Metro'
            )
    );
    
    add_settings_field(
            'num_show_slide', // ID used to identify the field throughout the theme  
            'Number Show Home Slide Metro', // The label to the left of the option interface element  
            'sandbox_num_show_slide_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Number Show Home Slide Metro'
            )
    );

    add_settings_field(
            'num_pagination', // ID used to identify the field throughout the theme  
            'Number News Limit on Category Page', // The label to the left of the option interface element  
            'sandbox_num_pagination_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  
        'Number News Limit on Category Page.'
            )
    );
     add_settings_field(
            'num_orther_news', // ID used to identify the field throughout the theme  
            'Number Orther News Readmore', // The label to the left of the option interface element  
            'sandbox_num_orther_news_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  
        ''
            )
    );
     add_settings_field(
            'num_slide_footer_news', // ID used to identify the field throughout the theme  
            'Number News Slide Footer', // The label to the left of the option interface element  
            'sandbox_num_slide_footer_news_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  
        ''
            )
    ); 
     
    add_settings_field(
            'skype', // ID used to identify the field throughout the theme  
            'Skype', // The label to the left of the option interface element  
            'sandbox_skype_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Skype Contact.'
            )
    );
     add_settings_field(
            'conditional', // ID used to identify the field throughout the theme  
            'conditional', // The label to the left of the option interface element  
            'sandbox_conditional_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Conditional Customer.'
            )
    );
      add_settings_field(
            'gmap', // ID used to identify the field throughout the theme  
            'gmap', // The label to the left of the option interface element  
            'sandbox_gmap_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Google map Shop.'
            )
    );

     add_settings_field(
            'tour_percent', // ID used to identify the field throughout the theme  
            'Tour Percent (%)', // The label to the left of the option interface element  
            'sandbox_tour_percent_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Tour Percent.'
            )
    );      

    add_settings_field(
            'real_page_id', // ID used to identify the field throughout the theme  
            'Real page ID', // The label to the left of the option interface element  
            'sandbox_real_page_id_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Real page ID.'
            )
    );  
    add_settings_field(
            'real_detail_page_id', // ID used to identify the field throughout the theme  
            'Real detail page ID', // The label to the left of the option interface element  
            'sandbox_real_detail_page_id_callback', // The name of the function responsible for rendering the option interface  
            'general', // The page on which this option will be displayed  
            'general_settings_section', // The name of the section to which this field belongs  
            array(// The array of arguments to pass to the callback. In this case, just a description.  

        'Real detail page ID.'
            )
    );         




    register_setting(
            'general', 'num_pagination'
    );
    register_setting(
            'general', 'num_show_home'
    );
    register_setting(
            'general', 'num_show_slide'
    );
    register_setting(
            'general', 'num_orther_news'
    );
    register_setting(
            'general', 'num_slide_footer_news'
    );
     register_setting(
            'general', 'name'
    );



    register_setting(
            'general', 'facebook'
    );

    register_setting(
            'general', 'twister'
    );

    register_setting(
            'general', 'in'
    );

    register_setting(
            'general', 'youtube'
    );

    register_setting(
            'general', 'hotline'
    );

    register_setting(
            'general', 'address'
    );

    register_setting(
            'general', 'phone'
    );

    register_setting(
            'general', 'fax'
    );

    register_setting(
            'general', 'mail'
    );

    register_setting(
            'general', 'num_post_news'
    );

    register_setting(
            'general', 'num_post_project'
    );

    register_setting(
            'general', 'yahoo'
    );

    register_setting(
            'general', 'skype'
    );
    register_setting(
            'general', 'conditional'
    );
    register_setting(
            'general', 'gmap'
    );
    register_setting(
            'general', 'tour_percent'
    );
     register_setting(
            'general', 'real_page_id'
    );
      register_setting(
            'general', 'real_detail_page_id'
    );
}

function sandbox_general_options_callback() {

    echo '<p>Setting more.</p>';
}

// end sandbox_general_options_callback  

function sandbox_name_callback($args) {

    $html = '<input type="text" value="' . get_option('name') . '" size="50" id="name" name="name"/>';

    echo $html;
}

function sandbox_facebook_callback($args) {



    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field  

    $html = '<input type="text" id="facebook" name="facebook" size="50" value="' . get_option('facebook') . '"/>';



    // Here, we will take the first argument of the array and add it to a label next to the checkbox  
    //$html .= '<label for="show_header"> '  . $args[0] . '</label>';   



    echo $html;
}

function sandbox_twister_callback($args) {

    $html = '<input type="text" value="' . get_option('twister') . '" size="50" id="twister" name="twister"/>';

    echo $html;
}

function sandbox_in_callback($args) {

    $html = '<input type="text" value="' . get_option('in') . '" size="50" id="in" name="in"/>';

    echo $html;
}

function sandbox_youtube_callback($args) {

    $html = '<input type="text" value="' . get_option('youtube') . '" size="50" id="youtube" name="youtube"/>';

    echo $html;
}

function sandbox_hotline_callback($args) {

    $html = '<input type="text" value="' . get_option('hotline') . '" size="50" id="hotline" name="hotline"/>';

    echo $html;
}

function sandbox_phone_callback($args) {

    $html = '<input type="text" value="' . get_option('phone') . '" size="50" id="phone" name="phone"/>';

    echo $html;
}

function sandbox_fax_callback($args) {

    $html = '<input type="text" value="' . get_option('fax') . '" size="50" id="fax" name="fax"/>';

    echo $html;
}

function sandbox_mail_callback($args) {

    $html = '<input type="text" value="' . get_option('mail') . '" size="50" id="mail" name="mail"/>';

    echo $html;
}

function sandbox_address_callback($args) {

    $html = '<input type="text" value="' . get_option('address') . '" size="50" id="address" name="address"/>';

    echo $html;
}

function sandbox_news_callback($args) {

    $html = '<input type="text" value="' . get_option('num_post_news') . '" size="50" id="num_post_news" name="num_post_news"/>';

    echo $html;
}

function sandbox_project_callback($args) {

    $html = '<input type="text" value="' . get_option('num_post_project') . '" size="50" id="num_post_project" name="num_post_project"/>';

    echo $html;
}

function sandbox_yahoo_callback($args) {

    $html = '<input type="text" value="' . get_option('yahoo') . '" size="50" id="yahoo" name="yahoo"/>';

    echo $html;
}

function sandbox_skype_callback($args) {

    $html = '<input type="text" value="' . get_option('skype') . '" size="50" id="skype" name="skype"/>';

    echo $html;
}
function sandbox_num_pagination_callback($args) {

    $html = '<input type="text" value="' . get_option('num_pagination') . '" size="50" id="num_pagination" name="num_pagination"/>';

    echo $html;
}
function sandbox_num_show_home_callback($args) {

    $html = '<input type="text" value="' . get_option('num_show_home') . '" size="50" id="num_show_home" name="num_show_home"/>';

    echo $html;
}
function sandbox_num_show_slide_callback($args) {

    $html = '<input type="text" value="' . get_option('num_show_slide') . '" size="50" id="num_show_slide" name="num_show_slide"/>';

    echo $html;
}
function sandbox_num_orther_news_callback($args) {

    $html = '<input type="text" value="' . get_option('num_orther_news') . '" size="50" id="num_orther_news" name="num_orther_news"/>';

    echo $html;
}
function sandbox_num_slide_footer_news_callback($args) {

    $html = '<input type="text" value="' . get_option('num_slide_footer_news') . '" size="50" id="num_slide_footer_news" name="num_slide_footer_news"/>';

    echo $html;
}
function sandbox_gmap_callback($args) {

    $html = '<textarea cols="70" rows="10" id="gmap" name="gmap">' . get_option('gmap') . '</textarea>';

    echo $html;
}
function sandbox_conditional_callback($args) {

    wp_editor(get_option('conditional'), 'conditional' );

    
    //echo $html;
}
function sandbox_tour_percent_callback($args) {

    $html = '<input type="text" value="' . get_option('tour_percent') . '" size="50" id="tour_percent" name="tour_percent"/>';

    echo $html;
}
// end sandbox_toggle_header_callback
function sandbox_real_page_id_callback($args) {

    $html = '<input type="text" value="' . get_option('real_page_id') . '" size="50" id="real_page_id" name="real_page_id"/>';

    echo $html;
}
function sandbox_real_detail_page_id_callback($args) {

    $html = '<input type="text" value="' . get_option('real_detail_page_id') . '" size="50" id="real_detail_page_id" name="real_detail_page_id"/>';
    echo $html;
}
