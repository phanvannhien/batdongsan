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
<?php

    //global $wp_query;
    //echo '<pre>';
    //var_dump($wp_query->query_vars);


     $queried_object = get_queried_object();
     $term_id = $queried_object->term_id;
     $taxonomy = $queried_object->taxonomy;

     $Real = new KBBDS();


    // Pagination

    $realAllByCate = $Real->getCountRealByCate($term_id,$taxonomy);
    $numrows = $realAllByCate->num_rows;

    //echo 'Total:'.$numrows.'/ page'.get_query_var('page');

    $rowsperpage = 10;
    $range = 3;

    $totalpages = ceil($numrows / $rowsperpage);
    if (get_query_var('page') && is_numeric(get_query_var('page'))) {
       $currentpage = (int) get_query_var('page');
    } else {
       $currentpage = 1;
    } 

    if ($currentpage > $totalpages) {
       $currentpage = $totalpages;
    } 

    if ($currentpage < 1) {
       $currentpage = 1;
    }

    //echo 'Current Page: '.$currentpage;
    $offset = ($currentpage - 1) * $rowsperpage;

    $allReal = $Real->getAllRealByCate($term_id,$taxonomy,$offset,$rowsperpage);
     //var_dump($allReal);
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
               
            if($allReal){
                foreach ($allReal as $value) {
                    $thumb = getRealThumbnailUrl($value->bds_image);    
                    $term = get_term($value->loai_bds, 'loai-bat-dong-san');
                    $termdiadiem = get_term($value->tinhtp, 'dia-diem');
                    $termdiadiemquanhuyen = get_term($value->quanhuyen, 'dia-diem');
                    $termloai = get_term($value->loai_bds, 'loai-bat-dong-san');



                    ?>
                    <div class="news-item clearfix">     
                        <div class="c30 pull-left">
                            <a href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>">
                            <?php resizeRealThumnail($thumb,180,120,'center-block',$value->bds_name);?>
                            </a>
                        </div>
                         <div class="c70 pull-left">
                            <h3><a href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>"><?php echo $value->bds_name?></a></h3>
                            <div class="info-bar">
                                <span class="color-gray"><i class="fa fa-edit fa-lg"></i> <?php echo date('d-m-Y',strtotime($value->date_start)) ?></span>
                                <span class="pull-right price">Giá:  <?php echo format_price($value->price).' '.$value->loai_tien?> </span></span>
                            
                            </div>
                            <p style="margin-bottom:10px;">
                                <span>Danh mục: <a href="<?php echo get_term_link($term)?>"><strong><?php echo $term->name;?></strong></a></span>
                                <span>Tỉnh/Tp: <a href="<?php echo get_term_link($termdiadiem)?>"><strong><?php echo $termdiadiem->name;?></strong></a></span>
                                <span>Quận/Huyện: <a href="<?php echo get_term_link($termdiadiemquanhuyen)?>"><strong><?php echo $termdiadiemquanhuyen->name;?></strong></a></span>
                                <span>Loại BĐS: <a href="<?php echo get_term_link($termloai)?>"><strong><?php echo $termloai->name;?></strong></a></span>
                              
                            </p>   
                            <div class="excerpt">
                                <?php echo wp_trim_words($value->description,30)?>
                            </div>
                        </div>
                    </div>   
                    <?php
                }//end
            }//end if    
            ?>
        </div>
        <div class="pagination clearfix">
            <span>Tổng số tin: <?php echo $numrows?></span>
            <ul class="pull-right">
                <?php
                $currentUrl = get_term_link($term_id,$taxonomy);
                if ($currentpage > 1)
                {
                    $prevpage = $currentpage - 1;
                    echo "<li class='next_btn'> <a href='".$currentUrl.$prevpage."'>&laquo;</a> </li>";  
                    if($prevpage>3){
                        echo "<li><a href='".$currentUrl."1' title='First Page 1'>1..</a></li> ";
                    }
                    else{
                        if($prevpage==4){
                            echo " <li><a href='".$currentUrl."1'>1</a></li> ";
                        }
                        else{
                            echo "";
                        }   
                    }     
                } 
                //
                for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
                    if (($x > 0) && ($x <= $totalpages)) {
                        if ($x == $currentpage) {
                            echo "<li class='currentPage'><a>$x</a></li> ";
                        }else {
                            echo " <li><a href='".$currentUrl.$x."'>$x</a></li> ";
                        } 
                    } 
                } 
                //
                if ($currentpage != $totalpages) {
                    $nextpage = $currentpage + 1;          
                    //echo " <li><a href='#' onclick='LoadPage_Job($totalpages,$category_id);'  title='End-Page -$totalpages'>End</a></li> ";
                    echo "<li class='next_btn'> <a href='".$currentUrl.$nextpage."' title='Next'>&raquo;</a> </li>";
                    echo " <li><a href='".$currentUrl.$totalpages."' title='End-Page -$totalpages'>Cuối</a></li> ";
                }


                ?>
            </ul>
        </div>

    </div>

</div>
<!-- #main-content -->
</div>
<!-- end wrapper main-->
<?php
get_footer();    


            