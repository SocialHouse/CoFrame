<?php
$checked = '';
$password = '';
$username = '';
echo $user_pass=$this->input->cookie('user_pass', TRUE);
echo $user_name=$this->input->cookie('user_name', TRUE);
if((isset($user_pass) && !empty($user_pass)) && (isset($user_name) && !empty($user_name))){
    $checked='checked="checked"';
    $username = $user_name;
    $password = $user_pass;
}
?>
<!--Login Modal-->
<div class="modal login-modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
		        <a class="navbar-brand hidden-print" href="/">
            <span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        </a>
		<div class="visible-print-block logo-print">
       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
		</div>
	  	<h3>Log In</h3>
        <form id="loginForm">
			<div class="form-group">
				<label class="sr-only" for="username">Username</label>

				<input type="username" class="form-control" id="username" placeholder="Username" name="username" value="<?php echo set_value('username',$username); ?>">
			</div>
			<div class="form-group">
				<label class="sr-only" for="password">Password</label>
				<input type="password" class="form-control" id="login_password" placeholder="Password" name="password" value="<?php echo set_value('user_pass',$user_pass); ?>">
			</div>
			<div class="form-group">
				<div class="checkbox pull-left">
					<label>
						<input type="checkbox" <?php echo $checked; ?> name="remember_me" id="remember_me"> Remember password
					</label>
				</div>
				<a href="#recoverPassword" data-backdrop="static" data-toggle="modal" class="pull-right">Forgot password?</a>
			</div>
			<div class="text-center clear">
				<button type="submit" id="login" class="btn btn-primary btn-sm">Submit</button>
				<a href="#invalidEmail" type="button" id="loginSuccess" class="hide" data-backdrop="static" data-toggle="modal"></a>
			</div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Invalid Login Modal-->
<div class="modal fade" id="invalidEmail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		        <a class="navbar-brand hidden-print" href="/">
            <span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        </a>
		<div class="visible-print-block logo-print">
       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
		</div>
              <div class="modal-body text-center bg-white">
	  	<h5 id="fail_msg_header">Invalid Email or Password</h5>
		<hr>
		<p id="login_fail_msg">The email and/or password you entered did not match our records. Please try again.</p>
		<hr>
		<p><a href="#loginModal" class="btn btn-warning btn-sm" data-backdrop="static" data-toggle="modal" id="go_to_login">Try again</a></p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Password Recovery Modal-->
<div class="modal fade" id="recoverPassword" tabindex="-1" role="dialog" aria-hidden="true">
  	<div class="modal-dialog modal-sm" role="document">
    	<div class="modal-content">
			<a class="navbar-brand hidden-print" href="/">
            	<span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        	</a>
			<div class="visible-print-block logo-print">
	       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
			</div>
	        <div class="modal-body text-center bg-white">
			  	<h5>Password Recovery</h5>
				<hr>
				<p>Enter the email address associated with your account, and we’ll send you an email with instructions on resetting your password.</p>
		        <form id="resetPassForm">
					<div class="form-group" style="text-align: left;">
						<label class="sr-only" for="forgotEmail">Email Address</label>
						<input type="email" class="form-control" id="forgotEmail" placeholder="Email" name="email">
					</div>
					<hr>
					<div class="clearfix">
						<a href="#" class="btn btn-default btn-sm pull-left" data-dismiss="modal" aria-label="Close">Cancel</a>
						<button type="submit" id="reset_pass" class="btn btn-primary btn-sm pull-right">Submit</button>
						<a href="#recoverPasswordSuccess" class="hide" data-backdrop="static" data-toggle="modal" id="recoverSuccessBtn"></a>
					</div>
				</form>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Password Recovery Success Modal-->
<div class="modal fade" id="recoverPasswordSuccess" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		        <a class="navbar-brand hidden-print" href="/">
            <span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        </a>
		<div class="visible-print-block logo-print">
       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
		</div>
              <div class="modal-body text-center bg-white">
	  	<h5 id="recovery_header">Password Recovery</h5>
		<hr>
		<p id="recovery_message"></p>
		<hr>
		<div class="text-center">
			<a id="dismissBtn" href="#" class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">Dismiss</a>			
			<a href="#recoverPassword" class="btn btn-warning btn-sm hide" data-backdrop="static" data-toggle="modal" id="go_to_recover_pass">Try again</a>
			<a  href="#loginModal" class="btn btn-warning btn-sm" data-backdrop="static" data-toggle="modal" id="go_login">Go to login</a>
		</div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Save new password-->
