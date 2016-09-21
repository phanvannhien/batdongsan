		
		<footer id="footer">
			<div id="top-footer">
	        <?php
            wp_nav_menu(
                array(
                     'theme_location' => 'footer-top-menu',
                     'container_class' => 'collapse wrapper',
                     'container_id' => 'footer-top-menu-container',
                     'menu_class' => 'clearfix',
                     'menu_id' => 'footer-top-menu',
                )
             );
          ?>
			</div>
      <!-- #top-footer -->
      <div id="main-footer" class="clearfix">
        <div class="inner-footer wrapper">
          <?php
            wp_nav_menu(
                array(
                     'theme_location' => 'footer-main-menu',
                     'container_class' => 'collapse',
                     'container_id' => 'footer-main-menu-container',
                     'menu_class' => 'clearfix',
                     'menu_id' => 'footer-main-menu',
                )
             );
          ?>
          

           <div id="main-content-f" class="clearfix">
              <div class="col-f c40 pull-left">
                <?php dynamic_sidebar('footer-info-1')?>
              </div>
              <div class="col-f c40 pull-left">
                 <?php dynamic_sidebar('footer-info-2')?>
              </div>
              <div class="col-f c20 pull-left">
                 <?php dynamic_sidebar('footer-info-3')?>
              </div>
          </div>

          <p id="copy-right">Copyright &copy; 2014 by <a href="<?php site_url()?>"><?php bloginfo('name')?></a>. Design by <a href="http://kienbien.net">kienbien</a></p>
        </div>
        <!-- .inner-footer wrapper -->

       
         
  
      </div>
      <!-- #main-footer -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

  <div class="popup">
    <span class="button b-close"><span>X</span></span>
    <div class="content">
    </div>
  </div>


	<?php wp_footer(); ?>

  <!-- Đặt thẻ này vào phần đầu hoặc ngay trước thẻ đóng phần nội dung của bạn. -->
  <script src="https://apis.google.com/js/platform.js" async defer>
    {lang: 'vi'}
  </script>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=1030012203691140&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <script type="text/javascript">
  window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
  </script>


</body>
</html>
<?php ob_flush()?>