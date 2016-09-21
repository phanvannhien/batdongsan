<?php
	function customer_gift(){
		global $wpdb;
		$arr_insert_gift = array(
			'customer_email' => $_POST['customer_email'], 
			'gift_date' => date('Y-m-d H:s:i'),
			'gift_mark' => $_POST['gift_mark'],
			'gift_description' => $_POST['gift_description'],
		);
		//var_dump($arr_insert_gift);die();

		if($wpdb->insert($wpdb->prefix.'customer_gift',$arr_insert_gift)){
			$arr_result['result'] = __('success','kienbien'); 
		}
		else
			$arr_result['result'] = __('Error','kienbien'); 

		echo json_encode($arr_result);
		die();

	}
	add_action('wp_ajax_nopriv_customer_gift', 'customer_gift');
	add_action('wp_ajax_customer_gift', 'customer_gift');