var $ = jQuery;
// var sessionId = '2_MX40NTYxNzExMn5-MTQ2Nzc4ODIzMDcwM35EZlQ5dDB4NlYyOWxXNlQxUHdhZmJzRWV-UH4';
// // var apiKey = '<?php echo $this->config->item('opentok_key'); ?>';
// var token = 'T1==cGFydG5lcl9pZD00NTYxNzExMiZzaWc9YmJhOTMyNzQzMDg1ZGE0OWZlZWZhNDY0OGFkMDhlZWMzNWY5NGYxZjpzZXNzaW9uX2lkPTJfTVg0ME5UWXhOekV4TW41LU1UUTJOemM0T0RJek1EY3dNMzVFWmxRNWREQjRObFl5T1d4WE5sUXhVSGRoWm1KelJXVi1VSDQmY3JlYXRlX3RpbWU9MTQ2Nzc4ODIzMiZyb2xlPXB1Ymxpc2hlciZub25jZT0xNDY3Nzg4MjMyLjQzOTgxNDcyNTk0NTUz';
var session;

$(document).ready(function() {		
	initializeSession(apiKey, sessionId,token);		
});	


function initializeSession(apiKey, sessionId,token) {
	session = OT.initSession(apiKey, sessionId);	  
	OT.getDevices(function(error,devices) {		
		if(!devices.length) {
			alert(language_message.video_audio_not_enabled);
		}
	});
	// Subscribe to a newly created stream
	session.on('streamCreated', function(event) {
		console.log(event.stream);
		session.subscribe(event.stream, 'subscriber', {
		  insertMode: 'append',
		  width: '100%',
		  height: '100%'
		});
	});

	session.on('sessionDisconnected', function(event) {
		console.log(language_message.disconnected_from_session, event.reason);
	});

	// Connect to the session
	session.connect(token, function(error) {
		// If the connection is successful, initialize a publisher and publish to the session
		if (!error) {
			var publisher = OT.initPublisher('publisher', {
				insertMode: 'append',
				width: '100%',
				height: '100%',
				name:'Ninad'
			});
		  	session.publish(publisher);
		} else {
		  console.log(language_message.connecting_error_session, error.code, error.message);
		}
    });

   // Receive a message and append it to the history	
  	session.on('signal:msg', function(event) {
  		var userData = event.from.data.split(',');
  		console.log(userData[2]);

  		var className = event.from.connectionId === session.connection.connectionId ? 'sent' : 'receive';
  		
  		var msg_div = '<div class="row msg_container base_'+className+'">';
	    var msg_div_img = '<div class="col-md-2 col-xs-2 avatar">';
	    msg_div_img += '<img src="'+userData[2]+'" class=" img-responsive ">'
	    msg_div_img += '</div>';

	    var msg_div_msg = '<div class="col-xs-10 col-md-10">';
	    msg_div_msg += '<div class="messages msg_'+className+'">';
	    msg_div_msg += '<p>'+event.data+'</p>';
	    msg_div_msg += '</div>';
	    msg_div_msg += '</div>';
	    var append_div = msg_div_img+msg_div_msg;
	    if(className == 'sent') {
	    	append_div = msg_div_msg+msg_div_img;
	    }
	    msg_div += append_div;
	    msg_div += '</div>';
	  	$('.panel-body').append(msg_div);
	});
}

function exceptionHandler(event) {
  console.log("Exception: " + event.code + "::" + event.message);
}

var form = document.querySelector('form');
var msgTxt = document.querySelector('#btn-input');
// Send a signal once the user enters data in the form
$('#btn-chat').on('click',function(event) {
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