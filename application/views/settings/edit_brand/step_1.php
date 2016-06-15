<form id="step_1_edit" class="file-upload clearfix has-advanced-upload" method="POST" action="<?php echo base_url()?>brands/save_brand" enctype="multipart/form-data">

<input type="hidden" name="brand_id" value="<?php echo $brand->id; ?>">
<input type="hidden" name="slug" value="<?php echo $brand->slug; ?>">
	<div class="container-brand-step">	
		<h3 class="text-xs-center">Step 1</h3>
		<h4 class="text-xs-center">Add Brand</h4>
		<div class="brand-fields pd-bot-15">
			<div class="form-group">
			<?php
				$image = '';
				$cls_1 = 'hide';

				if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand->id.'/'.$brand->id.'.png'))
				{
					$image_path = upload_url().$brand->created_by.'/brands/'.$brand->id.'/'.$brand->id.'.png';
					$image = '<img class="form__file-preview" src="'.$image_path.'">';
					$cls_1 = '';
					$cls_2 = 'has-files';
				}else{
					$cls_2 = '';
				}
			?> 
				<div class="brand-logo">
					<a href="#" class="pull-sm-right remove-brand-img <?php echo $cls_1; ?>">
						<i class="tf-icon circle-border">x</i>
					</a><br><br>
					<label>
					
					<div class="form__input center-block brand-image  <?php echo $cls_2; ?>">
						<?php echo $image; ?>
						<input type="file" name="file[]" id="brandFile" class="form__file" data-multiple-caption="{count} files selected">
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
				<input type="text" class="form-control" id="brandName" placeholder="INSERT BRAND NAME" name="name" value="<?php echo $brand->name ?>">
			</div>
			<div class="form-group">
				<label>Brand Time Zone:</label>
				<select class="form-control" name="timezone" id="timezone">
					<option value=""> Select Brand Time Zone </option>
					<?php
				    foreach($timezones_list as $tmzone)
				    {
				    	if($timezone == $tmzone->timezone ){
				    		$selected = 'selected="selected"';
				    	}else{
				    		$selected = '';
				    	}
				    	?>
				    	<option value="<?php echo $tmzone->value ?>" <?php echo $selected; ?> ><?php echo $tmzone->timezone; ?></option>
				    	<?php
				    }
				    ?>
				</select>
			</div>
		</div>
		<footer class="post-content-footer">
			<button type="button" class="btn btn-sm btn-default close_brand" data-step-no="1">Cancel</button>
			<button type="submit" class="btn btn-sm btn-default pull-sm-right save_brand" data-step-no="1">Save</button>
		</footer>
	</div>
</form>
<?php       
if(isset($js_files))
{
    foreach ($js_files as $js_src) 
    {
        ?>
        <script src="<?php echo $js_src; ?>"></script>
        <?php
    }
}
?>