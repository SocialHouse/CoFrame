<h1 class="text-xs-center">Print or Export</h1>
<div class="row form-inline" id="selectExportDates">
	<div class="col-md-6">
		<h2 class="text-xs-center">Starts</h2>
		<select class="form-control" name="start-date-type" id="startDateType">
			<option value="on-date">On Date</option>
			<option value="today">Today</option>
			<option value="tomorrow">Tomorrow</option>
		</select>
		<input type="text" class="form-control" name="start-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-start-date" data-popover-class="popover-clickable popover-sm" data-attachment="top left" data-target-attachment="bottom left" data-popover-container="#qtip-calendar-post-print" data-popover-width="300">
	</div>
	<div class="col-md-6">
		<h2 class="text-xs-center">Ends</h2>
		<select class="form-control" name="end-date-type" id="endDateType">
			<option value="on-date">On Date</option>
			<option value="today">Today</option>
			<option value="tomorrow">Tomorrow</option>
		</select>
		<input type="text" class="form-control" name="end-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-end-date" data-popover-class="popover-clickable popover-sm" data-attachment="top right" data-target-attachment="bottom right" data-popover-container="#qtip-calendar-post-print" data-popover-width="300">
	</div>
</div>
<div class="row hidden" id="exportPosts">
	<div class="col-md-12">
		<h2 class="text-xs-center">Select Export Option</h2>
		<div class="text-sm-center col-sm-8 center-block">
			<div class="radio-inline col-sm-6">
				<label>
				<input type="radio" name="exportType" value="CSV" checked>
				.CSV
				</label>
			</div>	
			<div class="radio-inline col-sm-6 no-margin">
				<label>
				<input type="radio" name="exportType" value="PDF">
				.PDF
				</label>
			</div>
		</div>
	</div>
</div>
<footer class="form-footer">
	<div id="exportPrintBtns">
		<button type="button" class="btn btn-sm btn-default qtip-hide">Cancel</button>
		<div class="pull-sm-right">
		<button type="button" class="btn btn-sm btn-secondary show-hide" data-hide="#selectExportDates, #exportPrintBtns" data-show="#exportPosts, #exportBtns">Export</button>
		<button type="button" class="btn btn-sm btn-secondary">Print</button>
		</div>
	</div>
	<div id="exportBtns" class="hidden">
		<button type="button" class="btn btn-sm btn-default show-hide" data-show="#selectExportDates, #exportPrintBtns" data-hide="#exportPosts, #exportBtns">Back</button>
		<div class="pull-sm-right">
		<button type="submit" class="btn btn-sm btn-secondary">Export</button>
		</div>
	</div>
</footer>

<div id="calendar-start-date" class="hidden calendar-select-date">
	<div class="date-select-calendar"></div>
</div>
<div id="calendar-end-date" class="hidden calendar-select-date">
	<div class="date-select-calendar"></div>
</div>							
