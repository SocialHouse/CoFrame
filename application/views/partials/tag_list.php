<div class="tag-list">
	<?php
		if(!empty($tags))
		{
			?>
			<ul>
			<?php
			foreach($tags as $tag)
			{
				?>
				<li class="post_tags tag" data-value="<?php echo $tag->id; ?>" data-group="post-tag[]">
					<i class="fa fa-circle" data-tag="<?php echo $tag->id; ?>" style="color:<?php echo $tag->color ?>"><input type="checkbox" class="hidden-xs-up" name="post_tag[]" value="<?php echo $tag->id; ?>"></i><span class="tag-title"><?php echo $tag->name ?></span>
				</li>
				<?php
			}
			?>
			</ul>
			<?php
		}
	?>	
</div>