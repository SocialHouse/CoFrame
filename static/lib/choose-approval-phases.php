<div class="overlay-box bg-white animated fadeIn">
	<div class="text-xs-center form-inline">
		<label for="approvalPhases">How many approval phases would you like to add? (1-3)</label>
		<select class="form-control" id="approvalPhases">
			<option value="">1</option>
			<option value="">2</option>
			<option value="">3</option>
		</select>
	</div>
	<footer class="form-footer">
		<button class="btn btn-xs btn-default">Cancel</button>
		<button type="button" class="btn btn-xs btn-secondary pull-sm-right" onClick="showContent(jQuery('#phaseDetails')); hideContent(jQuery(this).closest('.overlay-box'));">Next</button>
	</footer>
</div>