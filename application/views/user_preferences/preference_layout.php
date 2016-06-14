
<section id="user-preferences" class="page-main bg-white col-sm-12">
	<header class="page-main-header">
		<h1 class="center-title section-title">User Preferences</h1>
	</header>
	<div class="row">
		<?php 
			if(!empty($view_name)){
				$this->load->view('user_preferences/'.$view_name);
			}
		?>
	</div>
</section>		

