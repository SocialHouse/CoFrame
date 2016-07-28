<div class="container-brand-step">
	<form id="step_4_edit" method="POST" action="<?php echo base_url()?>brands/update_tags" enctype="multipart/form-data">
		<input type="hidden" id="brand_id" name="brand_id" value="<?php echo $brand->id; ?>">
		<input type="hidden" id="slug" name="slug" value="<?php echo $brand->slug; ?>">
		<h4 class="text-xs-center">Manage Tags<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h4>
		<div class="add-brand-details brand-fields border-bottom border-black">
			<div id="selectedTags" class="tag-list selected-items hidden" style="display: block;">
				<ul>
				<?php 
					if(!empty($selected_tags))
					{
						foreach ($selected_tags as $st_tag) 
						{
							?>
							<li data-previous_color="<?php echo $st_tag->color; ?>" data-previous_value="<?php echo $st_tag->tag_name; ?>" data-index="<?php echo $st_tag->id; ?>" data-group="brand-tag" data-value="<?php echo $st_tag->tag_name; ?>" class="tag save-list-tag" data-tag="<?php echo $st_tag->tag_name; ?>">
								<input class="tg-ids" type="hidden" name='tag_id[]' value="<?php echo $st_tag->id; ?>">
								<input type="checkbox" value="<?php echo $st_tag->color; ?>" checked="checked" name="selected_tags[]" class="hidden-xs-up color">
								<i class="fa fa-circle" style="color:<?php echo $st_tag->color; ?>"><i class="fa fa-check"></i></i>
								<input type="hidden" value="<?php echo $st_tag->tag_name; ?>" class="labels" name="labels[]"><span><?php echo $st_tag->tag_name; ?></span>
								<a data-remove-tag="<?php echo $st_tag->tag_name; ?>" class="pull-sm-right remove-tag" href="#">
									<i class="tf-icon circle-border">x</i>
								</a>
								<a data-previous_color="<?php echo $st_tag->color; ?>" data-previous_value="<?php echo $st_tag->tag_name; ?>" data-index="<?php echo $st_tag->id; ?>" href="#brandOutlets" data-color="<?php echo $st_tag->color; ?>" data-value="<?php echo $st_tag->tag_name; ?>" class="btn-icon btn-gray post-filter-popup edit-tag edit-pensil show-hide" data-hide="#addTagLink, #outletStep4Btns, #selectedTags" data-show="#selectBrandTags, #addTagBtns">
								<i class="fa fa-pencil"></i>
								</a>
							</li>
							<?php						
						}
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
						<li class="tag" data-value="" data-color="#ef3c39" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ef3c39"><i class="fa fa-circle" style="color:#ef3c39;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#ff7bac" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ff7bac"><i class="fa fa-circle" style="color:#ff7bac;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#f7931e" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#f7931e"><i class="fa fa-circle" style="color:#f7931e;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#ffdf7f" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ffdf7f"><i class="fa fa-circle" style="color:#ffdf7f;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#8cc63f" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#8cc63f"><i class="fa fa-circle" style="color:#8cc63f;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#009245" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#009245"><i class="fa fa-circle" style="color:#009245;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#58b0e3" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#58b0e3"><i class="fa fa-circle" style="color:#58b0e3;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#0071bc" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#0071bc"><i class="fa fa-circle" style="color:#0071bc;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#662d91" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#662d91"><i class="fa fa-circle" style="color:#662d91;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#a75574" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag[]" checked="checked" value="#a75574"><i class="fa fa-circle" style="color:#a75574;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#a67c52" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#a67c52"><i class="fa fa-circle" style="color:#a67c52;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#c7b299" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#c7b299"><i class="fa fa-circle" style="color:#c7b299;"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-color="#bfbfbf" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#bfbfbf"><i class="fa fa-circle" style="color:#bfbfbf;"><i class="fa fa-check"></i></i></li>
						<li class="tag hidden custom-tag" data-value="" data-color="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" checked="checked" name="brand-tag[]" value=""><i class="fa fa-circle tag-custom"><i class="fa fa-check"></i></i></li>
						<li class="tag" data-value="" data-group="brand-tag"><a href="#" id="chooseTagColor"><i class="tf-icon circle-border">+</i></a></li>
					</ul>
				</div>
				<div class="form-group">
					<select class="form-control" name="tagLabel" id="tagLabel">								
						<option value="">Select Label</option>
						<?php 
							foreach ($selected_tags as $st_tag) {
								?>
								<option value="<?php echo $st_tag->name; ?>"><?php echo $st_tag->name; ?></option>
								<?php								
							}
						?>
						<option value="other">+ Add Label</option>						
					</select>
					<div id="labelSelectValid" class="error hide">This label is already been used.</div>
				</div>
				<div class="form-group hidden" id="otherTagLabel">
					<input type="text" class="form-control" name="otherTagLabel" id="newLabel">
					<div id="labelValid" class="error hide">This label is already been used.</div>
				</div>
			</div>			
		</div>
		<footer class="post-content-footer">
			<div id="outletStep4Btns">
				<button type="button" class="btn btn-sm btn-default close_brand"  data-step-no="4" >Cancel</button>
				<button type="submit" class="btn btn-sm btn-secondary pull-sm-right" data-step-no="4">Save</button>
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
