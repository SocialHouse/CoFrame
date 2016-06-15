<div class="container-brand-step">
	<form id="step_4_edit" method="POST" action="<?php echo base_url()?>brands/save_outlet" enctype="multipart/form-data">
		<h3 class="text-xs-center">Step 4</h3>
		<h4 class="text-xs-center">Post Tags<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h4>
		<div class="add-brand-details brand-fields border-bottom border-black">
			<div id="selectedTags" class="tag-list selected-items hidden" style="display: block;">
				<ul>
				<?php 
					foreach ($selected_tags as $st_tag) {
						?>
						<li data-group="brand-tag" data-value="<?php echo $st_tag->tag_name; ?>" class="tag" data-tag="<?php echo $st_tag->tag_name; ?>">
							<input type="checkbox" value="<?php echo $st_tag->color; ?>" name="brand-tag" class="hidden-xs-up">
							<i class="fa fa-circle" style="color:<?php echo $st_tag->color; ?>"><i class="fa fa-check"></i></i>
							<?php echo $st_tag->tag_name; ?>
							<a data-remove-tag="<?php echo $st_tag->tag_name; ?>" class="pull-sm-right remove-tag" href="#">
								<i class="tf-icon circle-border">x</i>
							</a>
						</li>
						<?php						
					}
				?>
					
				</ul>
			</div>
			<a href="#brandOutlets" id="addTagLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addTagLink, #outletStep4Btns, #selectedTags" data-show="#selectBrandTags, #addTagBtns"><i class="tf-icon circle-border">+</i>Add Tag</a>
			<div id="selectBrandTags" class="hidden">
				<h5 class="text-xs-center border-bottom border-black ">Add a Tag</h5>
				<h5 class="border-title"><span>Select Tag Color</span></h5>
				<div class="tag-list">
					<ul class="tags-to-add">
						<li class="tag" data-value="" data-color="#ef3c39" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ef3c39"><i class="fa fa-circle" style="color:#ef3c39;"></i></li>
						<li class="tag" data-value="" data-color="#ff7bac" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ff7bac"><i class="fa fa-circle" style="color:#ff7bac;"></i></li>
						<li class="tag" data-value="" data-color="#f7931e" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#f7931e"><i class="fa fa-circle" style="color:#f7931e;"></i></li>
						<li class="tag" data-value="" data-color="#ffdf7f" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ffdf7f"><i class="fa fa-circle" style="color:#ffdf7f;"></i></li>
						<li class="tag" data-value="" data-color="#8cc63f" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#8cc63f"><i class="fa fa-circle" style="color:#8cc63f;"></i></li>
						<li class="tag" data-value="" data-color="#009245" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#009245"><i class="fa fa-circle" style="color:#009245;"></i></li>
						<li class="tag" data-value="" data-color="#58b0e3" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#58b0e3"><i class="fa fa-circle" style="color:#58b0e3;"></i></li>
						<li class="tag" data-value="" data-color="#0071bc" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#0071bc"><i class="fa fa-circle" style="color:#0071bc;"></i></li>
						<li class="tag" data-value="" data-color="#662d91" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#662d91"><i class="fa fa-circle" style="color:#662d91;"></i></li>
						<li class="tag" data-value="" data-color="#a75574" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag[]" checked="checked" value="#a75574"><i class="fa fa-circle" style="color:#a75574;"></i></li>
						<li class="tag" data-value="" data-color="#a67c52" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#a67c52"><i class="fa fa-circle" style="color:#a67c52;"></i></li>
						<li class="tag" data-value="" data-color="#c7b299" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#c7b299"><i class="fa fa-circle" style="color:#c7b299;"></i></li>
						<li class="tag" data-value="" data-color="#bfbfbf" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#bfbfbf"><i class="fa fa-circle" style="color:#bfbfbf;"></i></li>
						<li class="tag hidden custom-tag" data-value="" data-color="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" checked="checked" name="brand-tag[]" value=""><i class="fa fa-circle tag-custom"></i></li>
						<li class="tag" data-value="" data-group="brand-tag"><a href="#" id="chooseTagColor"><i class="tf-icon circle-border">+</i></a></li>
					</ul>
				</div>
				<div class="form-group">
					<select class="form-control" name="tagLabel" id="tagLabel">								
						<option value="">Select Label</option>
						<?php 
							foreach ($selected_tags as $st_tag) {
								?>
								<option value="<?php echo $st_tag->color; ?>"><?php echo $st_tag->name; ?></option>
								<?php								
							}
						?>
						<option value="other">+ Add Label</option>
					</select>
				</div>
				<div class="form-group hidden" id="otherTagLabel">
					<input type="text" class="form-control" name="otherTagLabel" id="newLabel">
				</div>
			</div>
		</div>
		<footer class="post-content-footer">
			<div id="outletStep4Btns">
				<div class="disclaimer"><button class="btn btn-sm btn-default skip_step" type="button">Skip this Step</button></div>
				<button type="button" class="btn btn-sm btn-default close_brand"  data-step-no="4" >Cancel</button>
				<button type="button" class="btn btn-sm btn-secondary pull-sm-right submit_tag" data-step-no="4">Save</button>
			</div>
			<div id="addTagBtns" class="hidden">
				<button type="button" class="btn btn-sm btn-default show-hide" data-show="#addTagLink, #outletStep4Btns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns">Cancel</button>
				<button class="btn btn-sm btn-disabled pull-sm-right btn-secondary show-hide" data-show="#addTagLink, #outletStep4Btns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns" id="addTag" disabled="disabled">Add</button>
			</div>
		</footer>
	</form>
</div>

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
