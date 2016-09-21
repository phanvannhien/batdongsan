<?php 

if(!class_exists(Gallery_Post_Type)){
	class Gallery_Post_Type{

		const POST_TYPE_GALLERY	= "gallery";
		const TAXONOMY_CAT_GALLERY = "cat-gallery";
		protected $url_images;
		
		private $meta_box = array();

		/**
    	 * The Constructor
    	 */
    	public function __construct()
    	{

    		$this->url_images = plugins_url('..',__FILE__).'/images/';
    		// register actions
    		add_action('init', array(&$this, 'init'));
    		add_action('admin_init', array(&$this, 'admin_init'));
    		
    	} // END

    	

    	/**
    	 * hook into WP's init action hook
    	 */
    	public function init()
    	{
    		
    		//add_action('init', array(&$this,'create_gallery_taxonomies'));
    		add_filter('manage_edit-gallery_columns', array(&$this,'gallery_columns'));
    		add_action('manage_posts_custom_column', array(&$this,'populate_columns'));
    		add_filter('manage_edit-gallery_sortable_columns', array(&$this,'sort_me'));
    		add_action('restrict_manage_posts', array(&$this,'gallery_category_filter_list'));
    		add_filter('parse_query', array(&$this,'perform_filtering_gallery_category'));

    	} // END public function init()

    

    	/**
    	 * Save the metaboxes for this custom post type
    	 */
    	public function save_post($post_id)
    	{
            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            {
                return;
            }
            
    		if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE_GALLERY && current_user_can('edit_post', $post_id))
    		{
    			foreach($this->_meta as $field_name)
    			{
    				// Update the post's meta field
    				update_post_meta($post_id, $field_name, $_POST[$field_name]);
    			}
    		}
    		else
    		{
    			return;
    		} // if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
    	} // END public function save_post($post_id)

    	/**
    	 * hook into WP's admin_init action hook
    	 */
    	public function admin_init()
    	{			
    		
    	} // END public function admin_init()


		function gallery_columns($columns) {
		    $columns['col_cat_gallery'] = __('Gallery Category',KB_TEXT_DOMAIN);
		    //$columns['gallery_gallery_number'] = 'Number';
		    $columns['col_gallery_image'] = __('Gallery Image',KB_TEXT_DOMAIN);
		    unset($columns['comments']);
		    unset($columns['author']);
		    return $columns;
		}

		function populate_columns($column) {

		    if ('col_cat_gallery' == $column) {
		        $terms = wp_get_post_terms(get_the_ID(), self::TAXONOMY_CAT_GALLERY);
		        $col_cat_gallery = '';
		        foreach ($terms as $t) {
		            $term_link = get_term_link($t,self::TAXONOMY_CAT_GALLERY);
		            $col_cat_gallery .= '<a href="' . $term_link . '" >' . $t->name . '</a>, ';
		        }

		        echo $col_cat_gallery;
		    } elseif ('col_gallery_image' == $column) {
		        $img_gallery_col = get_the_post_thumbnail(get_the_ID(), array(100, 100));
		        echo $img_gallery_col;
		    }
		}

		function sort_me($columns) {
		    $columns['col_cat_gallery'] = 'col_cat_gallery';
		    $columns['col_gallery_image'] = 'gallery_gallery_image';
		    return $columns;
		}

		/**
		 * Filters With Custom Taxonomy Category Gallery
		 */
		//add_action('restrict_manage_posts', 'gallery_category_filter_list');

		function gallery_category_filter_list() {
		    $screen = get_current_screen();
		    global $wp_query;
		    if ($screen->post_type == self::POST_TYPE_GALLERY) {
		        wp_dropdown_categories(array(
		            'show_option_all' => __('Show All Gallery Category',KB_TEXT_DOMAIN),
		            'taxonomy' => self::TAXONOMY_CAT_GALLERY,
		            'name' => self::TAXONOMY_CAT_GALLERY,
		            'orderby' => 'name',
		            'selected' => ( isset($wp_query->query[self::TAXONOMY_CAT_GALLERY]) ? $wp_query->query[self::TAXONOMY_CAT_GALLERY] : '' ),
		            'hierarchical' => false,
		            'depth' => 5,
		            'show_count' => true,
		            'hide_empty' => false,
		        ));
		    }
		}
		/*
		 * Display Filtered Results
		 */
		//add_filter('parse_query', 'perform_filtering_gallery_category');

		function perform_filtering_gallery_category($query) {
		    $qv = &$query->query_vars;
		    if (( $qv[self::TAXONOMY_CAT_GALLERY] ) && is_numeric($qv[self::TAXONOMY_CAT_GALLERY])) {
		        $term = get_term_by('id', $qv[self::TAXONOMY_CAT_GALLERY], self::TAXONOMY_CAT_GALLERY);
		        $qv[self::TAXONOMY_CAT_GALLERY] = $term->slug;
		    }
		}


	}
}//end if class_exists