var $ = jQuery;
// var sessionId = '2_MX40NTYxNzExMn5-MTQ2Nzc4ODIzMDcwM35EZlQ5dDB4NlYyOWxXNlQxUHdhZmJzRWV-UH4';
// // var apiKey = '<?php echo $this->config->item('opentok_key'); ?>';
// var token = 'T1==cGFydG5lcl9pZD00NTYxNzExMiZzaWc9YmJhOTMyNzQzMDg1ZGE0OWZlZWZhNDY0OGFkMDhlZWMzNWY5NGYxZjpzZXNzaW9uX2lkPTJfTVg0ME5UWXhOekV4TW41LU1UUTJOemM0T0RJek1EY3dNMzVFWmxRNWREQjRObFl5T1d4WE5sUXhVSGRoWm1KelJXVi1VSDQmY3JlYXRlX3RpbWU9MTQ2Nzc4ODIzMiZyb2xlPXB1Ymxpc2hlciZub25jZT0xNDY3Nzg4MjMyLjQzOTgxNDcyNTk0NTUz';
var session;

$(document).ready(function() {		
	initializeSession(apiKey, sessionId,token);

	$('#send-join').click(function(){
    	var selected_users = [];
    	$('.check-box').each(function(){
    		if($(this).data('value') != 'check-all' && $(this).hasClass('selected'))
    		{
    			selected_users.push($(this).data('value'));
    		}
    	})
    	var request_string = $('#request-string').val();
    	var slug = $('#slug').val();
    	if(selected_users.length)
    	{
    		$.ajax({
    			url:base_url+'co_create/send_join_request',
    			type:'post',
    			data:{selected_users:selected_users,request_string: request_string,slug: slug},
    			success:function(response)
    			{

    			}
    		});
    	}
    });
});	


function initializeSession(apiKey, sessionId,token) {
	session = OT.initSession(apiKey, sessionId);	  
	OT.getDevices(function(error,devices) {		
		if(!devices.length) {
			getConfirm(language_message.video_audio_not_enabled,'','alert',function(confResponse) {});
			// alert(language_message.video_audio_not_enabled);
		}
	});
	// Subscribe to a newly created stream
	session.on('streamCreated', function(event) {
		var userData = event.from.data.split(','); 
		var subscriberProperties = {insertMode: 'append'};
		var subscriber = session.subscribe(event.stream,
		    'subscriber',
		    subscriberProperties,
		    function (error) {
		      if (error) {
		        console.log(error);
		      } else {
		        console.log('Subscriber added.');
		      }
		  });
	});

	session.on('sessionDisconnected', function(event) {
		console.log(language_message.disconnected_from_session, event.reason);
	});

	// Connect to the session
	session.connect(token, function(error) {
		// If the connection is successful, initialize a publisher and publish to the session
		if (!error) {
			var targetElement = 'publisherContainer';
			console.log(session.capabilities.publish);
			// var pubOptions = {publishAudio:true, publishVideo:true};
			var publisher = OT.initPublisher('publisher', {
				insertMode: 'append',
				width: '100%',
				height: '100%',
				name: $('#full_name').val(),
				publishAudio:true, 
				publishVideo:true
			},function(error){
				console.log(error.message);
			});			
		  	session.publish(publisher);
		} else {
		  console.log(language_message.connecting_error_session, error.code, error.message);
		}
    });

   // Receive a message and append it to the history	
  	session.on('signal:msg', function(event) {
  		var userData = event.from.data.split(',');
  		var className = event.from.connectionId === session.connection.connectionId ? 'sent' : 'receive';
  		
  		var msg_div = '<li data-id="'+event.from.connectionId+'">';
		msg_div += '<img width="36" height="36" class="circle-img" src="'+userData[2]+'">';
		var comment = '<div class="comment">';
		comment += '<p>'+ event.data+'</p>';
		comment += '</div>';
		var li_end = '</li>';
		if($('.discussion-list ul li:last').attr('data-id') == event.from.connectionId)
		{
			$('.discussion-list ul li:last').append(comment);
		}
		else
		{
	  		$('.discussion-list ul').append(msg_div+comment+li_end);
		}

		var participants = $('#participants span').text()
		if(participants.indexOf(userData[0]) == -1)
		{
			if(participants.length > 0)
			{
				var append_text = participants+','+userData[0];			
			}
			else
			{
				var append_text = userData[0];				
			}
			console.log(user_data.first_name);
			if(user_data.first_name.toLowerCase() != userData[0].toLowerCase())
				$('#participants span').text(append_text);
		}
		
	});
}

function exceptionHandler(event) {
  console.log("Exception: " + event.code + "::" + event.message);
}


var msgTxt = document.querySelector('#cocreate-comment');
// Send a signal once the user enters data in the form
$('#cocreate-comment').on('keydown',function(event) {
	if (event.keyCode === 13) {
	  session.signal({
		  type: 'msg',
		  data: msgTxt.value
		}, function(error) {
		  if (!error) {
			msgTxt.value = '';
		  }
		});
	}
});