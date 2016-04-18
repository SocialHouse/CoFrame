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
	
	<?php
    if(!empty($phases))
	{
	 	foreach($phases as $key=>$phase)
	 	{	 		
			?>	   
		    <div class="col-md-12 well">
		    	<div class="col-md-12 phase_num_div">
			    	<label for="date_time">Phase <?php echo $key; ?></label><br/>
			    	<?php			    	
				    	foreach($phase as $user)
				    	{
				    		?>
					    	<label class="checkbox-inline"><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?></label>					
					    	<?php

					    }
					?>
				</div>
			    <div class="col-md-12">
		    		<label for="date_time">Approve by</label>
			    </div>
			    <div class="col-md-12">
			    	<div class="row">
					    <div class="col-md-3">
					    	<div class="form-group"> 
					    		<label for="date">Month</label>
					    		<select  name="approve_month[a]" class="form-control" readonly>
					    			<?php
					    			for($i = 1;$i<=12;$i++)
					    			{
					    				$selected = '';
					    				if(date('m',strtotime($phase[0]->approve_by)) == $i)
					    				{
					    					$selected = 'selected="selected"';
					    				}

					    				?>
					    				<option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					    				<?php
					    			}
					    			?>
					    		</select>   		
					    	</div>
					    </div>
					    <div class="col-md-3">
					    	<div class="form-group"> 
					    		<label for="date">Day</label>			    		
					    		<select  name="approve_day[a]" class="form-control" readonly>
					    			<?php
					    			for($i = 1;$i<=31;$i++)
					    			{
					    				$selected = '';
					    				if(date('d',strtotime($phase[0]->approve_by)) == $i)
					    				{
					    					$selected = 'selected="selected"';
					    				}
					    				?>
					    				<option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					    				<?php
					    			}
					    			?>
					    		</select> 	    		
					    	</div>
					    </div>
					    <div class="col-md-3">
					    	<div class="form-group"> 
					    		<label for="date">Year</label>
					    		<select  name="approve_year[a]" class="form-control" readonly>
					    			<?php
					    			for($i = date('Y');$i<=date('Y') +10;$i++)
					    			{
					    				$selected = '';
					    				if(date('Y',strtotime($phase[0]->approve_by)) == $i)
					    				{
					    					$selected = 'selected="selected"';
					    				}
					    				?>
					    				?>
					    				<option <?php echo $selected; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					    				<?php
					    			}
					    			?>	
					    		</select>		    		
					    	</div>
					    </div>
					    <div class="col-md-3">
					    	<div class="form-group">
					    		<label for="approve_time">Time</label>
						    	<input type="text" id="approve_time" name="approve_time[a]" class="form-control time" value="<?php echo date('h:i A',strtotime($phase[0]->approve_by)); ?>" readonly>
					    	</div>
					    </div>
				    </div>
			    </div>
			    <div class="col-md-12">
					<label for="time">Note to approvers(optional)</label>
					<textarea name="note[a]" class="form-control" readonly><?php echo $phase[0]->note; ?></textarea>
				</div>
			</div>
			<?php
		}
	}
	?>  


    <button type="submit" class="btn btn-primary">Save post</button>    

<?php echo form_close(); ?>