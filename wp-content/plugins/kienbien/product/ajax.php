<?php
	function get_order_detail(){
		$order_id = $_POST['order_id'];
		global $wpdb;
		$sql = "SELECT * FROM ".$wpdb->prefix.'order_detail'." WHERE order_id='{$order_id}'";
		//echo $sql;die();
		$data = $wpdb->get_results($sql);
		$total;
		echo '<table class="table-default" width="100%">';
		echo '<tr>';
		echo	'<td>Order ID</td>';
		echo	'<td>Product</td>';
		echo	'<td>Quantity</td>';
		echo	'<td>Price</td>';
		echo	'<td>Total</td>';
		echo '</tr>';
		foreach ($data as $data) {
			# code...
			$total += (int)$data->quantity * (int)$data->price;
			$product_name = get_post($data->product_id)->post_title;
			?>
				<tr>
					<td><?php echo $data->order_id?></td>
					<td><a href="<?php echo get_permalink($data->product_id)?>"><?php echo $product_name;?></a></td>
					<td><?php echo $data->quantity?></td>
					<td><?php echo $data->price?></td>
					<td><?php echo number_format((int)$data->quantity * (int)$data->price)?></td>
				</tr>
			<?php
		}
		echo '<tr><td colspan="5">Total: '.number_format($total).'</td></tr>';
		echo '</table>';
		die();
	}
	add_action('wp_ajax_nopriv_get_order_detail', 'get_order_detail');
	add_action('wp_ajax_get_order_detail', 'get_order_detail');

?>