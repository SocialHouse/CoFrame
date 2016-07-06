
<section id="user-preferences" class="page-main bg-white col-sm-12">
	<header class="page-main-header">
		<h1 class="center-title section-title">User Preferences</h1>
	</header>
	<select style="float:right;" onchange="javascript:window.location.href='<?php echo base_url(); ?>welcome/switch_language/'+this.value;">
	    <option value="english" <?php if($this->session->userdata('site_lang') == 'english') echo 'selected="selected"'; ?>>English</option>
	    <option value="french" <?php if($this->session->userdata('site_lang') == 'french') echo 'selected="selected"'; ?>>French</option>
	    <option value="german" <?php if($this->session->userdata('site_lang') == 'german') echo 'selected="selected"'; ?>>German</option>   
	</select>
	<div class="row">
		<?php 
			if(!empty($view_name)){
				$this->load->view('user_preferences/'.$view_name);
			}
		?>
	</div>
</section>		

