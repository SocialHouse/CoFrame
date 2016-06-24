<?php echo form_open(base_url().'me/change_plan',array('method'=>'post','novalidate'=>"novalidate")); ?>
    
    <div class="form-group">
        <label for="email">Plan:</label>	        
        <div class="radio">
				<label><input type="radio" name="plan" value="START-UP" <?php echo set_radio("plan","START-UP") ? set_radio("plan","START-UP") : ( (isset($current_plan) AND $current_plan === 'START-UP') ? 'checked="checked"'  : ''); ?> >START-UP</label>
		</div>
		<div class="radio">
				<label><input type="radio" name="plan" value="BUSINESS" <?php echo set_radio("plan","BUSINESS") ? set_radio("plan","BUSINESS") : ( (isset($current_plan) AND $current_plan === 'BUSINESS') ? 'checked="checked"'  : ''); ?> >BUSINESS</label>
		</div>
		<div class="radio">
				<label><input type="radio" name="plan" value="CORPORATE" <?php echo set_radio("plan","CORPORATE") ? set_radio("plan","CORPORATE") : ( (isset($current_plan) AND $current_plan === 'CORPORATE') ? 'checked="checked"'  : ''); ?> >CORPORATE</label>
		</div>
		<div class="radio">
				<label><input type="radio" name="plan" value="PREMIERE" <?php echo set_radio("plan","PREMIERE") ? set_radio("plan","PREMIERE") : ( (isset($current_plan) AND $current_plan == 'PREMIERE') ? 'checked="checked"' : '' ); ?> >PREMIERE</label>
		</div>
		<?php echo form_error('plan', '<div class="text-danger">', '</div>'); ?>
	</div>

<button type="submit" class="btn btn-primary">Update</button>    
<?php echo form_close(); ?>