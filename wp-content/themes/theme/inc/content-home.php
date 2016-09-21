<?php 
	if(!class_exists('KBBDS')){
		echo '<p>Please active the plugin real</p>';
	}
	else{
		$Real = new KBBDS();
		$allReal = $Real->getAllRealLimit(0,5);

	}
?>

<div class="panel panel-primary cats-real">
	<div class="panel-heading">Bất động sản mới nhất</div>
    <div class="panel-body">
	
		<ul class="clearfix">
			<?php if($allReal){
				foreach ($allReal as $value) {
					# code...
					echo '<li class="c25 pull-left">';
					$thumb = getRealThumbnailUrl($value->bds_image);	
					$term = get_term($value->loai_bds, 'loai-bat-dong-san');

					?>
						<div class="padding10">
							<a href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>">
								<?php
									resizeRealThumnail($thumb,150,120,'center-block',$value->bds_name);
								?>
							</a>
							<h4>
								<a href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>" title="<?php echo $value->bds_name?>">
									<?php echo $value->bds_name?>
								</a>
							</h4>
							<span class="pull-left price">Giá:  <?php echo format_price($value->price); ?></span>
							<span class="pull-right">
								<a href="<?php echo get_term_link($term );?>">
									<?php echo $term->name;?>
								</a>
							</span>
						</div>
					<?php
					echo '</li>';
				}
			}?>	
		</ul>
    </div>
</div>
<!-- end panel -->

<?php dynamic_sidebar('home-widget')?>
<!-- end panel -->

<?php ?>