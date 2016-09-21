<?php
if(!class_exists('Tour_Settings'))
{
	class Tour_Settings
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// register actions
            add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'add_menu'));
		} // END public function __construct
		
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
        	// register your plugin's settings
        	register_setting('tour-setting-group', 'tour_percent');//setting page , setting field
        	register_setting('tour-setting-group', 'tour_pagination');

        	// add your settings section
        	add_settings_section(
        	    'tour_section_id', //Defined section id
        	    __('Section setting for Tour Order Point',KB_TEXT_DOMAIN), // Title section
        	    array(&$this, 'settings_section_tour'), // Callback description
        	    'tour_settings_fields' // defined page doing setting action
        	);
        	
        	// add your setting's fields
            add_settings_field(
                'tour_settings_fields-tour_percent', 
                __('Tour Point Percent',KB_TEXT_DOMAIN), // Label 
                array(&$this, 'settings_field_input_text'), // Callback function form field
                'tour_settings_fields', // define action call field
                'tour_section_id',// Field to section
                array(
                    'field' => 'tour_percent',
                )
            );
             add_settings_field(
                'tour_settings_fields-tour_pagination', 
                 __('Tour Pagination',KB_TEXT_DOMAIN), // Label 
                array(&$this, 'settings_field_input_text'), 
                'tour_settings_fields', 
                'tour_section_id',
                array(
                    'field' => 'tour_pagination'
                )
            );
            
            // Possibly do additional admin_init tasks
        } // END public static function activate
        
        public function settings_section_tour()
        {
            // Think of this as help text for the section.
            echo __('Setting point when Customer Order Tour, using for gift point.',KB_TEXT_DOMAIN);
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)
        
        /**
         * add a menu
         */		
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
           
        	
           

            // add submenu gift
            add_submenu_page('tour-manager',__('Setting Tour'), __('Setting Tour'),'manage_options','setting-tour',array($this ,'plugin_settings_page'));
    
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */		
        public function plugin_settings_page()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}
	
        	// Render the settings template
        	include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class Tour_Settings
} // END if(!class_exists('Tour_Settings'))
