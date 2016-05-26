<div class="container-post-details post-content">
	<h4 class="text-xs-center">Post Details</h4>
	<div class="form-group">
		<div class="outlet-list clearfix">
			<label for="postOutlet" class="pull-sm-left">Outlet: </label>
			<ul class="pull-sm-left">
				<li class="disabled" data-selected-outlet="facebook"><i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i></li>
				<li class="disabled" data-selected-outlet="twitter"><i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i></li>
				<li class="disabled" data-selected-outlet="instagram"><i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i></li>
				<li class="disabled" data-selected-outlet="linkedin"><i class="fa fa-linkedin"><span class="bg-outlet bg-linkedin"></span></i></li>
				<li class="disabled" data-selected-outlet="vimeo"><i class="fa fa-vimeo"><span class="bg-outlet bg-vimeo"></span></i></li>
				<li class="disabled" data-selected-outlet="pinterest"><i class="fa fa-pinterest"><span class="bg-outlet bg-pinterest"></span></i></li>
				<li class="disabled" data-selected-outlet="tumblr"><i class="fa fa-tumblr"><span class="bg-outlet bg-tumblr"></span></i></li>
				<li class="disabled" data-selected-outlet="youtube"><i class="fa fa-youtube-play"><span class="bg-outlet bg-youtube"></span></i></li>
			</ul>
			<input type="hidden" id="postOutlet">
		</div>
	</div>
	<div class="form-group">
		<label for="postCopy">Post Copy</label>
		<textarea class="form-control" id="postCopy" rows="5" placeholder="Type your copy here..."></textarea>
	</div>
	<div class="form-group">
		<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></label>
		<div class="form__input">
			<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple />
			<label for="postFile" id="postFileLabel" class="file-upload-label"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>
			<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
		</div>
		<div class="form__uploading">Uploading ...</div>
		<div class="form__success">Done!</div>
		<div class="form__error">Error! <span></span>.</div>
	</div>
	<div class="form-group form-inline pull-sm-left">
		<label>Slate Post:</label><br>
		<div class="hide-top-bx-shadow">
			<input type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
		</div>
	</div>
	<div class="form-group pull-sm-left">
		<div class="pull-xs-left">
			<label class="invisible">Post Time</label>
			<div class="time-select form-control">
				<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" placeholder="HH">
				<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" placeholder="MM">
				<input type="text" class="time-input amselect" name="post-ampm" value="am">
			</div>
		</div>
		<span class="timezone pull-xs-right">PST</span>
	</div>
	<div class="form-group form-inline pull-xl-right">
		<label>Tags:</label><br>
		<div class="hide-top-bx-shadow">
			<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="lib/tag-list.php" data-title="Select all that apply:" data-popover-class="popover-tags select-post-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-offset-x="0" data-offset-y="-2">
				<i class="fa fa-circle color-gray-lighter"></i> | <i class="fa fa-caret-down color-black"></i>
			</div>
		</div>
	</div>
	<footer class="post-content-footer">
		<div class="auto-save text-xs-center hidden">Auto Saving ...</div>
	</footer>
</div>