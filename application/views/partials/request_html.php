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
				if($comment->user_id == $this->user_id)
				{
					?>
					<a data-id="<?php echo $comment->id; ?>" class="pull-right delete-suggest" href="javascript:;">
					<i class="fa fa-trash-o"></i>
					</a>
					<?php
				}
				?>
				<span class="dateline">Now</span>
			</div>
		</div>		
		<div class="comment">
			<p><?php echo $comment->comment; ?></p>
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
			<div class="comment-btns">
				<a href="#" class="reply-link show-hide-reply" data-show="#commentReply_<?php echo $comment->id; ?>">Reply</a>
			</div>
		</div>
	</li>
	<?php
}
?>
