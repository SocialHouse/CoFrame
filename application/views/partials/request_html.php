<?php
if(!empty($comment))
{
	$path = img_url()."default_profile.jpg";

	if (file_exists(upload_path().$brand_owner.'/users/'.$comment->user_id.'.png'))
	{
		$path = upload_url().$brand_owner.'/users/'.$comment->user_id.'.png';
	}
	?>
	<li>
		<div class="author clearfix">
			<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>" class="circle-img pull-sm-left">
			<div class="author-meta pull-sm-left">
				<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>
				<span class="dateline"><?php echo date('m/d/Y' , strtotime($comment->created_at));; ?></span>
			</div>
		</div>		
		<div class="comment">
			<p><?php echo $comment->comment; ?></p>
			<p><?php echo $comment->status ? 'Staus: '.$comment->status : 'Staus: '.'Pending'; ?></p>

			<?php
			if(!empty($comment->media))
			{
				?>
				<div class="comment-asset">
					<a target="_blank" href="<?php echo upload_url().$brand_owner.'/brands/'.$brand_id.'/requests/'.$comment->media ?>" title="Download Asset">
						<i class="tf-icon-download"></i>
						<img src="<?php echo upload_url().$brand_owner.'/brands/'.$brand_id.'/requests/'.$comment->media ?>" width="60" height="60" alt=""/>
					</a>
				</div>
				<?php
			}
			?>												
		</div>
	</li>
	<?php
}