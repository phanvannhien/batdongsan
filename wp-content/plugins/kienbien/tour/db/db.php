<?php
	echo 'Create Table Tour';
	global $wpdb;
	$table_order = $wpdb->prefix . "_order";
	$table_customer_gift = $wpdb->prefix . "customer_gift";
	$sql = "";

	if($wpdb->get_var('SHOW TABLES LIKE ' . $table_customer_gift) != $table_customer_gift){
		$sql .= "CREATE TABLE IF NOT EXISTS $table_customer_gift (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_email` varchar(100) NOT NULL,
		  `gift_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `gift_mark` int(11) NOT NULL DEFAULT '0',
		  `gift_description` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;";	
	}

	if($wpdb->get_var('SHOW TABLES LIKE ' . $table_order) != $table_order){
		$sql .= "CREATE TABLE IF NOT EXISTS $table_order (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `customer_note` varchar(255) NOT NULL,
		  `order_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  `tour_id` int(5) NOT NULL,
		  `customer_email` varchar(100) NOT NULL,
		  `customer_name` varchar(100) NOT NULL,
		  `customer_cmnn` varchar(50) NOT NULL,
		  `customer_phone` varchar(20) NOT NULL,
		  `customer_address` varchar(255) NOT NULL,
		  `order_status` int(1) NOT NULL DEFAULT '0',
		  `order_total` int(11) NOT NULL DEFAULT '0',
		  `order_percent` float NOT NULL DEFAULT '0',
		  `order_mark` int(11) NOT NULL DEFAULT '0',
		  `service` varchar(50) NOT NULL DEFAULT 'tour',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;";	
	}
	

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
