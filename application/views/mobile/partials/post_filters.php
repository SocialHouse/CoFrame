<?php
$selected_filter = [];
$selected_tags = [];
$selected_outlets = [];
$selected_statuses = [];
if(!empty($filters))
{
	$selected_filter = $filters;
	$selected_outlets = !empty($filters[0]['outlets']) ? explode(',',$filters[0]['outlets']) : [];
	$selected_tags = !empty($filters[0]['tags']) ? explode(',',$filters[0]['tags']) : [];
	$selected_statuses = !empty($filters[0]['statuses']) ? explode(',',$filters[0]['statuses']) : [];
}
?>
<div class="post-filters">
	<input type="hidden" id="filter_id" value="<?php echo !empty($filters) ? $filters[0]['id'] : ''; ?>" />
	<input type="hidden" id="filter_brand_id" value="<?php echo $brand_id; ?>" />

	<div class="row">
		<div class="col-xs-12">
			<h2 class="text-xs-center col-xs-12">Post Status</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="form-group filter <?php echo in_array('posted', $selected_statuses) ? 'checked' : ''; ?>" data-value="posted" data-group="post-status"><i class="tf-icon check-box circle-border border-black pull-xs-left"><i class="fa fa-check"></i></i> <label class="label-check-box" data-for=".f-posted">Posted</label></div>		

			<?php
			if(check_user_perm($this->user_id,'create',$brand_id) OR $this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
			{
				?>
				<div class="form-group filter <?php echo in_array('draft', $selected_statuses) ? 'checked' : ''; ?>" data-value="draft" data-group="post-status"><i class="tf-icon check-box circle-border border-black pull-xs-left"><i class="fa fa-check"></i></i> <label class="label-check-box" data-for=".f-draft">Draft</label></div>
				<?php
			}

			if(check_user_perm($this->user_id,'create',$brand_id) OR check_user_perm($this->user_id,'approve',$brand_id) OR $this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
			{
				?>
				<div class="form-group filter <?php echo in_array('scheduled', $selected_statuses) ? 'checked' : ''; ?>" data-value="scheduled" data-group="post-status"><i class="tf-icon check-box circle-border border-black pull-xs-left"><i class="fa fa-check"></i></i> <label class="label-check-box" data-for=".f-scheduled">Scheduled</label></div>
				<?php
			}
			?>
		</div>
		<div class="col-xs-6">
			<?php
			if(check_user_perm($this->user_id,'create',$brand_id) OR check_user_perm($this->user_id,'approve',$brand_id) OR $this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
			{
				?>
				<div class="form-group filter <?php echo in_array('pending', $selected_statuses) ? 'checked' : ''; ?>" data-value="pending" data-group="post-status"><i class="tf-icon check-box circle-border border-black pull-xs-left"><i class="fa fa-check"></i></i> <label class="label-check-box" data-for=".f-pending">Pending</label></div>
				<?php
			}
			?>
			<div class="form-group filter" data-value="check-all" data-group="post-status"><i class="tf-icon check-box circle-border border-black pull-xs-left"><i class="fa fa-check"></i></i> <label class="label-check-box" data-for="check-all">All</label></div>
		</div>
	</div>
</div>
<div class="post-filters">
	<div class="row">
		<div class="col-xs-12">
			<h2 class="text-xs-center">Outlets</h2>
			<div class="outlet-list">
				<ul>
					<?php				
					if(!empty($outlets))
					{					
						foreach($outlets as $outlet)
						{
							$class = 'disabled';
							if(in_array($outlet->id,$selected_outlets))
							{
								$class = 'checked';
							}
							?>
							<li class="<?php echo $class; ?> filter" data-id="<?php echo $outlet->id; ?>" data-value="<?php echo "f-".strtolower($outlet->outlet_name); ?>" data-group="post-outlet">
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
	</div>
</div>
<div class="post-filters">
	<div class="row">
		<div class="col-xs-12">
			<h2 class="text-xs-center">Tags</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 tag-list">
			<ul>
				<?php 
				if(!empty($tags)){
					$count = 1;
					foreach ($tags as $key => $obj) {
						$class = '';
						if(in_array($obj->id,$selected_tags))
						{
							$class = 'checked';
						}
						?>
						<li class="tag filter <?php echo $class; ?>" data-color="<?php echo $obj->color; ?>" data-group="post-tag" data-value="<?php echo strtolower($obj->tag_name); ?>"  data-tag-id="<?php echo $obj->id ?>" >
							<i class="fa fa-circle tag-<?php echo $obj->tag_name; ?>" style="color:<?php echo $obj->color ; ?>"></i>
							<span class="tag-title"><?php echo $obj->name; ?></span>
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
<footer class="overlay-footer">
	<button type="button" class="btn btn-xs btn-default reset-filter" data-filter="*">Reset Filters</button>
	<div class="pull-xs-right">
		<button type="button" class="btn btn-xs btn-secondary modal-hide save-filter">Apply Filters</button>
	</div>
</footer>