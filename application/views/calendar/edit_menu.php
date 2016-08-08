<?php 
if(!empty($post_id) && !empty($slug)){
?>
	<div class="edit-menu list-group">
		<?php
		if($user_is != 'approver')
		{
			?>
			<ul class="list-group-item">
				<li><a href="#" data-clear="yes" data-modal-src="<?php echo base_url()?>calendar/edit_post_calendar/day/<?php echo $slug.'/'.$post_id; ?>" data-toggle="modal-ajax" data-modal-id="edit-post-id<?php echo $post_id; ?>" data-modal-size="lg">Edit</a></li>				
				<li><a href="#">Post Now</a></li>
			</ul>
		<?php
		}
		?>
		<ul class="list-group-item">
			<?php
			if($user_is == 'approver')
			{
				?>
				<li><a href="<?php echo base_url().'edit-request/'.$post_id; ?>">Edit Requests</a></li>
				<?php
			}
			else
			{
				?>
				<li><a href="<?php echo base_url().'edit-request/'.$post_id; ?>">Edit Requests</a></li>
				<?php
			}
			?>				
		</ul>
		
		<?php
		if($user_is != 'approver')
		{
			?>
			<ul class="list-group-item">
				<li><a href="#" class="delete_post" data-post-id="<?php echo $post_id ; ?>">Delete</a></li>
				<li><a href="#" class="duplicate-post" data-post-id="<?php echo $post_id;?>">Duplicate</a></li>
			</ul>
			<?php
		}
		?>
	</div>
<?php 
}
?>