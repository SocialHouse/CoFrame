<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>CoFrame</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="<?php echo css_url(); ?>admin/login.min.css">
    <link rel="stylesheet" href="<?php echo css_url(); ?>admin/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo css_url(); ?>admin/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo css_url(); ?>admin/main.css">
    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>
<body>

    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box" id="login_form" name="login_form" method="post" action="<?php echo base_url()."auth"; ?>">
                    <div class="sign-avatar">
                        <img src="<?php echo img_url(); ?>admin/avatar-sign.png" alt="">
                    </div>
                    <header class="sign-title">Log In</header>
                    <?php                    
                    $checked = '';
                    $password = '';
                    $email = '';
                    $user_pass=$this->input->cookie('admin_pass', TRUE);
                    $user_name=$this->input->cookie('admin_name', TRUE);
                    if((isset($user_pass) && !empty($user_pass)) && (isset($user_name) && !empty($user_name))){
                        $checked='checked="checked"';
                        $user_name = $user_name;
                        $password = $user_pass;
                    }


                    $message = $this->session->flashdata('message');
                    if(!empty($message))
                    {
                        ?>
                        <div class="alert alert-<?php echo $message['class']; ?> alert-fill alert-close alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <?php echo $message['message']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="user_name" placeholder="Username" value="<?php echo set_value('user_name',$user_name); ?>" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo set_value('password',$user_pass); ?>" />
                    </div>
                    <div class="form-group">
                        <div class="checkbox float-left">
                            <input type="checkbox" id="signed-in" name="remember_me_admin" <?php echo $checked; ?> />
                            <label for="signed-in">Remember password</label>
                        </div>
                       <!--  <div class="float-right reset">
                            <a href="reset-password.html">Reset Password</a>
                        </div> -->
                    </div>
                    <button type="submit" class="btn btn-rounded">Log in</button>
                    <!-- <p class="sign-note">New to our website? <a href="sign-up.html">Sign up</a></p> -->
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </form>
            </div>
        </div>
    </div><!--.page-center-->


<script src="<?php echo js_url(); ?>admin/jquery.min.js"></script>
<script src="<?php echo js_url(); ?>admin/tether.min.js"></script>
<script src="<?php echo js_url(); ?>admin/bootstrap.min.js"></script>
<script src="<?php echo js_url(); ?>admin/plugins.js"></script>
<script type="text/javascript" src="<?php echo js_url(); ?>admin/jquery.matchHeight.min.js"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
<script src="<?php echo js_url(); ?>admin/app.js"></script>
<script src="<?php echo js_url(); ?>jquery.validate.min.js"></script>
<script src="<?php echo js_url(); ?>admin/admin.js"></script>
</body>
</html>