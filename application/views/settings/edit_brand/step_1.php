<div class="container-brand-step">
	<h3 class="text-xs-center">Step 1</h3>
	<h4 class="text-xs-center">Add Brand</h4>					
	<div class="brand-fields">						
		<div class="form-group">
			<div class="brand-logo">
				<a href="#" class="pull-sm-right remove-brand-img hide"><i class="tf-icon circle-border">x</i></a><br><br>
				<label>
				<div class="form__input center-block brand-image">								
					<input type="file" name="files[]" id="brandFile" class="form__file" data-multiple-caption="{count} files selected" multiple>
					<label for="brandFile" id="brandFileLabel" class="file-upload-label">Click to upload <span class="form__dragndrop">or drag &amp drop here</span></label>
					<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
				</div>
				</label>
				<div class="form__uploading">Uploading ...</div>
				<div class="form__success">Done!</div>
				<div class="form__error">Error! <span></span></div>
			</div>
		</div>
		<div class="form-group">
			<label for="brandName">Brand Name:</label>
			<input type="text" class="form-control" id="brandName" placeholder="INSERT BRAND NAME" name="name">
		</div>
		<div class="form-group">
			<label>Brand Time Zone:</label>
			<select class="form-control" name="timezone" id="timezone">
				<option value="">Select Brand Time Zone</option>
				<?php
			    foreach($timezones_list as $timezone)
			    {
			    	?>
			    	<option value="<?php echo $timezone->value ?>" ><?php echo $timezone->timezone; ?></option>
			    	<?php
			    }
			    ?>
			</select>
		</div>
	</div>
	<footer class="post-content-footer">
		<button type="reset" class="btn btn-sm btn-default">Cancel</button>
		<button type="button" class="btn btn-sm btn-disabled pull-sm-right save_brand" disabled="disabled">Next</button>

		<button type="button" id="btn-next-step" class="btn btn-sm btn-disabled pull-sm-right btn-next-step hide" data-active-class="btn-secondary" data-next-step="2"></button>
	</footer>
</div>