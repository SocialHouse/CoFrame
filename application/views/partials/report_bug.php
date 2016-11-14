<form action="<?php echo base_url().'brands/create_ticket'; ?>" method="POST" enctype="multipart/form-data" id="report-bug">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="role" value="<?php echo $role; ?>" />
	<input type="hidden" name="current_brand" value="<?php echo $current_brand; ?>" />
	<div class="form-group">
		<label for="subject">Subject:</label>
		<input type="text" class="form-control form-control-sm" id="subject" name="subject">
		<div class="error hide" id="bug-error">Please enter the subject</div>
	</div>

	<div class="form-group">
		<label for="description">Description:</label>
		<textarea class="form-control description" id="description" name="description" rows="2" placeholder="Type bug description..."></textarea>
	</div>
	<div class="form-group">
		<label for="attachment">Attachment:</label><br/>
		<input type="file" id="attachment" name="attachment" />
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-sm btn-default close-bug-model">Cancel</button>
		<button type="button" class="btn btn-xs pull-sm-right btn-secondary send">Send</button>
	</div>
</form>