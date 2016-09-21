<?php
	//echo untrailingslashit( dirname(__FILE__)).'<br>';
	//echo dirname(__FILE__).'<br>';
	//echo __FILE__.'<br>';
	class KBProduct{

		protected $class_name = 'product';
		protected $product_dir;
		protected $product_url;

		public function __construct(){
			$this->product_dir = untrailingslashit(dirname(__FILE__));
			$this->product_url = plugins_url( '', __FILE__ );

			// Register custom post types
			require_once(sprintf("%s/post-types/product-post-type.php", dirname(__FILE__)));
			$Product_Post_Type = new Product_Post_Type();

			// Create Menu
			add_action('admin_menu', array($this, 'KBProduct_addmenu'));
			
			// Add Style CSS
			add_action('admin_head',  array($this, 'KBProduct_addStyleSheet'));

			include $product_dir.'ajax.php';
			
		}
		public function KBProduct_addStyleSheet(){
			wp_enqueue_style($this->class_name.'style', $this->product_url.'/css/style.css', '');
		}
		
		public function KBProduct_addScriptJs(){

		}
		
		public function KBProduct_addmenu(){
			// add new menu top level
			//add_menu_page( 'Order Manager', 'Order manager', 'manage_options', 'order-manager', array($this,'KBProduct_manage_order'),PLUGIN_URL.'/images/icon_travel.jpg','83');
		
			add_submenu_page('edit.php?post_type=product',__('Customer'), __('Customer'),'manage_options','customer-manager',array($this ,'KBProduct_manage_customer'));
			add_submenu_page('edit.php?post_type=product',__('Order'), __('Order'),'manage_options','order-manager',array($this ,'KBProduct_manage_order'));
			add_submenu_page('edit.php?post_type=product',__('Inventory'), __('Inventory'),'manage_options','inventory',array($this ,'KBProduct_manage_inventory'));
	
		}
		public function KBProduct_manage_order(){
			include $product_dir.'order.php';
		}
		public function KBProduct_manage_customer(){
			include $product_dir.'customer.php';
		}
		public function KBProduct_manage_inventory(){
			//include PLUGIN_DIR.'/inventory.php';
		}
	}
	if(class_exists('KienBien')){
		$KBProduct = new KBProduct();
	}