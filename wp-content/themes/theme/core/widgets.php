<?php
/**
 * Created by PhpStorm.
 * User: Van-Cao
 * Date: 05/08/2014
 * Time: 23:16
 */
function kienbien_widgets_init() {

     register_sidebar(array(
        'name' => __('Hiển thị trang chủ', 'kienbien'),
        'id' => 'home-widget',
        'description' => __('Hiển thị trên trang chủ', 'kienbien'),
        'before_widget' => '<div class="panel panel-primary list-real-home">',
        'after_widget' => '</div>',
        'before_title' => '<div class="panel-heading">',
        'after_title' => '</div>',
    ));

      register_sidebar(array(
        'name' => __('Tin tức', 'kienbien'),
        'id' => 'news-sidebar',
        'description' => __('Tin tức', 'kienbien'),
        'before_widget' => '<div class="panel panel-default list-news">',
        'after_widget' => '</div>',
        'before_title' => '<div class="panel-heading">',
        'after_title' => '</div>',

    ));

    register_sidebar(array(
        'name' => __('Quảng cáo trên', 'kienbien'),
        'id' => 'ads-top',
        'description' => __('Quảng cáo trên', 'kienbien'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '',
        'after_title' => '',

    ));
      register_sidebar(array(
        'name' => __('Quảng cáo phải', 'kienbien'),
        'id' => 'ads-left',
        'description' => __('Quảng cáo bên phải.', 'kienbien'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '',
        'after_title' => '',

    ));
       register_sidebar(array(
        'name' => __('Quảng cáo ngoài cùng bên phải', 'kienbien'),
        'id' => 'ads-floatright',
        'description' => __('Quảng cáo ngoài cùng bên phải.', 'kienbien'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '',
        'after_title' => '',

    ));
       register_sidebar(array(
        'name' => __('Quảng cáo ngoài cùng bên trái', 'kienbien'),
        'id' => 'ads-floatleft',
        'description' => __('Quảng cáo ngoài cùng bên trái.', 'kienbien'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '',
        'after_title' => '',

    ));
      register_sidebar(array(
        'name' => __('Support', 'kienbien'),
        'id' => 'sidebar-3',
        'description' => __('Support.', 'kienbien'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',

    ));

    register_sidebar(array(
        'name' => __('Footer Info 1', 'kienbien'),
        'id' => 'footer-info-1',
        'description' => __('Footer Info 1', 'kienbien'),
        'before_widget' => '<aside id="item" class="item">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="footer-title">',
        'after_title' => '</h5>',
    ));

    register_sidebar(array(
        'name' => __('Footer Info 2', 'kienbien'),
        'id' => 'footer-info-2',
        'description' => __('Footer Info 2', 'kienbien'),
        'before_widget' => '<aside id="item" class="item">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="footer-title">',
        'after_title' => '</h5>',
    ));

    register_sidebar(array(
        'name' => __('Footer Info 3', 'kienbien'),
        'id' => 'footer-info-3',
        'description' => __('Footer Info 3', 'kienbien'),
        'before_widget' => '<aside id="item" class="item">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="footer-title">',
        'after_title' => '</h5>',
    ));

   


   

}

add_action('widgets_init', 'kienbien_widgets_init');

