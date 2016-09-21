<?php 

foreach ($replies as $key => $obj) {
	?>
	<ul class="commentReply timeframe-list replay">
		<li class="comment-section">
			<div class="author clearfix">
				<?php
				$path = img_url()."default_profile.jpg";
				if (file_exists(upload_path().$obj->img_folder.'/users/'.$obj->user_id.'.png'))
				{
					$path = upload_url().$obj->img_folder.'/users/'.$obj->user_id.'.png';
				}
				?>
				<img class="circle-img pull-sm-left" src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($obj->first_name).' '.ucfirst($obj->last_name); ?>" >

				<div class="author-meta pull-sm-left">
					<?php 
					echo ucfirst($obj->first_name).' '.ucfirst($obj->last_name);
					if($obj->user_id == $this->user_id)
					{
						?>
						<a data-id="<?php echo $obj->id; ?>" class="pull-right delete-suggest" href="javascript:;">
						<i class="fa fa-trash-o"></i>
						</a>
						<a data-id="<?php echo $obj->id; ?>" class="pull-right edit-suggest" href="javascript:;"><i class="fa fa-pencil"></i></a>
						<?php
					}
					?>	
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
				<div class="comment_view<?php echo $obj->id; ?>">
					<p class="text"><?php echo $obj->comment; ?></p>
					<?php
					if(!empty($obj->media))
					{
						?>
						<div class="comment-asset">
							<a download="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$obj->media; ?>" href="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$obj->media; ?>" title="Download Asset">
								<i class="tf-icon-download"></i>
								<img  width="60" height="60" alt="" src="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$obj->media ?>"/>
							</a>
						</div>
						<?php
					}
					?>		
				</div>
				<div class="hide edit_suggest_form<?php echo $obj->id; ?> suggest-edit" data-state="hide">
					<div class="form-group">
						<input type="hidden" id="suggestId<?php echo $obj->id; ?>">
						<textarea id="comment_copy" class="form-control suggestTect<?php echo $obj->id; ?>"><?php echo $obj->comment; ?></textarea>
					</div>
					<div class="form-group clearfix">
						<div class="attachment pull-sm-left">
							<input type="file" class="hidden attachment_image" name="replay-attachment">
							<button class="btn-icon add-attachment" title="Add Attachment">
								<i class="fa fa-paperclip"></i>
							</button>
							<?php
							$media_class = 'hide';
							if(!empty($obj->media))
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
							<button data-id="<?php echo $obj->id; ?>" data-phase-id="64" class="btn btn-secondary btn-sm save-edit-req" type="button" data-parent-id="43">Submit</button>
						</div>
					</div>
				</div>

				<div class="comment-btns">
					<a href="#" class="reply-link show-hide-reply" data-show="#commentReply_<?php echo $obj->id; ?>">Reply</a>
				</div>
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
