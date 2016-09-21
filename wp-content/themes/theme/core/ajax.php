<?php
add_action('wp_ajax_nopriv_check_validate_captcha', 'check_validate_captcha');
add_action('wp_ajax_check_validate_captcha', 'check_validate_captcha');
function check_validate_captcha(){
    $value = $_POST['value'];
    $prefix_captcha = $_POST['prefix_captcha'];
    if(class_exists('ReallySimpleCaptcha')){
        $captcha_instance = new ReallySimpleCaptcha();
        $correct = $captcha_instance->check( $prefix_captcha, $value );
        echo $correct;
    }
    else{
        echo 'Undefined Class'; 
    }
    die();
}



add_action('wp_ajax_nopriv_getQuanHuyen', 'getQuanHuyen');
add_action('wp_ajax_getQuanHuyen', 'getQuanHuyen');
function getQuanHuyen(){
    $parentID = $_POST['mid'];

    $cat  = get_terms('dia-diem',array(
        'orderby'=> 'id',
        'order'=> 'ASC',
        'parent' => $parentID,
        'hide_empty' => 0
    ));
    if($cat){
        $option =  "<option value='-1'>Chọn Quận/Huyện</option>";
        foreach ($cat as $tax) {
            $option .=  "<option value='{$tax->term_id}'>{$tax->name}</option>";
        }
        echo $option;
    }
    
    die();
}

add_action('wp_ajax_nopriv_getSearchQuanHuyen', 'getSearchQuanHuyen');
add_action('wp_ajax_getSearchQuanHuyen', 'getSearchQuanHuyen');
function getSearchQuanHuyen(){
    $parentID = $_POST['mid'];

    $cat  = get_terms('dia-diem',array(
        'orderby'=> 'id',
        'order'=> 'ASC',
        'parent' => $parentID,
        'hide_empty' => 0
    ));
    if($cat){
       
        foreach ($cat as $list) {
            $option .=  "<li><a class='s-value-query' data-close='list-qh' data-value='".$list->term_id."' data-we='s_quanhuyen' href='javascript:;' title='".$list->name."'>".$list->name."</a></li>";
        }
        echo $option;
    }
    
    die();
}



add_action('wp_ajax_nopriv_checkExistEmail', 'checkExistEmail');
add_action('wp_ajax_checkExistEmail', 'checkExistEmail');
function checkExistEmail(){
    $email = $_POST['value'];
    if( email_exists($email)) {
        echo '0';
    }
    echo '1';
    die();
}


add_action('wp_ajax_nopriv_checkExistUsername', 'checkExistUsername');
add_action('wp_ajax_checkExistUsername', 'checkExistUsername');
function checkExistUsername(){
    $username = $_POST['value'];
    if( username_exists($username)) {
        echo '0';
    }
    echo '1';
    die();
}

add_action('wp_ajax_nopriv_loadRealGallery', 'loadRealGallery');
add_action('wp_ajax_loadRealGallery', 'loadRealGallery');
function loadRealGallery() {
     //var_dump($post_id);
     $attachIDs = $_POST['attachIDs'];
     
     if (!$attachIDs)
          echo "Không có hình ảnh";
     else {
            $arrAttach = explode(',', $attachIDs);
            //var_dump($arrAttach);die();
            foreach ($arrAttach as $attachID) {
                //var_dump($attachID);
                $url = wp_get_attachment_url($attachID);
                //var_dump($url);
             
               ?>

               <div class="c-30 pull-left" id="del-<?php echo $attachID; ?>">
                    <div class="thumbnail">
                         <img width="80" src="<?php echo $url; ?>">
                         <input class="hidden inserted-file" name="real_attachment[]" type="hidden" value="<?= $attachID; ?>">
                         <a href="javascript:void(0)" onclick="remove_attachment(<?= $attachID; ?>)" class="fa fa-remove fa-2x" id=""></a>
                    </div>
               </div>

               <?php
               //$link = the_attachment_link($attachment->ID, false);
               // echo $link;
               //apply_filters('the_title', $attachment->post_title);
          }
     }

     //var_dump($attachments);

     exit();
}

