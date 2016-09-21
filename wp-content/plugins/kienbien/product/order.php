<?php 

	global $wpdb;

	$table_order = $wpdb->prefix . "order";
	$table_customer = $wpdb->prefix . "customer";
	$order_page = ADMIN_URL_PAGE.'?page=order-manager';
	$where_news = '';

	// Search
	if( ($_GET['page']=='order-manager') && isset($_GET['s']) ):
		$input_key=$_GET['s'];
		//$input_key_in= preg_replace("/[^0-9]{,}/", "",$input_key);
		$input_key_rep=str_replace(" ","",$input_key);
		$input_key_in=explode(",",$input_key_rep);
		//print_r($input_key_in);
		$count_ep=count($input_key_in);
		$input_in="";
		if($count_ep>0):
			for($sk=0;$sk<$count_ep;$sk++){
				$input_in_str_value .=(int)$input_key_in[$sk].",";
			}
				$input_in=strip_tags($input_in_str_value);
				$string_len_cut= strlen($input_in)-1;
				$input_in=mb_strimwidth($input_in,0,$string_len_cut,'','UTF-8');
		else:
			$input_in=(int)$input_key_in;
		endif;
			$where_news  = " 1=1 and MATCH(`order_id`) AGAINST ('{$input_key}' IN BOOLEAN MODE) or `order_id` IN ($input_in) ";
		//echo $where_news;

		else:
			if($_GET['page']=='order-manager'):
				$where_news  = " 1=1 ";
			endif;
	endif;

	// Approved order


	if($_GET['page']=='order-manager' && isset($_GET['order_id']) && $_GET['status'] && $_GET['status'] == 'approved'){
		$wpdb->update($wpdb->prefix.'order',array('order_status' => 'approved'),array('order_id'=> $_GET['order_id']));		

	}

	//Filter order

	if($_GET['page']=='order-manager' && isset($_POST['filter_submit'])){
		if($_POST['filter_order_id'] != ''){
			$where_news = "order_id = '{$_POST['filter_order_id']}'";
		}
	}

	// Delete order 
	if($_GET['page']=='order-manager' && isset($_GET['order_id']) && $_GET['action'] == 'delete'){
		//echo 'Delete';
		$order_id_del = $_GET['order_id'];
		$query_delete = "DELETE FROM ".$table_order." WHERE `order_id` ='".$order_id_del."' LIMIT 1";
		//echo $query_delete;
		$wpdb->query($query_delete);
		//wp_redirect($order_page);
	}

	//Delete data tour

	if($_GET['page']=='order-manager' && !empty($_POST['order_id'])):

		$post_id_array = $_POST['order_id'];
		//print_r($post_id_array);
		$k=0;
		for($k=0; $k<count($post_id_array); $k++):

			$query_delete = "DELETE FROM ".$table_order." WHERE `order_id` =".$post_id_array[$k]." LIMIT 1";
			$wpdb->query($query_delete);

		endfor;

	endif;

?>



