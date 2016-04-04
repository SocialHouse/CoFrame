<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reset password</title>
  </head>
  <body>
    <div id="wrapper">
      <div class="content">
        <p><i>Hi <?php echo $user->name;?>,</i></p>
        <a href="<?php echo base_url();?>welcome/verify_user/<?php echo $user->login_verify_token;?>">Click on link to veryfy user</a>
      </div>
      
    </div>
  </body>
</html>

