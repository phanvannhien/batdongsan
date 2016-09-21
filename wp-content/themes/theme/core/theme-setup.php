<?php

show_admin_bar(false);

// flush_rules() if our rules are not yet included
add_action('wp_loaded', 'flush_rules');
function flush_rules() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}


// hook add_rewrite_rules function into rewrite_rules_array
add_filter('rewrite_rules_array', 'real_rewrite_rules');
function real_rewrite_rules($aRules) {
    $aNewRules = array(
        'bat-dong-san/([^/]+)/([^/]+)/?$' =>  'index.php?pagename=real&real_slug=$matches[1]&real_id=$matches[2]',
        //'quan-ly-tin/p([0-9]{1,})/?$' =>  'index.php?pagename=realmanager&page=$matches[1]'
        //'quan-ly-tin/p([0-9]{1,})/?$' =>  'index.php?pagename=realmanager&page=$matches[1]'
        //'danh-muc/([^/]+)/p([0-9]{1,})/?$'=> 'index.php?danh-muc=$matches[1]&page=$matches[2]'
    );
    $aRules = $aNewRules + $aRules;
    return $aRules;
}



add_filter('query_vars', 'real_query_vars');
function real_query_vars($vars) {
    $vars[] = 'real_id';
    $vars[] = 'real_slug';
    //$vars[] = 'page';
    return $vars;
}

//register plugin custom pages display
add_filter('template_include', 'real_display');

function real_display($path) {
    $page = get_query_var('pagename');
    $real_id = get_query_var('real_id');
    if ('real' == $page && '' != $real_id){
        return get_template_directory() . '/page-templates/template-real-detail.php';
    }

    return $path;
    
}


add_filter('wp_title', 'custom_theme_title');
function custom_theme_title(){
    global $wpdb;
    global $paged, $page;

    $Real = new KBBDS();
    if (is_feed()) {
        return $title;
    }
    // Add the site name.
    $title .= get_bloginfo('name', 'display');
    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page())) {
        return $title .= " | $site_description";
    }

    if (get_query_var('pagename') == 'real' && get_query_var('real_id')) {
        $readID = get_query_var('real_id');
        $real = $Real->getRealByID($readID);
        
        if($real){
             return $real->bds_name . ' | ' . $site_description;
        }
       
       
    } 
    return $site_description;
}

add_action('after_setup_theme', 'themes_setup');
if (!function_exists('themes_setup')) :
    function themes_setup() {
        load_theme_textdomain('theme_language', get_template_directory() . '/languages');
        
        // Add RSS feed links to <head> for posts and comments.
        add_theme_support('automatic-feed-links');

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(672, 372, true);

        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
        ));


    }
endif; // themes_setup

add_action('init','create_cat_bds');
function create_cat_bds(){
    // Create product taxonomy
    register_taxonomy('danh-muc', 'post', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Danh mục',THEME_LANG),
            'singular_name' => __('Danh mục',THEME_LANG),
            'add_new' => __('Thêm mới',THEME_LANG),
            'add_new_item' => __('Thêm mới',THEME_LANG),
            'new_item' => __('Thêm mới',THEME_LANG),
            'search_items' => __('Tìm Danh mục',THEME_LANG),
        ),
        'rewrite' => array('with_front' => false),
    ));

    // Create product taxonomy
    register_taxonomy('dia-diem', 'post', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Địa điểm',THEME_LANG),
            'singular_name' => __('Địa điểm',THEME_LANG),
            'add_new' => __('Thêm mới',THEME_LANG),
            'add_new_item' => __('Thêm mới',THEME_LANG),
            'new_item' => __('Thêm mới',THEME_LANG),
            'search_items' => __('Tìm Địa điểm',THEME_LANG),
        ),
    ));


    // Create product taxonomy
    register_taxonomy('loai-bat-dong-san', 'post', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Loại BDS',THEME_LANG),
            'singular_name' => __('Loại BDS',THEME_LANG),
            'add_new' => __('Thêm mới',THEME_LANG),
            'add_new_item' => __('Thêm mới',THEME_LANG),
            'new_item' => __('Thêm mới',THEME_LANG),
            'search_items' => __('Tìm Loại BDS',THEME_LANG),
        ),
    ));
}


