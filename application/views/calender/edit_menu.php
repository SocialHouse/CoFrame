<?php 
if(!empty($post_id) && !empty($slug)){
?>
	<div class="edit-menu list-group">
		<ul class="list-group-item">
			<li><a href="#" data-modal-src="<?php echo base_url()?>calender/edit_post_calendar/<?php echo $slug.'/'.$post_id; ?>" data-toggle="modal-ajax" data-modal-id="edit-post-id<?php echo $post_id; ?>" data-modal-size="lg">Edit</a></li>
			<li><a href="#">Schedule</a></li>
			<li><a href="#">Post Now</a></li>
		</ul>
		<ul class="list-group-item">
			<li><a href="#">View Edit Requests</a></li>
			<li><a href="#">Suggest an Edit</a></li>
		</ul>
		<ul class="list-group-item">
			<li><a href="#">Delete</a></li>
		</ul>
	</div>
<?php 
}
?>