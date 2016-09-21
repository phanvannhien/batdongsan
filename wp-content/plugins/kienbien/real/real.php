<?php
	//echo untrailingslashit( dirname(__FILE__)).'<br>';
	//echo dirname(__FILE__).'<br>';
	//echo __FILE__.'<br>';
	class KBReal{

		protected $class_name = 'real';
		protected $real_dir;
		protected $real_url;

		public function __construct(){
			$this->real_dir = untrailingslashit(dirname(__FILE__));
			$this->real_url = plugins_url( '', __FILE__ );


			// Create Menu
			add_action('admin_menu', array($this, 'KBreal_addmenu'));
			
			// Add Style CSS
			add_action('admin_head',  array($this, 'KBreal_addStyleSheet'));

			// Class customer
			include $real_dir.'modules/customer/clsCustomer.php';
			include $real_dir.'modules/customer/clsReal.php';
			
		}
		public function KBreal_addStyleSheet(){
			//wp_enqueue_style($this->class_name.'style', $this->real_url.'/css/style.css', '');
		}
		
		public function KBreal_addScriptJs(){

		}
		
		public function KBreal_addmenu(){
			// add new menu top level
			add_menu_page( 'Quản lý BĐS', 'Quản lý BĐS', 'manage_options', 'real-manager', array($this,'KBreal_manage'),'','81');
		
			add_submenu_page('real-manager',__('Khách hàng'), __('Khách hàng'),'manage_options','customer-manager',array($this ,'KBreal_manage_customer'));
			
			//add_submenu_page('edit.php?post_type=real',__('Order'), __('Order'),'manage_options','order-manager',array($this ,'KBreal_manage_order'));
			//add_submenu_page('edit.php?post_type=real',__('Inventory'), __('Inventory'),'manage_options','inventory',array($this ,'KBreal_manage_inventory'));
	
		}
		public function KBreal_manage(){
			include $real_dir.'real-dashboard.php';
		}
		public function KBreal_manage_customer(){
			include $real_dir.'customer.php';
		}
		public function KBreal_manage_inventory(){
			//include PLUGIN_DIR.'/inventory.php';
		}
	}

	if(class_exists('KBReal')){
		$KBReal = new KBReal();
	}