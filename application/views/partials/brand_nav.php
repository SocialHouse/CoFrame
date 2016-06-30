<section class="brand-navigation bg-white opaque-88 col-sm-2">
	<nav class="navbar navbar-light navbar-brand-manage bg-transparent">
		<?php
		$image_path = img_url().'default_brand.png';
		$image_class = 'center-block brand-img';
		if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand_id.'/'.$brand_id.'.png'))
		{
			$image_path = upload_url().$brand->created_by.'/brands/'.$brand_id.'/'.$brand_id.'.png';
			$image_class = 'circle-img center-block brand-img';
		}
		?>
	  	<a href="<?php echo base_url().'brands/dashboard/'.$brand->slug; ?>"><img src="<?php echo $image_path ?>" width="135" height="135" class="<?php echo $image_class; ?>" alt=""/></a>

		<ul class="nav navbar-nav">
			<li class="nav-item">
		  		<a class="nav-link" href="<?php echo base_url().'posts/create/'.$brand->slug; ?>">Create Post</a>
			</li>
			<li class="nav-item">
		  		<a data-sub_pages="request" class="nav-link" href="<?php echo base_url().'approvals/'.$brand->slug; ?>">Approvals</a>
			</li>
			<li class="nav-item">
	  			<a class="nav-link" href="<?php echo base_url().'co_create/create/'.$brand->slug; ?>">Co-Create</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="<?php echo base_url().'calendar/day/'.$brand->slug; ?>">Calendar</a>
			</li>
			<li class="nav-item">
		  		<a class="nav-link" href="<?php echo base_url().'drafts/'.$brand->slug; ?>">Drafts</a>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-user">
			<li class="nav-item">
		  		<a class="nav-link" href="<?php echo base_url().'settings/view/'.$brand->slug; ?>">Settings</a>
			</li>
			<li class="nav-item">
	  			<a class="nav-link" href="<?php echo base_url().'archives/'.$brand->slug; ?>">Archive</a>
			</li>
		</ul>
	</nav>
	<div class="current-user-details">
		<div class="user-name"><?php echo $user_group;?></div>
		<div class="user-time row">
			<div class="col-md-5">Current Brand Time </div>
			<div class="col-md-7 text-md-right current-time">
				<strong id="userTime"></strong><br>
				<span id="userTimeZone"></span>
			</div>
		</div>
	</div>
</section>