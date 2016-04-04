<?php
echo form_open(base_url().'tags/save_brand_tag',array('method'=>'post','enctype' => 'multipart/form-data'));
?>
	<h1>Add tag for <?php echo $brand_name; ?></h1>    
	<input type="hidden" name="brand_id" value="<?php echo $brand_id; ?>">
	<input type="hidden" name="id" value="<?php echo set_value('id') ? set_value('id') : (isset($tag_data->id) ? $tag_data->id : '' ); ?>">
 	<div class="form-group">
	    <label for="color">Selcte color</label>	  
	    <input type="color" class="form-control" id="color" name="color" value="<?php echo set_value('color') ? set_value('color') : (isset($tag_data->color) ? $tag_data->color : '' ); ?>">		    
	    <?php echo form_error('color', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
      	<label for="timezone">Add label</label>
		<select name="label" id="label" class="form-control" >
      		<option value="">Select label</option>
		    <?php
		    foreach($tags as $tag)
		    {
		    	$selected = "";
		    	if($tag_data->name == $tag->name)
		    	{
		    		$selected = 'selected="selected"';
		    	}
		    	?>
		    	<option value="<?php echo $tag->name ?>" <?php echo set_select('timezone', $tag->name)?set_select('tag', $tag->name):(!empty($selected)?$selected:''); ?>><?php echo $tag->name; ?></option>
		    	<?php
		    }
		    ?>
		</select>
		<?php echo form_error('label', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
	    <label for="color">Add new label</label>

	    <input type="text" class="form-control" id="new_label" name="new_label" value="<?php echo set_value('new_label') ? set_value('new_label') : (isset($tag_data->new_label) ? $tag_data->new_label : '' ); ?>">		    
	    <?php echo form_error('new_label', '<div class="text-danger">', '</div>'); ?>
    </div>
	<button type="submit" class="btn btn-primary">ADD</button>
<?php echo form_close(); ?>