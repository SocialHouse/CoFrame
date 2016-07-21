<?php
//echo '<pre>'; print_r($replies);echo '</pre>';
foreach ($replies as $key => $replay)
{
	if($replay) {
		$disabled = '';
		if($replay->status == 'accepted' or $replay->status == 'rejected')
		{
			$disabled = 'disabled="disabled"';
		}
		?>
		<ul class="commentReply timeframe-list replay">
			<li>
				<div class="author clearfix">
					<?php
					$path = img_url()."default_profile.jpg";
					if (file_exists(upload_path().$brand->created_by.'/users/'.$replay->user_id.'.png'))
					{
						$path = upload_url().$brand->created_by.'/users/'.$replay->user_id.'.png';
					}
					?>
					<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($replay->first_name).' '.ucfirst($replay->last_name); ?>	" class="circle-img pull-sm-left">

					<div class="author-meta pull-sm-left">
						<?php echo ucfirst($replay->first_name).' '.ucfirst($replay->last_name); ?>	
						<span class="dateline"><?php echo date('m/d/Y' , strtotime($replay->created_at));; ?></span>
					</div>
				</div>	
				<div class="comment">
					<p><?php echo $replay->comment; ?></p>
					<?php
					if(!empty($replay->media))
					{
						?>
						<div class="comment-asset">
							<a href="<?php echo upload_url().$brand->created_by.'/brands/'.$brand->id.'/requests/'.$replay->media ?>" title="Download Asset">
								<i class="tf-icon-download"></i>
								<img src="<?php echo upload_url().$brand->created_by.'/brands/'.$brand->id.'/requests/'.$replay->media ?>" width="60" height="60" alt=""/>
							</a>
						</div>
						<?php
					}

					if(!empty($replay->replies))
					{
						$data['replies'] =$replay->replies;
						$data['phase_id'] = $phase_id;
						$this->load->view('approvals/comment_view_request' , $data);
					}
					?>

				</div>														
			</li>
		</ul>
		<?php
	}
	if(empty($replay->replies))
	{
		?>
		<div class="comment-btns">
			<button <?php echo $disabled; ?> class="btn btn-default btn-xs change-status" type="button" data-status="accepted" data-id="<?php echo $replay->id; ?>">Accept</button>
			<button <?php echo $disabled; ?> class="btn btn-default btn-xs change-status" type="button" data-status="rejected" data-id="<?php echo $replay->id; ?>">Reject</button>
			<a data-show="#commentReply<?php echo $replay->id; ?>" class="reply-link show-hide" href="#">Reply</a>
		</div>
		<ul id="commentReply<?php echo $replay->id; ?>" class="commentReply timeframe-list hidden replay">
			<li>
				<?php
				$path = img_url()."default_profile.jpg";						
				if (file_exists(upload_path().$brand->created_by.'/users/'.$this->user_id.'.png'))
				{
					$path = upload_url().$brand->created_by.'/users/'.$this->user_id.'.png';
				}
				?>
				<div class="author clearfix">
					<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']); ?>" class="circle-img pull-sm-left">
					<div class="author-meta pull-sm-left">
						<?php
						echo ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']);
						?>
						<span class="dateline">Reply to request</span>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="phase_id<?php echo $replay->id; ?>" value="<?php echo $phase_id; ?>" />
					<textarea class="form-control reply-comment" name="comment<?php echo $replay->id; ?>" rows="2" placeholder="Suggest an edit here..."></textarea>
				</div>
				<div class="form-group clearfix">
					<div class="attachment pull-sm-left">
						<input type="file" name="attachment<?php echo $replay->id; ?>" class="hidden reply-attach">
						<button title="Add Attachment" class="btn-icon add-attachment"><i class="fa fa-paperclip"></i></button>
						<img src="" class="hide" height="25" width="25">
					</div>
					<div class="pull-sm-right">
						<button type="button" data-comment-id="<?php echo $replay->id; ?>" class="btn btn-default btn-sm reset-comment">Clear</button>
						<button type="button" data-comment-id="<?php echo $replay->id; ?>" class="btn btn-disabled btn-sm save-reply" disabled="disabled">Submit</button>
					</div>
				</div>
			</li>
		</ul>
		<?php
	}
}
