<!doctype html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<title>CoFrame</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
	<link rel="stylesheet" href="<?php echo css_url(); ?>print.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css"/>
	  <style type="text/css">
	  .fa {
	    display: inline;
	    font-style: normal;
	    font-variant: normal;
	    font-weight: normal;
	    font-size: 14px;
	    line-height: 1;
	    font-family: FontAwesome;
	    font-size: inherit;
	    text-rendering: auto;
	    -webkit-font-smoothing: antialiased;
	    -moz-osx-font-smoothing: grayscale;
	  }
	  </style>
</head>

	<body class="page-global">
		<div class="logo-print">
			<img alt="logo" src="assets/images/logo-black.png">
		</div>
		<h1>Archive Export: <?php echo date("n/j/Y", strtotime($start_date)) .' - '. date("n/j/Y", strtotime($end_date)); ?></h1>
		<?php 
			if(!empty($post_details))
			{
				// echo '<pre>'; print_r($post_details);echo '</pre>'; die;
				$selected_date =  date('Y-m-d',strtotime($post_details[0]->slate_date_time));
				$count = 1;
				foreach ($post_details as $key => $post) 
				{
					$outlet_name = strtolower($post->outlet_name);
					$brand_onwer = $this->user_data['account_id'];
					$brand_id = $post->brand_id;
									
					?>
					<div class="clearfix post-day">
						<div class="post-img day-image">
							<?php 
								$img_src = '';
								
								if(!empty($post->post_images))
								{
									foreach ($post->post_images as $img) 
									{

										if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$img->name)) 
										{
											if($img->type == 'images'){
												$img_src ='uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name;
												break;
											}
										}
									}
								}
								if($img_src) {									
							?>
								<img  alt="Image" height="500" style="display: -dompdf-image !important;" src="<?php echo $img_src; ?>">
							<?php } else {?>
							&nbsp;
							<?php } ?>
						</div>
						<div class="post-content">
							<div class="outlet-list">
								<i class="fa fa-<?php echo $outlet_name; ?>"></i>
							</div>
							<div class="post-meta">
								<div class="post-author">
									Post By <?php echo (!empty($post->user))?$post->user :'';?>:
								</div>
								<div class="post-date">
									<?php echo date('l, n/j/y \a\t g:i A' , strtotime($post->slate_date_time )); ?>
								</div>
								<?php 
								if($post->status == 'scheduled')
								{
								?>
									<span class="post-approval">
										<strong>All Approvals Received</strong>
									</span>
								<?php 
								}
								if($post->status == 'pending')
								{
								?>
									<span class="post-approval">
										<strong>Pending Approvals</strong>
									</span>
								<?php
								}
								if($post->status == 'posted')
								{
								?>
									<span class="post-approval">
										<strong>Published</strong>
									</span>
								<?php
								}
								?>
							</div>
							<div class="post-tags">
									<?php 
									if(!empty($post->post_tags))
									{
										echo '<strong>TAGS:</strong> ';
										foreach ($post->post_tags as $key_1 => $val) 
										{
										?>
											<?php echo $val["name"];?>  
										<?php
										}
									}
									?>
							</div>
							<div>
								<h6>POST COPY</h6>
								<div class="post-body">
									<p><?php echo (!empty($post->content))? $post->content:'&nbsp;';?></p>
								</div>
							</div>
						</div>
					</div>
					<?php
					$count++;
				}
			}
		?>
	</body>
</html>
