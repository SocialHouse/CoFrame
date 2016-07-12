<div class="container-brand-step">
	<h4 class="text-xs-center">
		<button type="button" class="btn btn-sm btn-default edit-brands-info" data-step-no="1" >Edit Brand Info</button>
	</h4>
	<div class="brand-logo text-xs-center">
		<?php
		$image_path = img_url().'default_brand.png';
		$image_class = 'center-block';
		if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand_id.'/'.$brand_id.'.png'))
		{
			$image_path = upload_url().$brand->created_by.'/brands/'.$brand_id.'/'.$brand_id.'.png';
			$image_class = 'circle-img center-block';
		}
		?> 
		<img src="<?php echo $image_path ?>" alt="" class="<?php echo $image_class; ?>">
	</div>
	<div class="saved-items">
		<ul class="text-xs-center">
			<li class="brand-title"><?=$brand->name?></li>
			<li><span class="brand-time"><?php echo $timezone; ?></span></li>
		</ul>
	</div>
	<footer class="post-content-footer">
		<div class="text-xs-center">
		<button type="button" class="btn btn-sm btn-default edit-brands-info" data-step-no="1" >Edit Brand Info</button>
		</div>
	</footer>
</div>