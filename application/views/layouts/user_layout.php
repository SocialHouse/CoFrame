<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- <link rel="icon" href="../../favicon.ico"> -->

        <title>Timeframe</title>

        <!-- Bootstrap core CSS -->
        <link href="<?=css_url()?>bootstrap.min.css" rel="stylesheet">
        <?php    
        if(isset($css_files))
        {
            foreach ($css_files as $css_src) 
            {
                ?>
                <link href="<?php echo $css_src ?>" rel="stylesheet">
                <?php
            }
        }
        ?>
        <style type="text/css">
            body
            {
                padding-top:50px;
            }

            .main
            {
                padding: 40px 15px;
            }

            .payment-errors
            {
                display: none;
            }
        </style>
        <script type="text/javascript">
           var base_url = "<?php echo base_url(); ?>";
        </script>
        <script type='text/javascript' src='<?php echo js_url(); ?>json_message.json?ver=3.3.1?ver=3.3.1'></script>
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Timeframe</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url().'payment' ?>">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Brands<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url().'brands/overview'; ?>">Overview</a></li>
                                <li><a href="<?php echo base_url().'brands/add' ?>">Add brand</a></li>
                            </ul>
                        </li>
                        <?php
                        // print_r(get_user_groups($this->user_id));
                        if(in_array(get_user_groups($this->user_id),array('Creator','Approver')))
                        {
                            ?>
                            <li><a href="<?php echo base_url().'approvals/'.get_my_brand($this->user_id); ?>">Approvals</a></li>
                            <li><a href="<?php echo base_url().'reminders/'.get_my_brand($this->user_id); ?>">Reminders</a></li>
                            <?php  
                        }
                        ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url().'me/edit_profile'; ?>">Edit my info</a></li>
                                <li><a href="<?php echo base_url().'me/edit_billing_details' ?>">Edit billing details</a></li>
                                <li><a href="<?php echo base_url().'me/plan' ?>">Plan</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url().'tour/logout' ?>">Logout</a></li>                        
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="main">
                    <?php 
                    $message = $this->session->flashdata('message');
                    $flash_error = $this->session->flashdata('error');
                    if((isset($message) && !empty($message)) OR (isset($error) && !empty($error)) OR (isset($flash_error) && !empty($flash_error)) )
                    {
                        if(isset($message))
                        {
                            $class = 'success';
                            $flash_message = $message;
                        }
                        else
                        {                       
                            if(isset($flash_error))
                            {
                                $flash_message = $flash_error;
                            }
                            else
                            {
                                $flash_message = $error;
                            }
                            $class = 'danger';
                            
                        }
                        ?>
                        <div class="alert alert-<?php echo $class ?>">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $flash_message; ?>
                        </div>
                        <?php
                    }        
                    echo $yield; 
                    ?>
                </div>
            </div>

        </div><!-- /.container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?=js_url()?>jquery.js"></script> 
        <script src="<?=js_url()?>bootstrap.min.js"></script>
        <?php       
        if(isset($js_files))
        {
            foreach ($js_files as $js_src) 
            {
                ?>
                <script src="<?php echo $js_src; ?>"></script>
                <?php
            }
        }
        ?>
        <script src="<?=js_url()?>timeframe.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->  
    </body>
</html>
