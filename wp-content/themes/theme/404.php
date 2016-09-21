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
 	<p class="alert alert-danger">
 		Xin lỗi trang không tìm thấy!
		<span>Nhấn <a href="<?php echo home_url()?>"><strong>vào đây</strong> để trở về trang chủ</a>
			Hoặc trang sẽ tự chuyển sau <strong><span id="timer">10s</span></strong>
		</span>
 	</p>
 	
</div>
</div>
<!-- end wrapper main-->
<script>
	jQuery(document).ready(function(){
		var time = 10;
		var runTime = setInterval(function(){
			time -= 1;
			jQuery('#timer').text(time);
			if(time <= 0){
				clearInterval(runTime);
				window.location = '<?php echo home_url() ?>'
			}
		},1000);
	})
</script>
<!-- #main-content -->
<?php
get_footer();    


            