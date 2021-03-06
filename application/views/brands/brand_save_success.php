<section id="overview" class="page-main bg-white col-xs-12">
	<form action="" class="file-upload clearfix row-sm-12">	
	<div class="row row-sm-12 equal-columns relative-wrapper">
		<div class="brand-steps col-xl-11 center-block">
			<div class="col-xs-3 brand-step equal-height brand-steps-success" id="brandStep1">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 1</h3>
					<h4 class="text-xs-center">Add Brand</h4>
					<div class="brand-logo">

						<?php
						$image_path = img_url().'default_brand.png';
						$image_class = 'center-block';
						if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand[0]->id.'/'.$brand[0]->id.'.png'))
						{
							$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand[0]->id.'/'.$brand[0]->id.'.png';
							$image_class = 'center-block circle-img';
						}
						?>

						<img src="<?php echo $image_path ?>" alt="<?php echo $brand[0]->name; ?>" class="<?php echo $image_class; ?>">
					</div>
					<div class="saved-items">
						<ul class="text-xs-center">
							<li class="brand-title"><?php echo $brand[0]->name; ?></li>
							<li><span class="brand-time"><?php echo get_time_zone($brand[0]->timezone); ?></span></li>
						</ul>
					</div>					
					<footer class="post-content-footer">						
					</footer>
				</div>
			</div>
			<div class="col-xs-3 equal-height brand-step" id="brandStep2">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 2</h3>
					<h4 class="text-xs-center">Brand Outlets</h4>
					<div class="outlet-list saved-items">
						<?php
						if(!empty($outlets))
						{
							?>
							<ul>
								<?php
								foreach($outlets as $outlet)
								{
									?>
									<li data-outlet="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i><?php echo strtolower($outlet->outlet_name); ?></li>
									<?php
								}
								?>								
								<?php
								?>
							</ul>
							<?php
						}
						?>						
					</div>					
					<footer class="post-content-footer">						
					</footer>
				</div>
			</div>
			<div class="col-xs-3 equal-height brand-step" id="brandStep3">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 3</h3>
					<h4 class="text-xs-center">Users &amp; Permissions</h4>
					<div class="user-permissions-list">
						<div class="clearfix">
							<div class="pull-xs-right">
								<div class="table-header">
									<div class="permission">Create</div>
								</div>
								<!-- <div class="table-header">
									<div class="permission">Edit</div>
								</div> -->
								<div class="table-header">
									<div class="permission">Approve</div>
								</div>
								<div class="table-header">
									<div class="permission">View Content</div>
								</div>
								<div class="table-header">
									<div class="permission">Brand Settings</div>
								</div>
								<div class="table-header">
									<div class="permission">Billing</div>
								</div>
								<div class="table-header">
								<div class="permission">Master</div>
							</div>
							</div>
						</div>
						<?php
						if(!empty($brands_user))
						{
							$num_users = count($brands_user);
							$u = 1;
							foreach($brands_user as $user)
							{
								$image_path = img_url().'default_profile.jpg';
								if(file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$user->aauth_user_id.'.png'))
								{
									$image_path = upload_url().$this->user_data['img_folder'].'/users/'.$user->aauth_user_id.'.png';
								}
								?>
								<div class="table<?php if($num_users == $u) {echo ' border-bottom border-black';} ?>">
									<div class="table-cell">
										<div class="pull-xs-left"><img src="<?php echo $image_path; ?>" width="36" height="36" alt="<?php ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>" class="circle-img"/></div>
										<div class="pull-xs-left post-approver-name"><strong><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?></strong><?php echo get_user_groups($user->aauth_user_id,$brand[0]->id); ?></div>
									</div>
									<div class="table-cell text-xs-center vertical-middle has-permission">
										<?php
										if(check_user_perm($user->aauth_user_id,'create.',$brand[0]->id))
										{
											?>
											<i class="fa fa-check"></i>
											<?php
										}
										?>											
									</div>
								<!-- 	<div class="table-cell text-xs-center vertical-middle has-permission">
										<?php
										if(check_user_perm($user->aauth_user_id,'edit',$brand[0]->id))
										{
											?>
											<i class="fa fa-check"></i>
											<?php
										}
										?>
									</div> -->
									<div class="table-cell text-xs-center vertical-middle has-permission">
										<?php
										if(check_user_perm($user->aauth_user_id,'approve',$brand[0]->id))
										{
											?>
											<i class="fa fa-check"></i>
											<?php
										}
										?>
									</div>
									<div class="table-cell text-xs-center vertical-middle has-permission">
										<?php
										if(check_user_perm($user->aauth_user_id,'view',$brand[0]->id))
										{
											?>
											<i class="fa fa-check"></i>
											<?php
										}
										?>
									</div>
									<div class="table-cell text-xs-center vertical-middle has-permission">
										<?php
										if(check_user_perm($user->aauth_user_id,'settings',$brand[0]->id))
										{
											?>
											<i class="fa fa-check"></i>
											<?php
										}
										?>
									</div>
									<div class="table-cell text-xs-center vertical-middle has-permission">
										<?php
										if(check_user_perm($user->aauth_user_id,'billing',$brand[0]->id))
										{
											?>
											<i class="fa fa-check"></i>
											<?php
										}
										?>
									</div>
									<div class="table-cell text-xs-center vertical-middle has-permission">
										<?php 
											if (check_user_perm($user->aauth_user_id,"master",$brand[0]->id)) {
												?> 
												<i class="fa fa-check"></i>
												<?php
											}
										?> 
									</div> 
								</div>
								<?php
								$u++;
							}
						}
						?>
					</div>					
					<footer class="post-content-footer">						
					</footer>
				</div>
			</div>
			<div class="col-xs-3 equal-height brand-step" id="brandStep4">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 4</h3>
					<h4 class="text-xs-center">Post Tags<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h4>
					<div class="tag-list saved-items">
						<?php
						if(!empty($brand_tags))
						{
							?>
							<ul>
								<?php
								foreach($brand_tags as $tag)
								{
									?>
									<li class="tag" data-value="<?php echo $tag->name; ?>" data-group="brand-tag" data-tag="<?php echo $tag->name; ?>"><i class="fa fa-circle" style="color:<?php echo $tag->color; ?>;"></i><?php echo $tag->name; ?>
									</li>
									<?php
								}
								?>								
							</ul>
							<?php
						}
						?>
						
					</div>
					<div class="add-brand-details brand-fields border-bottom border-black hidden">
						<div id="selectedTags" class="tag-list selected-items hidden">
							<ul>
							</ul>
						</div>
						<a href="#brandOutlets" id="addTagLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addTagLink, #outletStep4Btns, #selectedTags" data-show="#selectBrandTags, #addTagBtns"><i class="tf-icon circle-border">+</i>Add Tag</a>
						<div id="selectBrandTags" class="hidden">
							<h5 class="text-xs-center border-bottom border-black ">Add a Tag</h5>
							<h5 class="border-title"><span>Select Tag Color</span></h5>
							<div class="tag-list">
								<ul>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="red"><i class="fa fa-circle tag-red"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="pink"><i class="fa fa-circle tag-pink"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="orange"><i class="fa fa-circle tag-orange"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="yellow"><i class="fa fa-circle tag-yellow"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="green"><i class="fa fa-circle tag-green"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="green-dark"><i class="fa fa-circle tag-green-dark"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="blue"><i class="fa fa-circle tag-blue"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="blue-dark"><i class="fa fa-circle tag-blue-dark"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="purple-dark"><i class="fa fa-circle tag-purple-dark"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="purple"><i class="fa fa-circle tag-purple"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="brown"><i class="fa fa-circle tag-brown"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="tan"><i class="fa fa-circle tag-tan"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="gray"><i class="fa fa-circle tag-gray"></i></li>
									<li class="tag hidden custom-tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="custom"><i class="fa fa-circle tag-custom"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><a href="#" id="chooseTagColor"><i class="tf-icon circle-border">+</i></a></li>
								</ul>
							</div>
							<div class="form-group">
								<select class="form-control" name="tagLabel" id="tagLabel">
									<option value="">Select Label</option>
									<option value="Marketing">Marketing</option>
									<option value="E-Commerce">E-Commerce</option>
									<option value="Sales">Sales</option>
									<option value="Promotion">Promotion</option>
									<option value="other">+ Add Label</option>
								</select>
							</div>
							<div class="form-group hidden" id="otherTagLabel">
								<input type="text" class="form-control" name="otherTagLabel">
							</div>
						</div>
					</div>
					<footer class="post-content-footer">						
					</footer>
				</div>
			</div>
		</div>
		<?php if ($isFirstBrand === TRUE): ?>
			<div id="addBrandSuccess" class="brand-success-btn" align="center"><a href="<?php echo base_url().'brands/dashboard/'.$brand[0]->slug; ?>" class="btn btn-secondary btn-sm" tabindex="0" data-content="Click here to head to the brand dashboard where you can create your first post, view the calendar and more.">Go to Brand Dashboard</a></div>
		<?php else: ?>
			<div id="addBrandSuccess" class="brand-success-btn" align="center"><a href="<?php echo base_url().'brands/dashboard/'.$brand[0]->slug; ?>" class="btn btn-secondary btn-sm" tabindex="0" data-content="">Go to Brand Dashboard</a></div>
		<?php endif; ?>
	</div>
	</form>
</section>