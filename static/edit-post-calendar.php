					<form action="http://timeframe.localhost:8080/static/create-post.php//?" id="post-details" class="file-upload clearfix">	
						<div class="row equal-cols">
							<div class="col-md-4">
								<?php include("lib/post-preview.php"); ?>
							</div>
							<div class="col-md-4">
								<?php include("lib/add-post-details.php"); ?>
							</div>
							<div class="col-md-4">
								<div class="container-phases">
									<div class="bg-gray-lightest border-gray-lighter border-all padding-22px">
										<?php include("lib/view-approval-phases.php"); ?>
									</div>
									<footer class="post-content-footer">
									<button class="btn btn-sm btn-default">Save Changes</button>
									<button class="btn btn-sm btn-secondary pull-sm-right">Resubmit to Phases</button>
									</footer>
								</div>
							</div>
						</div>
					</form>
