<h1 class="text-xs-center">Filters</h1>
<div class="row post-filters">
	<div class="col-md-2">
		<h2 class="text-xs-center">Post Status</h2>
		<div class="form-group filter" data-status="published" data-value=".f-published" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-published">Published</label></div>
		<div class="form-group filter" data-status="approved" data-value=".f-approved" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-approved">Approved</label></div>
		<div class="form-group filter" data-status="scheduled" data-value=".f-scheduled" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-scheduled">Scheduled</label></div>
		<div class="form-group filter" data-status="pending" data-value=".f-pending" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-pending">Pending</label></div>
		<div class="form-group filter" data-status="published" data-value="check-all" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for="check-all">All</label></div>
	</div>
	<div class="col-md-4">
		<h2 class="text-xs-center">Outlets</h2>
		<div class="outlet-list">
			<ul>
				<?php
				if(!empty($outlets))
				{
					foreach($outlets as $outlet)
					{
						?>
						<li class="disabled filter" data-id="<?php echo $outlet->id; ?>" data-value="<?php echo '.f-'.strtolower($outlet->outlet_name); ?>" data-group="post-outlet"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>
						<?php
					}
				}
				?>				
				<li class="filter" data-value="check-all" data-group="post-outlet"><i class="fa"><span class="bg-outlet bg-all"></span><span class="outlet-text">All</span></i></li>
			</ul>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="text-xs-center">Tags</h2>
			</div>
			<div class="col-sm-6 tag-list">
				<ul>
					<li class="tag filter" data-tag="" data-value=".f-brandbuilding" data-group="post-tag"><i class="fa fa-circle tag-red"></i><span class="tag-title">Brand Building / Product Education</span></li>
					<li class="tag filter" data-value=".f-marketing" data-group="post-tag"><i class="fa fa-circle tag-pink"></i><span class="tag-title">Marketing</span></li>
					<li class="tag filter" data-value=".f-orange" data-group="post-tag"><i class="fa fa-circle tag-orange"></i><span class="tag-title">Orange Tag</span></li>
					<li class="tag filter" data-value=".f-ecommerce" data-group="post-tag"><i class="fa fa-circle tag-yellow"></i><span class="tag-title">E-Commerce</span></li>
					<li class="tag filter" data-value=".f-retail" data-group="post-tag"><i class="fa fa-circle tag-green"></i><span class="tag-title">Retail Support</span></li>
					<li class="tag filter" data-value=".f-darkgreen" data-group="post-tag"><i class="fa fa-circle tag-green-dark"></i><span class="tag-title">Dark Green Tag</span></li>
					<li class="tag filter" data-value=".f-blue" data-group="post-tag"><i class="fa fa-circle tag-blue"></i><span class="tag-title">Blue Tag</span></li>
				</ul>
			</div>
			<div class="col-sm-6 tag-list">
				<ul>
					<li class="tag filter" data-value=".f-darkblue" data-group="post-tag"><i class="fa fa-circle tag-blue-dark"></i><span class="tag-title">Dark Blue Tag</span></li>
					<li class="tag filter" data-value=".f-lorem" data-group="post-tag"><i class="fa fa-circle tag-purple-dark"></i><span class="tag-title">Lorem Ipsum Dolor</span></li>
					<li class="tag filter" data-value=".f-purple" data-group="post-tag"><i class="fa fa-circle tag-purple"></i><span class="tag-title">Purple Tag</span></li>
					<li class="tag filter" data-value=".f-onsectetur" data-group="post-tag"><i class="fa fa-circle tag-brown"></i><span class="tag-title">Onsectetur Adipiscing</span></li>
					<li class="tag filter" data-value=".f-tan" data-group="post-tag"><i class="fa fa-circle tag-tan"></i><span class="tag-title">Tan Tag</span></li>
					<li class="tag filter" data-value=".f-gray" data-group="post-tag"><i class="fa fa-circle tag-gray"></i><span class="tag-title">Gray Tag</span></li>
					<li class="tag filter" data-value="check-all" data-group="post-tag"><i class="fa fa-circle tag-custom" style="color: #000; border-color: #000"></i><span class="tag-title">All</span></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<footer class="form-footer">
	<button type="button" class="btn btn-sm btn-secondary reset-filter" data-filter="*">Reset Filters</button>
	<div class="pull-sm-right">
		<button type="button" class="btn btn-sm btn-default qtip-hide">Close</button>
	</div>
</footer>