<nav class="navbar navbar-light row">
<div class="col-sm-12">
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#globalNav">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand hidden-print" href="<?php echo base_url(); ?>brands/overview"><span class="brand-logo hide-text">CoFrame</span></a>
  <div class="go-to-brands pull-xs-right">
    <a href="#" class="hide-text show-brands-toggler animated infinite pulse popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/brand_list/'.$this->user_id; ?>" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-brand-list" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="0" data-offset-y="6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body" data-popover-width="90%">Go To Brand</a>
  </div>
  
    <ul class="nav navbar-nav navbar-main bg-white collapse" id="globalNav">
      <?php
      if(isset($brand_id) AND !empty($brand_id))
      {
        ?>
        <li class="nav-item brand-title text-xs-center"><?php echo $brand->name; ?></li>
        <?php
      }
      ?>
      <li class="nav-item search-item border-gray-lighter border-top border-bottom">
        <?php
        if(isset($brand_id) AND !empty($brand_id))
        {
          ?>
          <form method="get" action="<?php echo base_url().'approvals/search'; ?>" class="form-inline form-search">
            <input type="hidden" name="slug" value="<?php echo $brand->slug; ?>" />
            <input type="text" name="search" class="form-control input-search" value="<?php echo isset($search) ? $search : ''; ?>" placeholder="Search">
            <button type="submit" class="btn btn-search"><i class="tf-icon-search"></i></button>
          </form> 
          <?php
        }
        ?>
      </li>
      <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>brands/overview">Overview</a> </li>
      <?php
      if(isset($brand_id) AND !empty($brand_id))
      {
        ?>
        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>approvals/approvals-menu/<?php echo $brand->slug; ?>">Approvals</a> </li>
        <?php
      }
      ?>      
      <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>user_preferences">Account Settings</a> </li>
      <li class="nav-item"> <a class="nav-link border-gray-lighter border-top border-bottom" href="<?php echo base_url().'tour/logout' ?>">Log out</a> </li>     
      <li>
        <div class="current-user-details">
          <div class="user-time">
            <?php
            $parent_id = NULL;
            $is_account_user = 0;
            if(empty($current_brand) AND isset($this->user_data['user_group']))
            {
              $parent_id = $this->user_data['account_id'];
              $is_account_user = 1;
            }

            if($this->user_id == $this->user_data['account_id'])
            {
              $is_account_user = 1; 
            }
            if($is_account_user == 1 OR !empty($current_brand))
            {           
              ?>
              <div class="btn btn-secondary btn-xs no-hover"><?php echo get_user_groups($this->user_id,$current_brand,$parent_id); ?></div>
              <?php
            }
            
            if(isset($brand_id) AND !empty($brand_id))
            {
              ?>
              <div class="clearfix current-time">
                <div class="pull-xs-left time-label border-gray-lighter border-right">Current<br>Brand<br>Time </div>
                <div class="pull-xs-left">
                <strong id="userTime"></strong><br>
                <span id="userTimeZone">pm CDT</span>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>
