<?php
if(!empty($brands))
{
	?>
	<ul class="brand-list timeframe-list">
		<?php
		foreach($brands as $brand)
		{
			$image_path = img_url().'default_brand.png';
			if(file_exists(upload_path().'brands/'.$brand->id))
			{
				$image_path = upload_url().'brands/'.$brand->id;
			}
			?>
			<li><a href="<?php echo base_url().'brands/dashboard/'.$brand->id; ?>"><img src="<?php echo $image_path; ?>" alt="<?php echo $brand->name; ?>" class="circle-img" /><?php echo $brand->name; ?></a></li>	
			<?php
		}
		?>		
	</ul>
	<?php
}
