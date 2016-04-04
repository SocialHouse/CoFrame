<?php
echo form_open(base_url().'brands/save_brand',array('method'=>'post','enctype' => 'multipart/form-data'));
?>
	<h1>Add brand</h1>
    <div class="form-group">
		<label for="Username">Name</label>
		<input type="hidden" name="id" value="<?php echo set_value('id') ? set_value('id') : (isset($brand->id) ? $brand->id :''); ?>">
		<input type="text" id="name" name="name" class="form-control" placeholder="Brand name" value="<?php echo set_value('name') ? set_value('name') : (isset($brand->name) ? $brand->name :''); ?>" >
		<?php echo form_error('name', '<div class="text-danger">', '</div>'); ?>
    </div>    
  
    <div class="form-group">
	    <label for="logo">Logo</label>
	    <?php
		if((isset($brand->id) AND file_exists(upload_path().'brands/'.$brand->id.'.png')) OR (set_value('id') AND file_exists(upload_path().'brands/'.set_value('id').'.png')))
		{
			?>
			<div class="">
				<img height="70" width="50" src="<?php echo upload_url().'brands/'.(set_value('id')?set_value('id'):$brand->id).'.png'; ?>">
			</div>
			<?php
		}		
		?>
	    <input type="file" id="logo" name="logo" accept="image/*">
	</div>		
	
	<div class="form-group">
      	<label for="timezone">Timezone</label>
		<select name="timezone" id="timezone" class="form-control" >
      		<option value="">Select timezone</option>
		    <?php
		    foreach($timezones as $timezone)
		    {
		    	$selected = "";
		    	if($brand->timezone == $timezone->value)
		    	{
		    		$selected = 'selected="selected"';
		    	}
		    	?>
		    	<option value="<?php echo $timezone->value ?>" <?php echo set_select('timezone', $timezone->value)?set_select('timezone', $timezone->value):(!empty($selected)?$selected:''); ?>><?php echo $timezone->timezone; ?></option>
		    	<?php
		    }
		    ?>
		</select>
		<?php echo form_error('timezone', '<div class="text-danger">', '</div>'); ?>
    </div>
	<?php
	if(isset($brand->id) OR set_value('id'))
	{
		?>		
		<div class="radio clear-fix">
		  	<label>
		    	<input type="radio" name="is_hidden" value="1" <?php echo set_radio('is_hidden', '1') ? 'checked' : ((isset($brand->is_hidden) AND $brand->is_hidden == 1) ? 'checked' : ''); ?> value="1">
		    	Hide
		  	</label>
		</div>
		<div class="radio">
		  	<label>
		    	<input type="radio" name="is_hidden" value="0" <?php echo set_radio('is_hidden', '0') ? 'checked' : ((isset($brand->is_hidden) AND $brand->is_hidden == 0) ? 'checked' : ''); ?>>
		    	Unhide
		  	</label>
		</div>
		<?php
	}
	?>
    <button type="submit" class="btn btn-primary">ADD</button>
<?php echo form_close(); ?>