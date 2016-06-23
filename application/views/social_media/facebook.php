<input id="connect" type="button" value="Connect with Twitter" />
 <a href="signout.php">Sign Out</a>


 <script type='text/javascript' src='<?php echo js_url(); ?>jquery.js?ver=1.0.0'></script>
 <script type='text/javascript' src='<?php echo js_url(); ?>twitter.js?ver=1.0.0'></script>
 <script type="text/javascript">
 	var base_url = '<?php echo base_url(); ?>'
 	$('#connect').click(function(){
        $.oauthpopup({
            path: base_url+'twitter_connect/twitter',
            callback: function(){
            	alert('clode');
                // window.location.reload();
            }
        });
    });
 </script>