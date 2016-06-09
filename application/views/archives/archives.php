<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
<header class="page-main-header">
	<h1 class="center-title section-title">Archive</h1>
</header>
<form action="http://timeframe.localhost:8080/static/create-post.php//?" id="archive-export">	
	<div class="col-sm-12 archives">
			<div class="col-md-9 col-sm-12">
				<div class="container-archive">
					<h2 class="text-xs-center">Date Selection</h2>
					<div class="row">
						<div class="col-sm-4 archive-calendar calendar-select-date equal-section">
							<div id="calendar-archive-1"></div>
						</div>
						<div class="col-sm-4 archive-calendar calendar-select-date equal-section">
							<div id="calendar-archive-2"></div>
						</div>
						<div class="col-sm-4">
							<div class="bg-gray-lightest export-options equal-section">
								<div class="radio form-inline radio-w-inputs">
									<label>
									<input type="radio" name="exportDate" value="daterange">
									<div class="hide-top-bx-shadow"><input type="text" class="form-control popover-toggle" name="start-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-start-date" data-popover-class="popover-clickable popover-sm" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300"></div> <span>To</span> <div class="hide-top-bx-shadow"><input type="text" class="form-control popover-toggle" name="end-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-end-date" data-popover-class="popover-clickable popover-sm" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300"></div>
									</label>
								</div>
								<div class="radio">
									<label>
									<input type="radio" name="exportDate" value="7days">
									Last 7 Days
									</label>
								</div>
								<div class="radio">
									<label>
									<input type="radio" name="exportDate" value="30days">
									Last 30 Days
									</label>
								</div>
								<div class="radio">
									<label>
									<input type="radio" name="exportDate" value="month">
									Last Month
									</label>
								</div>
								<div class="radio">
									<label>
									<input type="radio" name="exportDate" value="3months">
									Last 3 Months
									</label>
								</div>
								<div class="radio">
									<label>
									<input type="radio" name="exportDate" value="year">
									Last Year
									</label>
								</div>
							</div>
						</div>
					</div>
					<footer class="post-content-footer">
						<button type="reset" class="btn btn-sm btn-default">Reset</button>
					</footer>
					<div id="calendar-start-date" class="hidden calendar-select-date">
						<div class="date-select-calendar"></div>
					</div>
					<div id="calendar-end-date" class="hidden calendar-select-date">
						<div class="date-select-calendar"></div>
					</div>
				</div>

			</div>
			<div class="col-md-3 col-sm-12">
				<div class="container-archive">
					<h2 class="text-xs-center">Export Foramt</h2>
					<div class="row">
						<div class="col-md-3 col-sm-6 center-block equal-section export-format">
							<div class="radio">
								<label>
								<input type="radio" name="exportType" value="CSV" checked>
								.CSV
								</label>
							</div>
							<div class="radio">
								<label>
								<input type="radio" name="exportType" value="PDF">
								.PDF
								</label>
							</div>
						</div>
					</div>
					<footer class="post-content-footer">
						<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right">Export</button>
					</footer>
				</div>
			</div>
	</div>
</form>