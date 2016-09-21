<?php
	//echo untrailingslashit( dirname(__FILE__)).'<br>';
	//echo dirname(__FILE__).'<br>';
	//echo __FILE__.'<br>';
	class KBGallery{

		protected $class_name = 'gallery';
		protected $gallery_dir;
		protected $gallery_url;

		public function __construct(){
			$this->gallery_dir = untrailingslashit(dirname(__FILE__));
			$this->gallery_url = plugins_url( '', __FILE__ );

			// Register custom post types
			require_once(sprintf("%s/post-types/gallery-post-type.php", dirname(__FILE__)));
			$Gallery_Post_Type = new Gallery_Post_Type();
			
			// Create Menu
			add_action('admin_menu', array($this, 'KBGallery_addmenu'));
			// Add Style CSS
			add_action('admin_head',  array($this, 'KBGallery_addStyleSheet'));
			
		}
		public function KBGallery_addStyleSheet(){
			wp_enqueue_style($this->class_name.'style', $this->gallery_url.'/css/style.css', '');
		}
		
		public function KBGallery_addScriptJs(){

		}
		public static function KBGallery_activate(){

		}
		public static function KBGallery_deactivate(){

		}
		public function KBGallery_addmenu(){
			// add new menu top level
			//add_menu_page( 'Tour Manager', 'Tour manager', 'manage_options', 'tour-manager', array($this,'manage_order'),PLUGIN_URL.'/images/icon_travel.jpg','80');
			// add submenu to the custom top level menu
    	 	//add_submenu_page('tour-manager',__('Customer'), __('Customer'),'manage_options','tour-customer',array($this ,'manage_customer'));
	
		}
		public function KBGallery_manage_order(){
			//include PLUGIN_DIR.'/order.php';
		}
		public function KBGallery_manage_customer(){
			//include PLUGIN_DIR.'/customer.php';
		}


	}

	$KBGallery = new KBGallery();
	// Plugin active
	//register_activation_hook(__FILE__, array('KBGallery', 'KBGallery_activate'));
	// Plugin desactive
	//register_deactivation_hook(__FILE__, array('KBGallery', 'KBGallery_deactivate'));