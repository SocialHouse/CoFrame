
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
		<li class="disabled" data-selected-outlet="facebook"><i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i></li>
		<li class="disabled" data-selected-outlet="twitter"><i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i></li>
		<li class="disabled" data-selected-outlet="instagram"><i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i></li>
		<li class="disabled" data-selected-outlet="linkedin"><i class="fa fa-linkedin"><span class="bg-outlet bg-linkedin"></span></i></li>
		<li class="disabled" data-selected-outlet="vine"><i class="fa fa-vine"><span class="bg-outlet bg-vine"></span></i></li>
		<li class="disabled" data-selected-outlet="pinterest"><i class="fa fa-pinterest"><span class="bg-outlet bg-pinterest"></span></i></li>
		<li class="disabled" data-selected-outlet="tumblr"><i class="fa fa-tumblr"><span class="bg-outlet bg-tumblr"></span></i></li>
		<li class="disabled" data-selected-outlet="youtube"><i class="fa fa-youtube-play"><span class="bg-outlet bg-youtube"></span></i></li>
		<li class="disabled" data-selected-outlet="google"><i class="fa fa-google-plus"><span class="bg-outlet bg-google-plus"></span></i></li>
		<li class="disabled" data-selected-outlet="vimeo"><i class="fa fa-vimeo"><span class="bg-outlet bg-vimeo"></span></i></li>
		<li class="disabled" data-selected-outlet="wordpress"><i class="fa fa-wordpress"><span class="bg-outlet bg-wordpress"></span></i></li>
		<li class="disabled" data-selected-outlet="blogger"><i class="icon-blogger"><span class="bg-outlet bg-blogger"></span></i></li>
	</ul>
	<input type="hidden" id="userOutlet">
</div>
