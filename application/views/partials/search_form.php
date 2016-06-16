<form method="get" action="<?php echo base_url().'posts/search'; ?>" class="form-inline pull-xs-left form-search">
	<input type="hidden" name="slug" value="<?php echo $brand->slug; ?>" />
	<input type="text" name="search" class="form-control input-search" value="<?php echo isset($search) ? $search : ''; ?>">
	<button type="submit" class="btn btn-search"><i class="tf-icon-search"></i></button>
</form>
<a href="#" class="tf-icon-circle pull-xs-left" id="showSearch"><i class="tf-icon-search"></i></a>