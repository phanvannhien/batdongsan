<?php
/*
	Template Name: Real detail page
*/
?>
<?php
    get_header(); 
    if (get_query_var('pagename') == 'real' && get_query_var('real_id')) {
    	$Real = new KBBDS();
        $readID = get_query_var('real_id');
        $real = $Real->getRealByID($readID);
        $term = get_term($real->loai_bds, 'loai-bat-dong-san');
		$termdiadiem = get_term($real->tinhtp, 'dia-diem');
		$termdiadiemquanhuyen = get_term($real->quanhuyen, 'dia-diem');
		$termloai = get_term($real->loai_bds, 'loai-bat-dong-san');

		$Customer = new KBRealCustomer();
		$curentCustomer = $Customer->getCustomerRealByID($real->bds_user_id);

    }else{
    	wp_redirect(home_url());
    }
?>

<div id="main-content" class="clearfix">
    <div id="sidebar">
        <?php get_sidebar()?>
    </div>
    <!-- # side bar -->
    <div id="content-primary">


		<h2><?php echo $real->bds_name;?></h2>   
		<p style="margin-bottom:10px;"><i class="fa fa-home"></i> <strong>Địa chỉ: <?php echo $real->diachi?></strong></p>   
		<p style="margin-bottom:10px;"><i class="fa fa-edit"></i> <strong>Ngày đăng: <?php echo date('d-m-Y',strtotime($real->date_start))?></strong></p>   
		<div class="info-real">
			<span>Danh mục: <a href="<?php echo get_term_link($term)?>"><strong><?php echo $term->name;?></strong></a></span>
			<span>Tỉnh/Tp: <a href="<?php echo get_term_link($termdiadiem)?>"><strong><?php echo $termdiadiem->name;?></strong></a></span>
			<span>Quận/Huyện: <a href="<?php echo get_term_link($termdiadiemquanhuyen)?>"><strong><?php echo $termdiadiemquanhuyen->name;?></strong></a></span>
			<span>Loại BĐS: <a href="<?php echo get_term_link($termloai)?>"><strong><?php echo $termloai->name;?></strong></a></span>
			<span class="pull-right price-lg">Giá:  <?php echo $real->price.' '.$real->loai_tien?> </span></span>
		</div>   
		<div class="padding10 clearfix" style="height:15px">
			<a id="view-map" onclick="viewmap()" class="pull-right" href=""><i class="fa fa-map-marker"> Xem bản đồ</i></a>
		</div>

		<div id="real-map" style="margin-bottom:10px;display:none;">
			<div id="map-canvas">
				
			</div>
		</div>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
			<script>
				var geocoder;
			    var map;
			    var currentMarker;
			    function initializeMap() {
			        geocoder = new google.maps.Geocoder();
			        var mapOptions = {
			            zoom: 15,
			            mapTypeId: google.maps.MapTypeId.ROADMAP,
			            center: new google.maps.LatLng(<?php echo ($real) ? $real->lat.','.$real->lng : '10.7753675,106.70180649999998' ?>)
			        };

			        map = new google.maps.Map(document.getElementById('map-canvas'),
			            mapOptions);

			        currentMarker = new google.maps.Marker({
			            map: map,
			            position: new google.maps.LatLng(<?php echo ($real) ? $real->lat.','.$real->lng : '10.7753675,106.70180649999998' ?>),
			            //icon: {
			            //  path: google.maps.SymbolPath.CIRCLE,
			            //  scale: 10
			            //},
			            draggable: false,
			        });

			       
			    } //end init	
			    //google.maps.event.addDomListener(window, 'load', initialize);

			   jQuery('#view-map').on('click',function(e){
			   		e.preventDefault();
			   		if(jQuery(this).hasClass('opened')){
			   			jQuery('#real-map').slideUp();
			   			jQuery(this).removeClass('opened');
			   			jQuery(this).addClass('closed');
			   		}else{
			   			jQuery('#real-map').slideDown(500);
			   			jQuery(this).removeClass('closed');
			   			jQuery(this).addClass('opened');
			   			initializeMap();
			   		}

			   		
			   });
			</script>
       
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="content-single">
					<ul class="basic-real-info">
						<li>Hướng: <?php echo $real->huong;?></li>
						<li>Diện tích: <?php echo $real->dientich;?> / m2</li>
						<li>Giá/m2: <?php echo $real->gia_m2;?></li>
					</ul>
					<?php echo $real->description;?>
				 </div>	
			 <div class="real-contact">
			 	<p>
			 		<span><i class="fa fa-user fa-lg"></i> Tên liên hệ: <?php echo $curentCustomer->fullname;?></span>
            		<span><i class="fa fa-phone fa-lg"></i> Điện thoại: <?php echo $curentCustomer->phone;?></span>
			 	</p>
            	
            </div>

			</div>

		</div>        
          
           	
       
        <div id="real-gelary" class="slider-img">
       		<ul class="slides">
       		<?php
       			$galery = getRealThumbnailUrl($real->bds_image,'all');
       			foreach ($galery as  $value) {
       				?>
						<li><img rel="prettyPhoto[]" class="center-block" src="<?php echo $value;?>" alt=""></li>
       				<?php
       				# code...
       			}
       		?>
       		</ul>
       	</div>
	
    </div>
</div><!-- #main-content -->
</div>
<!-- end wrapper main-->
<script>
	// Can also be used with $(document).ready()
	jQuery(window).load(function() {
	  jQuery('#real-gelary').flexslider({
	    animation: "slide",
	    namespace:'',
	    prevText: 'Lùi',
	    nextText:'Tới',
	    directionNav: false
	  });
	});

</script>

<?php
get_footer();    
