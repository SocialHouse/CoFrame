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
			<img class="circle-img pull-sm-left" width="36"  height="36" src="<?php echo $path; ?>"  alt="<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>">
			<div class="author-meta pull-sm-left">
				<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>
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
?>
