<?php ob_start();session_start();?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
     <!--<![endif]-->
     <head>
          <meta charset="<?php bloginfo('charset'); ?>">
          <meta name="viewport" content="width=device-width">
          <title><?php wp_title('|', true, 'right'); ?></title>
          <link rel="profile" href="http://gmpg.org/xfn/11">
          <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
          <!--[if lt IE 9]>
          <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
          <![endif]-->
          <?php wp_head(); ?>
          <script>
          var url_ajax = "<?php echo admin_url('admin-ajax.php');?>";
          </script>
     </head>
     <body> 
        <div id="page" class="">
          <div id="top" class="">
            <div class="wrapper">
              <div class="clearfix">
                <p class="pull-left">
                  <i class="fa fa-phone color-red fa-lg"></i> Hotline: <b><?php echo get_option('phone')?></b>
                  Hỗ trợ trực tuyến
                </p>
                <p class="pull-right"><a href="#" id="support-link"> <i class="fa fa-support fa-lg "></i> Quảng cáo & Trợ giúp</a></p>
              </div>
            </div>

          </div>
          <!-- end #top-->

    

          <div class="wrapper">
            <div id="banner" class="">
              <div class="clearfix">
                 <div id="logo" class="pull-left"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" width="265px"/></div>
                  <div id="ads-top" class="pull-right">
                    <?php dynamic_sidebar('ads-top')?>
                  </div>
              </div>
            </div>
            <!-- end #banner-->
             <div id="main-nav" class="navigation-bar">
                    <?php
                      wp_nav_menu(
                          array(
                               'theme_location' => 'primary',
                               'container_class' => '',
                               'container_id' => 'nav-bar-main-container',
                               'menu_class' => 'clearfix',
                               'menu_id' => 'nav-bar-main',
                          )
                       );
                    ?>
             
              </div>  
               <script>
              jQuery(document).ready(function(){
                jQuery('#nav-bar-main > li:last-child > a').before('<i class="fa fa-newspaper-o fa-lg color-white padding-right5"></i>');
              });
              </script>
              <!-- end #main-nav-->
              <div id="control-bar" class="">

                  <div class="clearfix">
                    <div class="breadcrumbs pull-left">
                        <?php if(function_exists('bcn_display'))
                        {
                            bcn_display();
                        }?>
                    </div>
                    <div id="user-holder" class="pull-right">
                      
                      <?php if(is_user_logged_in()){ 

                        $current_user = wp_get_current_user();?>
                      <a href="/?page_id=47"><i class="fa fa-user fa-lg color-gray"></i>Chào: <?php echo $current_user->user_login ?></a> | <a href="<?php echo wp_logout_url( home_url())?>" title="Đăng xuất">Đăng xuất</a>
                      
                      <?php 

                      }else{//end if
                        $registerPageLink = get_page_link(50);
                        $loginPageLink = get_page_link(47);
                        ?>
                      <a href="<?php echo $registerPageLink; ?>" id="us-register">Đăng kí <i class="fa fa-users fa-lg color-gray"></i></a>
                      <a href="<?php echo $loginPageLink; ?>">Đăng nhập <i class="fa fa-user fa-lg color-gray"></i></a>
                      <?php }?>
                    </div>
                  </div>  
              </div>
              <!-- end #control-bar-->
              <?php 
                if(is_home())
                  include(TEMPLATEPATH.'/inc/search.php')
              ?>
           
             

          
        
         

