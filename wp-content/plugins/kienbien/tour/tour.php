<?php
	class KBTour{
		protected $class_name = 'tour';
		protected $tour_dir;
		protected $tour_url;

		public function __construct(){
			$this->tour_dir = untrailingslashit(dirname(__FILE__));
			$this->tour_url = plugins_url( '', __FILE__ );
			
			// Register custom post types
			require_once(sprintf("%s/post-types/tour-post-type.php", dirname(__FILE__)));
			$Tour_Post_Type = new Tour_Post_Type();

			add_action('admin_menu', array($this, 'addmenu'));
			add_action('admin_head',  array($this, 'addStyleSheet'));


			// Initialize Settings
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$Tour_Settings = new Tour_Settings();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));

			// Include ajax
			include($this->tour_dir.'/ajax.php');

			

		}
		public function addStyleSheet(){
			wp_enqueue_style($this->class_name.'style', $this->gallery_url.'/css/style.css', '');
		}
		public function addScript(){

		}

		public function addmenu(){
			// add new menu top level
			add_menu_page( 'Tour Manager', 'Tour manager', 'manage_options', 'tour-manager', array($this,'manage_order'),$this->tour_url.'/images/tour.png','21');
			// add submenu to the custom top level menu
    	 	add_submenu_page('tour-manager',__('Customer'), __('Customer'),'manage_options','tour-customer',array($this ,'manage_customer'));
			// add submenu gift
    	 	add_submenu_page('tour-manager',__('Gift'), __('Gift'),'manage_options','gift',array($this ,'manage_gift'));
			
		}
		public static function KBTour_activate(){
			echo 'Active';
			include $this->tour_dir.'/db/db.php';
		}
		public static function KBTour_deactivate(){

		}
		public function manage_order(){
			include $this->tour_dir.'/order.php';
		}
		public function manage_customer(){
			include $this->tour_dir.'/customer.php';
		}
		public function manage_gift(){
			include $this->tour_dir.'/gift.php';
		}

		// Add the settings link to the plugins page
		function plugin_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=setting-tour">Setting Tour</a>';
			array_unshift($links, $settings_link);
			return $links;
		}
	}
	$kbTour = new KBTour();
	// Plugin active
	register_activation_hook(__FILE__, array('KBTour', 'KBTour_activate'));
	// Plugin desactive
	register_deactivation_hook(__FILE__, array('KBTour', 'KBTour_deactivate'));