					<form action="http://timeframe.localhost:8080/static/create-post.php//?" id="post-details" class="file-upload clearfix">	
						<div class="row equal-cols">
							<div class="col-md-6 bg-white equal-height">
								<?php include("lib/post-preview-2.php"); ?>
							</div>
							<div class="col-md-6 bg-gray-lightest equal-height">
								<div class="container-phases">
									<div class="">
										<?php include("lib/view-approval-phases-2.php"); ?>
									</div>
									<footer class="post-content-footer">
										<div class="btn-group pull-md-right" role="group">
										  <button type="button" class="btn btn-xs btn-default">View Edit Requests</button>
										  <button type="button" class="btn btn-xs btn-default">Suggest an Edit</button>
										</div>		
									</footer>
								</div>
							</div>
						</div>
					</form>
