<?php

class News_Widget extends WP_Widget {

	// constructor
	function News_Widget() {
		/* ... */
		 parent::WP_Widget(false, $name = 'News widget on sidebar');

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
				
				<option <?php echo ($select == 'list_image' ? 'selected' :'')?> value="list_image">Hiển thị hình</option>
				<option <?php echo ($select == 'list' ? 'selected' :'')?> value="list">Không hiện hình</option>

			</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('selectdm'); ?>"><?php _e('Danh mục', 'wp_widget_plugin'); ?></label>
		<select name="<?php echo $this->get_field_name('selectdm'); ?>" 

			id="<?php echo $this->get_field_id('selectdm'); ?>">
			<?php
                $listTermDanhMuc = get_terms('category',array('hide_empty'=>0));
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
	
		$news = new WP_Query(array(
			'post_type'=>'post',
			'cat_id'=> array($selectdm),
			'posts_per_page'=>$limit
		));
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
								if($news->have_posts()){
									$i = 0;
									while ($news->have_posts()) {
										$news->the_post();
										
										?>
										<div class="news-item clearfix">     
					                        <div class="c40 pull-left">
					                            <a href="<?php the_permalink()?>">
					                            <?php resizeThumnail($post->ID,80,50,'thumb',get_the_title()) ?>
					                            </a>
					                        </div>
					                         <div class="c60 pull-left">
					                            <a href="<?php the_permalink()?>"><?php the_title()?></a>
					                            <div class="info-bar"><span><i class="fa fa-edit fa-lg"></i> <?php  the_modified_date('');?></span></div>
					                           
					                        </div>
					                    </div>   
										<?php
										
									}
								}//end 
							?>

						</li>
						<li>
							<a class="pull-right" href="<?php echo get_category_link($selectdm);?>">
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
						if($news->have_posts()){
							while ($news->have_posts()) {
								$news->the_post();
								?>
								<li>
			                       <a href="<?php the_permalink()?>"><?php the_title()?></a> (
		                           <span><i class="fa fa-edit fa-lg color-gray"></i> <?php  the_modified_date('');?></span>)
		                           
			                    </li>
								<?php
								
							}
						}//end 
					?>
					<li>
						<a class="pull-right" href="<?php echo get_category_link($selectdm);?>">
							Xem tất cả <i class="fa fa-mail-forward"></i>
						</a>
					</li>	
				</ul>	
				<?php
			}

		echo '</div>';
		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("News_Widget");'));