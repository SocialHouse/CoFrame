<div class="container-archive">
	<h2 class="text-xs-center">Date Range</h2>
	<ul class="timeframe-list">
		<li class="radio form-inline radio-w-inputs">
			<label>
				<input type="radio" name="exportDate" value="daterange" class="category_date">
				<div class="hide-top-bx-shadow">
					<input type="text" id="start_date" class="form-control popover-toggle" name="start-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-start-date" data-popover-class="popover-clickable popover-sm" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-popover-container="body">
				</div> 
				<span>To</span> 
				<div class="hide-top-bx-shadow">
				<input type="text" id="end_date"  class="form-control popover-toggle" name="end-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-end-date" data-popover-class="popover-clickable popover-sm" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-popover-container="body">
				</div>
			</label>
		</li>
		<li class="radio">
			<label>
			<input type="radio" name="exportDate" value="7days" checked  class="category_date">
			Last 7 Days
			</label>
		</li>
		<li class="radio">
			<label>
			<input type="radio" name="exportDate" value="30days"  class="category_date">
			Last 30 Days
			</label>
		</li>
		<li class="radio">
			<label>
			<input type="radio" name="exportDate" value="month"  class="category_date">
			Last Month
			</label>
		</li>
		<li class="radio">
			<label>
			<input type="radio" name="exportDate" value="3months"  class="category_date">
			Last 3 Months
			</label>
		</li>
		<li class="radio">
			<label>
			<input type="radio" name="exportDate" value="year" class="category_date">
			Last Year
			</label>
		</li>
	</ul>
	<div id="calendar-start-date" class="hidden calendar-select-date">
		<div class="date-select-calendar"></div>
	</div>
	<div id="calendar-end-date" class="hidden calendar-select-date">
		<div class="date-select-calendar"></div>
	</div>
</div>