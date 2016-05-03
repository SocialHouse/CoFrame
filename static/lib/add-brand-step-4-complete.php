<div class="container-brand-step">
	<h3 class="text-xs-center">Step 4</h3>
	<h4 class="text-xs-center">Post Tags<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h4>
	<div class="tag-list saved-items">
		<ul>
			<li class="tag" data-value="Marketing" data-group="brand-tag" data-tag="Marketing"><i class="fa fa-circle tag-red"></i>Marketing</li>
			<li class="tag" data-value="E-Commerce" data-group="brand-tag" data-tag="E-Commerce"><i class="fa fa-circle tag-blue-dark"></i>E-Commerce</li>
			<li class="tag" data-value="Sales" data-group="brand-tag" data-tag="Sales"><i class="fa fa-circle tag-yellow"></i>Sales</li>
			<li class="tag" data-value="Promotion" data-group="brand-tag" data-tag="Promotion"><i class="fa fa-circle tag-green-dark"></i>Promotion</li>
			<li class="tag" data-value="Lorem Ipsum Dolor" data-group="brand-tag" data-tag="Lorem Ipsum Dolor"><i class="fa fa-circle tag-purple-dark"></i>Lorem Ipsum Dolor</li>
		</ul>
	</div>
	<div class="add-brand-details brand-fields border-bottom border-black hidden">
		<div id="selectedTags" class="tag-list selected-items hidden">
			<ul>
			</ul>
		</div>
		<a href="#brandOutlets" id="addTagLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addTagLink, #outletStepBtns, #selectedTags" data-show="#selectBrandTags, #addTagBtns"><i class="tf-icon circle-border">+</i>Add Tag</a>
		<div id="selectBrandTags" class="hidden">
			<h5 class="text-xs-center border-bottom border-black ">Add a Tag</h5>
			<h5 class="border-title"><span>Select Tag Color</span></h5>
			<div class="tag-list">
				<ul>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="red"><i class="fa fa-circle tag-red"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="pink"><i class="fa fa-circle tag-pink"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="orange"><i class="fa fa-circle tag-orange"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="yellow"><i class="fa fa-circle tag-yellow"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="green"><i class="fa fa-circle tag-green"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="green-dark"><i class="fa fa-circle tag-green-dark"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="blue"><i class="fa fa-circle tag-blue"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="blue-dark"><i class="fa fa-circle tag-blue-dark"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="purple-dark"><i class="fa fa-circle tag-purple-dark"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="purple"><i class="fa fa-circle tag-purple"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="brown"><i class="fa fa-circle tag-brown"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="tan"><i class="fa fa-circle tag-tan"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="gray"><i class="fa fa-circle tag-gray"></i></li>
					<li class="tag hidden custom-tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="custom"><i class="fa fa-circle tag-custom"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><a href="#" id="chooseTagColor"><i class="tf-icon circle-border">+</i></a></li>
				</ul>
			</div>
			<div class="form-group">
				<select class="form-control" name="tagLabel" id="tagLabel">
					<option value="">Select Label</option>
					<option value="Marketing">Marketing</option>
					<option value="E-Commerce">E-Commerce</option>
					<option value="Sales">Sales</option>
					<option value="Promotion">Promotion</option>
					<option value="other">+ Add Label</option>
				</select>
			</div>
			<div class="form-group hidden" id="otherTagLabel">
				<input type="text" class="form-control" name="otherTagLabel">
			</div>
		</div>
	</div>
	<footer class="post-content-footer">
		<div class="hidden" id="outletStepBtns">
			<div class="disclaimer"><button class="btn btn-sm btn-default" type="submit">Skip this Step</button></div>
			<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="3">Back</button>
			<button type="submit" class="btn btn-sm btn-disabled pull-sm-right btn-next-step btn-secondary" disabled>Done</button>
		</div>
		<div id="addTagBtns" class="hidden">
			<button type="button" class="btn btn-sm btn-default show-hide" data-show="#addTagLink, #outletStepBtns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns">Cancel</button>
			<button class="btn btn-sm btn-disabled pull-sm-right btn-secondary show-hide" data-show="#addTagLink, #outletStepBtns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns" id="addTag">Add</button>
		</div>
	</footer>
</div>