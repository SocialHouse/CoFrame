<nav class="navbar navbar-light navbar-brand-manage bg-transparent">
	<?php
	$image_path = img_url().'default_brand.png';
	if(file_exists(upload_path().'brands/'.$brand_id.'.png'))
	{
		$image_path = upload_path().'brands/'.$brand_id.'.png';
	}
	?>
  	<a href="<?php echo base_url().'brands/dashboard/'.$brand_id; ?>"><img src="<?php echo $image_path ?>" width="135" height="135" class="circle-img center-block brand-img" alt=""/></a>

	<ul class="nav navbar-nav">
		<li class="nav-item">
	  		<a class="nav-link" href="<?php echo base_url().'posts/create/'.$brand_id ?>">Create Post</a>
		</li>
		<li class="nav-item">
	  		<a class="nav-link" href="approvals.php">Approvals</a>
		</li>
		<li class="nav-item">
  			<a class="nav-link" href="cocreate.php">Co-Create</a>
		</li>
		<li class="nav-item">
	  		<a class="nav-link" href="calendar.php">Calendar</a>
		</li>
		<li class="nav-item">
	  		<a class="nav-link" href="drafts.php">Drafts</a>
		</li>
	</ul>
	<ul class="nav navbar-nav navbar-user">
		<li class="nav-item">
	  		<a class="nav-link" href="settings.php">Settings</a>
		</li>
		<li class="nav-item">
  			<a class="nav-link" href="archive.php">Archive</a>
		</li>
	</ul>
</nav>