<h1 class="text-xs-center">Filters</h1>
<div class="row post-filters">
	<div class="col-md-2">
		<h2 class="text-xs-center">Post Status</h2>
		<div class="form-group filter" data-status="published" data-value=".f-published" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-published">Published</label></div>
		<div class="form-group filter" data-status="approved" data-value=".f-approved" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-approved">Approved</label></div>
		<div class="form-group filter" data-status="scheduled" data-value=".f-scheduled" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-scheduled">Scheduled</label></div>
		<div class="form-group filter" data-status="pending" data-value=".f-pending" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-pending">Pending</label></div>
		<div class="form-group filter" data-status="published" data-value="check-all" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for="check-all">All</label></div>
	</div>
	<div class="col-md-4">
		<h2 class="text-xs-center">Outlets</h2>
		<div class="outlet-list">
			<ul>
				<?php
				if(!empty($outlets))
				{
					foreach($outlets as $outlet)
					{
						?>
						<li class="disabled filter" data-id="<?php echo $outlet->id; ?>" data-value="<?php echo ".f-".strtolower($outlet->outlet_name); ?>" data-group="post-outlet">
							<i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>">
								<span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span>
							</i>
						</li>
						<?php
					}
					echo '<li class="filter" data-value="check-all" data-group="post-outlet"><i class="fa"><span class="bg-outlet bg-all"></span><span class="outlet-text">All</span></i></li>';
				}
				?>				
				
			</ul>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="text-xs-center">Tags</h2>
			</div>

			<div class="col-sm-6 tag-list">
				<ul>
					<?php 
						if(!empty($tags)){
							$count = 1;
							foreach ($tags as $key => $obj) {
								?>
								<li class="tag filter" data-group="post-tag" data-value="<?php echo strtolower($obj->name); ?>"  data-tag-id="<?php echo $obj->id ?>" >
									<i class="fa fa-circle tag-<?php echo $obj->tag_name; ?>" style="color:<?php echo $obj->color ; ?>"></i>
									<span class="tag-title"><?php echo $obj->name?></span>
								</li>
								<?php
								if($count %7 == 0){
									?>
										</ul>
									</div>
									<div class="col-sm-6 tag-list">
										<ul>
									<?php
								}
								$count++;
							}
							echo '<li data-group="post-tag" data-value="check-all" class="tag filter"><i class="fa fa-circle tag-custom"></i><span class="tag-title">All</span></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<footer class="form-footer">
	<button type="button" class="btn btn-sm btn-secondary reset-filter" data-filter="*">Reset Filters</button>
	<div class="pull-sm-right">
		<button type="button" class="btn btn-sm btn-default qtip-hide">Close</button>
	</div>
</footer>