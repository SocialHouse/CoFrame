<form id="step_1_edit" class="clearfix file-upload" method="POST" action="<?php echo base_url()?>brands/save_brand">

<input type="hidden" name="brand_id" value="<?php echo $brand->id; ?>">
<input type="hidden" name="slug" value="<?php echo $brand->slug; ?>">
<input type="hidden" id="base64" name="base64" value="">

	<div class="container-brand-step">	
		<h4 class="text-xs-center">General Settings</h4>
		<div class="brand-fields pd-bot-15">
			<div class="form-group">
			<?php
				$image = '';
				$cls_1 = 'hide';
				$is_img='no';

				if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand->id.'/'.$brand->id.'.png'))
				{
					$image_path = upload_url().$brand->created_by.'/brands/'.$brand->id.'/'.$brand->id.'.png';
					$image ='<img src="'.$image_path.'" id="photo">';
					$cls_1 = '';
					$is_img='yes';
				}
			?> 
			<input type="hidden" name="is_brand_image" id="is_brand_image" value="<?php echo $is_img; ?>" >
				<div class="brand-logo text-xs-center">
					<a href="#" class="remove-brand-img <?php echo $cls_1; ?>">
						<i class="tf-icon circle-border">x</i>
					</a>
					<div class="form__input center-block brand-image"  id="img_div" >
						<input type='file' id='fileInput' name='files' accept='image/*'>
						<div class="cropme" id="add_brand_img" style="width: 200px; height: 200px;">
							<?php echo $image; ?>
						</div>
					</div>
					<div class="upload-error error hide">Wrong file type uploaded</div>
					<div class="form__uploading">Uploading ...</div>
					<div class="form__success">Done!</div>
					<div class="form__error"></div>
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
			<button type="submit" class="btn btn-sm btn-default pull-sm-right" data-step-no="1">Save</button>
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