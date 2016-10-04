<?php echo form_open(base_url().'posts/save_post',array('method'=>'post','enctype' => 'multipart/form-data')); ?>

	<h2>Add user for: <?php echo $brand_name; ?></h2>
	<input type="hidden" name="brand_id" class="form-control" value="<?php echo $brand_id; ?>">
    <div class="form-group">
    	<?php
    	if(!empty($outlets))
    	{
	    	foreach($outlets as $outlet)
	    	{
	    		?>
		    	<label class="checkbox-inline">
		      		<input type="checkbox" name="outlets[]" value="<?php echo $outlet->id; ?>" <?php echo set_checkbox('outlets',$outlet->id); ?>><?php echo $outlet->outlet_name; ?>
				</label>
		    	<?php
		    }
		}
	    ?>
	   	<?php echo form_error('outlets[]', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="post_copy">Post copy</label>
		<textarea id="post_copy" class="form-control" name="post_copy"><?php echo set_value('post_copy'); ?></textarea>
		<?php echo form_error('post_copy', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="title">Upload photo`s or video</label>
		<input type="file" id="media_files" name="media_files[]" value="" multiple accept="image/*,video/*">
    </div>

    <div class="row">
    	<div class="col-sm-12">
    		<label for="date_time">Slate post</label>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group"> 
	    		<label for="date">Date</label>
	    		<input type="text" id="date" name="date" class="form-control" value="<?php echo set_value('date') ?>">
	    		<?php echo form_error('date', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	    		<label for="time">Time</label>
		    	<input type="text" id="time" name="time" class="form-control" value="<?php echo set_value('time') ?>">
		    	<?php echo form_error('time', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	    <div class="col-sm-6">
	    	<div class="form-group">
	    		<label for="date_time">Tag(s)</label>
		    	<select name="tags[]" id="tags" class="form-control" multiple>		    		
				    <?php
				    if(!empty($tags))
    				{
					    foreach($tags as $tag)
					    {
					    	?>
					    	<option value="<?php echo $tag->id ?>" <?php echo set_select('tags', $tag->id); ?>>  <?php echo $tag->name; ?></option>
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
	    		?>
		    	<label class="checkbox-inline">
		      		<input type="checkbox" name="users[]" value="<?php echo $user->aauth_user_id; ?>" <?php echo set_checkbox('users',$user->aauth_user_id); ?>><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
				</label>					
		    	<?php

		    }
		}
	    echo form_error('users[]', '<div class="text-danger">', '</div>'); 
	    ?>
   		
	</div>	    
    

    <button type="submit" class="btn btn-primary">Save post</button>    

<?php echo form_close(); ?>