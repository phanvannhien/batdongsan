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
	<!-- # Add float left -->
	<div id="float-left">
		<?php dynamic_sidebar('ads-floatleft')?>
	</div>
	<div id="sidebar">
		<?php get_sidebar();?>
	</div>
	<!-- # side bar -->
	<div id="content-primary">
		<?php
			include(TEMPLATEPATH.'/inc/top-news.php');
			include(TEMPLATEPATH.'/inc/content-home.php');
		?>
	</div>
	<!-- # content-primary-->
	<!-- # Add float right -->
	<div id="float-right">
		<?php dynamic_sidebar('ads-floatright')?>
	</div>
</div>
<!-- #main-content -->
</div>
<!-- end wrapper main-->

<?php
get_footer();
