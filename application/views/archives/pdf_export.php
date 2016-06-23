<!doctype html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<title>Timeframe</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" media="all">
	<link type="text/css" rel="stylesheet" href="<?php echo css_url(); ?>style.css" media="all">
	<link type="text/css" rel="stylesheet" href="<?php echo css_url(); ?>search.css" media="all">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	
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
					$tag_list = '' ;
					if(!empty($post->post_tags))
					{
						foreach ($post->post_tags as $key_1 => $val) 
						{
							if(empty($tag_list))
							{
								$tag_list = ''.strtolower($val['tag_name']);
							}
							else
							{
								$tag_list .= ' '.strtolower($val['tag_name']);
							}
						}				
					}
					$style = '';
					if($count > 1)
					{
						$style= 'style="page-break-before:always;"';
					}
					?>
					<div  class="row bg-white clearfix post-day" <?php echo $style; ?> >
						<div class="col-md-5 post-img day-image">
							<?php 
							$display_img = 'false';
							if(!empty($post->post_images))
							{
								foreach ($post->post_images as $img) 
								{
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$img->name)) 
									{
										if($img->type == 'images'){

											echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name.'" style="width:200px" /> ';
											$display_img = 'true';
											break;
										}elseif ($img->type == 'video') {
											echo '<video autobuffer autoloop loop controls width="100%" >
											<source src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name.'">
												<object type="'.$img->mime.'">
													<param name="src" value="/media/video.oga">
													<param name="autoplay" value="false">
													<param name="autoStart" value="0">
													<p><a href="/media/video.oga">Download this video file.</a></p>
												</object>
											</video>';
											$display_img = 'true';
											break;
										}

									}
								}
							}
							if($display_img == 'false')
							{
								echo '<img class="default-img reblog-avatar-image-thumb" src="'.img_url().'post-img-3.jpg"  width="228px"  >';
							}
							?>
						</div>
						<div class="col-md-7 post-content">
							<div class="row">
								<div class="col-md-2 outlet-list text-xs-center outlet-list">
									<i class="fa fa-<?php echo $outlet_name; ?>"><span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span></i>
								</div>
								<div class="col-md-10 post-meta">
									<span class="post-author"><?php echo $outlet_name; ?> Post By <?php echo (!empty($post->user))?$post->user :'';?>:</span>
									<span class="post-date"><?php echo date('l, m/d/y \a\t h:i A' , strtotime($post->slate_date_time )); ?> PST 
									</span>
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
											<strong>Pending Approvals <i class="icon-clock2 color-danger post-filter-popup" data-hide="false"  data-popover-id="approvals-postid-<?php echo $post->id; ?>" data-toggle="popover-ajax" data-content-src="<?php echo base_url()?>calendar/approval_list/<?php echo $post->id; ?>" data-popover-class="popover-sm popover-post-approvals" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day"></i>
											</strong>
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
							<div class="row">
								<div class="col-md-2 post-tags text-xs-center" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-<?php echo $post->id; ?>" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
									<?php 
									if(!empty($post->post_tags))
									{
										foreach ($post->post_tags as $key_1 => $val) 
										{
											echo '<i class="fa fa-circle '.strtolower($val["tag_name"]).'" style="color:'.$val["tag_color"].'"></i>';
										}
										
									}
									?>
									<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
									<div class="hidden">
										<div class="tag-list">
											<ul>
												<?php 
												if(!empty($post->post_tags))
												{
													foreach ($post->post_tags as $key_1 => $val) 
													{
														echo '<li class="tag"><i class="fa fa-circle '.strtolower($val["tag_name"]).'" style="color:'.$val["tag_color"].'"></i>'.$val["name"].'</li>';
													}
													
												}
												?>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-10">
									<h6>POST COPY</h6>
									<div class="post-body">
										<p><?php echo (!empty($post->content))? $post->content:'&nbsp;';?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
		<!-- </div> -->
	</body>
</html>