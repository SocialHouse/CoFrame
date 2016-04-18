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
    	<div class="col-md-12">
    		<label for="date_time">Slate post</label>
	    </div>
	    <div class="col-md-2">
	    	<div class="form-group"> 
	    		<label for="slate_date_month">Month</label>			    		
	    		<select  name="slate_date_month" class="form-control">
	    			<?php
	    			for($i = 1;$i<=12;$i++)
	    			{
	    				?>
	    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	    				<?php
	    			}
	    			?>
	    		</select> 
	    		<?php echo form_error('slate_date_month', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	     <div class="col-md-2">
	    	<div class="form-group"> 
	    		<label for="slate_date_day">Day</label>			    		
	    		<select  name="slate_date_day" class="form-control">
	    			<?php
	    			for($i = 1;$i<=31;$i++)
	    			{
	    				?>
	    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	    				<?php
	    			}
	    			?>
	    		</select>
	    		<?php echo form_error('slate_date_day', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	    <div class="col-md-2">
	    	<div class="form-group"> 
	    		<label for="slate_date_year">Year</label>
	    		<select  name="slate_date_year" class="form-control">
	    			<?php
	    			for($i = date('Y');$i<=date('Y') +10;$i++)
	    			{
	    				?>
	    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	    				<?php
	    			}
	    			?>	
	    		</select>
	    		<?php echo form_error('slate_date_day', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	    <div class="col-md-2">
	    	<div class="form-group">
	    		<label for="slate_date_time">Time</label>
		    	<input type="text" id="slate_time" name="slate_time" class="form-control time">
		    	<?php echo form_error('slate_time', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>

	   <!--  <div class="col-md-3">
	    	<div class="form-group"> 
	    		<label for="date">Date</label>
	    		<input type="text" id="date" name="date" class="form-control date" value="<?php echo set_value('date') ?>">
	    		<?php echo form_error('date', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div>
	    <div class="col-md-3">
	    	<div class="form-group">
	    		<label for="time">Time</label>
		    	<input type="text" id="time" name="time" class="form-control time" value="<?php echo set_value('time') ?>">
		    	<?php echo form_error('time', '<div class="text-danger">', '</div>'); ?>
	    	</div>
	    </div> -->
	    <div class="col-md-4">
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
    	<label class="checkbox-inline">
      		<input type="checkbox" name="load_default" class="load_default" />Load default phases
		</label>
	</div>

    <div class="row default_phases well">
    	<div class="col-md-12">
	    	<label for="date_time">Default phase</label>
	    	<?php
	    	if(!empty($default_phases))
	    	{
	    		?>
	    		<ul>
		    		<?php
		    		foreach($default_phases as $key=>$phase)
		    		{
		    			?>	    			
						<li><?php echo "Phase: ".$key; ?>
						    <ul>
							    <?php
							    foreach($phase as $user)
							    {
							    	?>
							    	<li>
					    				<?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name) ?>
					    			</li>
							    	<?php
							    }
							    ?>
						    </ul>
						</li>	    			
		    			<?php
		    		}
		    		?>
	    		</ul>
	    		<?php
	    	}
	    	?>
     		<div class="col-md-12">
	    		<label for="date_time">Approve by</label>
		    </div>
		    <div class="col-md-12">
		    	<div class="row">
				    <div class="col-md-3">
				    	<div class="form-group"> 
				    		<label for="default_phase_month">Month</label>			    		
				    		<select  name="default_phase_month" class="form-control">
				    			<?php
				    			for($i = 1;$i<=12;$i++)
				    			{
				    				?>
				    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				    				<?php
				    			}
				    			?>
				    		</select>   		
				    	</div>
				    </div>
				     <div class="col-md-3">
				    	<div class="form-group"> 
				    		<label for="default_phase_day">Day</label>			    		
				    		<select  name="default_phase_day" class="form-control">
				    			<?php
				    			for($i = 1;$i<=31;$i++)
				    			{
				    				?>
				    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				    				<?php
				    			}
				    			?>
				    		</select> 	    		
				    	</div>
				    </div>
				    <div class="col-md-3">
				    	<div class="form-group"> 
				    		<label for="default_phase_year">Year</label>
				    		<select  name="default_phase_year" class="form-control">
				    			<?php
				    			for($i = date('Y');$i<=date('Y') +10;$i++)
				    			{
				    				?>
				    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				    				<?php
				    			}
				    			?>	
				    		</select>		    		
				    	</div>
				    </div>
				    <div class="col-md-3">
				    	<div class="form-group">
				    		<label for="default_phase_time">Time</label>
					    	<input type="text" id="default_phase_time" name="default_phase_time" class="form-control time">
				    	</div>
				    </div>
			    </div>
		    </div>
		    <div class="col-md-12">
				<label for="default_note">Note to approvers(optional)</label>
				<textarea name="default_note" class="form-control"></textarea>
			</div>
		</div>

    </div>  

    <div class="row phase_div">
	    <div class="col-md-12 user_phases well">
	    	<div class="col-md-12">
		    	<label for="date_time">Approvers for phase 1</label><br/>
		    	<?php
		    	if(!empty($users))
		    	{
			    	foreach($users as $user)
			    	{
			    		?>
				    	<label class="checkbox-inline">
				      		<input type="checkbox" name="phase[users][0][]" value="<?php echo $user->aauth_user_id; ?>" <?php echo set_checkbox('users',$user->aauth_user_id); ?>><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
						</label>					
				    	<?php

				    }
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
				    		<select  name="phase[approve_month][0]" class="form-control">
				    			<?php
				    			for($i = 1;$i<=12;$i++)
				    			{
				    				?>
				    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				    				<?php
				    			}
				    			?>
				    		</select>   		
				    	</div>
				    </div>
				     <div class="col-md-3">
				    	<div class="form-group"> 
				    		<label for="date">Day</label>			    		
				    		<select  name="phase[approve_day][0]" class="form-control">
				    			<?php
				    			for($i = 1;$i<=31;$i++)
				    			{
				    				?>
				    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				    				<?php
				    			}
				    			?>
				    		</select> 	    		
				    	</div>
				    </div>
				    <div class="col-md-3">
				    	<div class="form-group"> 
				    		<label for="date">Year</label>
				    		<select  name="phase[approve_year][0]" class="form-control">
				    			<?php
				    			for($i = date('Y');$i<=date('Y') +10;$i++)
				    			{
				    				?>
				    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				    				<?php
				    			}
				    			?>	
				    		</select>		    		
				    	</div>
				    </div>
				    <div class="col-md-3">
				    	<div class="form-group">
				    		<label for="approve_time">Time</label>
					    	<input type="text" id="approve_time" name="phase[approve_time][0]" class="form-control time">
				    	</div>
				    </div>
			    </div>
		    </div>
		    <div class="col-md-12">
				<label for="time">Note to approvers(optional)</label>
				<textarea name="phase[note][0]" class="form-control"></textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 well" align="center">
			<label for="time">Approval phases(optional)</label><br/>
			<button type="button" class="btn btn-info" id="add_phases_number">Add approval phases</button>
		</div>
	</div>
	<div class="row">
	    <div class="col-md-12">
	    	<button type="submit" class="btn btn-primary">Save post</button>    
	    </div>
	</div>

    <div class="col-md-12 hide well">
    	<div class="col-md-12 phase_num_div">
	    	<label for="date_time">Approvers for phase 1</label><br/>
	    	<?php
	    	if(!empty($users))
	    	{
		    	foreach($users as $user)
		    	{
		    		?>
			    	<label class="checkbox-inline">
			      		<input type="checkbox" name="users[a][]" value="<?php echo $user->aauth_user_id; ?>" <?php echo set_checkbox('users',$user->aauth_user_id); ?>><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
					</label>					
			    	<?php

			    }
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
			    		<select  name="approve_month[a]" class="form-control">
			    			<?php
			    			for($i = 1;$i<=12;$i++)
			    			{
			    				?>
			    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			    				<?php
			    			}
			    			?>
			    		</select>   		
			    	</div>
			    </div>
			    <div class="col-md-3">
			    	<div class="form-group"> 
			    		<label for="date">Day</label>			    		
			    		<select  name="approve_day[a]" class="form-control">
			    			<?php
			    			for($i = 1;$i<=31;$i++)
			    			{
			    				?>
			    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			    				<?php
			    			}
			    			?>
			    		</select> 	    		
			    	</div>
			    </div>
			    <div class="col-md-3">
			    	<div class="form-group"> 
			    		<label for="date">Year</label>
			    		<select  name="approve_year[a]" class="form-control">
			    			<?php
			    			for($i = date('Y');$i<=date('Y') +10;$i++)
			    			{
			    				?>
			    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			    				<?php
			    			}
			    			?>	
			    		</select>		    		
			    	</div>
			    </div>
			    <div class="col-md-3">
			    	<div class="form-group">
			    		<label for="approve_time">Time</label>
				    	<input type="text" id="approve_time" name="approve_time[a]" class="form-control approve_time">
			    	</div>
			    </div>
		    </div>
	    </div>
	    <div class="col-md-12">
			<label for="time">Note to approvers(optional)</label>
			<textarea name="note[a]" class="form-control"></textarea>
		</div>
	</div>
 <?php $this->load->view('modals/approvers'); ?>

<?php echo form_close(); ?>