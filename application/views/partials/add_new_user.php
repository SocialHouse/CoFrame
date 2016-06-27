
<div id="addNewUser" class="hidden">
	<h5 class="text-xs-center border-bottom border-black ">Add a User<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="User Images...Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h5>
	<div class="form-group">
		<a href="#" class="remove-user-img hide">
			<i class="tf-icon-circle remove-upload">x</i>
		</a>
		<div class="center-block new-user-pic"  id="img_div" >
			<input type='file' id='userfileInput' name='files' accept='image/*'>
			<div class="cropme" id="new_user_pic" style="width: 70px; height: 70px;"></div>
			<input type="hidden" name="user_pic_base64" value="" id="user_pic_base64">
		</div>
		<div class="upload-error error hide" style="margin-left: 15%;">Wrong file type uploaded</div>
		<div class="form__uploading">Uploading ...</div>
		<div class="form__success">Done!</div>
		<div class="form__error">Error! <span></span></div>
	</div>

	<div class="form-group input-margin">
		<label for="firstName">User Info:</label>
		<input type="text" class="form-control" id="firstName" placeholder="First Name *" name="first_name" autocomplete="off">
		<input type="text" class="form-control" id="lastName" placeholder="Last Name *" name="last_name" autocomplete="off">
		<div id="nameValid" class="error hide">This name is already in use. Please enter a new one.</div>
		<input type="text" class="form-control" id="userTitle" placeholder="Title">
		<input type="email" class="form-control" id="userEmail" placeholder="Email *" name="email" autocomplete="off">
		<div id="emailValid" class="error hide">This is not a valid email.</div>
	</div>
	
	<h5 class="border-title"><span>Permitted Outlets</span></h5>
	<div class="outlet-list">
		<ul>
			<?php
			if(!empty($outlets))
			{
				foreach($outlets as $outlet)
				{
					?>
					<li class="disabled sub-user-outlet" data-selected-outlet-name="<?php echo strtolower($outlet->outlet_name); ?>" data-selected-outlet="<?php echo strtolower($outlet->id); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>		
					<?php
				}
			}
			?>								
		</ul>
	</div>
	<input type="hidden" id="userOutlet">
</div>
