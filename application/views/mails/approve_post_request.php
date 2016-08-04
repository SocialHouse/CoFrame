<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Approve post</title>
  </head>
  <body>
    <div id="wrapper">
      <div class="content">
        <p><i>Hi <?php echo $name ?>,</i></p><br>
        <p>Please approve <?php echo get_outlet_by_id($post_details->outlet_id); ?> post created by <?php echo get_users_full_name($owner_id); ?> </p>
      </div>
      
    </div>
  </body>
</html>

