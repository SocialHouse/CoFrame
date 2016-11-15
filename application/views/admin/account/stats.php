<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h2>Accounts statistics</h2>				
			</div>
		</div>
	</div>
</header>
<!-- <section class="card">
	<div class="card-block"> -->
		<div class="row">
            <div class="col-sm-6">
                <article class="statistic-box red">
                    <div>
                        <div class="number"><?php echo get_brand_count($account_id); ?></div>
                        <div class="caption"><div>No of brands</div></div>
                        <!-- <div class="percent">
                            <div class="arrow up"></div>
                            <p>15%</p>
                        </div> -->
                    </div>
                </article>
            </div><!--.col-->
            <div class="col-sm-6">
                <article class="statistic-box purple">
                    <div>
                        <div class="number"><?php echo get_user_count($account_id); ?></div>
                        <div class="caption"><div>No of users</div></div>
                        <!-- <div class="percent">
                            <div class="arrow down"></div>
                            <p>11%</p>
                        </div> -->
                    </div>
                </article>
            </div><!--.col-->
            <div class="col-sm-6">
                <article class="statistic-box yellow">
                    <div>
                        <div class="number"><?php echo account_post_count($account_id); ?></div>
                        <div class="caption"><div>No of created posts</div></div>
                        <!-- <div class="percent">
                            <div class="arrow down"></div>
                            <p>5%</p>
                        </div> -->
                    </div>
                </article>
            </div><!--.col-->
            <div class="col-sm-6">
                <article class="statistic-box green">
                    <div>
                        <div class="number">
                        	<?php 
                        	$date = isset(get_last_transaction($account_id)->created_at) ? get_last_transaction($account_id)->created_at : '';
                        	if(!empty($date))
                        		echo date('Y-m-d',strtotime($date)); 
                        	?>
                        </div>
                        <div class="caption"><div>Last payment date</div></div>
                       <!--  <div class="percent">
                            <div class="arrow up"></div>
                            <p>84%</p>
                        </div> -->
                    </div>
                </article>
            </div><!--.col-->
        </div>
<!-- 	</div>
</section> -->