<div class="wrap clear">

  	<h2><?php _e('Manage order','kienbien') ?></h2>
 	 <?php 
 	    $sql_pagination = "SELECT * FROM {$table_order} WHERE {$where_news}";
		$count_row = $wpdb->get_results($sql_pagination);
		$numrows = count($count_row);
		$rowsperpage =30;
		$range = 3;
		$totalpages = ceil($numrows / $rowsperpage);
		if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
		   $currentpage = (int) $_GET['currentpage'];
		} else {
		   $currentpage = 1;
		} 

		

		if ($currentpage > $totalpages) {
		   $currentpage = $totalpages;
		} 

		if ($currentpage < 1) {
		   $currentpage = 1;
		}
		$offset = ($currentpage - 1) * $rowsperpage;
  		?>

  <!--Search form-->

  	<form method="get" id="search_frm">
  		<input type="hidden" name="page" value="order-manager"/>
  		<span><i>Search</i></span>&nbsp;&nbsp;
        <input type="text" name="s" id="search_txt" value="<?php echo $_GET['s'] ?>" />
    	<input type="submit" name="search_tbl" class="button-secondary" value="<?php _e('Search')?>" />
    </form>

    <!--End Search form-->

   <form method="post" action="" id="bor_form_action">
    <div class="ptm-top clear">
		<div class="l">
			<select name="bor_action">
			    <option value="actions"><?php _e('Actions')?></option>
			    <option value="delete"><?php _e('Delete')?></option>
			</select>
			<input type="submit" name="bor_form_action_changes" class="button-secondary" value="<?php _e('Apply')?>" />
			<input type="text" name="filter_order_id" placeholder="<?php _e('Order ID',KB_TEXT_DOMAIN)?>">	
			<input type="submit" name="filter_submit" class="button-secondary" value="<?php _e('Filter','kienbien')?>" />

		</div> 

    <!--PageNavi-->
  	<div class="r page_navi">
  	<ul class="navi" >
    	<li><i>Page Item:</i> </li>
    	<?php 
			$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https')  === FALSE ? 'http' : 'https';
			$host     = $_SERVER['HTTP_HOST'];
			$script   = $_SERVER['SCRIPT_NAME'];
			$params_first   = "page=order-manager";
			if(isset($_GET['s'])):
				$params_search="&s=".$_GET['s'];
			else:
				$params_search="";
			endif;
			$string_page="&currentpage=";
			$currentUrl = $protocol . '://' . $host . $script . '?' . $params_first.$params_search.$string_page;

			if ($currentpage > 1)
			{
				$prevpage = $currentpage - 1;
				echo "<li class='next_btn'> <a href='".$currentUrl.$prevpage."'>&laquo;</a> </li>";  
				if($prevpage>3){
					echo "<li><a href='".$currentUrl."1' title='First Page 1'>1..</a></li> ";
				}
				else{
					if($prevpage==4){
						echo " <li><a href='".$currentUrl."1'>1</a></li> ";
					}
					else{
						echo "";
					}	
				}	  
			} 
			//
			for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
			    if (($x > 0) && ($x <= $totalpages)) {
				  	if ($x == $currentpage) {
						echo "<li class='currentPage'><b style='color:#F00'>$x</b></li> ";
				  	}else {
						echo " <li><a href='".$currentUrl.$x."'>$x</a></li> ";
				  	} 
			   	} 
			} 
			//
			if ($currentpage != $totalpages) {
				$nextpage = $currentpage + 1;		   
			    //echo " <li><a href='#' onclick='LoadPage_Job($totalpages,$category_id);'  title='End-Page -$totalpages'>End</a></li> ";
			    echo "<li class='next_btn'> <a href='".$currentUrl.$nextpage."' title='Next'>&raquo;</a> </li>";
			    echo " <li><a href='".$currentUrl.$totalpages."' title='End-Page -$totalpages'>End</a></li> ";
			}
		?>
    </ul>
