<section id="overview" class="page-main bg-white col-sm-12">
	<form action="" id="add-brand-details" class="file-upload clearfix row-sm-12">	
	<div class="row row-sm-12 equal-cols relative-wrapper">
		<div class="brand-steps col-xl-11 center-block">
			<div class="col-md-3 col-sm-6 brand-step brand-steps-success" id="brandStep1">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 1</h3>
					<h4 class="text-xs-center">Add Brand</h4>
					<div class="brand-logo">
						<?php
						$image_path = img_url().'default_brand.png';
						if(file_exists(upload_path().'brands/'.$brand[0]->id.'.png'))
						{
							$image_path = upload_url().'brands/'.$brand[0]->id.'.png';
						}
						?>
						<img src="<?php echo $image_path ?>" alt="<?php echo $brand[0]->name; ?>" class="circle-img center-block">
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
			<div class="col-md-3 col-sm-6 brand-step" id="brandStep2">
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
			<div class="col-md-3 col-sm-6 brand-step" id="brandStep3">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 3</h3>
					<h4 class="text-xs-center">Users &amp; Permissions</h4>
					<div class="user-permissions-list">
						<div class="clearfix">
							<div class="pull-sm-right">
								<div class="table-header">
									<div class="permission">Create</div>
								</div>
								<div class="table-header">
									<div class="permission">Edit</div>
								</div>
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
							</div>
						</div>
						<div class="table">
							<div class="table-cell">
								<div class="pull-sm-left"><img src="<?php echo img_url(); ?>fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
								<div class="pull-sm-left post-approver-name"><strong>Norel Mancuso</strong>Master Admin</div>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
						</div>
						<div class="table">
							<div class="table-cell">
								<div class="pull-sm-left"><img src="<?php echo img_url(); ?>fpo/david.jpg" width="36" height="36" alt="David Weinberg" class="circle-img"/></div>
								<div class="pull-sm-left post-approver-name"><strong>David Weinberg</strong>Manager</div>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
						</div>
						<div class="table">
							<div class="table-cell">
								<div class="pull-sm-left"><img src="<?php echo img_url(); ?>fpo/kristin.jpg" width="36" height="36" alt="David Weinberg" class="circle-img"/></div>
								<div class="pull-sm-left post-approver-name"><strong>Kristin Patrick</strong>Approver</div>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
						</div>
						<div class="table border-bottom border-black">
							<div class="table-cell">
								<div class="pull-sm-left"><img src="<?php echo img_url(); ?>fpo/johan.jpg" width="36" height="36" alt="David Weinberg" class="circle-img"/></div>
								<div class="pull-sm-left post-approver-name"><strong>Johan Loekito</strong>Creator</div>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
								<i class="fa fa-check"></i>
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
							<div class="table-cell text-xs-center vertical-middle has-permission">
							</div>
						</div>
					</div>					
					<footer class="post-content-footer">						
					</footer>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 brand-step" id="brandStep4">
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
									<li class="tag" data-value="<?php echo $tag->name; ?>" data-group="brand-tag" data-tag="<?php echo $tag->name; ?>"><i class="fa fa-circle tag-<?php echo $tag->color; ?>"></i><?php echo $tag->name; ?>
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
		<div id="addBrandSuccess" class="brand-success-btn" align="center"><a href="<?php echo base_url().'brands/dashboard/'.$brand[0]->id; ?>" class="btn btn-secondary btn-sm" tabindex="0" data-content="CONGRATULATIONS!<br><br>You’ve just added your first brand. Go to the brand dashboard to create your first post, view calendar, and more.">Go to Brand Dashboard</a></div>
	</div>
	</form>
</section>