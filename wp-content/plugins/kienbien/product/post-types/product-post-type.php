<?php 

if(!class_exists(Product_Post_Type)){
	class Product_Post_Type{

		const POST_TYPE_PRODUCT	= "product";
		const TAXONOMY_CAT_PRODUCT = "cat-product";
		protected $url_images;
		
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
  
    		add_filter('manage_edit-product_columns', array(&$this,'product_columns'));
    		add_action('manage_posts_custom_column', array(&$this,'populate_columns'));
    		add_filter('manage_edit-product_sortable_columns', array(&$this,'sort_me'));
    		add_action('restrict_manage_posts', array(&$this,'product_category_filter_list'));
    		add_filter('parse_query', array(&$this,'perform_filtering_product_category'));
    	} // END public function init()

    	/**
    	 * hook into WP's admin_init action hook
    	 */
    	public function admin_init()
    	{			
    
    	} // END public function admin_init()


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
            
    		if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE_PRODUCT && current_user_can('edit_post', $post_id))
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


		function product_columns($columns) {
		    $columns['col_cat_product'] = __('Product Category',KB_TEXT_DOMAIN);
		    //$columns['product_product_number'] = 'Number';
		    $columns['col_product_image'] = __('Product Image',KB_TEXT_DOMAIN);
		    unset($columns['comments']);
		    unset($columns['author']);
		    return $columns;
		}

		function populate_columns($column) {

		    if ('col_cat_product' == $column) {
		        $terms = wp_get_post_terms(get_the_ID(), self::TAXONOMY_CAT_PRODUCT);
		        $col_cat_product = '';
		        foreach ($terms as $t) {
		            $term_link = get_term_link($t,self::TAXONOMY_CAT_PRODUCT);
		            $col_cat_product .= '<a href="' . $term_link . '" >' . $t->name . '</a>, ';
		        }

		        echo $col_cat_product;
		    } elseif ('col_product_image' == $column) {
		        $img_product_col = get_the_post_thumbnail(get_the_ID(), array(100, 100));
		        echo $img_product_col;
		    }
		}

		function sort_me($columns) {
		    $columns['col_cat_product'] = 'col_cat_product';
		    $columns['col_product_image'] = 'product_product_image';
		    return $columns;
		}

		/**
		 * Filters With Custom Taxonomy Category Product
		 */
		//add_action('restrict_manage_posts', 'product_category_filter_list');

		function product_category_filter_list() {
		    $screen = get_current_screen();
		    global $wp_query;
		    if ($screen->post_type == self::POST_TYPE_PRODUCT) {
		        wp_dropdown_categories(array(
		            'show_option_all' => __('Show All Product Category',KB_TEXT_DOMAIN),
		            'taxonomy' => self::TAXONOMY_CAT_PRODUCT,
		            'name' => self::TAXONOMY_CAT_PRODUCT,
		            'orderby' => 'name',
		            'selected' => ( isset($wp_query->query[self::TAXONOMY_CAT_PRODUCT]) ? $wp_query->query[self::TAXONOMY_CAT_PRODUCT] : '' ),
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
		//add_filter('parse_query', 'perform_filtering_product_category');

		function perform_filtering_product_category($query) {
		    $qv = &$query->query_vars;
		    if (( $qv[self::TAXONOMY_CAT_PRODUCT] ) && is_numeric($qv[self::TAXONOMY_CAT_PRODUCT])) {
		        $term = get_term_by('id', $qv[self::TAXONOMY_CAT_PRODUCT], self::TAXONOMY_CAT_PRODUCT);
		        $qv[self::TAXONOMY_CAT_PRODUCT] = $term->slug;
		    }
		}


	}
}//end if class_exists