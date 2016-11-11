<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-10">
				<h3 class="panel-title">
					Brand details					
				</h3>
			</div>		
			<div class="col-sm-2">
				<a href="<?php echo base_url('accounts/brands/'.$brand[0]->account_id); ?>" class="btn btn-primary pull-right">Back</a>
			</div>
		</div>
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="col-sm-3">
					<div class="form-group">						
						<div class="col-sm-3">&nbsp;</div>
						<div><h3>Brand info</h3></div>
					</div>
					<?php
					$image_path = img_url().'default_brand.png';
					$image_class = 'center-block';
					if(file_exists(upload_path().$brand[0]->account_id.'/brands/'.$brand[0]->id.'/'.$brand[0]->id.'.png'))
					{
						$image_path = upload_url().$brand[0]->account_id.'/brands/'.$brand[0]->id.'/'.$brand[0]->id.'.png';
						$image_class = 'center-block circle-img';
					}
					?>

					<img src="<?php echo $image_path ?>" alt="<?php echo $brand[0]->name; ?>" class="<?php echo $image_class; ?>">
					<br>

					<div class="form-group">
						<label class="control-label col-sm-4" >Brand name:</label>
						<div class="col-sm-8">
							<?php echo $brand[0]->name; ?>							
						</div>
					</div><br><br>

					<div class="form-group">
						<label class="control-label col-sm-4" >Timezone</label>
						<div class="col-sm-8">
							<?php echo get_time_zone($brand[0]->timezone); ?>
						</div>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<div class="col-sm-3">&nbsp;</div>
						<div class="col-sm-7"><h3>Outlets</h3></div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Outlet</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($outlets))
							{
								foreach($outlets as $outlet)
								{
									?>
									<tr>
										<td><?php echo $outlet->outlet_name; ?></td>
									</tr>
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td>No data available</td>
								</tr>
								<?php
							}
							?>
						</tbody>				
					</table>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<div class="col-sm-3">&nbsp;</div>
						<div class="col-sm-7"><h3>Users</h3></div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($brands_user))
							{
								foreach($brands_user as $user)
								{
									?>
									<tr>
										<td><?php echo get_users_full_name($user->aauth_user_id); ?></td>
										<td><?php echo get_user_groups($user->aauth_user_id,$brand[0]->id); ?></td>
									</tr>
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="2">No data available</td>
								</tr>
								<?php
							}
							?>
						</tbody>				
					</table>
				</div>

				<div class="col-sm-3">					
					<div class="form-group">
						<div class="col-sm-3">&nbsp;</div>
						<div class="col-sm-7"><h3>Tags</h3></div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Tag</th>
								<th>Label</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($brand_tags))
							{
								foreach($brand_tags as $tag)
								{
									?>
									<tr>
										<td><i class="fa fa-circle" style="color:<?php echo $tag->color; ?>"></i></td>
										<td><?php echo $tag->name; ?></td>
									</tr>
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="2">No data available</td>
								</tr>
								<?php
							}
							?>
						</tbody>				
					</table>
				</div>
			</div>
		</div>
	</div>
</div>