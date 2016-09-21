<div id="top-news" class="news-flexslider">
	<ul id="news-slide" class="slides">
		<?php
			$post_news = new WP_Query('post_type=post&posts_perpage=5');
			if($post_news->have_posts()){
				while ($post_news->have_posts()) {
					# code...
					$post_news->the_post();
					?>
					<li class="clearfix">
						<div id="left-news" class="pull-left">
							<?php the_post_thumbnail()?>
						</div>
						<div id="right-news" class="pull-right">
							<h3><a title="<?php the_title()?>" href="<?php the_permalink()?>"><?php the_title()?></a></h3>
							<div id="content-news">
								<?php the_excerpt()?>
							</div>
						</div>
					</li>
					<?php
				}
			}
			wp_reset_query();
		?>
		
    </ul>
</div>
<script type="text/javascript">
	// Can also be used with $(document).ready()
	jQuery(window).load(function() {
	  jQuery('.news-flexslider').flexslider({
	    animation: "slide",
	    namespace: '',
	    directionNav: true,
	    controlNav: false,
	    prevText: 'Lùi',
	    nextText:'Tới'
	  });
	});
</script>