<div class="modal fade" id="savePassword" tabindex="-1" role="dialog" aria-hidden="true">
  	<div class="modal-dialog modal-sm" role="document">
   		<div class="modal-content">
			<a class="navbar-brand hidden-print" href="/">
            	<span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        	</a>
			<div class="visible-print-block logo-print">
	       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
			</div>
	        <div class="modal-body text-center bg-white">
			  	<h5>Change Password</h5>
				<hr>				
		        <form id="setPassForm">
		        	<input type="hidden" id="token" value="<?php echo set_value('token',isset($token)?$token:''); ?>" name="token">
					<div class="form-group" style="text-align: left">
						<label class="sr-only" for="newPass">Password</label>
						<input type="password" class="form-control" id="newPass" placeholder="Password" name="password">
					</div>
					<div class="form-group" style="text-align: left">
						<label class="sr-only" for="forgotEmail">Cpnfirm Password</label>
						<input type="password" class="form-control" id="confirmPass" placeholder="Confirm password" name="confirm_password">
					</div>
					<hr>
					<div class="clearfix">
						<a href="#" class="btn btn-default btn-sm pull-left" data-dismiss="modal" aria-label="Close">Cancel</a>
						<button type="submit" 	id="save_pass" class="btn btn-primary btn-sm pull-right">Submit</button>
					</div>
				</form>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--verification response-->
<div class="modal fade" id="verifyResponse" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		        <a class="navbar-brand hidden-print" href="/">
            <span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        </a>
		<div class="visible-print-block logo-print">
       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
		</div>
              <div class="modal-body text-center bg-white">
	  	<h5 id="responseHeader"></h5>
		<hr>
		<p id="responseMessage"></p>
		<hr>
		<p><a href="#loginModal" class="btn btn-warning btn-sm" data-backdrop="static" data-toggle="modal" id="verifyResponseBtn">Try again</a></p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--verification response-->
<div class="modal fade" id="registerResponse" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		        <a class="navbar-brand hidden-print" href="/">
            <span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        </a>
		<div class="visible-print-block logo-print">
       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
		</div>
        <div class="modal-body text-center bg-white">	  	
		<hr>
		<p class="registerResponseText">You have registered successfully and verification link sent to your email address</p>
		<hr>

		<div class="clearfix">
			<a href="#" class="btn btn-default btn-sm pull-left" id="registerCancel" data-dismiss="modal" aria-label="Close">Cancel</a>
			<p><a id="gotTologRegister" href="#loginModal" class="btn btn-warning btn-sm pull-right" data-backdrop="static" data-toggle="modal">Go to login</a></p>

			<button type="button" class="btn btn-default btn-sm" id="registerTryAgain" data-dismiss="modal" aria-label="Close">Cancel</button>
				
		</div>
			
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
  	<div class="modal-dialog modal-sm" role="document">
    	<div class="modal-content">
			<a class="navbar-brand hidden-print" href="/">
            	<span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">Timeframe</span>
        	</a>
			<div class="visible-print-block logo-print">
	       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
			</div>
	        <div class="modal-body text-center bg-white">
			  	<h5>Create Your Account</h5>
				<hr>
		        <form id="registerSubUser">
		        	<input type="hidden" name="verification_code" id="verification_code" value="<?php echo !empty ($verification_code)? $verification_code:'' ; ?>" />
		        	<input type="hidden" name="user_id" id="user_id" value="<?php echo (!empty($user_id))? $user_id : ''; ?>" />
					<div class="form-group">
						<label class="sr-only" for="username_reg">Username</label>
						<input type="text" class="form-control" id="username_reg" placeholder="Username" name="username" >
					</div>

					<div class="form-group">
						<label class="sr-only" for="password_reg">Password</label>
						<input type="password" class="form-control" id="password_reg" placeholder="Password" name="password" value="<?php echo set_value('user_pass',$user_pass); ?>">
					</div>

					<div class="form-group">
						<label class="sr-only" for="confirm_password">Confirm password</label>
						<input type="password" class="form-control" id="confirm_password_reg" placeholder="Confirm password" name="confirm_password" value="<?php echo set_value('user_pass',$user_pass); ?>">
					</div>
					
					<hr>
					<div class="clearfix">
						<a href="#" class="btn btn-default btn-sm pull-left" data-dismiss="modal" aria-label="Close">Cancel</a>
						<button type="submit" 	id="save_pass" class="btn btn-primary btn-sm pull-right">Submit</button>
						<a href="#loginModal" type="button" id="loginSuccess" class="hide" data-backdrop="static" data-toggle="modal"></a>
					</div>
				</form>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Calender -->
<div id="calendar-select-date" class="hidden calendar-select-date">
	<div class="date-select-calendar"></div>
</div>

<!-- Delete Modal -->
<div class="modal alert-modal fade" id="deleteDrafts" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content bg-white">
			<div class="modal-body">
				<h2 class="text-xs-center">Delete Drafts</h2>
				<p class="text-xs-center">Are you sure you want to delete these drafts? You cannot undo this action.</p>
				<footer class="overlay-footer">
				<button type="button" class="btn btn-sm btn-default modal-hide go-back">Go Back</button>
				<button type="submit" class="btn btn-sm pull-sm-right btn-secondary" id="submitDeleteDrafts">Delete</button>
			</footer>
			</div>
		</div>
	</div>
</div>