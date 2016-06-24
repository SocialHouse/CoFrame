<div class="tag-list">
	<?php
		if(!empty($tags))
		{
			?>
			<ul>
				<?php
				foreach($tags as $tag)
				{
					$cls = '';
					if(!empty($selected_tags)){
						foreach ($selected_tags as $stag) {
							if($stag['id'] == $tag->id){
								$cls = 'selected';
							}
						}
					}
					?>
					<li data-group="post-tag[]" data-value="<?php echo $tag->id; ?>" class="post_tags tag <?php echo $cls ; ?>">
						<i  class="fa fa-circle" data-tag="<?php echo $tag->id; ?>" style="color:<?php echo $tag->color; ?>">
							<input type="checkbox" value="<?php echo $tag->id; ?>" name="post_tag[]" class="hidden-xs-up">
						</i><span class="tag-title"><?php echo $tag->name; ?></span>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
		}
	?>	
</div>