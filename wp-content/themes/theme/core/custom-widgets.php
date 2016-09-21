<?php

class wp_real_plugin extends WP_Widget {

	// constructor
	function wp_real_plugin() {
		/* ... */
		 parent::WP_Widget(false, $name = 'Custom list home page');

	}

	// widget form creation
	// widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
	     $title = esc_attr($instance['title']);
	     $text = esc_attr($instance['text']);
	     $select = esc_textarea($instance['select']);
	     $selectdm = esc_textarea($instance['selectdm']);
	} else {
	     $title = '';
	     $text = '';
	     $select = '';
	     $selectdm = '';
	}
	?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tiêu đề', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		

		<p>
			<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Kiểu hiển thị', 'wp_widget_plugin'); ?></label>
			<select class="widefat" 
				name="<?php echo $this->get_field_name('select'); ?>"
				id="<?php echo $this->get_field_id('select'); ?>">
				
				<option <?php echo ($select == 'list_image' ? 'selected' :'')?> value="list_image">Danh sách hình</option>
				<option <?php echo ($select == 'list' ? 'selected' :'')?> value="list">Danh sách không hình</option>

			</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('selectdm'); ?>"><?php _e('Loại Danh mục', 'wp_widget_plugin'); ?></label>
		<select name="<?php echo $this->get_field_name('selectdm'); ?>" 

			id="<?php echo $this->get_field_id('selectdm'); ?>">
			<?php
                $listTermDanhMuc = get_terms('danh-muc',array('parent' => 0,'hide_empty'=>0));
                foreach ($listTermDanhMuc as $list) {
                  # code...
                	$selected = '';
                	if($selectdm == $list->term_id){
                		$selected = 'selected';
                	}
                	echo '<option '.$selected.' value="'.$list->term_id.'">'.$list->name.'</option>';	
                 
                }
              ?>
		</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Giới hạn số tin', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
		</p>
		
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['select'] = strip_tags($new_instance['select']);
		$instance['selectdm'] = strip_tags($new_instance['selectdm']);

		return $instance;
	}

	// display widget
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		$text = $instance['text'];
		$select = $instance['select'];
		$selectdm = $instance['selectdm'];

		
		echo $before_widget;
		$Real = new KBBDS();
		$real = $Real->getAllRealByDanhMuc($selectdm,$text);

		$currentTerm = get_term($selectdm,'danh-muc');
		// Check if title is set
		if ( $title ) {
		  echo $before_title . $title . $after_title;
		}
		// Display the widget
		echo '<div class=" panel-body">';
			if($select == 'list_image'){
				?>
					<ul>
						<li class="row clearfix">
							<?php
								if($real){
									$i = 0;
									foreach ($real as $value) {
										$i++;
										$thumb = getRealThumbnailUrl($value->bds_image);	
										$term = get_term($value->loai_bds, 'loai-bat-dong-san');
										
										?>
											<div class="c50 pull-left">
												<div class="thumb c40 pull-left">
													<a href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>">
														<?php
															resizeRealThumnail($thumb,100,80,'center-block',$value->bds_name);
														?>
													</a>
												</div>
												<div class="sub-content c60 pull-left">
													
													<h4>
														<a href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>" title="<?php echo $value->bds_name?>">
															<?php echo $value->bds_name?>
														</a>
													</h4>
													<p>
														<span class="price">Giá: <?php echo format_price($value->price) ?></span>
														<span class="">
															<a href="<?php echo get_term_link($term );?>">
																<?php echo $term->name;?>
															</a>
														</span>
													</p>
												</div>
												
											</div>


										<?php
										 echo ($i % 2 == 0 ) ?'</li><li class="row clearfix">':''; 
									}
								}//end 
							?>

						</li>
						<li>
							<a class="pull-right" href="<?php echo get_term_link($currentTerm,'danh-muc');?>">
								Xem tất cả <i class="fa fa-mail-forward"></i>
							</a>
						</li>	
					</ul>
				<?php
			}//end list image

			if($select == 'list'){

				?>
				<ul class="list-real-no-img">
					<?php
						if($real){
							foreach ($real as $value) {
							
								$thumb = getRealThumbnailUrl($value->bds_image);	
								$term = get_term($value->loai_bds, 'loai-bat-dong-san');
								$termdiadiem = get_term($value->tinhtp, 'dia-diem');
								$termloai = get_term($value->loai_bds, 'loai-bat-dong-san');
								?>
									
								<li class="clearfix">
									<a href="<?php echo get_term_link($termdiadiem);?>">
										<strong><i class="fa fa-hand-o-right"></i> <?php echo $termdiadiem->name;?></strong>
										<span>( <?php echo $termloai->name?> )</span>
									</a>
									<a title="<?php echo $value->bds_name?>" href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>">
										<?php echo $value->bds_name?>
									</a>
									<span class="price">
										Giá: ( <?php echo format_price($value->price) ?> )
									</span>
								</li>
								<?php
							}
						}//end 
					?>

				</ul>	
				<?php
			}

		echo '</div>';
		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_real_plugin");'));