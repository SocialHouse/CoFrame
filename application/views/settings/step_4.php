<div class="container-brand-step">
	<h4 class="text-xs-center">
		<button type="button" class="btn btn-sm btn-default edit-brands-info" data-step-no="4">Manage Tags</button>
	</h4>
	<div class="tag-list saved-items" >
		<ul>
			<?php 
			if(!empty($selected_tags))
			{
				foreach ($selected_tags as $st_tag) 
				{
					?>
					<li class="tag" data-value="<?php echo $st_tag->tag_name; ?>" data-group="brand-tag" data-tag="<?php echo $st_tag->tag_name; ?>">
						<i class="fa fa-circle" style="color:<?php echo $st_tag->color; ?>">
						</i><?php echo $st_tag->tag_name; ?></li>
					<?php
				}				
			}
			
			?>
		</ul>
	</div>
	<footer class="post-content-footer">
		<div class="text-xs-center">
			<button type="button" class="btn btn-sm btn-default edit-brands-info" data-step-no="4">Manage Tags</button>
		</div>
	</footer>
</div>