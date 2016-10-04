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
			<div class="col-sm-12 bg-white">
				<div class="container-post-preview">
					<div id="live-post-preview-approver">
						<?php
						if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($outlet_name).".php")){
							$this->load->view('calendar/post_preview/'.strtolower($outlet_name));
						}
						?>
					</div>
					<?php
					$edit_req_btn = '';
					if($user_is == 'approver' OR get_user_groups($this->user_id) == "Master admin" OR  get_user_groups($this->user_id,NULL,$this->user_data['parent_id']) == "Master admin")
					{
						
						$edit_req_btn = '<a type="button" class="btn btn-xs btn-default" href="'.base_url().'"edit-request/"'.$post_details->id.'">Edit Requests</a>';
						
					}

					$btns = week_month_overlay_buttons($user_is,$approver_status,$phase_status,$phase_id,$post_details,$view_type);
					if(!empty($edit_req_btn) OR !empty($btns))
					{
						?>
						<footer class="post-content-footer clearfix">
							<?php
							echo $btns;
							echo $edit_req_btn;
							?>						
						</footer>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<?php
			}
		?>
