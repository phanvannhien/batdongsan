<?php
	/* Template Name: Login Page*/
?>
<?php get_header();?>
<div id="main-content" class="clearfix">
	<div id="login-container">
    <p class="text-center">Bạn chưa có tài khoản? <a href="<?php echo home_url().'/dang-ky'?>"><i class="fa fa-key fa-lg"></i> Đăng ký</a></p>
		<div id="login-error">
			<?php
				//check if user is login
				if(is_user_logged_in()){
					wp_redirect(home_url());
				}

				if(isset($_GET['login'])){
					$login  = (isset($_GET['login']) ) ? $_GET['login'] : 'failed';  
					if ( $login == "failed" ) {  
					    echo '<p class="alert alert-danger"><strong>Lỗi:</strong> Tên đăng nhập hoặc mật khẩu không đúng</p>';  
					} elseif ( $login == "empty" ) {  
					    echo '<p class="alert alert-danger"><strong>Lỗi:</strong> Tên đăng nhập hoặc mật khẩu rỗng.</p>';  
					} elseif ( $login == "false" ) {  
					    echo '<p class="alert alert-danger"><strong>Lỗi:</strong> Bạn đã đăng xuất.</p>';  
					}  
				}

				if(isset($_GET['res']) == '1'){
					 echo '<p class="alert alert-success">Bạn đã đăng kí thành công. Đăng nhập tại đây.</p>';  
				}
				
			?>
		</div>
		<div id="login-form">
			<?php  

      $redirectUrl = ($_GET['url'])? $_GET['url'] : home_url();

			$args = array(  
			    'redirect' => $redirectUrl,   
			    'id_username' => 'user',  
			    'id_password' => 'pass',  
			   )   
			;?>  
			<?php wp_login_form( $args ); ?>  
		</div>

	</div>

</div>
</div>
<!-- end wrapper main-->
<?php get_footer()?>
<script>
	jQuery(document).ready(function(){
		jQuery("form#loginform").validate({
	            rules: {
	                log: "required",
	                pwd: {
	                    required:true,
	                    minlength: 6
	                },               
	            },
	            messages: {
	                log: "Nhập tên đăng nhập",
	                pwd: {
	                    required: "Nhập mật khẩu",
	                    minlength:"Tối thiểu 6 kí tự"
	                },
	                

	            },
	            submitHandler: function(form) {
	                form.submit();

	            }
	        });
	});

</script>

<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
  
    	cookie     : true,  // enable cookies to allow the server to access 
		appId      : '1030012203691140',
		xfbml      : true,
		version    : 'v2.2'
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=id,name,events,activities.limit(2){name},likes', function(response) {
      console.log(JSON.stringify(response));
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + JSON.stringify(response) + '!';
    });
  }
</script>