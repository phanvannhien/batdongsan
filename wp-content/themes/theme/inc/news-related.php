
<div id="news-related" class="panel panel-primary">
    <div class="panel-heading">Tin liên quan khác</div>
    <div class="panel-body">
        
    
    <?php
    $categories = get_the_category($post->ID);
    if ($categories) {
        $category_ids = array();
        foreach ($categories as $individual_category):
            $category_ids[] = $individual_category->term_id;
        
            $args = array(
				
                'category__in' => $category_ids,
                'post__not_in' => array($post->ID),
                'showposts' => 10, // Số bài viết bạn muốn hiển thị.
                'caller_get_posts' => 1
            );
        endforeach;
        $my_query = new wp_query($args);
        if ($my_query->have_posts()) {
            ?>
            <ul class="news-more">
                <?php
                while ($my_query->have_posts()) {
                    $my_query->the_post();
                    ?>
                    <li>
                        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                        <i class="fa fa-angle-right"></i>
                        <?php the_title(); ?>
                        </a>
                        <em>(<?php the_modified_date('d-m-Y');?>)</em>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        } else {
            
        }
    }//end if
    ?>

    </div>
</div>