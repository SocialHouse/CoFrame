<?php
	if(!empty($post_details))
	{
		$outlet_name = $post_details->outlet_name;

		$all_phases = get_post_approvers($post_details->id);
		$user_is = '';
		$approver_status = '';
		$phase_status = '';
		$phase_id = '';
		if(isset($all_phases['result']) and !empty($all_phases['result']))
		{
			foreach($all_phases['result'] as $phase)
			{
				if($phase['user_id'] == $this->user_id)
				{
					$user_is = 'approver';
					$approver_status = $phase['status'];
					$phase_status = $phase['phase_status'];
					$phase_id = $phase['id'];
				}
			}
		}
		if(empty($view_type)){
			$view_type = 'week';
		}
?>
		<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />
		<input type="hidden" name="outlet_id" id="postOutlet" value="<?php echo $post_details->user_id; ?>" />

		<div class="row">
			<div class="col-md-12 bg-white">
				<div class="container-post-preview">
					<div id="live-post-preview-approver">
						<?php
						if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($outlet_name).".php")){
							$this->load->view('calendar/post_preview/'.strtolower($outlet_name));
						}
						?>
					</div>
					<footer class="post-content-footer">
						<span class="post-actions">
							<?php
							echo week_month_overlay_buttons($user_is,$approver_status,$phase_status,$phase_id,$post_details,$view_type);
							?>
						</span>
						<div class="btn-group" role="group">
							<?php
							// $is_edit_request = is_edit_request($post_details->id);
							// if($is_edit_request)
							// {
								?>
								<a type="button" class="btn btn-xs btn-default" href="<?php echo base_url().'edit-request/'.$post_details->id; ?>">Edit Requests</a>
								<?php
							// }
							?>
						</div>
					</footer>
				</div>
			</div>
		</div>
		<?php
			}
		?>
