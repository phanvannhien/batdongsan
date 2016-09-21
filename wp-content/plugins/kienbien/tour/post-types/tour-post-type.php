<?php 

if(!class_exists(Tour_Post_Type)){
	class Tour_Post_Type{

		const POST_TYPE_TOUR	= "tour";
		const TAXONOMY_CAT_TOUR = "cat-tour";
		protected $url_images;
		
		private $meta_box = array();

		/**
    	 * The Constructor
    	 */
    	public function __construct()
    	{

    		$this->create_metabox_variable();
    		$this->url_images = plugins_url('..',__FILE__).'/images/';
    		// register actions
    		add_action('init', array(&$this, 'init'));
    		add_action('admin_init', array(&$this, 'admin_init'));

    		
    	} // END

    	function create_metabox_variable(){
    		$this->meta_box[] = array(
			    'id' => 'tour_properties',
			    'title' => __('Tour Properties',KB_TEXT_DOMAIN),
			    'pages' => array(self::POST_TYPE_TOUR),
			    'fields' => array(
			        array(
			            'name' => __('Tour Price',KB_TEXT_DOMAIN),
			            'id' => self::POST_TYPE_TOUR . '_price',
			            'type' => 'text',
			        )
			        ,
			         array(
			            'name' => __('Tour SKU',KB_TEXT_DOMAIN ),
			            'id' => self::POST_TYPE_TOUR .'_sku',
			            'type' => 'text',
			        )
			        ,
			         array(
			            'name' => __('Tour Gallery',KB_TEXT_DOMAIN),
			            'id' => self::POST_TYPE_TOUR .'_gallery',
			            'type' => 'image_advanced',
			        )
		     
		    		// Other fields go here
		    	)
			);
    	} 

    	/**
    	 * hook into WP's init action hook
    	 */
    	public function init()
    	{
    		// Initialize Post Type
    		$this->create_post_type();
    		//add_action('save_post', array(&$this, 'save_post'));

    		$this->create_tour_taxonomies();
    		//add_action('init', array(&$this,'create_tour_taxonomies'));
    		add_filter('manage_edit-tour_columns', array(&$this,'tour_columns'));

    		add_action('manage_posts_custom_column', array(&$this,'populate_columns'));

    		add_filter('manage_edit-tour_sortable_columns', array(&$this,'sort_me'));

    		add_action('restrict_manage_posts', array(&$this,'tour_category_filter_list'));

    		add_filter('parse_query', array(&$this,'perform_filtering_tour_category'));


    	} // END public function init()

    	/**
    	 * Create the post type
    	 */
    	public function create_post_type()
    	{
    		
    		register_post_type(
				'tour', array(
					'labels' => array(
						'name' => __('Tour',KB_TEXT_DOMAIN),
						'singular_name' => __('Tour',KB_TEXT_DOMAIN),
						'add_new' => __('Add New',KB_TEXT_DOMAIN),
						'add_new_item' => __('Add New Tour',KB_TEXT_DOMAIN),
						'edit' => __('Edit',KB_TEXT_DOMAIN),
						'edit_item' => __('Edit Tour',KB_TEXT_DOMAIN),
						'new_item' => __('New Tour',KB_TEXT_DOMAIN),
						'view' => __('View Tour',KB_TEXT_DOMAIN),
						'view_item' => __('View Tour',KB_TEXT_DOMAIN),
						'search_items' => __('Search Tours',KB_TEXT_DOMAIN),
						'not_found' => __('No Tours found',KB_TEXT_DOMAIN),
						'not_found_in_trash' => __('No Tours found in Trash',KB_TEXT_DOMAIN)
					),
					'public' => true,
					'show_ui' => true,
					'publicy_queryable' => true,
					'exclude_from_search' => false,
					'menu_position' => 26,
					'menu_icon' => $this->url_images . 'tour.png',
					'hierarchical' => false,
					'query_var' => true,
					'supports' => array(
					'title', 'editor', 'comments', 'author', 'excerpt', 'thumbnail',
					'custom-fields'
					),
					'rewrite' => array('slug' => 'tour', 'with_front' => false),
					//'taxonomies' =>  array('post_tag', 'category'),
					'can_export' => true,
					//'register_meta_box_cb'  =>  'call_to_function_do_something',
					'description' => __('Tour description here.',KB_TEXT_DOMAIN)
				)
			);
    	}
    	/**
    	 * Create metabox
    	 */

    	public function create_meta_box(){
    		if (!class_exists('RW_Meta_Box')) {
    			echo 'Not have class';
          		return;
		    }

		    foreach ($this->meta_box as $mb) {
		    	//echo '<pre>';
		    	//var_dump($mb);
		        new RW_Meta_Box($mb);
		    }
    	}

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
            
    		if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE_TOUR && current_user_can('edit_post', $post_id))
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
    		// Add metaboxes
    		//add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
    		$this->create_meta_box();
    	} // END public function admin_init()
			
    	/**
    	 * hook into WP's add_meta_boxes action hook
    	 */
    	public function add_meta_boxes()
    	{
    		// Add this metabox to every selected post
    		add_meta_box( 
    			sprintf('wp_plugin_template_%s_section', self::POST_TYPE_TOUR),
    			sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE_TOUR))),
    			array(&$this, 'add_inner_meta_boxes'),
    			self::POST_TYPE_TOUR
    	    );					
    	} // END public function add_meta_boxes()

		/**
		 * called off of the add meta box
		 */		
		public function add_inner_meta_boxes($post)
		{		
			// Render the job order metabox
			include(sprintf("%s/../templates/metabox.php", dirname(__FILE__)));			
		} // END public function add_inner_meta_boxes($post)

		/**
		 * called off of the taxonomies
		 */	

		function create_tour_taxonomies() {
			//echo self::TAXONOMY_CAT_TOUR;
			register_taxonomy(self::TAXONOMY_CAT_TOUR, self::POST_TYPE_TOUR, array(
				'hierarchical' => true,
				'labels' => array(
				    'name' => __('Tour Categories',KB_TEXT_DOMAIN),
				    'singular_name' => __('Tour Category',KB_TEXT_DOMAIN),
				    'add_new' => __('Add New',KB_TEXT_DOMAIN),
				    'add_new_item' => __('Add New Tour Category',KB_TEXT_DOMAIN),
				    'new_item' => __('New Tour Category',KB_TEXT_DOMAIN),
				    'search_items' => __('Search Tour Category',KB_TEXT_DOMAIN),
				),
			));

			/********************************************************

			register_taxonomy('type-tour', 'tour', array(
				'hierarchical' => true,
				'labels' => array(
				'name' => __('Type Tour'),
				'singular_name' => __('Type Tour'),
				'add_new' => __('Add New Type Tour'),
				'add_new_item' => __('Add New Type Tour Item'),
				'new_item' => __('New Category Type Item'),
				'search_items' => __('Search Type Tour'),
				),
			));
			/*  * *********************************************************
			register_taxonomy('model-tour', 'tour', array(
				'hierarchical' => true,
				'labels' => array(
				'name' => __('Model Tour'),
				'singular_name' => __('Model Tour'),
				'add_new' => __('Add New Model Tour'),
				'add_new_item' => __('Add New Model Tour Item'),
				'new_item' => __('New Category Model Item'),
				'search_items' => __('Search Model Tour'),
				),
			));

			register_taxonomy('manufacture', 'tour', array(
				'hierarchical' => true,
				'labels' => array(
				'name' => __('Manufacture'),
				'singular_name' => __('Manufacture'),
				'add_new' => __('Add Manufacture'),
				'add_new_item' => __('Add New Manufacture'),
				'new_item' => __('New Manufacture'),
				'search_items' => __('Search Manufacture'),
				),
			));
			******************************** */
		}

		function tour_columns($columns) {
		    $columns['col_cat_tour'] = __('Tour Category',KB_TEXT_DOMAIN);
		    //$columns['tour_tour_number'] = 'Number';
		    $columns['col_tour_image'] = __('Tour Image',KB_TEXT_DOMAIN);
		    unset($columns['comments']);
		    unset($columns['author']);
		    return $columns;
		}

		function populate_columns($column) {

		    if ('col_cat_tour' == $column) {
		        $terms = wp_get_post_terms(get_the_ID(), self::TAXONOMY_CAT_TOUR);
		        $col_cat_tour = '';
		        foreach ($terms as $t) {
		            $term_link = get_term_link($t,self::TAXONOMY_CAT_TOUR);
		            $col_cat_tour .= '<a href="' . $term_link . '" >' . $t->name . '</a>, ';
		        }

		        echo $col_cat_tour;
		    } elseif ('col_tour_image' == $column) {
		        $img_tour_col = get_the_post_thumbnail(get_the_ID(), array(100, 100));
		        echo $img_tour_col;
		    }
		}

		function sort_me($columns) {
		    $columns['col_cat_tour'] = 'col_cat_tour';
		    $columns['col_tour_image'] = 'tour_tour_image';
		    return $columns;
		}

		/**
		 * Filters With Custom Taxonomy Category Tour
		 */
		//add_action('restrict_manage_posts', 'tour_category_filter_list');

		function tour_category_filter_list() {
		    $screen = get_current_screen();
		    global $wp_query;
		    if ($screen->post_type == self::POST_TYPE_TOUR) {
		        wp_dropdown_categories(array(
		            'show_option_all' => __('Show All Tour Category',KB_TEXT_DOMAIN),
		            'taxonomy' => self::TAXONOMY_CAT_TOUR,
		            'name' => self::TAXONOMY_CAT_TOUR,
		            'orderby' => 'name',
		            'selected' => ( isset($wp_query->query[self::TAXONOMY_CAT_TOUR]) ? $wp_query->query[self::TAXONOMY_CAT_TOUR] : '' ),
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
		//add_filter('parse_query', 'perform_filtering_tour_category');

		function perform_filtering_tour_category($query) {
		    $qv = &$query->query_vars;
		    if (( $qv[self::TAXONOMY_CAT_TOUR] ) && is_numeric($qv[self::TAXONOMY_CAT_TOUR])) {
		        $term = get_term_by('id', $qv[self::TAXONOMY_CAT_TOUR], self::TAXONOMY_CAT_TOUR);
		        $qv[self::TAXONOMY_CAT_TOUR] = $term->slug;
		    }
		}


	}
}//end if class_exists