
<!doctype html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<title>Timeframe</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php echo css_url(); ?>bootstrap.min.css"> 
	<link rel="stylesheet" href="<?php echo css_url(); ?>style.css"/>
	<link rel="stylesheet" href="<?php echo css_url(); ?>search.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css"/>
	  <style type="text/css">
	  .fa {
	    display: inline;
	    font-style: normal;
	    font-variant: normal;
	    font-weight: normal;
	    font-size: 14px
	    line-height: 1;
	    font-family: FontAwesome;
	    font-size: inherit;
	    text-rendering: auto;
	    -webkit-font-smoothing: antialiased;
	    -moz-osx-font-smoothing: grayscale;
	  }
	  .bg-outlet {
			left: -9px;
			position: absolute;
			top: -0.667rem;
			z-index: 0;
		}
	  </style>
</head>

	<body class="page-global">
		<!-- <div class="container container-head"> -->
			<?php 
			if(!empty($post_details))
			{
				//echo '<pre>'; print_r($post_details);echo '</pre>'; die;
				$selected_date =  date('Y-m-d',strtotime($post_details[0]->slate_date_time));
				$count = 1;
				foreach ($post_details as $key => $post) 
				{
					$outlet_name = strtolower($post->outlet_name);
					$brand_onwer = $post->created_by;
					$brand_id = $post->brand_id;
					$style = '';
					$style_prop = '';
					if($count > 1)
					{
						// send page
						$style .= ' page-break-before:always;';
						$style_prop = ' transform: rotate(140deg);margin-top: 3.6%; left: 1px;';
					}
					else
					{
						// first page
						$style_prop = 'transform: rotate(140deg); margin-top: 2.06%; left: -13px;';
					}
					?>
					<div  class="row bg-white clearfix post-day" style="margin:2rem 10px 0; <?php echo $style?>" >
						<div class="col-md-7" style="float: right; width:45%;margin:0px;padding:0px;"">
							<div class="row clearfix" style="margin:0px;padding:0px;"">
								<div class="col-md-12 outlet-list outlet-list">
									<i class="fa fa-<?php echo $outlet_name; ?>">
										<span class="bg-outlet bg-<?php echo $outlet_name; ?>" style="<?php echo $style_prop; ?>"></span>
										<?php echo $outlet_name; ?>
									</i>
								</div>
								<br/>
								<div class="col-md-12 post-meta" style="padding-top:5px">
									<div class="post-author">
										<br/>Post By <?php echo (!empty($post->user))?$post->user :'';?>:
									</div>
									<div class="post-date">
										<?php echo date('l, m/d/y \a\t h:i A' , strtotime($post->slate_date_time )); ?> PST 
									</div>
									<?php 
									if($post->status == 'scheduled')
									{
										?>
										<span class="post-approval">
											<strong>All Approvals Received 
												<i class="fa fa-check-circle color-success"></i>
											</strong>
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
											<strong>Published 
												<i class="fa fa-globe color-gray-lighter"></i>
											</strong>
										</span>
										<?php
									}
									?>
								</div>
							</div>
							<div class="row" >
								<div class="col-md-2" style="margin:0px;padding-top:0px;" >
									<?php 
									if(!empty($post->post_tags))
									{
										foreach ($post->post_tags as $key_1 => $val) 
										{
											?>
											<i class="fa fa-circle" style="color:<?php echo $val["tag_color"]; ?>"></i> <?php echo $val["name"];?><br/>
											<?php
										}
										
									}
									?>
								</div>
								<div class="col-md-10" style="padding-top:10px">
									<h6>POST COPY</h6>
									<div class="post-body">
										<p><?php echo (!empty($post->content))? $post->content:'&nbsp;';?></p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-5" style="width:45%;" >
							<?php 
								$img_src = base_url().'assets/images/post-img-3.jpg';
								if(!empty($post->post_images))
								{
									foreach ($post->post_images as $img) 
									{
										if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$img->name)) 
										{
											if($img->type == 'images'){
												$img_src = base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name;
												break;
											}
										}
									}
								}
							?>
							<img style="width:300px;display: inline; display: -dompdf-image !important;" src="<?php echo $img_src; ?>">
						</div>
					</div>
					<?php
					$count++;
				}
			}
			?>
		<!-- </div> -->
	</body>
</html>
