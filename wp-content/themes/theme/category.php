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
?>
<?php
    get_header(); 
?>

<div id="main-content" class="clearfix">
    <div id="sidebar">
        <?php get_sidebar()?>
    </div>
    <!-- # side bar -->

    <div id="content-primary">
        <h2><?php single_cat_title();?></h2>
        <div class="content-news">
            
        
        <?php
               
            while (have_posts()) {
                    the_post();
                    ?>
                    <div class="news-item clearfix">     
                        <div class="c30 pull-left">
                            <a href="<?php the_permalink()?>">
                            <?php resizeThumnail($post->ID,180,120,'thumb',get_the_title()) ?>
                            </a>
                        </div>
                         <div class="c70 pull-left">
                            <h3><a href="<?php the_permalink()?>"><?php the_title()?></a> </h3>
                            <div class="info-bar"><span><i class="fa fa-edit fa-lg"></i> <?php  the_modified_date('');?></span></div>
                            <div class="excerpt">
                                <?php the_excerpt();?>
                            </div>
                        </div>
                    </div>   
                    <?php
                }//endwhile
            ?>
        </div>
        <div class="pagination">
            <?php
                if (function_exists('wp_pagenavi'))
                    wp_pagenavi();
            ?>
        </div>

    </div>

</div>
<!-- #main-content -->
</div>
<!-- end wrapper main-->
<?php
get_footer();    


            