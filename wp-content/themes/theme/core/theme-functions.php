<?php
require_once('aq_resizer.php');

function format_price($price){
    $returnPrice = '0';

    //echo strlen($price).'-';
    if (strlen($price) >= 4){
        $returnPrice = substr("$price",0,-3).' tỷ';
    }else{
        $returnPrice = $price.' tr';
    }

    return $returnPrice;
}


function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
        return "1";
    }
    return $count . '';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function getThumbnailUrl($postID) {
     $imgID = get_post_thumbnail_id($postID); // lấy id của hình
     $arrImages = wp_get_attachment_image_src($imgID, false, false); // lấy link hình featured
     return $arrImages[0]; // 0: link hình ; 1: width ; 2: height
}

function resizeThumnail($postID,$width,$height,$class,$alt) {
    $src =  getThumbnailUrl($postID);
    $image = aq_resize( $src, $width,$height, true );
    echo '<img class="lazy '.$class.'" src="'.$image.'" width="'.$width.'" height="'.$height.'"  alt="' . $alt . '" />';
}

function getRealThumbnailUrl($strRealID, $limit = "1"){
    $arrAttach = explode(',', $strRealID);
   
    if($limit == "1"){
        return wp_get_attachment_url($arrAttach[0]);
    }
    $arrImg = array();
    foreach ($arrAttach as $attachID) {
        $url = wp_get_attachment_url($attachID);
        array_push($arrImg, $url );
    }
    return $arrImg;
}

function resizeRealThumnail($url,$width,$height,$class,$alt) {
    $image = aq_resize( $url, $width,$height, true );
    echo '<img class="lazy '.$class.'" src="'.$image.'" width="'.$width.'" height="'.$height.'"  alt="' . $alt . '" />';
}


function showSocial($url){
    ?>
    <div class="fb-like" data-href="<?php echo $url;?>" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
    <!-- Đặt thẻ này vào nơi bạn muốn Nút +1 kết xuất. -->
    <div class="g-plusone" data-annotation="none"></div>

    <a class="twitter-share-button"
      href="https://twitter.com/share">
    Tweet
    </a>

    <?php

}

function getRealLink($slug,$realID){
    return home_url()."/bat-dong-san/{$slug}/{$realID}";
}

function customer_order(){
    global $wpdb;

    $arr_result = array();
    $cus_email = $_POST['cus_email'];
    if( email_exists($cus_email)) {
        $arr_result['type'] = 'error';
        $arr_result['message'] = 'Email đã được đăng ký. Vui lòng nhập email khác';
        echo json_encode($arr_result);
        die();
    }

    $cus_name = $_POST['cus_name'];
    $cus_phone = $_POST['cus_phone'];
    
    $cus_note = $_POST['cus_note'];
    $cus_total = $_POST['cus_total'];
    $cus_cmnn = $_POST['cus_cmnn'];
    $cus_address = $_POST['cus_address'];
    $order_date = date('Y-m-d H:s:i');
    $p_id = $_POST['p_id'];

    $price = get_post_meta($p_id ,'kb_price',true);
    $instrument = get_post_meta($post->ID,'instrument',true);
    $duration = get_post_meta($post->ID,'kb_duration',true);
    $start = get_post_meta($post->ID,'flignt_start',true);
    $hotel = get_post_meta($post->ID,'hotel',true);
    $link = get_permalink($p_id);

    $current_user = wp_get_current_user();

    if($current_user->user_email && $current_user->user_email != ''){
        $cus_email = $current_user->user_email;
    }
    else{
        /*
        $user_id = wp_create_user($cus_name,$cus_phone,$cus_email);
        add_user_meta($user_id,'user_address',$cus_address);
        add_user_meta($user_id,'user_cmnn',$cus_cmnn);
        // update user role using wordpress function
        wp_update_user( array ('ID' => $user_id, 'role' => '' ) ) ;
        */
    }
    $mark = (float)get_option('tour_percent') / 100 * (int)$price;
    $meta_data_insert =  array( 
        'customer_note' => $cus_note,
        'order_date' => $order_date,  
        'tour_id' => $p_id,
        'customer_email' => $cus_email,  
        'customer_name' => $cus_name,
        'customer_cmnn' => $cus_cmnn,
        'customer_phone' => $cus_phone,
        'customer_address' => $cus_address,
        'order_status' => 0 ,
        'order_total' =>  (int)$price,
        'order_percent' => get_option('tour_percent'),
        'order_mark' => $mark,
        'service' => 'tour'
    );
    

    $wpdb->insert($wpdb->prefix.'order',$meta_data_insert);
    //echo $wpdb->last_query;die();

    $email = get_bloginfo('admin_email');
    $email_subject = "[" . get_bloginfo('name') . "] ";

    $email_message = "<h1>Order Tour Name: ".get_the_title($p_id).'</h1> ';
    $email_message .= '<a href="'.$link.'"> Xem tour được đặt </a>';
    $email_message .= "<h2>Order Tour detail</h2>";
    $email_message .= "<p>Customer Name:".$cus_name."</p>";
    $email_message .= "<p>Customer Phone:".$cus_phone."</p>";
    $email_message .= "<p>Customer Email:".$cus_email."</p>";
    $email_message .= "<p>Message:".$cus_note."</p>";

    //$email_message .= "<p><strong style='color:red;'>Price:".get_post_meta($p_id ,'kb_dis_price',true)."</strong></p>";

    //var_dump($email);
    //var_dump($email_subject);
    //var_dump($email_message);

    $headers = "From: " . $cus_name . " <" . $cus_email . ">\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";
    if(wp_mail($email, $email_subject, $email_message, $headers))
    {
        $arr_result['type'] = 'success';
        $arr_result['message'] = 'Đặt tour thành công,Cám ơn Quý khách !';
    }
    else
    {
        $arr_result['type'] = 'error';
        $arr_result['message'] = 'Có lỗi xảy ra.';
    }
    echo json_encode($arr_result);
    die();
}
add_action('wp_ajax_nopriv_customer_order', 'customer_order');
add_action('wp_ajax_customer_order', 'customer_order');



