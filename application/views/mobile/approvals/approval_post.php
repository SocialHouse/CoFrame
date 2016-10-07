<input type="hidden" value="<?php echo $this->user_id; ?>" id="user-id" />
<?php
$user_group = get_user_groups($this->user_id,$brand_id);
if(!empty($approval_list))
{
	foreach($approval_list as $approval)
	{
		$outlet_name = get_outlet_by_id($approval->outlet_id);
		?>
		<li>
			<div class="post-meta clearfix pos-relative">
				<a href="<?php echo base_url().'edit-request/'.$approval->id; ?>">
				<div class="outlet-list pull-xs-left">
					<i class="fa fa-<?php echo strtolower($outlet_name); ?>" title="<?php echo strtolower($outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet_name); ?>"></span></i>
				</div>
				<div class="post-meta-content">
					<span class="post-author"><?php echo $outlet_name; ?> Post By <?php echo get_users_full_name($this->user_id); ?>:</span>
					<span class="post-date"><?php echo date('l, m/d/y \a\t h:i A',strtotime($approval->slate_date_time)); ?> PST</span>
				</div>
				<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
				</a>
			</div>
			<div class="post-content clearfix">
				<?php
				$medias = get_post_media($approval->id);
				if(!empty($medias))
				{
					foreach ($medias as $media) 
					{
						if($media->type == 'images')
						{
							?>
							<img src="<?php echo base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$brand_id.'/posts/'. $media->name; ?>" class="pull-xs-left" width="420">
							<?php
						}
						else
						{
							?>
							<video class="pull-xs-left" width="420" src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$brand_id.'/posts/'. $media->name.'"></video>
							<?php
						}
					}
				}
				?>							
				<div class="post-body">								
					<?php 
					$title = '';
					if(!empty($approval->tumblr_content_type))
					{
						if($approval->tumblr_content_type == 'Photo')
						{
							$title = $approval->tumblr_caption;
						}
						else if($approval->tumblr_content_type == 'Text')
						{
							$title = $approval->tumblr_title;
						}
						else if($approval->tumblr_content_type == 'Quote')
						{
							$title = $approval->tumblr_quote;
						}
						else if($approval->tumblr_content_type == 'Link')
						{
							$title = $approval->tumblr_custom_url;
						}
						else if($approval->tumblr_content_type == 'Chat')
						{
							$title = $approval->tumblr_chat_title;
						}
						else if($approval->tumblr_content_type == 'Video')
						{
							$title = $approval->tumblr_video_caption;
						}
					}
					else
						$title = strip_tags($approval->content);
					?>
					<p><?php echo (!empty($title))? read_more(nl2br(strip_tags($title)), 100) :'&nbsp;';?></p>
				</div>
			</div>
			<?php
			$is_any_pending_approver = 0;
			$approvers = get_post_approvers($approval->id);
			if($approvers)
			{
				$approver_status = '';
				$phase_status = '';
				$phase_id = '';
				$deadline = '';
				$approver_count = 0;
				if(!empty($approvers['result']))
				{
					$approver_count = 0;
					$show_additional_approvers = 0;				
					$approved_status = [];
					$approver_img_shown = [];
					foreach($approvers['result'] as $approver)
					{						
						if($approver['status'] == 'approved')
						{
							array_push($approved_status, 'approved');
						}

						if($approver['user_id'] == $this->user_id AND $approver['id'] == $approval->phase_id)
						{
							$approver_status = $approver['status'];
							$phase_status = $approver['phase_status'];
							$phase_id = $approver['id'];
							$deadline = $approver['approve_by'];
						}

						if($approver['status'] == 'pending')
						{
							//it should show same user image multiple times if user is available in multiple phases
							if(!in_array($approver['user_id'],$approver_img_shown))
							{
								array_push($approver_img_shown, $approver['user_id']);
								$is_any_pending_approver = 1;								
							}
						}
					}
				}
				
			}
			?>
			<div class="post-footer clearfix">
				<span class="pull-xs-left post-actions">
					<?php
					echo get_approval_list_buttons($approval,$deadline,$phase_status,$user_group,$approver_status,$phase_id,$brand_id,$is_any_pending_approver,0);
					?>					
				</span>
				<button class="btn-icon btn-icon-lg btn-menu pull-xs-right" data-toggle="modal-ajax" data-hide="false" data-modal-src="<?php echo base_url().'calendar/get_view/edit_menu/'.get_brand_slug($post_details->brand_id).'/'.$post_details->id; ?>" data-modal-id="modal-post-menu">
					<i class="fa fa-circle-o"></i> 
					<i class="fa fa-circle-o"></i> 
					<i class="fa fa-circle-o"></i>
				</button>
			</div>
		</li>
		<?php
	}
}
else
{
	?>
	<li>
		<div class="post-meta clearfix pos-relative">
		<?php echo $this->lang->line('no_post_found'); ?>
		</div>
	</li>
	<?php
}
