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
        
        <?php     
            while (have_posts()) {
                    the_post();
                    ?>

                    <h2><?php the_title();?></h2>
                    
                    <div class="content-single">
                        <h4>
                            <?php the_excerpt()?>
                        </h4>
                        <?php the_content()?>
                    </div>
                    <div class="news-info-bar clearfix" >
                        <div id="social" class="pull-right">
                            <?php showSocial(get_permalink())?>
                        </div>
                    </div>
                    <?php
                }//endwhile
        ?>
       
    </div>
</div>
<!-- #main-content -->
</div>
<!-- end wrapper main-->
<?php
get_footer();    


            