<div class="container-archive">
	<h2 class="text-xs-center">Tags</h2>
	<div class="tag-list timeframe-list">
		<ul>
			<?php 
				if(!empty($selected_tags))
				{
					foreach ($selected_tags as $obj => $tag) 
					{
						$tag_name = strtolower($tag->tag_name);
						?>
						<li class="tag filter" data-value="<?php echo $tag_name; ?>" data-group="post-tag">
							<div class="pull-sm-left">
								<input type="checkbox" class="hidden-xs-up" name="post-tag[]" value="<?php echo $tag->id; ?>">
								<i class="tf-icon check-box circle-border has-archive" data-group="post-tag" data-value="<?php echo $tag->id; ?>" >
								<i class="fa fa-check"></i></i>
							</div>
							<i class="fa fa-circle" style="color:<?php echo $tag->color; ?>" ></i><span class="tag-title"><?php echo strtoupper($tag->name); ?></span>
						</li>						
						<?php
					}
				}
			?>
			<li class="tag filter" data-value="check-all" data-group="post-tag">
				<div class="pull-sm-left">
					<i class="tf-icon check-box circle-border has-archive" data-value="check-all" data-group="post-tag"><i class="fa fa-check"></i></i>
				</div>
				<i class="fa fa-circle tag-custom" style="color: #000; border-color: #000"></i>
				<span class="tag-title">All</span>
			</li>
		</ul>
	</div>
</div>
