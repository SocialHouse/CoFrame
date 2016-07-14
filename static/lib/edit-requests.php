<div class="container-post-discussion post-content">
	<h4 class="text-xs-center">Edit Requests</h4>
	<div class="bg-gray-lightest border-top border-bottom padding-22px">
		<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase1">
			<h2 class="clearfix">Phase 1 <i class="fa fa-angle-right"></i> <button class="btn btn-xs btn-default btn-disabled pull-sm-right">Finished</button></h2>
			<?php include("lib/post-approval-discussion.php"); ?>
			<footer class="post-content-footer text-xs-center">
				<a href="#" class="btn btn-default color-success btn-md">Approve</a>
				<a href="#" class="btn btn-secondary btn-md">Finish Phase 1</a>
			</footer>
		</div>
		
		<div class="bg-white approval-phase animated fadeIn active" id="approvalPhase2">
			<h2 class="clearfix">Phase 2 <i class="fa fa-angle-down"></i> <button class="btn btn-xs btn-default color-success pull-sm-right">Current</button></h2>
			<?php include("lib/post-approval-discussion.php"); ?>
			<footer class="post-content-footer text-xs-center">
				<a href="#" class="btn btn-secondary btn-md" data-toggle="modal" data-target="#finishPhase2">Finish Phase 2</a>
			</footer>
		</div>
		
		<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase3">
			<h2 class="clearfix"><a href="#approvalPhase3" class="toggleActive" title="Edit Phase">Phase 3 <i class="fa fa-angle-right"></i></a></h2>
			<?php include("lib/post-approval-discussion.php"); ?>
			<footer class="post-content-footer text-xs-center">
				<div class="inline-block">
					<span class="post-actions pull-sm-left">
						<button class="btn btn-secondary btn-disabled btn-md" disabled="">Approved</button><br>
						<a href="#" data-toggle="modal" data-target="#undoApproval">Undo</a>
					</span>
					<a href="#" class="btn btn-default color-success btn-md">Finish Phase 3</a>
				</div>
			</footer>
		</div>
	</div>
	<footer class="post-content-footer post-actions text-xs-right">
		<a href="#" class="btn btn-secondary btn-sm">Schedule</a>
		<a href="#" class="btn btn-secondary btn-sm">Post Now</a>
	</footer>
</div>