<?php
	/* Template Name: Real Manager */
?>
<?php get_header();?>
<?php

$realPageUrl = get_page_link(52);


//global $wp_query;
//echo '<pre>';
//var_dump($wp_query->query_vars);


if(!is_user_logged_in() || !class_exists(KBRealCustomer) || !class_exists(KBBDS)){ 
    wp_redirect(home_url()); 
} 

$clsCustomer = new KBRealCustomer(); 
$currentUser = wp_get_current_user();


$infoUser = $clsCustomer->getCustomerByID( $currentUser->user_email ); 
$Real = new KBBDS();


// Pagination

$numrows = count($Real->getAllRealByUser($infoUser->id));
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

//echo 'Page: '.$currentpage;
$offset = ($currentpage - 1) * $rowsperpage;

$real = $Real->getAllRealByUserLimit($infoUser->id,$offset,$rowsperpage);

?>
<div id="main-content" class="clearfix">
    <div id="user-sidebar" class="">
        
        <?php include(TEMPLATEPATH.'/inc/user-sidebar.php') ?>
   
    </div>

    <div id="user-main" class="">
    	<table class="table table-default">
			<thead>
				<tr>
					<th><input type="checkbox" name="select_real[]"></th>
					<th>STT</th>
					<th>Tiêu đề tin</th>
					<th>Hình đại diện</th>
					<th>Loại hình</th>
					<th>Tỉnh thành</th>
					<th>Loại BĐS</th>
					<th>Thành viên</th>
					<th>Chức năng</th>
					
				</tr>
				
			</thead>

			<tbody>
				<?php
					if($real){
						$i = 1;
						foreach ($real as $value) {

							$thumb = getRealThumbnailUrl($value->bds_image);    
		                    $term = get_term($value->loai_bds, 'loai-bat-dong-san');
		                    $termdiadiem = get_term($value->tinhtp, 'dia-diem');
		                    $termdiadiemquanhuyen = get_term($value->quanhuyen, 'dia-diem');
		                    $termloai = get_term($value->loai_bds, 'loai-bat-dong-san');
							# code...
							?>
							<tr id="row-<?php echo $value->bds_id?>">
								<td>
									<input type="checkbox">
								</td>
								<td>
									 <?php echo $i?>
								</td>
								<td>
									<a href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>">
										<?php echo $value->bds_name ?>
									</a>
								</td>
								<td>
									<?php resizeRealThumnail($thumb,100,60,'center-block',$value->bds_name);?>
								</td>
								<td>
									<a href="<?php echo get_term_link($term)?>"><strong><?php echo $term->name;?></strong></a>
								</td>
								<td>
									<a href="<?php echo get_term_link($termdiadiem)?>"><strong><?php echo $termdiadiem->name;?></strong></a>
								</td>
								<td>
									<a href="<?php echo get_term_link($termloai)?>"><strong><?php echo $termloai->name;?></strong></a>
								</td>
								<td>
									<?php echo $infoUser->username?>
								</td>
								<td>
									<a class="color-blue" href="<?php echo $realPageUrl.'/?bid='.$value->bds_id ?>"><i class="fa fa-edit fa-lg"></i> Sửa</a> <br>
									<a class="color-blue" id="del-real" data-id="<?php echo $value->bds_id?>" href="#"><i class="fa fa-trash-o fa-lg"></i> Xóa</a><br>
									<?php
								

									if($currentUser->caps['administrator']){
										if($value->bds_status == 'pending'){
											?>
											<a class="change-status pending fa fa-ban"  href="#"  data-id="<?php echo $value->bds_id?>"> Chưa duyệt</a>
									
									
										<?php }else{?>
											<a class="change-status approved fa fa-ban" href="#"  data-id="<?php echo $value->bds_id?>"> Đã duyệt</a>
									
										<?php } 
									}
									?>	

								</td>
							
							</tr>
							<?php
							$i++;
						}
					}
				?>
				
			</tbody>
    		

    	</table>


    	<div class="pagination clearfix">
    		<span>Tổng số tin: <?php echo $numrows?></span>
            <ul class="pull-right">
                <?php
                $currentUrl = get_permalink();
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
        <?php
        ?>

    </div>
</div><!-- #main-content -->
</div>
<!-- end wrapper main-->
<script>
	jQuery('a.change-status').on('click',function(e){
		e.preventDefault();
		var dataID = jQuery(this).data('id'); 
		var status = 'pending';

		if(jQuery(this).hasClass('approved')){
			status = 'approved';
		}

		that = this;
		jQuery.ajax({
			url:url_ajax,
			type:'POST',
			dataType:'JSON',
			data:{
				action : 'setStatusReal',
				bid: dataID,
				status: status
			},
			success: function(data){

				jQuery(that).removeClass(status)
							.addClass(data.sClass).text(data.rText);

			}

		});
		
	});

	jQuery('a#del-real').on('click',function(e){
		e.preventDefault();
		if(!confirm('Bạn chắc xóa mẩu tin này!')){
			return;
		}
		var dataID = jQuery(this).data('id');
		jQuery.ajax({
			url:url_ajax,
			type:'POST',
			data:{
				action : 'delReal',
				bid: dataID
			},
			success: function(data){
				if(data=='true'){
					jQuery('div#row-'+dataID).remove();
				}

			}

		});
	});
</script>

<?php get_footer();?>

