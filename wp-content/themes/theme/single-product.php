<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<?php
    $current_user = wp_get_current_user();
    if($current_user && $current_user != ''){
        $user_email = $current_user->user_email;
        $user_name = $current_user->display_name;
    }

    $cart_page = get_id_by_slug('cart');
    $cart_page_url = get_page_link($cart_page);

    $quote_page = get_page_link(79);
?>

<div id="main-content" class="container clearfix">
    <div class="row">
     <?php get_sidebar();?>
      <section id="content" class="col span_9">
            <?php
                while (have_posts()) {
                    global $wpdb;
                    $images = get_post_meta( get_the_ID(), 'product_gallery', false );
                    $images = implode( ',' , $images );
                    // Re-arrange images with 'menu_order'
                    $images = $wpdb->get_col( "
                        SELECT ID FROM {$wpdb->posts}
                        WHERE post_type = 'attachment'
                        AND ID in ({$images})
                        ORDER BY menu_order ASC
                    " );
                    the_post();
                    ?>  
                      
                            <div class="title clearfix">
                                <h2><?php the_title();?></h2>
                            </div>
                            <div class="clearfix">
                            <div class="product-media col span_6">
                                <?php the_post_thumbnail(array(300,300 ));?>
                            </div>   

                            <div class="product-des col span_6">
                                <div class="p-info">
                                    <ul>
                                        <li>
                                            Tên sản phẩm: <?php the_title()?>
                                        </li>
                                        <li>
                                            Mã sản phẩm: <?php echo get_post_meta($post->ID,'product_sku',true)?>
                                        </li>
                                        <li>
                                           Bảo hành: <?php echo get_post_meta($post->ID,'product_guarantee',true)?>
                                        </li>
                                        <li>
                                           Giá cả: <?php echo number_format(get_post_meta($post->ID,'product_price',true))?>
                                        </li>
                                    </ul>
                                </div>
                               
                                <div class="product-toolbar">
                                    <a class="btn-default" href="/bao-gia-san-pham"><?php _e('Báo giá',KB_TEXT_DOMAIN)?></a>
                                    <a class="btn-default" href="/gio-hang?action=add&pid=<?php echo $post->ID?>"><?php _e('Mua Hàng',KB_TEXT_DOMAIN)?></a>
                                    <a class="btn-default" href="/gio-hang"><?php _e('Giỏ hàng',KB_TEXT_DOMAIN)?></a>
                                
                                </div>    
                            </div>
                            </div>

                         
                            <div class="product-bottom clearfix">
                                <div id="tab-container" class="tab-container">
                                    <ul class='etabs'>
                                        <li class='tab'><a href="#tabs-des">Mô tả</a></li>
                                        <li class='tab'><a href="#tabs-technial">Thông số kỹ thuật</a></li>
                                        <li class='tab'><a href="#tabs-image">Hình ảnh</a></li>
                                        <li class='tab'><a href="#tabs-video">Video</a></li>
                                        <li class='tab'><a href="#tabs-catalogul">Catalogul</a></li>
                                    </ul>
                                    <div id="tabs-des">
                                        <!-- content -->
                                         <div class="the-content">
                                            <?php the_content()?>
                                        </div>
                                    </div>
                                    <div id="tabs-technial">
                                        <!-- content -->
                                        <div class="the-content">    
                                        <?php 
                                            echo get_post_meta($post->ID,'product_technial',true);
                                        ?>
                                        <div>
                                    </div>
                                    <div id="tabs-image">
                                        <!-- content -->
                                        <div class="the-content clearfix"> 
                                            <?php
                                                 foreach ($images as $att) {
                                                    $src = wp_get_attachment_image_src( $att, 'full' );
                                                    $src = $src[0];
                                                    ?>     
                                                        <div class="col span3">  
                                                            <a href="<?php echo $src  ?>" rel="prettyPhoto[]" title="<?php the_title()?>">
                                                                <img src="<?php echo $src  ?>" width="200" height="" alt="<?php the_title()?>" />
                                                            </a>       
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="tabs-video">
                                        <!-- content -->
                                         <div class="the-content"> 
                                            <?php 
                                                echo get_post_meta($post->ID,'product_video',true);
                                            ?>
                                        </div>
                                    </div>
                                    <div id="tabs-catalogul">
                                        <div class="the-content"> 
                                         <?php 
                                            echo get_post_meta($post->ID,'product_catalogul',true);
                                        ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                       
                    <?php
                }//endwhile post tour single main

            ?>
                <div id="product-realated" class="radius5">
                    <div class="title clearfix">
                        <h2><?php _e('Product related')?></h2>
                    </div> 
                    <div class="row clearfix">  
                            <?php
                            $product_related = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => 12,
                                'posts__not_in' => get_the_ID()
                                 )
                            );
                            $i =0;
                            while ( $product_related->have_posts()) {
                                # code...
                                $product_related->the_post();
                                $i++;
                                ?>

                                <div class="item-p col span_3" >
                                    <div class="img-wrap">
                                        <?php the_post_thumbnail(array(120,120))?>
                                    </div>
                                    
                                    <a href="<?php the_permalink()?>"><?php the_title()?></a>
                                    <div class="price">
                                            <span><?php echo get_post_meta($post->ID,'product_price',true)?></span>
                                    </div>
                                    <a class="btn-default radius3" href="/?p=71&action=add&pid=<?php echo $post->ID?>"><i class="fa fa-shopping-cart fa-lg"></i> <?php _e('Mua ngay',THEME_LANG)?></a>
                                    
                                </div>  

                                    
                                <?php
                                    echo ($i % 4 == 0 ) ?'</div><div class="row clearfix">':'';  
                            }
                            ?>

                    </div>
                </div>
                
             
        </section>            
        </div>
        <!-- end row -->
    
</div><!-- #main-content -->
<?php
get_footer();
