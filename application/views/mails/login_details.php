<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login Detasil</title>
  </head>
  <body>
    <div id="wrapper">
      <div class="content">
        <p>Hi <?php echo ucfirst($user['first_name']); ?>,</p><br><br>
        <p>Below are your login details for TIMEFRAME</p><br>
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Password: <?php echo $user['password']; ?></p>
      </div>      
    </div>
  </body>
</html>

