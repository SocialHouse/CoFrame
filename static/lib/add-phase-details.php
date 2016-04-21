	<div class="bg-gray-lightest border-gray-lighter padding-22px add-phases">
		<div class="container-phases">
			<h4 class="text-xs-center">Mandatory Approvals</h4>
			<?php include("choose-approval-phases.php"); ?>
			<div id="phaseDetails" style="display: none;">
				<?php include("add-approval-phases.php"); ?>
			</div>
			<footer class="post-content-footer">
				<button class="btn btn-sm btn-disabled" disabled data-active-class="btn-default">Cancel</button>
				<button class="btn btn-sm btn-disabled pull-sm-right" disabled data-active-class="btn-secondary">Save Phases</button>
			</footer>
		</div>
	</div>