</div>
  <!--End Page Navi-->
    </div>

    <table class="widefat page fixed" cellpadding="0">
		<thead>
			<tr>
				<th id="cb" class="manage-column column-cb check-column" style="" scope="col">
					<input type="checkbox"/>
				</th>	
				<th class="manage-column"><?php _e('Order ID','kienbien');?></th>
				<th class="manage-column"><?php _e('Customer','kienbien');?></th>
				<th class="manage-column"><?php _e('Order Date','kienbien');?></th>
				<th class="manage-column"><?php _e('Order Status','kienbien');?></th>
				<th class="manage-column"><?php _e('Order Total','kienbien');?></th>
				<th class="manage-column"><?php _e('Customer Note','kienbien');?></th>
				<th class="manage-column" width="20%"><?php _e('Order detail','kienbien');?></th>	
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th id="cb" class="manage-column column-cb check-column" style="" scope="col">
					<input type="checkbox"/>
				</th>	
				<th class="manage-column"><?php _e('Order ID','kienbien');?></th>
				<th class="manage-column"><?php _e('Customer','kienbien');?></th>
				<th class="manage-column"><?php _e('Order Date','kienbien');?></th>
				<th class="manage-column"><?php _e('Order Status','kienbien');?></th>
				<th class="manage-column"><?php _e('Order Total','kienbien');?></th>
				<th class="manage-column"><?php _e('Customer Note','kienbien');?></th>
				<th class="manage-column" width="20%"><?php _e('Order detail','kienbien');?></th>	
			</tr>
		</tfoot>
      <tbody>
        <?php
        $sql_view = "SELECT * FROM {$table_order} as o INNER JOIN {$table_customer} as c ON c.customer_id = o.customer_id WHERE {$where_news} ORDER BY order_date DESC LIMIT {$offset},{$rowsperpage} ";
    	$table_news = $wpdb->get_results($sql_view);
       // echo $wpdb->last_query;
        if($table_news){
            foreach($table_news as $news_item) {
            	$class = ($news_item->order_status == 'pending')?'bg-warning':'';
        	?>
			<tr class="<?php echo $class?>">
				<th class="check-column" scope="row">
					<input type="checkbox" value="<?php echo $news_item->id;?>" name="order_id[]" />
				</th>
				<td>
					<strong><?php echo $news_item->order_id; ?></strong>
					<div class="row-actions-visible">
						<span class="delete"><a href="?post_type=product&page=order-manager&amp;order_id=<?php echo $news_item->order_id;?>&amp;action=delete" onclick="return confirm('Are you sure you want to delete this news?');">Delete</a></span>
					</div>
				</td>
				<td><a href="?post_type=product&page=customer-manager&amp;customer_email=<?php echo $news_item->customer_email;?>"><?php echo $news_item->customer_name;?></a></td>
				<td><?php echo $news_item->order_date;?></td>
				<td>

					<?php 
					if($news_item->order_status == 'pending'){
						echo '<a href="?post_type=product&page=order-manager&amp;order_id='.$news_item->order_id.'&amp;status=approved">'.__('Pending',KB_TEXT_DOMAIN).'</a>';
					}
					else{
						_e('Approved',KB_TEXT_DOMAIN);
					}
				

					?>
				</td>
				<td><?php echo number_format($news_item->order_total);?></td>
				<td><?php echo $news_item->customer_note;?></td>
				<td>
					<a onclick="view_form('<?php echo $news_item->order_id ?>')" href="#TB_inline?width=400&height=300&inlineId=entry-form-order-detail" class="thickbox">
						<?php _e('Order detail','kienbien')?>
					</a>
				</td>
			</tr>

        <?php
           }//end foreach
        }//end if
        else{   
	    ?>
	        <tr><td colspan="4"><?php _e('There are no data.','kienbien')?></td></tr>   
	        <?php
	    }
        ?>   
      </tbody>
    </table>
  	<div class="ptm-bottom clear">
		<div class="l">
			<p>Total Order: <b><?php echo $numrows?></b></p>
		</div>
		<!--PageNavi-->
		<div class="r page_navi">
			<ul class="navi" >
			<li><i>Page Item:</i> </li>
			    <?php 
			if ($currentpage > 1){
				$prevpage = $currentpage - 1;
					echo "<li class='next_btn'> <a href='".$currentUrl.$prevpage."'>&laquo;</a> </li>";
				if($prevpage>3){
					echo "<li><a href='".$currentUrl."1' title='First Page 1'>1..</a></li> ";
				}
				else{
					if($prevpage==4){
						echo " <li><a href='".$currentUrl."1'>1</a></li> ";
					}
					else{
						echo "";
					}
				}
			} 
			//
			for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
				if (($x > 0) && ($x <= $totalpages)) {
					if ($x == $currentpage) {
						echo "<li class='currentPage'><b style='color:#F00'>$x</b></li> ";
					} else {
						echo " <li><a href='".$currentUrl.$x."'>$x</a></li> ";
					} 
				} 
			} 
			if ($currentpage != $totalpages) {
				$nextpage = $currentpage + 1;		   
			   //echo " <li><a href='#' onclick='LoadPage_Job($totalpages,$category_id);'  title='End-Page -$totalpages'>End</a></li> ";
			   echo "<li class='next_btn'> <a href='".$currentUrl.$nextpage."' title='Next'>&raquo;</a> </li>";
			   echo " <li><a href='".$currentUrl.$totalpages."' title='End-Page -$totalpages'>End</a></li> ";
			} 

	?>

		</ul>
	</div>
	<!--End Page Navi-->  
    </div>
  </form>
</div>



<?php add_thickbox(); ?>
<div id="entry-form-order-detail" style="display:none;">
	<div id="title">
		
	</div>
	<div id="content">
		
	</div>
</div>



<script type="text/javascript">
	var url = "/wp-admin/admin-ajax.php";
	function view_form(order_id){
		//jQuery('form#customer_gift_form #customer_email').val(customer_email_gift);
		jQuery.ajax({
			type: "POST",
            url: url,
            data: 'action=get_order_detail&order_id='+order_id,  
            success: function(data) {
            	jQuery('#TB_ajaxWindowTitle').text(order_id);
            	jQuery('#TB_ajaxContent > #content').html(data)
            	console.log(data);
            }

		});
	}
</script>