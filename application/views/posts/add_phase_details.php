<div class="add-phases">
	<div class="container-phases">
		<h4 class="text-xs-center">Mandatory Approvals</h4>		
		<div id="phaseDetails" style="display: none;">
			<?php 
				$this->load->view('partials/all_phases');
			?>
		</div>		
	</div>
</div>


<div class="overlay-box bg-white animated fadeIn add_phases_num">
	<div class="text-xs-center form-inline">
		<label for="approvalPhases">How many approval phases would you like?</label><br>
		<select class="form-control" id="approvalPhases">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
	</div>
	<footer class="form-footer">
		<button type="button" class="btn btn-xs btn-default cancel-phase phase-num">Cancel</button>
		<button type="button" class="btn btn-xs btn-secondary pull-sm-right" onClick="showContent(jQuery('#phaseDetails')); hideContent(jQuery(this).closest('.overlay-box'));">Next</button>
	</footer>
</div>