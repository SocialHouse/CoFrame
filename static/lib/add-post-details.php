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
				<li class="disabled" data-selected-outlet="youtube"><i class="fa fa-youtube"><span class="bg-outlet bg-youtube"></span></i></li>
			</ul>
			<input type="hidden" id="postOutlet">
		</div>
	</div>
	<div class="form-group">
		<label for="postCopy">Post Copy</label>
		<textarea class="form-control" id="postCopy" rows="5" placeholder="Type your copy here..."></textarea>
	</div>
	<div class="form-group">
		<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></label>
		<div class="form__input">
			<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple />
			<label for="postFile" id="postFileLabel"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>
			<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
		</div>
		<div class="form__uploading">Uploading ...</div>
		<div class="form__success">Done!</div>
		<div class="form__error">Error! <span></span>.</div>
	</div>
	<div class="form-group form-inline pull-sm-left">
		<label>Slate Post:</label><br>
		<select class="form-control">
			<option value="">Month</option>
		</select>
		<select class="form-control">
			<option value="">DD</option>
		</select>
		<select class="form-control">
			<option value="">YYYY</option>
		</select>
		<input type="text" class="form-control form-control-time" placeholder="HH:MM">
		<select class="form-control">
			<option value="am">AM</option>
			<option value="pm">PM</option>
		</select>
	</div>
	<div class="form-group form-inline pull-md-right">
		<label>Tags:</label><br>
		<div class="form-control tag-select" data-toggle="popover-ajax" data-placement="top" data-content-src="lib/tag-list.php" data-popover-class="popover-tags" data-popover-id="popover-tag-list">
			<i class="fa fa-circle color-gray-lighter"></i> | <i class="fa fa-caret-down color-black"></i>
		</div>
	</div>
	<footer class="post-content-footer">
		<div class="auto-save text-xs-center hidden-xs-up">Auto Saving ...</div>
	</footer>
</div>