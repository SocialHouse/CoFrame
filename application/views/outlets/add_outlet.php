<?php
echo form_open(base_url().'outlets/save_outlet',array('method'=>'post','enctype' => 'multipart/form-data'));
?>
	<h1>Add outlet for <?php echo $brand_name; ?></h1>       
    <div class="row">
    	<input type="hidden" name="brand_id" value="<?php echo $brand_id; ?>">
	    <div class="col-md-12">
	    	<?php

	    	foreach($outlets as $outlet)
	    	{
	    		$checked = "";
	    		if(in_array($outlet->id,$selected_outlets))
	    		{
	    			$checked = 'checked="checked"';
	    		}
	    		?>
	    		<label class="checkbox-inline">
	      			<input type="checkbox" <?php echo $checked ?> name="outlets[]" value="<?php echo $outlet->id; ?>"><?php echo $outlet->outlet_name; ?>
			    </label>
	    		<?php
	    	}
	    	?>
	    	<?php echo form_error('outlets[]', '<div class="text-danger">', '</div>'); ?>
		</div>
	</div><br/>
	<button type="submit" class="btn btn-primary">ADD</button>
<?php echo form_close(); ?>