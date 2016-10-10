<form method="post" action="<?php echo base_url().'approvals/save_post_tags'; ?>" >
	<input type="hidden" name="post_id" value="<?php echo $post[0]->id; ?>">
	<input type="hidden" name="brand_id" value="<?php echo $post[0]->brand_id; ?>">
	<div class="timeframe-list tag-list list-block clearfix">
		<ul>
			<?php
			if(!empty($tags)){
				$count = 1;
				foreach ($tags as $key => $obj) {
					$class = '';				
					$is_check = '';
					if(!empty($selected_tags))
					{
						if(in_array($obj->id,$selected_tags))
						{
							$class = 'selected';
							$is_check = 'checked="checked"';
						}
					}
					?>
					<li class="post_tags tag <?php echo $class; ?>" data-value="<?php echo $obj->id; ?>" data-group="post-tag[]">
						<i class="tf-icon-circle" data-tag="<?php echo $obj->id ?>" style="background-color:<?php echo $obj->color; ?>"><input type="checkbox" class="hidden-xs-up" name="post_tag[]" value="<?php echo $obj->id; ?>" <?php echo $is_check; ?>></i><span class="tag-title"><?php echo $obj->tag_name; ?></span>
					</li>
					<?php				
					$count++;
				}
				echo '<li class="post_tags tag" data-value="check-all" data-group="post-tag[]">
				<i class="tf-icon-circle tag-custom" style="background-color:#000"></i><span class="tag-title">All</span>
			</li>';
			}
			?>
			
		</ul>
		<div class="overlay-footer border-gray-lighter">
		<button class="btn btn-secondary btn-sm btn-block">Save Tags</button>
		</div>
	</div>
</form>