<div class="container-post-details post-content">
	<h4 class="text-xs-center">Post Details</h4>
	<form action="" id="post-details">
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
			<textarea class="form-control" id="postCopy" rows="7" placeholder="Type your copy here..."></textarea>
		</div>
		<div class="form-group">
			<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></label>
			<div class="box__input">
				<input type="file" name="files[]" id="file" class="box__file" data-multiple-caption="{count} files selected" multiple />
				<label for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
				<button type="submit" class="box__button">Upload</button>
			</div>
			<div class="box__uploading">Uploading&hellip;</div>
			<div class="box__success">Done! <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?" class="box__restart" role="button">Upload more?</a></div>
			<div class="box__error">Error! <span></span>. <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?" class="box__restart" role="button">Try again!</a></div>
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
			<div class="form-control">
				<i class="fa fa-circle color-gray-lighter"></i> | <i class="fa fa-caret-down color-black"></i>
			</div>		
		</div>
		<footer class="post-content-footer">
		</footer>
	</form>
</div>