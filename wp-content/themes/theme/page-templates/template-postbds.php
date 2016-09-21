<?php /* Template Name: Post BDS Page */ ?>
<?php get_header();?>
<?php

$captcha_instance = new ReallySimpleCaptcha();
$captcha_instance->bg = array( 255, 255, 255 );



if(!is_user_logged_in() || !class_exists(KBRealCustomer) || !class_exists(KBBDS)){ 
    wp_redirect(home_url().'/dang-nhap?url='.get_permalink()); 
} 

$clsCustomer = new KBRealCustomer(); 
$currentUser = wp_get_current_user(); 
$infoUser = $clsCustomer->getCustomerByID( $currentUser->user_email ); 
$Real = new KBBDS();


if(isset($_GET['bid'])){

    $bdsID = wp_strip_all_tags($_GET['bid']);

    $realEdit = $Real->getRealByID(wp_strip_all_tags($bdsID));

    if(!$Real->checkExistRealUser($infoUser->id,$bdsID)){ 
        //echo 'Có ID đâu';die();
        wp_redirect(home_url()); 
    } 
}



?>


<div id="main-content" class="clearfix">
    <div id="user-sidebar" class="">
        <?php include(TEMPLATEPATH.'/inc/user-sidebar.php') ?>
    </div>

    <div id="user-main" class="">
        <?php

        
        // Save post
        if(isset($_POST['submitSave'])){
            $title = wp_strip_all_tags($_POST['title']);
            $description = $_POST['description'];
            $file = $_POST['real_attachment'];

            if($file){
                $strFile = '';
                foreach ($file as $key => $value) {
                    # code...
                    $strFile .= $value.',';
                }
            }
            //var_dump($strFile);

            $loaidm = wp_strip_all_tags($_POST['loaidm']);
            $loaibds = wp_strip_all_tags($_POST['loaibds']);
            $loaitiente = wp_strip_all_tags($_POST['loaitiente']);
            $dientich = wp_strip_all_tags($_POST['dientich']);
            $tonggia = wp_strip_all_tags($_POST['tonggia']);
            $giam2 = wp_strip_all_tags($_POST['giam2']);
            $huong = wp_strip_all_tags($_POST['huong']);
            $slttinhtp = wp_strip_all_tags($_POST['slttinhtp']);
            $sltquanhuyen = wp_strip_all_tags($_POST['sltquanhuyen']);
            $diachi = wp_strip_all_tags($_POST['diachi']);
            $lat = wp_strip_all_tags($_POST['lat']);
            $lng = wp_strip_all_tags($_POST['lng']);

            if(isset($_POST['action']) && $_POST['action']=='edit' && $_POST['bdsid']){

                $bdsid = wp_strip_all_tags($_POST['bdsid']);
                if( !$Real->checkExistRealUser($infoUser->id,$bdsid) ){ 
                    wp_redirect(home_url()); 
                } 

                $arrEdit = array(
                    'bds_name' => $title, 
                    'bds_cate_id' => $loaidm ,
                    'bds_user_id' => $infoUser->id, 
                    'price' => $tonggia, 
                    'date_start' => date('Y-m-d H:s:i'),
                    'description' => $description,
                    'dientich' => $dientich, 
                    'bds_status' => 'pending', 
                    'bds_image' => substr($strFile,0,-1), 
                    'loai_bds' => $loaibds ,
                    'loai_tien' =>  $loaitiente, 
                    'gia_m2' =>$giam2 ,
                    'huong' => $huong,
                    'tinhtp' => $slttinhtp, 
                    'quanhuyen' => $sltquanhuyen  , 
                    'diachi' => $diachi,
                    'lat' => $lat, 
                    'lng' => $lng, 
                );
            
                if($result = $Real->editReal($bdsid,$arrEdit)){
                    wp_redirect(get_permalink().'/?bid='.$bdsid.'&message=2');
                }else{
                    wp_redirect(get_permalink().'/?bid='.$bdsid.'&message=3');
                }


            }else{//Insert
                $newBDSID = 'r-'.$infoUser->id.'-'.strtotime(date('Y-m-d H:s:i'));
                $arrInsert = array(
                    'bds_id' => $newBDSID,
                    'bds_name' => $title, 
                    'bds_cate_id' => $loaidm ,
                    'bds_user_id' => $infoUser->id, 
                    'price' => $tonggia, 
                    'date_start' => date('Y-m-d H:s:i'),
                    'description' => $description,
                    'dientich' => $dientich, 
                    'bds_status' => 'pending', 
                    'bds_image' => substr($strFile,0,-1), 
                    'loai_bds' => $loaibds ,
                    'loai_tien' =>  $loaitiente, 
                    'gia_m2' =>$giam2 ,
                    'huong' => $huong,
                    'tinhtp' => $slttinhtp, 
                    'quanhuyen' => $sltquanhuyen  , 
                    'diachi' => $diachi,
                    'lat' => $lat, 
                    'lng' => $lng, 
                );
             
                if($bid = $Real->insertReal($arrInsert)){
                    wp_redirect(get_permalink().'/?bid='.$newBDSID.'&message=1');
                }else{
                    
                }
            }//end if insert 
        }

        ?>
        <?php
            if(isset($_GET['message']) && $_GET['message'] == '1'){
                echo '<p class="alert alert-success">Thêm tin thành công!</p>';
            }

            if(isset($_GET['message']) && $_GET['message'] == '2'){
                echo '<p class="alert alert-success">Sửa tin thành công!</p>';
            }

            if(isset($_GET['message']) && $_GET['message'] == '3'){
                echo '<p class="alert alert-danger">Lỗi không thể sửa!</p>';
            }
        ?>    
        <form id="frm-post-bds" action="<?php echo get_permalink()?>" class="frm-default" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">Thông tin Bất Động sản</div>
                <div class="panel-body">
                    <p>
                        <label for="title">Tiêu đề</label>
                        <input id="title" type="text" name="title" size="80" value="<?php echo $realEdit->bds_name?>" data-tooltip = "Tiêu đề tin đăng">
                    </p>
                    <p>
                        <?php 
                        $content=$realEdit->description; 
                        $editor_id='description' ; 
                        $settings = array( 
                          'wpautop'=>true,
                          'media_buttons' => false, 
                          'textarea_name' => $editor_id, 
                          'tinymce' => true, 
                          'quicktags' => true 
                          );
                        wp_editor($content, $editor_id, $settings); ?>
                    </p>
                    <p>
                        <label for="noidung">Hình đính kèm</label>
                        <span id="upload_image_button" class="fileinput-button">
                            <i class="fa fa-plus fa-2x"></i>
                            <span>Chọn hình</span>
                        </span>
                        <div id="dropbox">
                            <div id="all-attachment"></div>
                            <?php
                                if(isset($_GET['bid'])){
                                    ?>
                                    <script>
                                       loadRealGallery('<?php echo $realEdit->bds_image; ?>');
                                    </script>
                                    <?php
                                }
                            ?>
                        </div>
                    </p>

                </div>
            </div>
            <!-- end panel -->

            <div class="panel panel-default">
                <div class="panel-heading">Thông tin cơ bản</div>
                <div class="panel-body">
                    <p>
                        <label for="loai-dm">Loại danh mục</label>
                        <select name="loaidm" id="loai-dm" class="chosen">
                            <option value="-1">-- Chọn loại danh mục --</option>
                            <?php 
                              $listTermDanhMuc=get_terms( 'danh-muc',array( 'parent'=>0,'hide_empty'=>0)); 
                              $i = 0; 
                              foreach ($listTermDanhMuc as $list) { 
                              # code... 
                                if($realEdit->bds_cate_id == $list->term_id){
                                    $selected = 'selected';
                                }
                                echo '<option '.$selected.' value="'.$list->term_id.'">'.$list->name.'</option>'; 
                              } 
                            ?>
                        </select>
                    </p>

                    <p>
                        <label for="loai-bds">Loại BĐS</label>
                        <select name="loaibds" id="loai-bds" class="chosen">
                            <option value="-1">-- Chọn loại BĐS --</option>
                            <?php 
                            $listLoaiBDS=get_terms( 'loai-bat-dong-san',array( 'parent'=>0,'hide_empty'=>0)); $i = 0; 
                            foreach ($listLoaiBDS as $list) { # code... 
                                if($realEdit->loai_bds == $list->term_id){
                                    $selected = 'selected';
                                }
                                echo '<option '.$selected.' value="'.$list->term_id.'">'.$list->name.'</option>'; } ?>
                        </select>
                    </p>
                    <p>
                        <label for="dien-tich">Diện tích</label>
                        <input type="text" id="dien-tich" name="dientich" value="<?php echo $realEdit->dientich;?>" data-tooltip="Diện tích phải là số"> <span>(m2)</span>

                        <label for="loai-tiente">Loại tiền tệ</label>
                        <select name="loaitiente" id="loai-tiente">
                            <option value="-1">--- Chọn loại tiền tệ ---</option>
                           
                            <option <?php echo ($realEdit->loai_tien == 'VND')?'selected':''?> value="VND">Việt Nam Đồng</option>
                            <option <?php echo ($realEdit->loai_tien == 'USD')?'selected':''?> value="USD">USD</option>
                        </select>

                    </p>
                    <p>
                        <label for="tong-gia">Tổng giá</label>
                        <input type="text" id="tong-gia" name="tonggia" data-tooltip="Phải dạng số" value="<?php echo $realEdit->price ?>">
                        <span> triệu (1.000tr = 1 tỉ)</span>
                    </p>
                    <p>
                        <label for="gia-m">Giá /m2</label>
                        <input type="text" id="gia-m" name="giam2" data-tooltip="Phải dạng số" value="<?php echo $realEdit->gia_m2 ?>">
                        <span> triệu (1.000tr = 1 tỉ)</span>
                    </p>
          
                    <p>
                        <label for="huong">Hướng</label>
                        <select name="huong" id="huong" class="chosen">
                            <option value="-1">--- Chọn hướng ---</option>
                            <option <?php echo ($realEdit->huong == '0')?'selected':''?> value="Đông">Đông</option>
                            <option <?php echo ($realEdit->huong == '1')?'selected':''?> value="Tây">Tây</option>
                            <option <?php echo ($realEdit->huong == '2')?'selected':''?> value="Nam">Nam</option>
                            <option <?php echo ($realEdit->huong == '3')?'selected':''?> value="Bắc">Bắc</option>
                            <option <?php echo ($realEdit->huong == '4')?'selected':''?> value="Đông Bắc">Đông Bắc</option>
                            <option <?php echo ($realEdit->huong == 'Đông Nam')?'selected':''?> value="Đông Nam">Đông Nam</option>
                            <option <?php echo ($realEdit->huong == 'Tây Nam')?'selected':''?> value="Tây Nam">Tây Nam</option>
                            <option <?php echo ($realEdit->huong == 'Tây Bắc')?'selected':''?> value="Tây Bắc">Tây Bắc</option>
                            <option <?php echo ($realEdit->huong == 'Chưa xác định')?'selected':''?> value="Chưa xác định">Chưa xác định</option>
                        </select>
                    </p>
                    <p>
                        <label for="tinh-tp">Tỉnh/ thành phố *</label>
                        <select name="slttinhtp" id="tinh-tp" onchange="getQuanHuyen(this.value)" class="chosen">
                            <option value="-1">--- Chọn Tỉnh / Tp ---</option>
                            <?php $listTp=get_terms( 'dia-diem',array( 'parent'=>0,'hide_empty'=>0)); 
                            foreach ($listTp as $list) { # code.. 
                                 if($realEdit->tinhtp == $list->term_id){
                                    $selected = 'selected';
                                }         

                              echo '<option '.$selected .' value="'.$list->term_id.'">'; echo $list->name; echo '</option>'; } 
                            ?>
                        </select>
                    </p>
                    <p>
                        <label for="quan-huyen">Quận / Huyện *</label>
                        <select name="sltquanhuyen" id="quan-huyen" onchange="" class="chosen">
                            <option value='-1'>Chọn Quận/Huyện</option>
                            <?php
                                if($realEdit->quanhuyen){
                                    ?>
                                        <script>
                                        loadQuanHuyenByTP(<?php echo $realEdit->tinhtp ?>,<?php echo $realEdit->quanhuyen ?>,'#quan-huyen');
                                        </script>
                                    <?php
                                }
                            ?>
                        </select>
                    </p>

                </div>

            </div>
            <!-- end panel -->

            <div class="panel panel-default">
                <div class="panel-heading">Liên hệ</div>
                <div class="panel-body">
                    <?php ?>
                    <p>
                        <label for="">Tên liên hệ *</label>
                        <input type="text" disabled value="<?php echo $infoUser->fullname;?>">

                        <label for="">Di động *</label>
                        <input type="text" disabled value="<?php echo $infoUser->phone;?>">
                    </p>
                    <p>
                        <label for="">Email *</label>
                        <input type="text" disabled value="<?php echo $infoUser->email;?>">
                    </p>
                </div>
            </div>
            <!-- end panel -->
            <div class="panel panel-default">
                <div class="panel-heading">Vị trí trên bản đồ</div>
                <div class="panel-body">
                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
                    <p>
                        <label for="">Nhập địa chỉ</label>
                        <input data-tooltip="Nhập địa chỉ của bạn" style="width:70%" id="map-address" type="text" name="diachi" value="<?php echo $realEdit->diachi ?>">
                        <input type="button" class="btn" value="Tìm địa chỉ" onclick="codeAddress()">

                    </p>
                    <p><span>Ví dụ: 7 Lê Lợi Quận 1, Ho Chi Minh</span>
                    </p>
                    <p>
                        Tọa độ: 
                        <input type="hidden" id="lat" name="lat"  value="<?php echo $realEdit->lat ?>" >
                        <input type="hidden" id="lng" name="lng"  value="<?php echo $realEdit->lng ?>" >
                    </p>
                    <div id="map-canvas">

                    </div>
                </div>
            </div>
            <!-- end panel -->

            <p>
                    <?php
                        
                        $word = $captcha_instance->generate_random_word();
                        $prefix = mt_rand();
                        $img =  $captcha_instance->generate_image( $prefix, $word );

                    ?>
                    <label for="captcha">Mã bảo vệ: *</label>
                    <?php
                     echo '<img class="place-left" src="' . plugins_url() .'/really-simple-captcha/tmp/'.$img. '" > ';
                    ?>
                    <input id="captcha" type="text" name="captcha" style="width:50px">
                    <input type="hidden" value="<?php echo $prefix;?>" name="prefix_captcha"/> 
                </p>
            <p>
                <?php
                    if($realEdit){
                        echo '<input type="hidden" name="action" value="edit" class="">';
                        echo '<input type="hidden" name="bdsid" value="'.$bdsID.'" class="">';
                    }
                ?>
                <input type="submit" name="submitSave" value="Đăng tin" class="btn">

            </p>
        </form>
    </div>

