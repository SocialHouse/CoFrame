
<div id="addNewUser" class="outlet-list hidden">
	<h5 class="text-xs-center border-bottom border-black ">Add a User</h5>
	<div class="form-group">
		<div class="form__input center-block">
			<input type="file" name="files[]" id="userFile" class="form__file" data-multiple-caption="{count} files selected" multiple>
			<label for="userFile" id="userFileLabel" class="file-upload-label">Upload photo</label>
			<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
		</div>
		<div class="form__uploading">Uploading ...</div>
		<div class="form__success">Done!</div>
		<div class="form__error">Error! <span></span></div>
	</div>
	<div class="form-group input-margin">
		<label for="firstName">User Info:</label>
		<input type="text" class="form-control" id="firstName" placeholder="First Name">
		<input type="text" class="form-control" id="lastName" placeholder="Last Name">
		<input type="text" class="form-control" id="userTitle" placeholder="Title (Optional)">
		<input type="email" class="form-control" id="userEmail" placeholder="Email">
	</div>
	
	<h5 class="border-title"><span>Permitted Outlets</span></h5>
	<ul>
		<ul>
			<?php
			if(!empty($outlets))
			{
				foreach($outlets as $outlet)
				{
					?>
					<li class="disabled" data-selected-outlet-name="<?php echo strtolower($outlet->outlet_name); ?>" data-selected-outlet="<?php echo strtolower($outlet->id); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>		
					<?php
				}
			}
			?>								
		</ul>		
	</ul>
	<input type="hidden" id="userOutlet">
</div>
