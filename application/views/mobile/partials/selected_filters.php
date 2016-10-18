<form method="post" id="filter-form-remove">
	<input type="hidden" name="statuses" id="statuses_ids" value="<?php echo isset($post_data['statuses']) ? $post_data['statuses'] : ''; ?>">
	<input type="hidden" name="tags" id="tags_ids" value="<?php echo isset($post_data['tags']) ? $post_data['tags'] : ''; ?>">
	<input type="hidden" name="outlets" id="outlets_ids" value="<?php echo isset($post_data['outlets']) ? $post_data['outlets'] : ''; ?>">

	<div id="selectedFilters" class="<?php echo !empty($post_data) ? '' : 'hidden'; ?>" style="">
		<ul class="filter-list tag-list clearfix">
			<?php
			if(!empty($post_data))
			{
				if(!empty($post_data['outlets']))
				{
					$outlet_ids = explode(',',$post_data['outlets']);
					foreach($outlet_ids as $id)
					{
						$outlet_name = strtolower(get_outlet_by_id($id));
						?>
						<li data-id="<?php echo $id; ?>" data-value="f-<?php echo $outlet_name; ?>" class="filter-remove outlet-list">
							<i class="fa fa-<?php echo $outlet_name; ?>">
								<span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span>
							</i>
						<i class="tf-icon-close"></i></li>
						<?php
					}
				}
				if(!empty($post_data['statuses']))
				{
					$statuses = explode(',',$post_data['statuses']);
					foreach($statuses as $status)
					{							
						?>
						<li class="filter-remove" data-status="<?php echo $status ?>" data-value="<?php echo $status; ?>" >
							<?php echo $status; ?>
							<i class="tf-icon-close"></i>
						</li>
						<?php
					}
				}

				if(!empty($post_data['tags']))
				{
					$tags = explode(',',$post_data['tags']);						
					foreach($tags as $tag)
					{
						$tag_data = get_tag_data($tag);

						if(!empty($tag_data))
						{
							?>
							<li data-value="<?php echo $tag_data[0]->name; ?>" class="filter-remove">
								<i style="color:<?php echo $tag_data[0]->color; ?>" class="fa fa-circle tag-test"></i>
								<span class="tag-title"><?php echo $tag_data[0]->name; ?></span>
								<i class="tf-icon-close"></i>
							</li>
							<?php
						}
					}
				}
			}
			?>
		</ul>
	</div>
</form>