add_action('wp_ajax_nopriv_loadQuanHuyenByTP', 'loadQuanHuyenByTP');
add_action('wp_ajax_loadQuanHuyenByTP', 'loadQuanHuyenByTP');
function loadQuanHuyenByTP(){
    $tpID = wp_strip_all_tags($_POST['tpID']);
    $qhID = wp_strip_all_tags($_POST['qhID']);

    $cat  = get_terms('dia-diem',array(
        'orderby'=> 'id',
        'order'=> 'ASC',
        'parent' => $tpID,
        'hide_empty' => 0
    ));

    //var_dump($cat);die();
    if($cat){
        $option =  "<option value='-1'>Chọn Quận/Huyện</option>";
        foreach ($cat as $tax) {

            if($tax->term_id ==  $qhID){
                $selected = 'selected';
            }
            $option .=  "<option {$selected} value='{$tax->term_id}'>{$tax->name}</option>";
        }
        echo $option;
    }
    
    die();
}

add_action('wp_ajax_nopriv_setStatusReal', 'setStatusReal');
add_action('wp_ajax_setStatusReal', 'setStatusReal');
function setStatusReal(){


    $bid = wp_strip_all_tags($_POST['bid']);
    $status = wp_strip_all_tags($_POST['status']);
    // Check if user have rule
    $Real = new KBBDS();
    $clsCustomer = new KBRealCustomer(); 
    $curentUser = wp_get_current_user();

    if(!is_admin()){
      $infoUser = $clsCustomer->getCustomerByID( $currentUser->user_email ); 
      if(!$Real->checkExistRealUser($infoUser->id,$bid)){
        die();
      }
    }


    $queryStatus = 'pending';
    if($status == 'pending'){
      $queryStatus = 'approved';
    }
    
    if($Real->setStatus($bid,$queryStatus)){
        $text = 'Chưa duyệt';
        if($queryStatus == 'approved'){
          $text = 'Đã duyệt';
        }
        $data = array('sClass' => $queryStatus, 'rText'=>$text);
        echo json_encode($data);
    }
    die();
}

add_action('wp_ajax_nopriv_delReal', 'delReal');
add_action('wp_ajax_delReal', 'delReal');
function delReal(){
    $bid = wp_strip_all_tags($_POST['bid']);
   
    // Check if user have rule
    $Real = new KBBDS();
    $clsCustomer = new KBRealCustomer(); 
    $curentUser = wp_get_current_user();
    $infoUser = $clsCustomer->getCustomerByID( $currentUser->user_email ); 
    if(!$Real->checkExistRealUser($infoUser->id,$bid)){
      die();
    }

    if($Real->delReal($bid)){
      echo 'true';
    }
    die();

}


add_action('wp_ajax_nopriv_getSearchBDS', 'getSearchBDS');
add_action('wp_ajax_getSearchBDS', 'getSearchBDS');
function getSearchBDS(){
    $dmSeach = wp_strip_all_tags($_POST['dmSeach']);
    $tinhTp = wp_strip_all_tags($_POST['tinhTp']);
    $quanHuyen = wp_strip_all_tags($_POST['quanHuyen']);
    $loaiBDS = wp_strip_all_tags($_POST['loaiBDS']);
    $sdientich = wp_strip_all_tags($_POST['sdientich']);
    $sgia = wp_strip_all_tags($_POST['sgia']);

    // Check if user have rule
    $Real = new KBBDS();

    if($data = $Real->searchReal($dmSeach,$tinhTp,$quanHuyen,$loaiBDS,$sgia,$sdientich)){
      ?>
      <h2>Kết quả tìm thấy</h2>
       <ul class="list-real-no-img">
          <?php
            if($data){
              foreach ($data as $value) {
              
                $thumb = getRealThumbnailUrl($value->bds_image);  
                $term = get_term($value->loai_bds, 'loai-bat-dong-san');
                $termdiadiem = get_term($value->tinhtp, 'dia-diem');
                $termloai = get_term($value->loai_bds, 'loai-bat-dong-san');
                ?>
                  
                <li class="clearfix">
                  <a href="<?php echo get_term_link($termdiadiem);?>">
                    <strong><i class="fa fa-hand-o-right"></i> <?php echo $termdiadiem->name;?></strong>
                    <span>( <?php echo $termloai->name?> )</span>
                  </a>
                  <a title="<?php echo $value->bds_name?>" href="<?php echo getRealLink(sanitize_title($value->bds_name),$value->bds_id)?>">
                    <?php echo $value->bds_name?>
                  </a>
                  <span class="price">
                    Giá: ( <?php echo $value->price ?> )
                  </span>
                </li>
                <?php
              }
            }//end 
          ?>

        </ul> 
        <?php
    }else{
      echo '<h2>Không tìm thấy!</h2>';
    }
    die();

}

