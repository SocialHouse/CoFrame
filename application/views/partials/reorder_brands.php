<?php
if(!empty($brands))
{
	?>
	<ul class="reorder-brand-list timeframe-list">
		<?php
		foreach($brands as $brand)
		{
			$image_path = img_url().'default_brand.png';
			if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
			{
				$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';
			}
			?>
			<li class="ui-state-default" data-brand="<?php echo $brand->order; ?>" data-brand_id="<?php echo $brand->id; ?>">
				<img src="<?php echo $image_path; ?>" alt="<?php echo $brand->name; ?>" class="circle-img"/><?php echo $brand->name; ?><i class="fa fa-bars pull-sm-right"></i>
			</li>
			<?php
		}
		?>
	</ul>
<?php
}
