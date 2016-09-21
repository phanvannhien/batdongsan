<?php
add_action('after_setup_theme', 'theme_navigations');
  // This theme uses wp_nav_menu() in two locations.
function theme_navigations(){
	register_nav_menus(array(
	    'primary' => __('Top primary menu', 'theme_language'),
	    'footer-top-menu' => __('The menu footer top', 'theme_language'),
	    'footer-main-menu' => __('The menu footer main', 'theme_language'),
	));
}
