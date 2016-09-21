<?php 

	

	global $wpdb;

	$table = $wpdb->prefix . "order";

	$order_page = ADMIN_URL_PAGE.'?page=tour-manager';

	$where_news = '';

	// Update status 



	if($_GET['page']=='tour-manager' && isset($_GET['order_id']) && $_GET['action'] == 'updatestatus'){

		$sql = "UPDATE ".$table." SET Order_status = ".$_GET['value']." WHERE id='".$_GET['order_id']."'";

		$wpdb->query($sql);

		//Create new User And Sent email



		$user_info_query = "SELECT * FROM ".$table." WHERE id=".$_GET['order_id'];

		$user_info = $wpdb->get_row($user_info_query);

		//var_dump($user_info);
                $current_user = wp_get_current_user();
		if($user_info && !email_exists($user_info->customer_email) && $current_user->user_email != $user_info->customer_email){
                
		$user_id = wp_create_user($user_info->customer_cmnn,$user_info->customer_phone,$user_info->customer_email);
               
	        add_user_meta($user_id,'user_address',$user_info->customer_address);

	        add_user_meta($user_id,'user_cmnn',$user_info->customer_cmnn);

	        add_user_meta($user_id,'user_phone',$user_info->customer_phone);

	        // update user role using wordpress function
                
	        //wp_update_user( array ('ID' => $user_id, 'role' => '' ) ) ;



	        // Send email to customer



	        $email_message = "<h2>Wellcome to User:{$user_info->customer_name}</h2>";

	        $email_message .= "<p>Login info:</p>";

	        $email_message .= "<p>Account Email: {$user_info->customer_email}</p>";

	        $email_message .= "<p>Password: {$user_info->customer_phone}</p>";



	        $headers = "From: " . get_bloginfo('name') . " <" . get_option('admin_email') . ">\n";

		    $headers .= "Content-Type: text/html; charset=UTF-8\n";

		    $headers .= "Content-Transfer-Encoding: 8bit\n";

		    if(wp_mail($user_info->customer_email,"Wellcome Active User", $email_message, $headers))

		    {

		       

		    }

		}//end if



		//wp_redirect($order_page);

	}







	//Delete data tour

	if($_GET['page']=='tour-manager' && !empty($_POST['order_id'])):

		$post_id_array = $_POST['order_id'];

		print_r($post_id_array);

		$k=0;

		for($k=0; $k<count($post_id_array); $k++):

			$query_delete = "DELETE FROM ".$table." WHERE `id` =".$post_id_array[$k]." LIMIT 1";

			$wpdb->query($query_delete);

		endfor;

	endif;



	// Delete tour 

	if($_GET['page']=='tour-manager' && isset($_GET['order_id']) && $_GET['action'] == 'delete'){

		$order_id_del = $_GET['order_id'];

		$query_delete = "DELETE FROM ".$table." WHERE `id` =".$order_id_del." LIMIT 1";

		$wpdb->query($query_delete);

		//wp_redirect($order_page);

	}



	// Search

	if( ($_GET['page']=='tour-manager') && isset($_GET['s']) ):

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

			$where_news  = " 1=1 and MATCH(`customer_id`,`id`) AGAINST ('{$input_key}' IN BOOLEAN MODE) or `customer_id` IN ($input_in) ";

		//echo $where_news;

		else:

			if($_GET['page']=='tour-manager'):

				$where_news  = " 1=1 ";

			endif;

	endif;



	//Filter email customer

	if($_GET['page']=='tour-manager' && isset($_POST['filter_submit'])){



		if($_POST['filter_type'] != ''){

			$where_news = " service = '{$_POST['filter_type']}'";

		}



		if($_POST['filter_email'] != ''){

			$where_news = "customer_email = '{$_POST['filter_email']}'";

		}



		if($_POST['filter_email'] != '' && $_POST['filter_type'] != ''){

			$where_news = " service = '{$_POST['filter_type']}' AND customer_email = '{$_POST['filter_email']}'";

		}

		

	}





?>



