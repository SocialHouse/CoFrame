<div class="container-brand-step">
	<h3 class="text-xs-center">Step 1</h3>
	<h4 class="text-xs-center">Add Brand</h4>
	<div class="brand-logo">
		<img src="assets/images/fpo/jbrand-brand-logo.png" alt="J Brand" class="circle-img center-block">
	</div>
	<div class="saved-items">
		<ul class="text-xs-center">
			<li class="brand-title">J Brand</li>
			<li><span class="brand-time">PST – Los Angeles, CA</span></li>
		</ul>
	</div>
	<div class="hidden brand-fields">
		<div class="form-group">
			<div class="form__input center-block brand-logo">
				<input type="file" name="files[]" id="brandFile" class="form__file" data-multiple-caption="{count} files selected" multiple>
				<label for="brandFile" id="brandFileLabel" class="file-upload-label">Click to upload <span class="form__dragndrop">or drag &amp drop here</span></span></label>
				<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
			</div>
			<div class="form__uploading">Uploading ...</div>
			<div class="form__success">Done!</div>
			<div class="form__error">Error! <span></span></div>
		</div>
		<div class="form-group">
			<label for="brandName">Brand Name:</label>
			<input type="text" class="form-control" id="brandName" placeholder="INSERT BRAND NAME">
		</div>
		<div class="form-group">
			<label>Brand Time Zone:</label>
			<select class="form-control">
				<option value="">Select Brand Time Zone</option>
			</select>
		</div>
	</div>
	<footer class="post-content-footer">
		<button type="reset" class="btn btn-sm btn-default hidden">Cancel</button>
		<button type="button" class="btn btn-sm btn-disabled pull-sm-right btn-next-step hidden" data-active-class="btn-secondary" data-next-step="2">Next</button>
	</footer>
</div>