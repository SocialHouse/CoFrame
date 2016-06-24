<?php
if(!empty($brands))
{
	?>
	<ul class="reorder-brand-list timeframe-list">
		<?php
		foreach($brands as $brand)
		{
			$image_path = img_url().'default_brand.png';
			if(file_exists(upload_path().'brands/'.$brand->id))
			{
				$image_path = upload_url().'brands/'.$brand->id;
			}
			?>
			<li class="ui-state-default" data-brand="<?php echo $brand->id; ?>">
				<img src="<?php echo $image_path; ?>" alt="<?php echo $brand->name; ?>" class="circle-img"/><?php echo $brand->name; ?><i class="fa fa-bars pull-sm-right"></i>
			</li>
			<?php
		}
		?>
	</ul>
<?php
}
