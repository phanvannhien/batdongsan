<?php
	/**
	Plugin Name: Kienbien
	Plugin URI: http://kienbien.net/
	Description: Kienbien plugin libarry
	Version: 1.0.0
	Author: phanvannhien@gmail.com
	Author http://pvndesign.net
	License: GPLv2 or later
	Text Domain: kienbien
	*/
?>
<?php
	if ( ! defined( 'PLUGIN_BASENAME' ) )
		define( 'PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

	if ( ! defined( 'PLUGIN_NAME' ) )
	    define( 'PLUGIN_NAME', trim( dirname( PLUGIN_BASENAME ), '/' ) );

	if ( ! defined( 'PLUGIN_DIR' ) )
	    define( 'PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );

	if ( ! defined( 'PLUGIN_URL' ) )
	    define( 'PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

	if ( ! defined( 'ADMIN_URL_PAGE' ) )
	    define( 'ADMIN_URL_PAGE', admin_url().'admin.php');

	if ( ! defined( 'KB_TEXT_DOMAIN' ) )
	    define( 'KB_TEXT_DOMAIN', 'kienbien');

	if ( ! defined( 'PLUGIN_IMAGE_URL' ) )
	    define( 'PLUGIN_IMAGE_URL', PLUGIN_URL.'/images/');

	if ( ! defined( 'VENDOR_URL' ) )
		define ('VENDOR_URL',PLUGIN_URL.'/vendor/');
	
	if ( ! defined( 'VENDOR_DIR' ) )
		define ('VENDOR_DIR',PLUGIN_DIR.'/vendor/');


	// Declare KienBien Class
	class KienBien{
		public function __construct(){
			// Create Menu
			add_action('admin_menu', array($this, 'KienBien_addmenu'));

			// Add Style CSS
			add_action('admin_head',  array($this, 'KienBien_addStyleSheet'));

			// Load text domain multi langguage
			load_plugin_textdomain( 'kienbien', false, PLUGIN_DIR . '/language/' );

			//Real
			include(PLUGIN_DIR.'/real/real.php');
			
			//Product
			//include(PLUGIN_DIR.'/product/product.php');

			//Gallery
			//include(PLUGIN_DIR.'/gallery/gallery.php');

			//Tour
			//include(PLUGIN_DIR.'/tour/tour.php');


	
		}

		public function KienBien_addStyleSheet(){
			wp_enqueue_style('kienbien-style', PLUGIN_URL.'/css/style-admin.css', '');
		}
		
		public function KienBien_addScriptJs(){

		}
		public static function KienBien_activate(){
			//Create 
		}
		public static function KienBien_deactivate(){

		}

		public function KienBien_addmenu(){
			// add new menu top level
			
		}
		public function KienBien_manage_dashboard(){
			include(PLUGIN_DIR.'/dashboard.php');
		}
	}
	if(class_exists(KienBien)){
		$KienBien = new KienBien();
	}
	

	
