<?php
	$newRealLink = get_page_link(52);
	$managerRealLink = get_page_link(85);
?>
<div class="panel panel-default">
	<div class="panel-body">
		<p>
			<span class="pull-left">Xin chào: <?php echo $infoUser->username?> </span>
			<a class="pull-right" href="<?php echo wp_logout_url( home_url())?>"><span><i class="fa fa-sign-out fa-lg"></i> Thoát</span></a>
		
			<ul class="manager">
				<li>
					<a href="<?php echo $newRealLink; ?>"><i class="fa fa-file-o fa-lg"></i> Đăng tin</a>
				</li>
				<li>
					<a href="<?php echo $managerRealLink; ?>"><i class="fa fa-file-text-o fa-lg"></i> Quản lý tin</a>
				</li>
			</ul>
		</p>
	</div>
</div>	