add_filter( 'posts_where', 'title_like_posts_where', 10, 2 );
function title_like_posts_where( $where, &$wp_query ) {
    global $wpdb;
    if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $post_title_like . '%\'';
    }
    return $where;
}

// Usage:
// get_id_by_slug('any-page-slug');
 
function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

function getNhanHieu(){
    $parentID = $_POST['mid'];
    
    $cat_product  = get_terms('cat-product',array(
        'orderby'=> 'id',
        'order'=> 'ASC',
        'parent' => $parentID,
        'hide_empty' => 0
    ));

    $option =  "<option value='-1'>Chọn nhãn hiệu</option>";
    foreach ($cat_product as $tax) {
        $option .=  "<option value='{$tax->term_id}'>{$tax->name}</option>";
    }
    echo $option;
    die();
}
add_action('wp_ajax_nopriv_getNhanHieu', 'getNhanHieu');
add_action('wp_ajax_getNhanHieu', 'getNhanHieu');


function getSKUProduct(){
    $parentID = $_POST['mid'];
   
    $loop_ma = new WP_Query(
        array(
            'post_type' =>'product',
            'tax-query'=> array(
                    array(
                            'taxonomy' => 'cat-product',
                            'field'    => 'id',
                            'terms'    => $parentID,
                        )
                )
         ));
    $option =  "<option value='-1'>Chọn Mã sản phẩm</option>";
    while ( $loop_ma->have_posts()) {
        # code...
        global $post;
        $loop_ma->the_post();

        $ma = get_post_meta($post->ID,'product_sku',true);
        $option .= "<option value='{$ma}'>{$ma}</option>";
    }
    echo $option;
    die();
}
add_action('wp_ajax_nopriv_getSKUProduct', 'getSKUProduct');
add_action('wp_ajax_getSKUProduct', 'getSKUProduct');

add_action('init','redirect_login_page');  
function redirect_login_page() {  
    $login_page  = home_url( '/?page_id=47' );  
    $page_viewed = basename($_SERVER['REQUEST_URI']);  
  
    if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {  
        wp_redirect($page_viewed);  
        exit;  
    }  
}  



add_action( 'wp_login_failed', 'login_failed' );  
function login_failed() {  
    $login_page  = home_url( '/?page_id=47' );  
    wp_redirect( $login_page . '&login=failed' );  
    exit;  
}  


add_filter( 'authenticate', 'verify_username_password', 1, 3);   
function verify_username_password( $user, $username, $password ) {  
    $login_page  = home_url( '/?page_id=47' );  
    if( $username == "" || $password == "" ) {  
        wp_redirect( $login_page . "&login=empty" );  
        exit;  
    }  
}  
