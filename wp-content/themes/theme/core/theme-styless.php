<?php
function theme_add_style_scripts() {
    
    // Add Genericons font, used in the main stylesheet.
    // Load our main stylesheet.
    wp_enqueue_script('jQuery');
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style('theme-ie', get_template_directory_uri() . '/css/ie.css', array('theme-style'));
    wp_style_add_data('theme-ie', 'conditional', 'lt IE 9');
    //wp_enqueue_style('bootstrap-font', get_template_directory_uri() . '/css/iconFont.min.css');
    //wp_enqueue_style('bootstrap-metro-css-res', get_template_directory_uri() . '/css/metro-bootstrap-responsive.css');
    // Custom javascript for them
    wp_enqueue_style('ico-lib', get_template_directory_uri() . '/css/font-awesome.css', array('theme-style'));
    
    //wp_enqueue_script('jquery-2', get_template_directory_uri() . '/js/jquery.min.js');
    // Tabs
    wp_enqueue_script('has-change', get_template_directory_uri() . '/js/jquery.hashchange.min.js', array( 'jquery' ));
    wp_enqueue_script('easy-tab', get_template_directory_uri() . '/js/jquery.easytabs.min.js', array( 'jquery' ));
    // Jquery Ui
    wp_enqueue_script('ui-js', get_template_directory_uri() . '/js/jquery-ui.js', array( 'jquery' ));
    wp_enqueue_style('ui-css', get_template_directory_uri() . '/css/jquery-ui.css',array('theme-style'));
    

    wp_enqueue_script('validate-js', get_template_directory_uri() . '/js/jquery.validate.min.js', array( 'jquery' ));
    //wp_enqueue_script('support-js', get_template_directory_uri() . '/js/float-right.js', array( 'jquery' ));
    wp_enqueue_script('theme-js', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ),false,true);
    
    if(is_page(52)){
        wp_enqueue_media();
    }
    

    wp_enqueue_script('popup-js', get_template_directory_uri() . '/js/jquery.simplemodal.1.4.4.min.js', array( 'jquery' ));

    // Tooltip
    // Add the styles first, in the <head> (last parameter false, true = bottom of page!)

    wp_enqueue_style('qtip-css', get_template_directory_uri().'/script/qtip/jquery.qtip.min.css', null, false, false);
    wp_enqueue_script('qtip-js',get_template_directory_uri().'/script/qtip/jquery.qtip.min.js', array('jquery'), false, true);
    // plex slider
    wp_enqueue_script('flex-js', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ));
    wp_enqueue_style('flex-css', get_template_directory_uri() . '/css/flexslider.css',array('theme-style'));
}
add_action('wp_enqueue_scripts', 'theme_add_style_scripts');
