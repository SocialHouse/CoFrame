<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Edit Post</h1>
	</header>
	<div class="bg-white col-sm-12 content-shadow brand-main">
		<div class="content-shadow brand-header row">
			<div class="col-sm-12">
				<?php
				$image_path = img_url().'default_brand.png';				
				if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
				{
					$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';					
				}									
				?>
				<img src="<?php echo $image_path; ?>" class="circle-img pull-xs-left" height="75" width="75"> <?php echo $brand->name; 
				?>
			</div>
		</div>
		<form>
			<ul class="timeframe-list full-width-list edit-post">
				<li data-toggle="modal" data-target="#changeOutletModal">
					<div class="outlet-list pull-xs-left">
						<i class="fa fa-<?php echo strtolower($post_details->outlet_name); ?>" title="<?php echo strtolower($post_details->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($post_details->outlet_name); ?>"></span></i><?php echo ucfirst($post_details->outlet_name); ?>
					</div>
					<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
				</li>
				<li>
					<a href="#postDateField" class="target-hidden"><?php echo date('l, m/d/y \a\t h:i A',strtotime($post_details->slate_date_time)); ?> PST</a>
					<input type="datetime-local" id="postDateField" class="invisible pos-absolute" name="postDate">
				</li>
				<li>
				<span contenteditable="true" id="postContentEditable" class="content-editable" data-input="#postContent">
				<?php 
				$title = '';
				if(!empty($post_details->tumblr_content_type))
				{
					if($post_details->tumblr_content_type == 'Photo')
					{
						$title = $post_details->tumblr_caption;
					}
					else if($post_details->tumblr_content_type == 'Text')
					{
						$title = $post_details->tumblr_title;
					}
					else if($post_details->tumblr_content_type == 'Quote')
					{
						$title = $post_details->tumblr_quote;
					}
					else if($approval->tumblr_content_type == 'Link')
					{
						$title = $post_details->tumblr_custom_url;
					}
					else if($post_details->tumblr_content_type == 'Chat')
					{
						$title = $post_details->tumblr_chat_title;
					}
					else if($post_details->tumblr_content_type == 'Video')
					{
						$title = $post_details->tumblr_video_caption;
					}
				}
				else
					$title = strip_tags($post_details->content);

				echo $title;
				?>
				
				<textarea id="postContent" class="hidden"><?php echo $title; ?></textarea>
				</li>
				<li>
				<div class="form-group" id="mediaUpload">
					<div class="form__input has-files clearfix">						
						<?php 
						if(!empty($post_images))
						{
							$class = 1;
							foreach ($post_images as $key) 
							{
								if($key->type =='images')
								{
									echo '<div class="form__preview-wrapper"><i data-delete-id="'.$key->id.'" class="tf-icon-circle remove-upload">x</i><img src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'" class="form__file-preview delete-img" data-delete="'.$class.'" /></div>';
									$class++;
								}
								else if($key->type =='video'){
									echo '<video class="form__file-preview"src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'"></video>';
								}										
                            }                           
						}	
						echo '<label class="file-upload-label" id="postFileLabel" for="postFile"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>';
						?>

						<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple>						
					</div>
				</div>
				</li>
				<li data-toggle="modal-ajax" data-modal-src="<?php echo base_url().'approvals/get_brand_tags/'.$post_details->id; ?>" data-class="full-page-modal" data-title="Edit Tags" data-clear="no" data-modal-id="modal-post-tags">
					<div class="post-tags pull-xs-left">
						<?php
						if(!empty($selected_tags))
						{
							$style = ' style="display: none;" ';
							foreach ($selected_tags as $stag) 
							{
								?>
								<i class="tf-icon-circle" style="background-color:<?php echo $stag['tag_color']; ?>"></i>							
								<?php
							}
						}
						?>
					</div>
					Tags						
					<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
				</li>
				<?php
				if(!empty($phases))
				{
					?>
					<li data-toggle="modal-ajax" data-modal-src="<?php echo base_url().'approvals/view_approvals/'.$post_details->id; ?>" data-class="full-page-modal" data-title="Mandatory Approvals" data-clear="no" data-modal-id="modal-approvals">
						View Mandatory Approvals
						<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
					</li>
					<?php
				}
				?>
			</ul>
		</form>
	</div>
</section>

<!-- Blank Modal -->
<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
	  </div>
	</div>
  </div>
</div>

<!-- Change Outlet Modal -->
<div class="modal alert-modal fade" id="changeOutletModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content bg-white">
			<div class="modal-header">
				<h1 class="text-xs-center">Change Outlet</h2>
			</div>
			<div class="modal-body">
				<p class="text-xs-center">Some of the post details such as multiple photos may not be compatible with certain outlets.</p>
			</div>
			<div class="modal-footer">
				<div class="btn-group" role="group">
				  <button type="button" class="btn btn-sm btn-default modal-hide col-xs-6">Cancel</button>
				  <button type="button" class="btn btn-sm btn-default col-xs-6" data-toggle="modal-ajax" data-modal-src="<?php echo base_url().'approvals/get_outlet_list/'.$post_details->id; ?>" data-class="full-page-modal" data-title="Change Outlet" data-clear="no" data-modal-id="modal-post-outlet">Continue</button>
				</div>
			</div>
		</div>
	</div>
</div>
