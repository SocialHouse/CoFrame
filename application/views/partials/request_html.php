<?php
if(!empty($comment))
{
	$path = img_url()."default_profile.jpg";

	if (file_exists(upload_path().$brand_owner.'/users/'.$comment->user_id.'.png'))
	{
		$path = upload_url().$brand_owner.'/users/'.$comment->user_id.'.png';
	}

	?>
	<li class="comment-section">
		<div class="author clearfix">
			<img class="circle-img pull-sm-left" width="36"  height="36" src="<?php echo $path; ?>"  alt="<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>">
			<div class="author-meta pull-sm-left">
				<?php 
				echo ucfirst($comment->first_name).' '.$comment->last_name; 
				if($comment->user_id == $this->user_id AND !isset($is_mobile))
				{
					?>
					<a data-id="<?php echo $comment->id; ?>" class="pull-right delete-suggest" href="javascript:;">
					<i class="fa fa-trash-o"></i>
					</a>
					<a data-id="<?php echo $comment->id; ?>" class="pull-right edit-suggest" href="javascript:;"><i class="fa fa-pencil"></i></a>
					<?php
				}
				?>
				<span class="dateline">Now</span>
			</div>
		</div>		
		<div class="comment">
			<div class="comment_view<?php echo $comment->id; ?>">
				<p class="text"><?php echo $comment->comment; ?></p>
				<?php
				if(!empty($comment->media))
				{
					?>
					<div class="comment-asset">
						<a download="<?php echo upload_url().$brand_owner.'/brands/'.$brand_id.'/requests/'.$comment->media ?>" href="<?php echo upload_url().$brand_owner.'/brands/'.$brand_id.'/requests/'.$comment->media ?>" title="Download Asset">
							<i class="tf-icon-download"></i>
							<img src="<?php echo upload_url().$brand_owner.'/brands/'.$brand_id.'/requests/'.$comment->media ?>" width="60" height="60" alt=""/>
						</a>
					</div>
					<?php
				}
				?>				
			</div>
			<div class="hide edit_suggest_form<?php echo $comment->id; ?> suggest-edit" data-state="hide">
				<div class="form-group">
					<input type="hidden" id="suggestId<?php echo $comment->id; ?>">
					<textarea id="comment_copy" class="form-control suggestTect<?php echo $comment->id; ?>"><?php echo $comment->comment; ?></textarea>
				</div>
				<div class="form-group clearfix">
					<div class="attachment pull-sm-left">
						<input type="file" class="hidden attachment_image" name="replay-attachment">
						<button class="btn-icon add-attachment" title="Add Attachment">
							<i class="fa fa-paperclip"></i>
						</button>
						<?php
						$media_class = 'hide';
						if(!empty($comment->media))
						{
							$media_class = '';
						}
						?>
						<img width="30" height="30" class="base-64-img <?php echo $media_class; ?>">
						<a class="remove-attached-img <?php echo $media_class; ?>" href="#">
							<i class="tf-icon-circle remove-upload">x</i>
						</a>
					</div>
					<div class="pull-sm-right">			
						<button data-id="<?php echo $comment->id; ?>" data-phase-id="64" class="btn btn-secondary btn-sm save-edit-req" type="button" data-parent-id="43">Submit</button>
					</div>
				</div>
			</div>
			<div class="comment-btns">
				<a href="#" class="reply-link show-hide-reply" data-show="#commentReply_<?php echo $comment->id; ?>">Reply</a>
			</div>
		</div>
	</li>
	<?php
}
?>
