<?php 

foreach ($replies as $key => $obj) {
	?>
	<ul class="commentReply timeframe-list replay">
		<li>
			<div class="author clearfix">
				<?php
				$path = img_url()."default_profile.jpg";
				if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$obj->user_id.'.png'))
				{
					$path = upload_url().$this->user_data['img_folder'].'/users/'.$obj->user_id.'.png';
				}
				?>
				<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($obj->first_name).' '.ucfirst($obj->last_name); ?>	" class="circle-img pull-sm-left">

				<div class="author-meta pull-sm-left">
					<?php echo ucfirst($obj->first_name).' '.ucfirst($obj->last_name); ?>	
					<span class="dateline">
						<?php echo relative_date(strtotime($obj->created_at)); ?>
					</span>
				</div>
			</div>
			<?php 
				$cmt_cls = '';
				if(!empty($obj->replies)){
					$cmt_cls = ' will-reply';
				}
			?>	
			<div class="comment <?php echo $cmt_cls; ?>">
				<p><?php echo $obj->comment; ?></p>
				<?php
				if(!empty($obj->media))
				{
					?>
					<div class="comment-asset">
						<a  target="_blank" href="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$obj->media ?>" title="Download Asset">
							<i class="tf-icon-download"></i>
							<img src="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$obj->media ?>" width="60" height="60" alt=""/>
						</a>
					</div>
					<?php
				}
				?>
				<?php 
				if($obj->user_id != $this->user_id)
				{
					?>
					<div class="comment-btns">
						<a href="#" class="reply-link show-hide-replay" data-show="#commentReply_<?php echo $obj->id; ?>">Reply</a>
					</div>
					<?php 
				}
				?>
				<?php
				if(!empty($obj->replies)){
					$data['replies'] = $obj->replies;
					$this->load->view('approvals/comment_edit_request',$data );
				}
				?>
			</div>
		</li>
	</ul>
	<?php
}
?>