</div><!-- #main-content -->
</div>
<!-- end wrapper main-->
<script type="text/javascript">

   
    //Create editor
    //jQuery('textarea').htmlarea();

    function template_attachment(img, attach_id) {
        var temp = '<div class="c-30 pull-left" id="del-' + attach_id + '">' +
            ' <div class="thumbnail">' + img +
            '<a href="javascript:void(0)" onclick = "remove_attachment(' + attach_id + ')" class = "fa fa-remove fa-2x" id = ""></a>' +
            '</div>' +
            '</div>';
        return temp;
    }

    function remove_attachment(att_id) {
        jQuery('#del-' + att_id).remove();
    }
    jQuery(document).ready(function($) {

     
        // Upload
        var custom_uploader;
        var dropbox = $('#dropbox'),
            message = $('span#upload_image_button', dropbox);
        $('#upload_image_button').click(function(e) {
            e.preventDefault();
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: true,
                library: {
                    type: "image"
                }
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                //attachment = custom_uploader.state().get('selection').toJSON();

                attachment = custom_uploader.state().get('selection');
                var curentNumberImage = $('#dropbox .thumbnail').length;

                if ((attachment.length + curentNumberImage) > 10) {
                    alert("Bạn chỉ được chọn tối đa 10 hình");
                    return;

                }

                attachment.map(function(attachment) {
                    var allimg = $('input.inserted-file');

                    if (allimg.length > 0) {
                        console.log("item vua add" + JSON.stringify(attachment));
                        attachment = attachment.toJSON();

                       
                        var check_exits = false;
                        allimg.each(function(item) {

                            if ($(this).attr('value') == attachment.id) {
                                check_exits = true;
                            }
                        });
                        if (!check_exits) {
                            var img = "<img width='80' src=" + attachment.url + "><input class='hidden inserted-file' name=real_attachment[] type='hidden' value=" + attachment.id + ">";
                            $('#all-attachment').after(template_attachment(img, attachment.id));
                        }
                    } else {
                        attachment = attachment.toJSON();
                        var img = "<img width='80' src=" + attachment.url + "><input class='hidden inserted-file' name=real_attachment[] type='hidden' value=" + attachment.id + ">";
                        $('#all-attachment').after(template_attachment(img, attachment.id));
                    }

                });

            });

            //Open the uploader dialog
            custom_uploader.open();
        });
        // Add validate
        validateSelect("validateloaidm", "loaidm");
        validateSelect("validateloaibds", "loaibds");
        validateSelect("validateloaitiente", "loaitiente");
        validateSelect("validatehuong", "huong");
        validateSelect("validateslttinhtp", "slttinhtp");
        validateSelect("validatesltquanhuyen", "sltquanhuyen");

        //validate
        jQuery("form#frm-post-bds").validate({
            rules: {
                title: "required",
                loaidm: {
                    validateloaidm: true,
                },
                loaibds: {
                    validateloaibds: true,
                },
                loaitiente: {
                    validateloaitiente: true,
                },
                huong: {
                    validatehuong: true,
                },
                slttinhtp: {
                    validateslttinhtp: true,
                },
                sltquanhuyen: {
                    validatesltquanhuyen: true,
                },

                tonggia:{
                    required:true,
                    number:true,
                },
                giam2:{
                    required:true,
                     number:true
                },

                captcha: {
                    validate_captcha:true
                }

            },
            messages: {
                title: "Vui lòng nhập tiêu đề",
                loaidm: {
                    validateloaidm: "Chọn loại danh mục",
                },
                 loaibds: {
                    validateloaibds: "Chọn loại BĐS",
                },
                 loaitiente: {
                    validateloaitiente: "Chọn loại tiền tệ",
                },
                 huong: {
                    validatehuong: "Chọn hướng",
                },
                 slttinhtp: {
                    validateslttinhtp: "Chọn Tỉnh / TP",
                },
                 sltquanhuyen: {
                    validatesltquanhuyen: "Chọn loại Quận / Huyện",
                },
                tonggia:{
                    required:"Vui lòng nhập giá",
                    number:"Giá phải là dạng số"
                },
                giam2:{
                    required:"Vui lòng nhập giá",
                    number:"Giá phải là dạng số"
                },
                captcha: {
                    validate_captcha:"Mã xác nhận chưa đúng"
                }


            },
            submitHandler: function(form) {
                form.submit();
            }

        });

    }); //end ready 

    // maps
    var geocoder;
    var map;
    var currentMarker;
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: new google.maps.LatLng(<?php echo ($realEdit) ? $realEdit->lat.','.$realEdit->lng : '10.7753675,106.70180649999998' ?>)
        };

        map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        currentMarker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(<?php echo ($realEdit) ? $realEdit->lat.','.$realEdit->lng : '10.7753675,106.70180649999998' ?>),
            //icon: {
            //  path: google.maps.SymbolPath.CIRCLE,
            //  scale: 10
            //},
            draggable: true,
        });

         google.maps.event.addListener(currentMarker, 'drag', function(event) {
            document.getElementById('lat').value = event.latLng.lat();
            document.getElementById('lng').value = event.latLng.lng();
        });

        google.maps.event.addListener(currentMarker, 'dragend', function(event) {
            document.getElementById('lat').value = event.latLng.lat();
            document.getElementById('lng').value = event.latLng.lng();
        });
    } //end init

    function codeAddress() {
        var address = document.getElementById('map-address').value;
        currentMarker.setMap(null);
        //markerNewPosition.setMap(null);
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                document.getElementById('lat').value = results[0].geometry.location.k;
                document.getElementById('lng').value = results[0].geometry.location.D;

                //console.log(JSON.stringify(results));
                map.setCenter(results[0].geometry.location);
                currentMarker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    //icon: {
                    //  path: google.maps.SymbolPath.CIRCLE,
                    //  scale: 10
                    //},
                    draggable: true,
                });

                google.maps.event.addListener(currentMarker, 'drag', function(event) {
                    document.getElementById('lat').value = event.latLng.lat();
                    document.getElementById('lng').value = event.latLng.lng();
                });

                google.maps.event.addListener(currentMarker, 'dragend', function(event) {
                    document.getElementById('lat').value = event.latLng.lat();
                    document.getElementById('lng').value = event.latLng.lng();
                });
            } else {
                alert('Có lỗi xảy ra không thể xác định địa điểm !');
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php get_footer();?>