<div class="wrap clear">

  	<h2><?php _e('Manage Order Tour','kienbien') ?></h2>

  

 	 <?php 

			//phan trang

		global $wpdb;

		$count_row = $wpdb->get_results("SELECT count('id') as `count` FROM " .$wpdb->prefix ."order WHERE ".$where_news);

		$numrows = $count_row[0]->count;

		

		//echo $numrows;

		$rowsperpage =30;

		$range = 3;

		//echo $numrows;

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

  		<input type="hidden" name="page" value="tour-manager"/>

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

			

			<select name="filter_type">

			    <option value="tour"><?php _e('Tour','kienbien')?></option>

			    <option value="ticket"><?php _e('Ticket','kienbien')?></option>

			</select>



			<input type="text" name="filter_email" placeholder="Email">	





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

			$params_first   = "page=tour-manager";

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

				<th class="manage-column"><?php _e('Order ID / Type','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Name','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Email','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Phone','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Address','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer CMNN','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Note','kienbien');?></th>

				<th class="manage-column"><?php _e('Order date','kienbien');?></th>

				<th class="manage-column"><?php _e('Total','kienbien');?></th>

				<th class="manage-column"><?php _e('Mark','kienbien');?></th>

				<th class="manage-column"><?php _e('Status','kienbien');?></th>

				<th class="manage-column"><?php _e('View Tour','kienbien');?></th>

			</tr>

		</thead>

		<tfoot>

			<tr>

				<th id="cb" class="manage-column column-cb check-column" style="" scope="col">

				 	<input type="checkbox"/>

				</th>

			<th class="manage-column"><?php _e('Order ID / Type','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Name','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Email','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Phone','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Address','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer CMNN','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Note','kienbien');?></th>

				<th class="manage-column"><?php _e('Order date','kienbien');?></th>

				<th class="manage-column"><?php _e('Total','kienbien');?></th>

				<th class="manage-column"><?php _e('Mark','kienbien');?></th>

				<th class="manage-column"><?php _e('Status','kienbien');?></th>

				<th class="manage-column"><?php _e('View Tour','kienbien');?></th>
			</tr>

		</tfoot>

      <tbody>

      

        <?php



    	$table_news = $wpdb->get_results("SELECT * FROM " .$wpdb->prefix ."order WHERE ".$where_news." ORDER BY ID DESC LIMIT {$offset},{$rowsperpage}");

        //echo $wpdb->last_query;



        if($table_news){

            $i=0;

            foreach($table_news as $news_item) { 

               $i++;

               $class = ($news_item->order_status == 0)? 'active':'';

        	?>

			<tr class="<?php echo $class;?>">

				<th class="check-column" scope="row">

					<input type="checkbox" value="<?php echo $news_item->id;?>" name="order_id[]" />

				</th>

				<td>

					<strong><?php echo $news_item->id.'/'.$news_item->service;?></strong>

					<div class="row-actions-visible">

						<span class="delete"><a href="?page=tour-manager&amp;order_id=<?php echo $news_item->id;?>&amp;action=delete" onclick="return confirm('Are you sure you want to delete this news?');">Delete</a></span>

					</div>

				</td>

					<td><?php echo $news_item->customer_name;?></td>

					<td><?php echo $news_item->customer_email;?></td>

					<td><?php echo $news_item->customer_phone;?></td>

					<td><?php echo $news_item->customer_address;?></td>

					<td><?php echo $news_item->customer_cmnn;?></td>

					<td><?php echo $news_item->customer_note;?></td>

					<td><?php echo $news_item->order_date;?></td>

					<td><?php echo number_format($news_item->order_total).' d';?></td>

					<td><?php echo number_format($news_item->order_mark)	;?></td>

					<td>

						<a href="<?php echo $order_page ?>&order_id=<?php echo $news_item->id?>&action=updatestatus&value=1">

							<?php echo ($news_item->order_status == 0)?__('Pending','kienbien'):__('Aprove','kienbien');?>
						</a>

					</td>

					<td>

						<a target="_blank" href="<?php echo get_permalink($news_item->tour_id);?>"><?php _e('View Tour','kienbien');?></a>

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

			<select name="bor_action-2">

			    <option value="actions"><?php _e('Actions','kienbien')?></option>

			    <option value="delete"><?php _e('Delete','kienbien')?></option>

			</select>

			<input type="submit" name="bor_form_action_changes-2" class="button-secondary" value="<?php _e('Apply','kienbien')?>" />

			

			<?php

				$sql_total = "SELECT SUM(order_total) as total FROM ".$table." WHERE ".$where_news;

				$total = $wpdb->get_row($sql_total);



			?>

			<p>Total: <b><?php echo number_format($total->total) ?> vnd</b> Total Order: <b><?php echo $numrows?></b></p>



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

				//		

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

  </form>

</div>