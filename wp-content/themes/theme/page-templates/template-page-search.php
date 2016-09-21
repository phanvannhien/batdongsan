<?php
	/*
	*	Template Name: Template page search
	*/
?>
<?php
get_header(); ?>
<div id="main-content" class="main-content row">
     <div class="col-lg-12 col-md-12 col-sm-12" id="content">
            <div class="row">
            <!--BEGIN LEFT-->
            <div class="col-lg-3" id="left">
                 <?php get_sidebar(); ?>
                 <?php dynamic_sidebar( 'sidebar-4' ); ?>
            </div>
            <!--END LEFT-->
            <!--BEGIN CONTENT-->
            <div class="col-lg-9" id="right">
                <h3>Search result</h3>
                <?php
                	//var_dump($_POST);
                         $tour_type = $_POST['tour_type'];
                         $diem_khoi_hanh = $_POST['diem_khoi_hanh'];
                         $diem_den = $_POST['diem_den'];
                         $tour_price = $_POST['tour_price'];

                         $tax_dm = "danh-muc-tour";
                         $tax_dkh = 'diem-khoi-hanh';
                         $tax_dd = 'diem-den';

                         //danh-muc-tour
                         if ($tour_type != "" && $diem_khoi_hanh == -1 && $diem_den == -1 && $tour_price == -1) {
                              $args_search = array(
                                  'post_type' => 'tour',
                                  'posts_per_page' => -1,
                                  'tax_query' => array(
                                      array(
                                          'taxonomy'=>$tax_dm,
                                          'field'=>'id',
                                          'terms'=>$tour_type
                                      )
                                  )
                              );
                         }
                         // danh-muc-tour & diem_khoi_hanh
                         if ($tour_type != "" && $diem_khoi_hanh != -1 && $diem_den == -1 && $tour_price == -1) {
                              $args_search = array(
                                  'post_type' => 'tour',
                                  'posts_per_page' => -1,
                                  'tax_query' => array(
                                  		'relation'=>'AND',
                                      	array(
                                          'taxonomy'=>$tax_dm,
                                          'field'=>'id',
                                          'terms'=>$tour_type
                                      	),
                                      	array(
                                          'taxonomy'=>$tax_dkh,
                                          'field'=>'id',
                                          'terms'=>$diem_khoi_hanh
                                      	),
                                  )
                              );
                         }
                         // danh-muc-tour & diem den
                         if ($tour_type != "" && $diem_khoi_hanh == -1 && $diem_den != -1 && $tour_price == -1) {
                              $args_search = array(
                                  'post_type' => 'tour',
                                  'posts_per_page' => -1,
                                  'tax_query' => array(
                                  		'relation'=>'AND',
                                      	array(
                                          'taxonomy'=>$tax_dm,
                                          'field'=>'id',
                                          'terms'=>$tour_type
                                      	),
                                      	array(
                                          'taxonomy'=>$tax_dd,
                                          'field'=>'id',
                                          'terms'=>$diem_den
                                      	),

                                  )
                              );
                         }
                         //  danh-muc-tour & diem khoi hanh & diem den
                        if ($tour_type != "" && $diem_khoi_hanh != -1 && $diem_den != -1 && $tour_price == -1) {
                              $args_search = array(
                                  'post_type' => 'tour',
                                  'posts_per_page' => -1,
                                  'tax_query' => array(
                                  		'relation'=>'AND',
                                      	array(
                                          'taxonomy'=>$tax_dm,
                                          'field'=>'id',
                                          'terms'=>$tour_type
                                      	),
                                      	array(
                                          'taxonomy'=>$tax_dd,
                                          'field'=>'id',
                                          'terms'=>$diem_den
                                      	),
                                      	array(
                                          'taxonomy'=>$tax_dkh,
                                          'field'=>'id',
                                          'terms'=>$diem_khoi_hanh
                                      	),
                                  )
                              );
                         }
                        
                        
                        $loop = new WP_Query($args_search);
                        while ($loop->have_posts()):
			               $loop->the_post();
			               ?>
			                  <?php get_template_part( 'content','tour');?>
			                  
			          	<?php 
			            	endwhile; 
			            	if (function_exists('wp_pagenavi'))                            
                        	wp_pagenavi();       
			            ?>

            </div>
            <!--END CONTENT-->
            
            </div>
     </div>
</div><!-- #main-content -->
<?php
get_footer();
