<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Overview</h1>
	</header>
	<?php
	if(empty($brands))
	{
		?>
		<div class="vertical-center text-xs-center col-sm-12">
			<p>You haven’t set up any brands yet. Please login to your account on a desktop computer to add a brand.</p>
			<p><a href="#" class="btn btn-default btn-sm">My Account</a>
		</div>
		<?php
	}
	else
	{		
		?>
		<div class="bg-white col-sm-12 content-shadow brand-main">
			<ul class="timeframe-list brand-list">
			<?php
			foreach($brands as $brand)
			{
				$image_path = img_url().'default_brand.png';				
				if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
				{
					$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';					
				}									
				?>
				<li><a href="<?php echo base_url().'brands/dashboard/'.$brand->slug; ?>"><img src="<?php echo $image_path; ?>" class="circle-img" height="75" width="75"><div class="vertical-center brand-title"><?php echo $brand->name; ?></div><div class="pull-xs-right"><span class="tag tag-danger tag-pill"><?php echo count_reminders($this->user_id,$brand->id); ?></span></div></a></li>
				<?php
			}
			?>
			</ul>
		</div>
		<?php
	}
	?>
</section>