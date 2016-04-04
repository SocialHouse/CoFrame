<?php echo form_open(base_url().'posts/update_post',array('method'=>'post','enctype' => 'multipart/form-data')); ?>
	
	<input type="hidden" name="id" class="form-control" value="<?php echo $post->id; ?>">

    <div class="form-group">
		<label for="post_copy">Post copy</label>
		<textarea id="post_copy" class="form-control" name="post_copy"><?php echo set_value('post_copy') ? set_value('post_copy') : $post->content; ?></textarea>
		<?php echo form_error('post_copy', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
    	<label for="title">Upload photo`s or video</label><br/>
    	<?php 
    		if(!empty($post_media))
    		{
    			foreach($post_media as $media)
    			{
    				if($media->type == 'video')
    				{
    					?>
    					<video width="320" height="240" controls>
						  <source src="<?php echo upload_url().'posts/'.$media->name; ?>" type="<?php echo $media->mime; ?>">
						</video>
    					<?php
    				}
    				else
    				{
    					?>
		    			<img height="50" width="40" src="<?php echo upload_url().'posts/'.$media->name;?>" />
		    			<?php
    				}
    			}    			
    		}
    	?>
		
		<input type="file" id="media_files" name="media_files[]" value="" multiple accept="image/*,video/*">
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<label for="date_time">Slate post</label>
	    </div>

	    <div class="col-md-3">
	    	<div class="form-group"> 
	    		<label for="date">Date</label>
	    		<input type="text" id="date" name="date" class="form-control" value="<?php echo set_value('date') ? set_value('date') : date('Y-m-d',strtotime($post->slate_date_time)); ?>">
	    		<?php echo form_error('date', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	    <div class="col-md-3">
	    	<div class="form-group">
	    		<label for="time">Time</label>
		    	<input type="text" id="time" name="time" class="form-control" value="<?php echo set_value('time') ? set_value('time') : date('h:i A',strtotime($post->slate_date_time)); ?>">
		    	<?php echo form_error('time', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	    <div class="col-md-6">
	    	<div class="form-group">
	    		<label for="date_time">Tag(s)</label>
		    	<select name="tags[]" id="tags" class="form-control" multiple>		    		
				    <?php
				    if(!empty($tags))
    				{
					    foreach($tags as $tag)
					    {
					    	$selected = '';
					    	if(in_array($tag->id,$selected_tags))
					    	{
					    		$selected = 'selected="selected"';
					    	}
					    	?>
					    	<option value="<?php echo $tag->id ?>" <?php echo set_select('tags', $tag->id) ? set_select('tags', $tag->id) : $selected; ; ?>>  <?php echo $tag->name; ?></option>
					    	<?php
					    }
					}
				    ?>
				</select>
	    	</div>
	    </div>
	</div>

    <div class="form-group">
    	<?php
    	if(!empty($users))
    	{
	    	foreach($users as $user)
	    	{
	    		$checked = '';
	    		if(isset($selected_approvers) AND in_array($user->aauth_user_id,$selected_approvers))
	    		{
	    			$checked = 'checked="checked"';
	    		}
	    		?>
		    	<label class="checkbox-inline">
		      		<input type="checkbox" name="users[]" value="<?php echo $user->aauth_user_id; ?>" <?php echo set_checkbox('users',$user->aauth_user_id) ? set_checkbox('users',$user->aauth_user_id): $checked; ?>><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
				</label>					
		    	<?php

		    }
		}
	    echo form_error('users[]', '<div class="text-danger">', '</div>'); 
	    ?>
   		
	</div>	    
    

    <button type="submit" class="btn btn-primary">Save post</button>    

<?php echo form_close(); ?>