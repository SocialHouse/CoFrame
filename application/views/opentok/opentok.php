<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>OpenTok CodeIgniter 2 Sample</title>
    <script type='text/javascript' src='<?php echo js_url(); ?>vendor/jquery.js?ver=1.11.3'></script>
     <script src="https://static.opentok.com/v2/js/opentok.js"></script>
    <!-- <script type="text/javascript" src="http://static.opentok.com/webrtc/v2.0/js/TB.min.js"></script> -->
</head>
<body>
    <h2>Session ID</h2>
    <p><?php echo $sessionId; ?></p>
    <h2>Token</h2>
    <p><?php echo $token ?></p>
    <br>
    <div id="textchat">
         <p id="history"></p>
         <form>
              <input type="text" placeholder="Input your text here" id="msgTxt"></input>
         </form>
	</div>
    <div id="myPublisherDiv"></div>
</body>
</html>
<script type="text/javascript">
	var $ = jQuery;
	var sessionId = '2_MX40NTYxNzExMn5-MTQ2Nzc4ODIzMDcwM35EZlQ5dDB4NlYyOWxXNlQxUHdhZmJzRWV-UH4';
		var apiKey = '<?php echo $this->config->item('opentok_key'); ?>';
		var token = 'T1==cGFydG5lcl9pZD00NTYxNzExMiZzaWc9YmJhOTMyNzQzMDg1ZGE0OWZlZWZhNDY0OGFkMDhlZWMzNWY5NGYxZjpzZXNzaW9uX2lkPTJfTVg0ME5UWXhOekV4TW41LU1UUTJOemM0T0RJek1EY3dNMzVFWmxRNWREQjRObFl5T1d4WE5sUXhVSGRoWm1KelJXVi1VSDQmY3JlYXRlX3RpbWU9MTQ2Nzc4ODIzMiZyb2xlPXB1Ymxpc2hlciZub25jZT0xNDY3Nzg4MjMyLjQzOTgxNDcyNTk0NTUz';
		var session;
	$(document).ready(function(){		
		initializeSession(apiKey, sessionId,token);		
	});	


	function initializeSession(apiKey, sessionId,token) {
	  session = OT.initSession(apiKey, sessionId);	  
	  // Subscribe to a newly created stream
	  session.on('streamCreated', function(event) {
	    session.subscribe(event.stream, 'subscriber', {
	      insertMode: 'append',
	      width: '100%',
	      height: '100%'
	    });
	  });

	  session.on('sessionDisconnected', function(event) {
	    console.log('You were disconnected from the session.', event.reason);
	  });

	  // Connect to the session
	  session.connect(token, function(error) {
	    // If the connection is successful, initialize a publisher and publish to the session
	    if (!error) {
	    	console.log('not error');
	      var publisher = OT.initPublisher('publisher', {
	        insertMode: 'append',
	        width: '100%',
	        height: '100%'
	      });

	      session.publish(publisher);
	    } else {
	      console.log('There was an error connecting to the session: ', error.code, error.message);
	    }
	  });

	   // Receive a message and append it to the history
  		var msgHistory = document.querySelector('#history');
	  	session.on('signal:msg', function(event) {
		    var msg = document.createElement('p');
		    msg.innerHTML = event.data;
		    msg.className = event.from.connectionId === session.connection.connectionId ? 'mine' : 'theirs';
		    msgHistory.appendChild(msg);
		    msg.scrollIntoView();
		});
	}

	var form = document.querySelector('form');
		var msgTxt = document.querySelector('#msgTxt');

		// Send a signal once the user enters data in the form
		form.addEventListener('submit', function(event) {
		  event.preventDefault();

		  session.signal({
		      type: 'msg',
		      data: msgTxt.value
		    }, function(error) {
		      if (!error) {
		        msgTxt.value = '';
		      }
		    });
		});
</script>

