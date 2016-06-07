<section class="brand-navigation bg-white opaque-88 col-sm-2">
	<nav class="navbar navbar-light navbar-brand-manage bg-transparent">
		<?php
		$image_path = img_url().'default_brand.png';
		if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand_id.'/'.$brand_id.'.png'))
		{
			$image_path = upload_url().$brand->created_by.'/brands/'.$brand_id.'/'.$brand_id.'.png';
		}
		?>
	  	<a href="<?php echo base_url().'brands/dashboard/'.$brand_id; ?>"><img src="<?php echo $image_path ?>" width="135" height="135" class="circle-img center-block brand-img" alt=""/></a>

		<ul class="nav navbar-nav">
			<li class="nav-item">
		  		<a class="nav-link" href="<?php echo base_url().'posts/create/'.$brand->slug; ?>">Create Post</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="approvals.php">Approvals</a>
			</li>
			<li class="nav-item">
	  			<a class="nav-link" href="cocreate.php">Co-Create</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="<?php echo base_url().'calendar/day/'.$brand->slug; ?>">Calendar</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="drafts.php">Drafts</a>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-user">
			<li class="nav-item">
		  		<a class="nav-link" href="<?php echo base_url().'settings/view/'.$brand->slug; ?>">Settings</a>
			</li>
			<li class="nav-item">
	  			<a class="nav-link" href="archive.php">Archive</a>
			</li>
		</ul>
	</nav>
	<div class="current-user-details">
		<?php
		$user_permission = get_user_groups($this->user_id);
		?>
		<div class="user-name"><?php echo !empty($user_permission) ? $user_permission : 'Master Admin';?></div>
		<div class="user-time row">
			<div class="col-md-5">Current Brand Time </div>
			<div class="col-md-7 text-md-right current-time">
				<strong id="userTime"></strong><br>
				<?php echo date('a T'); ?>
			</div>
		</div>
	</div>
</section>