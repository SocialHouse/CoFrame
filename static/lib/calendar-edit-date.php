	<hr>
	<?php date_default_timezone_set('America/Chicago'); ?>
	<select class="form-control" name="postMonth">
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05"<?php if(date('F') == 'May') { echo ' selected'; }?>>May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
	</select>
	<select class="form-control" name="postDay">
		<?php 
			$i = 1;
			while ($i <= 31) {
		?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php
			$i++;
			}
		?>
	</select>
	<select class="form-control" name="postYear">
		<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
		<option value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
	</select>
	<input name="postTime" type="text" class="form-control form-control-time" placeholder="<?php echo date('g:i'); ?>">
	<select class="form-control" name="postAmPm">
		<option value="am"<?php if(date('a') == 'am') { echo ' selected'; }?>>AM</option>
		<option value="pm"<?php if(date('a') == 'pm') { echo ' selected'; }?>>PM</option>
	</select>
	<footer class="form-footer">
		<button type="button" class="btn btn-sm btn-default qtip-hide">Cancel</button>
		<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Save</button>
	</footer>
