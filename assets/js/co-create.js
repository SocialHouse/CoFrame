var $ = jQuery;
// var sessionId = '2_MX40NTYxNzExMn5-MTQ2Nzc4ODIzMDcwM35EZlQ5dDB4NlYyOWxXNlQxUHdhZmJzRWV-UH4';
// // var apiKey = '<?php echo $this->config->item('opentok_key'); ?>';
// var token = 'T1==cGFydG5lcl9pZD00NTYxNzExMiZzaWc9YmJhOTMyNzQzMDg1ZGE0OWZlZWZhNDY0OGFkMDhlZWMzNWY5NGYxZjpzZXNzaW9uX2lkPTJfTVg0ME5UWXhOekV4TW41LU1UUTJOemM0T0RJek1EY3dNMzVFWmxRNWREQjRObFl5T1d4WE5sUXhVSGRoWm1KelJXVi1VSDQmY3JlYXRlX3RpbWU9MTQ2Nzc4ODIzMiZyb2xlPXB1Ymxpc2hlciZub25jZT0xNDY3Nzg4MjMyLjQzOTgxNDcyNTk0NTUz';
var session;
var publisher;
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

    $('.approve-cocreate').on('click',function(){
    	var req_id = $(this).data('req-id');
    	var btn = this;
    	$.ajax({
			url:base_url+'co_create/approve_cocreate',
			type:'post',
			data:{req_id:req_id},
			dataType: 'json',
			success:function(response)
			{
				if(response.response == 'success')
				{
					$(btn).prop('disabled',true);
					$(btn).addClass('btn-disabled');
					$(btn).text('Approved');
				}
				else
				{
					$(btn).prop('disabled',false);
					$(btn).removeClass('btn-disabled');
					$(btn).text('Approve Post');	
				}
			}
		});
    });

    jQuery(document).on('click','.add-approvers',function(){
    	var selected_approvers = [];
		$('.check-box.selected').each(function(a,b){
			selected_approvers.push($(this).data('value'))
		})
		console.log(selected_approvers);
		if(selected_approvers.length)
		{
			$.ajax({
				url:base_url+'co_create/add_participants',
				type:'post',
				data:{selected_users:selected_approvers,request_string: $('#co_create_req_id').val(),slug: $('#slug').val(),'brand_id':$('#brand_id').val(),'on_cocreate_post':1},
				success:function(response)
				{
					
				}
			});
		}
	});	

	$(document).on('click','#toogle-vide-aud',function(){
		console.log(publisher);
		if($(this).is(':checked'))
		{
			session.publish(publisher);
			// publisher.publishAudio(false);
			publisher.publishAudio(true);
			publisher.publishVideo(true);
		}
		else
		{
			session.unpublish(publisher);
			publisher.publishAudio(false);
			publisher.publishVideo(false);	
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
		//var userData = event.from.data.split(','); 
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

		SpeakerDetection(subscriber, function() {
			console.log(subscriber.id);
			$('#subscriber').find('#'+subscriber.id).show();
		  	console.log('started talking');
		}, function() {
			$('#subscriber').find('#'+subscriber.id).hide();
		  	console.log('stopped talking');
		});		

		$('#subscriber').removeClass('hidden');

	});

	session.on('sessionDisconnected', function(event) {
		console.log(event);
		console.log(language_message.disconnected_from_session, event.reason);
	});

	// Connect to the session
	session.connect(token, function(error) {
		// If the connection is successful, initialize a publisher and publish to the session
		if (!error) {
			var targetElement = 'publisherContainer';
			console.log(session.capabilities.publish);
			// var pubOptions = {publishAudio:true, publishVideo:true};
			publisher = OT.initPublisher('publisher', {
				insertMode: 'append',
				width: '100%',
				height: '100%',
				name: $('#full_name').val(),
				publishAudio:true, 
				publishVideo:true
			},function(error){
				// console.log(error.message);
			});
		  	session.publish(publisher);
			if(!$('#subscriber').hasClass('hidden')) {
				$('#publisher').removeClass('hidden');
			}
		} else {
		  console.log(language_message.connecting_error_session, error.code, error.message);
		}
    });

   // Receive a message and append it to the history	
  	session.on('signal:msg', function(event) {
  		var userData = event.from.data.split(',');
  		var className = event.from.connectionId === session.connection.connectionId ? 'sent' : 'receive';
  		
  		var msg_div = '<div class="msg_container base_'+className+'" data-id="'+event.from.connectionId+'">';
		var msg_div_img = '<img width="36" height="36" class="circle-img" src="'+userData[2]+'">';
		var comment = '<div class="comment msg_'+className+'">';
		comment += event.data;
		comment += '</div>';
		var append_div = msg_div_img+comment;
		if(className == 'sent') {
			append_div = comment+msg_div_img;
		}
		msg_div += append_div;
		msg_div += '</div>';
  		$('.discussion-list .chat-panel').append(msg_div);

		var participants = $('#participants').text()
		if(participants.indexOf(userData[0]) === -1)
		{
			if(participants.length > 0)
			{
				var append_text = participants+','+userData[0];	
			}
			else
			{
				var append_text = userData[0];
			}
			if(user_data.first_name.toLowerCase() != userData[0].toLowerCase()) {
				$('#participants').text(append_text);
			}
		}
	});

	var SpeakerDetection = function(subscriber, startTalking, stopTalking) {	
	  	var activity = null;
		subscriber.on('audioLevelUpdated', function(event) {
			var now = Date.now();
			if (event.audioLevel > 0.3) {
				if (!activity) {
					activity = {timestamp: now, talking: false};
				} else if (activity.talking) {
					activity.timestamp = now;
				} else if (now- activity.timestamp > 1000) {
					// detected audio activity for more than 1s
					// for the first time.
					activity.talking = true;
					if (typeof(startTalking) === 'function') {
						startTalking();
					}
				}
			} else if (activity && now - activity.timestamp > 3000) {
				// detected low audio activity for more than 3s
				if (activity.talking) {
					if (typeof(stopTalking) === 'function') {
						stopTalking();
					}
				}
				activity = null;
			}
		});
	};
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