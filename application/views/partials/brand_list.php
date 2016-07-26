<?php
if(!empty($brands))
{
	?>
	<ul class="brand-list timeframe-list">
		<?php
		foreach($brands as $brand)
		{			
			$image_path = img_url().'default_brand.png';
			if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
			{
				$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';
			}
			
			?>
			<li><a href="<?php echo base_url().'brands/dashboard/'.$brand->slug; ?>"><img src="<?php echo $image_path; ?>" alt="<?php echo $brand->name; ?>" class="circle-img" /><?php echo $brand->name; ?></a></li>	
			<?php
		}
		?>		
	</ul>
	<?php
}