//add_action('init','create_theme_components');
    // Create product post type
function create_theme_components(){
    register_post_type(
            'product', array(
                'labels' => array(
                    'name' => __('Product',THEME_LANG),
                    'singular_name' => __('Product',THEME_LANG),
                    'add_new' => __('Add New',THEME_LANG),
                    'add_new_item' => __('Add New Product',THEME_LANG),
                    'edit' => __('Edit',THEME_LANG),
                    'edit_item' => __('Edit Product',THEME_LANG),
                    'new_item' => __('New Product',THEME_LANG),
                    'view' => __('View Product',THEME_LANG),
                    'view_item' => __('View Product',THEME_LANG),
                    'search_items' => __('Search Products',THEME_LANG),
                    'not_found' => __('No Products found',THEME_LANG),
                    'not_found_in_trash' => __('No Products found in Trash',THEME_LANG)
                ),
                'public' => true,
                'show_ui' => true,
                'publicy_queryable' => true,
                'exclude_from_search' => false,
                'menu_position' => 21,
                //'menu_icon' => 'product.png',
                'hierarchical' => false,
                'query_var' => true,
                'supports' => array(
                'title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail',
                'custom-fields'
                ),
                'rewrite' => array('slug' => 'product', 'with_front' => false),
                //'taxonomies' =>  array('post_tag', 'category'),
                'can_export' => true,
                //'register_meta_box_cb'  =>  'call_to_function_do_something',
                'description' => __('Product description here.',THEME_LANG)
            )
        );
    // Create product taxonomy
    register_taxonomy('cat-product', 'product', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Product Categories',THEME_LANG),
            'singular_name' => __('Product Category',THEME_LANG),
            'add_new' => __('Add New',THEME_LANG),
            'add_new_item' => __('Add New Product Category',THEME_LANG),
            'new_item' => __('New Product Category',THEME_LANG),
            'search_items' => __('Search Product Category',THEME_LANG),
        ),
    ));

    // Create product meta box

    $meta_box_product = array();
    $meta_box_product[] = array(
                'id' => 'product_properties',
                'title' => __('Product Properties',THEME_LANG),
                'pages' => array('product'),
                'fields' => array(
                    array(
                        'name' => __('Product Price',THEME_LANG),
                        'id' => 'product' . '_price',
                        'type' => 'text',
                    )
                    ,
                     array(
                        'name' => __('Product SKU',THEME_LANG ),
                        'id' => 'product' .'_sku',
                        'type' => 'text',
                    )
                    ,
                     array(
                        'name' => __('Product Guarantee',THEME_LANG ),
                        'id' => 'product' .'_guarantee',
                        'type' => 'text',
                    )
                    ,
                     array(
                        'name' => __('Product Technial',THEME_LANG),
                        'id' => 'product' .'_technial',
                        'type' => 'wysiwyg',
                    ),
                     array(
                        'name' => __('Product Gallery',THEME_LANG),
                        'id' => 'product' .'_gallery',
                        'type' => 'image_advanced',
                    ),
                      
                    array(
                        'name' => __('Product Video',THEME_LANG),
                        'id' => 'product' .'_video',
                        'type' => 'wysiwyg',
                    ),
                    array(
                        'name' => __('Product Catalogul',THEME_LANG),
                        'id' => 'product' .'_catalogul',
                        'type' => 'wysiwyg',
                    )
             
                    // Other fields go here
                )
            );

    register_post_type(
            'staircase', array(
                'labels' => array(
                    'name' => __('Staircase',THEME_LANG),
                    'singular_name' => __('Staircase',THEME_LANG),
                    'add_new' => __('Add New',THEME_LANG),
                    'add_new_item' => __('Add New Staircase',THEME_LANG),
                    'edit' => __('Edit',THEME_LANG),
                    'edit_item' => __('Edit Staircase',THEME_LANG),
                    'new_item' => __('New Staircase',THEME_LANG),
                    'view' => __('View Staircase',THEME_LANG),
                    'view_item' => __('View Staircase',THEME_LANG),
                    'search_items' => __('Search Staircase',THEME_LANG),
                    'not_found' => __('No Staircase found',THEME_LANG),
                    'not_found_in_trash' => __('No Staircase found in Trash',THEME_LANG)
                ),
                'public' => true,
                'show_ui' => true,
                'publicy_queryable' => true,
                'exclude_from_search' => false,
                'menu_position' => 21,
                //'menu_icon' => 'product.png',
                'hierarchical' => false,
                'query_var' => true,
                'supports' => array(
                'title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail',
                'custom-fields'
                ),
                'rewrite' => array('slug' => 'staircase', 'with_front' => false),
                //'taxonomies' =>  array('post_tag', 'category'),
                'can_export' => true,
                //'register_meta_box_cb'  =>  'call_to_function_do_something',
                'description' => __('Staircase description here.',THEME_LANG)
            )
        );

      // Create product meta box

    $meta_box_staircase = array();
    $meta_box_staircase[] = array(
                'id' => 'staircase_properties',
                'title' => __('Staircase Properties',THEME_LANG),
                'pages' => array('staircase'),
                'fields' => array(
                    array(
                        'name' => __('Technial Infomation',THEME_LANG),
                        'id' => 'staircase' . '_technial',
                        'type' => 'wysiwyg',
                    )
                    ,
                     array(
                        'name' => __('Staircase Image',THEME_LANG),
                        'id' => 'staircase' .'_gallery',
                        'type' => 'image_advanced',
                    ),
                      array(
                        'name' => __('Staircase Video',THEME_LANG),
                        'id' => 'staircase' .'_video',
                        'type' => 'wysiwyg',
                    ),
                    array(
                        'name' => __('Staircase Catalogul',THEME_LANG),
                        'id' => 'staircase' .'_catalogul',
                        'type' => 'wysiwyg',
                    )
                    
                    // Other fields go here
                )
            );
    
    register_post_type(
            'building', array(
                'labels' => array(
                    'name' => __('Building',THEME_LANG),
                    'singular_name' => __('Building',THEME_LANG),
                    'add_new' => __('Add New',THEME_LANG),
                    'add_new_item' => __('Add New Building',THEME_LANG),
                    'edit' => __('Edit',THEME_LANG),
                    'edit_item' => __('Edit Building',THEME_LANG),
                    'new_item' => __('New Building',THEME_LANG),
                    'view' => __('View Building',THEME_LANG),
                    'view_item' => __('View Building',THEME_LANG),
                    'search_items' => __('Search Building',THEME_LANG),
                    'not_found' => __('No Building found',THEME_LANG),
                    'not_found_in_trash' => __('No Building found in Trash',THEME_LANG)
                ),
                'public' => true,
                'show_ui' => true,
                'publicy_queryable' => true,
                'exclude_from_search' => false,
                'menu_position' => 21,
                //'menu_icon' => 'product.png',
                'hierarchical' => false,
                'query_var' => true,
                'supports' => array(
                'title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail',
                'custom-fields'
                ),
                'rewrite' => array('slug' => 'building', 'with_front' => false),
                //'taxonomies' =>  array('post_tag', 'category'),
                'can_export' => true,
                //'register_meta_box_cb'  =>  'call_to_function_do_something',
                'description' => __('Building description here.',THEME_LANG)
            )
        );
    
     // Create building taxonomy
    register_taxonomy('cat-building', 'building', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Building Categories',THEME_LANG),
            'singular_name' => __('Building Category',THEME_LANG),
            'add_new' => __('Add New',THEME_LANG),
            'add_new_item' => __('Add New Building Category',THEME_LANG),
            'new_item' => __('New Building Category',THEME_LANG),
            'search_items' => __('Search Building Category',THEME_LANG),
        ),
    ));

    // Check if class KienBien exists
    if(class_exists('KienBien')){
        $kienbien = new KienBien();
    }

    if (class_exists('RW_Meta_Box')) {
       foreach ($meta_box_product as $mb) {
            //echo '<pre>';
            //var_dump($mb);
            new RW_Meta_Box($mb);
        }   

         foreach ($meta_box_staircase as $mb) {
            //echo '<pre>';
            //var_dump($mb);
            new RW_Meta_Box($mb);
        }   
    }
    
        
} // end create_theme_components

