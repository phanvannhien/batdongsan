<?php
	/* Template Name: Register Page */
?>
<?php get_header();?>
<?php

	$captcha_instance = new ReallySimpleCaptcha();
	$captcha_instance->bg = array( 255, 255, 255 );

	if(is_user_logged_in()){
	    wp_redirect(home_url());
	 }
	//define class real customer
	
	if(!class_exists(KBRealCustomer)){
		wp_redirect( home_url() ); exit;
	}else{
		$clsCustomer = new KBRealCustomer();
	}
	
?>
<div id="main-content" class="clearfix">
	<div id="register-page" class="clearfix">
		<div id="left-re" class="c40 pull-left">
			<h3>Là thành viên <?php bloginfo('name') ?> bạn có thể</h3>
			<ul>
				<li class="clearfix">
					<i class="fa fa-check-square fa-4x color-green pull-left"></i>
					<span>Quản lý tin đăng</span>
				</li>

				<li class="clearfix">
					<i class="fa fa-check-square fa-4x color-green pull-left"></i>
					<span>Xem toàn bộ bảng giá các dự án</span>
				</li>

				<li class="clearfix">
					<i class="fa fa-check-square fa-4x color-green pull-left"></i> 
					<span>Nhận thông tin newsletter hàng tuần</span>
				</li>

				<li class="clearfix">
					<i class="fa fa-check-square fa-4x color-green pull-left"></i> 
					<span>Nhận thông tin khuyến mãi</span>
				</li>
			</ul>

		</div>

		<div id="right-re" class="c60 pull-left">
			<h3>Đăng kí ngay</h3>	
			<p>Bạn đã có tài khoản <a href="/dang-nhap">Đăng nhập</a></p>
			<?php
				if(isset($_POST['submitReg'])){

					

					$arrCustomerInsert = array(

						'fullname' => $_POST['full_name'], 
						'username' => $_POST['user_name'], 
						'password' => $_POST['password'], 
						'email' => $_POST['email'], 
						'phone' => $_POST['phone'], 

					);
					//var_dump($arrCustomerInsert);
					if($clsCustomer->insertCustomer($arrCustomerInsert)){
						//insert to user wordpress
						$userdata = array(
						    'user_login'  => $_POST['user_name'],
						    'user_email' => $_POST['email'],
						    'display_name' => $_POST['full_name'],
						    'user_pass'   => $_POST['password'] // When creating an user, `user_pass` is expected.
						);

						$user_id = wp_insert_user( $userdata ) ;	

						$word = $captcha_instance->generate_random_word();
		                $prefix = mt_rand();
		                $img =  $captcha_instance->generate_image( $prefix, $word );

						//echo '<p class="alert alert-success">Đăng kí thành công! <a href="/?p=47">Đăng nhập</a></p>'; 
						wp_redirect('/?p=47&res=1');

					}
					else{
						echo '<p class="alert alert-danger">Đăng kí không thành công!</p>';  
					}
				}
				
			?>
			<form id="frm-register" action="" class="frm-default" method="post">
				<p>
					<label for="full-name">Họ tên: *</label>
					<input id="full-name" type="text" name="full_name">
				</p>
				<p>
					<label for="user-name">Tên đăng nhập: *</label>
					<input id="user-name" type="text" name="user_name">
				</p>
				<p>
					<label for="pass">Mật khẩu: *</label>
					<input id="pass" type="password" name="password">
				</p>
				<p>
					<label for="re-pass">Nhập lại mật khẩu: *</label>
					<input id="re-pass" type="password" name="re_password">
				</p>
				<p>
					<label for="c-email">Email: *</label>
					<input id="c-email" type="email" name="email">
				</p>
				<p>
					<label for="phone">Di động: *</label>
					<input id="phone" type="tel" name="phone">
				</p>
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
					<input type="submit" name="submitReg" value="Đăng kí tài khoản" class="btn" >
				</p>
			</form>
		</div>

	</div>
	<!-- #register-page -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			
			jQuery("form#frm-register").validate({
	            rules: {
	                full_name: "required",
	                user_name: {
	                    required:true,
	                    validateExistUsername:true
	                },
	                password: {
	                    required:true,
	                    minlength: 6
	                },
	                re_password: {
	                    required:true,
	                    equalTo: "#pass"
	                 },

	                email: {
	                    required:true,
	                    email: true,
	                    validateExistEmail:true
	                }, 
	                
	                phone: {
	                	required:true,
	                    number: true
	                }, 
	                captcha: {
	                    validate_captcha:true,
	                }
	            },
	            messages: {
	                full_name: "Vui lòng nhập họ tên",
	                user_name: {
	                    required: "Nhập tên đăng nhập",
	                },
	                password: {
	                    required: "Nhập mật khẩu",
	                    minlength:"Mật khẩu ít nhất 6 kí tự"
	                },
	                re_password: {
	                    required: "Nhập lặp lại mật khẩu ",
	                    equalTo: "Mật khẩu chưa khớp",
	                },
	                email: {
	                    required: "Nhập email ",
	                    email: "Email chưa đúng",
	                },
	                phone: {
	                    required: "Nhập số điện thoại",
	                    number: "Số điện thoại phải là dạng số",
	                },
	                captcha: {
	                    validate_captcha:"Mã xác nhận chưa đúng",
	                }

	            },
	            submitHandler: function(form) {
	               
	                form.submit(function(ev){
	                	console.log(form.email);
	                	ev.preventDefault();
	                	ev.unbind(); //unbind. to stop multiple form submit.
	                });

	            }

	        });
		});
	</script>
</div>
<!-- #main-content -->
</div>
<!-- end wrapper main-->
<?php get_footer();?>