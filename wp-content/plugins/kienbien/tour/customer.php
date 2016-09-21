<?php 

	

	global $wpdb;

	$table_order = $wpdb->prefix . "order";

	$table_user = $wpdb->prefix . "users";

	$table_user_meta = $wpdb->prefix . "usermeta";



	$order_page = ADMIN_URL_PAGE.'?page=tour-customer';

	$where_news = '';





	// Search

	if( ($_GET['page']=='tour-customer') && isset($_GET['s']) ):

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

			$where_news  = " 1=1 and MATCH(`ID`) AGAINST ('{$input_key}' IN BOOLEAN MODE) or `ID` IN ($input_in) ";

		//echo $where_news;

		else:

			if($_GET['page']=='tour-customer'):

				$where_news  = " 1=1 ";

			endif;

	endif;



	//Filter email customer

	if($_GET['page']=='tour-customer' && isset($_POST['filter_submit'])){



		if($_POST['filter_email'] != ''){

			$where_news = "u.user_email = '{$_POST['filter_email']}'";

		}



		if($_POST['filter_cmnn'] != ''){

			$where_news = "m.meta_key = 'user_cmnn' AND m.meta_value = '{$_POST['filter_cmnn']}'";

		}



	}





?>



<div class="wrap clear">

  	<h2><?php _e('Manage Customer','kienbien') ?></h2>

  

 	 <?php 

		

 	   $sql_pagination = "SELECT u.ID,u.user_login,u.user_email,SUM(o.order_total) as total,SUM(o.order_mark) as mark, m.meta_key FROM `vn_users` as u JOIN vn_order as o ON u.user_email = o.customer_email JOIN vn_usermeta as m ON u.ID = m.user_id WHERE m.meta_key = 'user_cmnn' AND {$where_news} GROUP BY u.ID,u.user_login,u.user_email,m.meta_key";



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

  		<input type="hidden" name="page" value="tour-customer"/>

  		<span><i>Search</i></span>&nbsp;&nbsp;

        <input type="text" name="s" id="search_txt" value="<?php echo $_GET['s'] ?>" />

    	<input type="submit" name="search_tbl" class="button-secondary" value="<?php _e('Search')?>" />

    </form>

    <!--End Search form-->

  

   <form method="post" action="" id="bor_form_action">

    <div class="ptm-top clear">

		<div class="l">

			

			<input type="text" name="filter_email" placeholder="Email">	



			<input type="text" name="filter_cmnn" placeholder="<?php _e('CMNN Number','kienbien')?>">	

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

			$params_first   = "page=tour-customer";

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

				

				<th class="manage-column"><?php _e('Customer ID','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Email','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Name','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Phone','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Address','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer CMNN','kienbien');?></th>

				<th class="manage-column"><?php _e('Money Total','kienbien');?></th>

				<th class="manage-column"><?php _e('Mark Total','kienbien');?></th>
				<th class="manage-column"><?php _e('Gift Total','kienbien');?></th>
				<th class="manage-column"><?php _e('Action','kienbien')?></th>
		

			</tr>

		</thead>

		<tfoot>

			<tr>

					<th class="manage-column"><?php _e('Customer ID','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Email','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Name','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Phone','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer Address','kienbien');?></th>

				<th class="manage-column"><?php _e('Customer CMNN','kienbien');?></th>

				<th class="manage-column"><?php _e('Money Total','kienbien');?></th>

				<th class="manage-column"><?php _e('Mark Total','kienbien');?></th>
				<th class="manage-column"><?php _e('Gift Total','kienbien');?></th>
				<th class="manage-column"><?php _e('Action','kienbien')?></th>
			</tr>

		</tfoot>

      <tbody>

      

        <?php

        $sql_view = "SELECT u.ID,u.user_login,u.user_email,SUM(o.order_total) as total,SUM(o.order_mark) as mark, m.meta_key FROM `vn_users` as u JOIN vn_order as o ON u.user_email = o.customer_email JOIN vn_usermeta as m ON u.ID = m.user_id WHERE o.order_status = 1 AND m.meta_key = 'user_cmnn' AND {$where_news} GROUP BY u.ID,u.user_login,u.user_email,m.meta_key ORDER BY ID DESC LIMIT {$offset},{$rowsperpage} ";



    	$table_news = $wpdb->get_results($sql_view);

        //echo $wpdb->last_query;



        if($table_news){

            foreach($table_news as $news_item) {
            	$sql_gift = "SELECT SUM(gift_mark) as mark_gift FROM ".$wpdb->prefix."customer_gift WHERE customer_email = '{$news_item->user_email}'";
        		$gift_mark = (int)$wpdb->get_row($sql_gift)->mark_gift;
        	?>

			<tr>

				

				<td>

					<strong><?php echo $news_item->ID ?></strong>

					

				</td>

					<td><?php echo $news_item->user_email;?></td>

					<td><?php echo $news_item->user_login;?></td>

					<td><?php echo get_user_meta($news_item->ID,'user_phone',true)?></td>

					<td><?php echo get_user_meta($news_item->ID,'user_address',true)?></td>

					<td><?php echo get_user_meta($news_item->ID,'user_cmnn',true)?></td>

					<td><?php echo number_format($news_item->total)?></td>
					<td><?php echo (int)$news_item->mark ?></td>
					<td><?php echo $gift_mark ?></td>
					<td>
						<a onclick="view_form('<?php echo $news_item->user_email ?>',<?php echo (int)$news_item->mark ?>)" href="#TB_inline?width=400&height=300&inlineId=entry-form-gift	" class="thickbox">
							<?php _e('Bonuses','kienbien')?>
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

			

			<?php

				$sql_total = "SELECT SUM(order_total) as total FROM ".$table_order." WHERE ".$where_news;

				$total = $wpdb->get_row($sql_total);



			?>

			<p>Total Money: <b><?php echo number_format($total->total) ?> vnd</b> Total Customer: <b><?php echo $numrows?></b></p>



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

<?php add_thickbox(); ?>
<div id="entry-form-gift" style="display:none;">
	<div id="title">
		
	</div>
	<div id="content">
		<form action="" id="customer_gift_form" name="customer_gift_form">
			<input type="hidden" id="customer_email" name="customer_email">
			<table>
				<tr>
					<td><?php _e('Mark','kienbien')?></td>
					<td>
						<input type="text" name="gift_mark">
					</td>
				</tr>
				<tr>
					<td><?php _e('Note','kienbien')?></td>
					<td>
						<textarea name="gift_description" id="" cols="40" rows="5"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input id="submit_gift" onclick="send_action_gift()" type="button" value="<?php _e('OK','kienbien')?>">
					</td>
				</tr>
			</table>
		</form>
	</div>
   
</div>

<script>

	var customer_email_gift;
	var url = "/wp-admin/admin-ajax.php";
	function view_form(customer_email,mark){
		customer_email_gift = customer_email;
		jQuery('#entry-form-gift > #title').html('<p>Gift for customer:'+customer_email+' Mark Total: '+mark+'</p>');
	}

	function send_action_gift(){
		jQuery('form#customer_gift_form #customer_email').val(customer_email_gift);
		jQuery.ajax({
			type: "POST",
            url: url,
            dataType:'JSON',
            data: jQuery('form#customer_gift_form').serialize()+'&action=customer_gift',  
            success: function(data) {
            	console.log(data);
               alert(data.result);
              location.reload();
            }

		});
	}

</script>

