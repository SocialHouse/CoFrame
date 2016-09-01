var $ = jQuery;
var compare_array = ['year', 'month', 'week', 'day', 'hour', 'minute', 'second'];

$(document).on('click','.first-phase li .pull-sm-left .check-box' ,function(){
	var txt;
	if($(".first-phase li .pull-sm-left .check-box.circle-border").hasClass('selected')){
		txt = 'Submit for Approval';
	}else{
		txt = 'Slate Post';		
	}
	$('#submit-approval').text(txt);
});


window.create_post_validation = function create_post_validation(){
 	var disable_btn 	= true,
 	is_outlet_selected 	= false,
 	post_copy_error 	= $('#post_copy_error'),
 	outlet_error		= $('#outlet_error'),
 	img_error 			= $('#img_error'),

 	slate_date 			= $('input[name="post-date"]').val(),
 	slate_hour 			= $('input[name="post-hour"]').val(),
 	slate_minute 		= $('input[name="post-minute"]').val(),
 	slate_ampm 			= $('input[name="post-ampm"]').val(),
 	date_error 			= $('#date_error'),
 	hm_error 			= $('#hm_error'),

 	phase1_date 		= $('#only_ph_one_date').val(),
 	phase1_hour 		= $('#only_ph_one_hour').val(),
 	phase1_minute 		= $('#only_ph_one_minute').val(),
 	phase1_ampm 		= $('#only_ph_one_ampm').val();
 	phase1_error 		= $('.phase-one-error');
 	outlet_const		= $('#postOutlet').attr('data-outlet-const') ;

 	$('#post-details .outlet-list li').each(function(i, elm) 
 	{
 		if(!$(elm).hasClass('disabled')){
 			is_outlet_selected = true;
 		}
 	});

 	reset_outlet_validation();

 	if(!is_outlet_selected)
 	{
 		outlet_error.show();
 		outlet_error.text('Please select outlet');
 	}else{
 		outlet_error.hide();
 		outlet_error.empty(); 
 		if(($('#postCopy').val()!='' || $('.form__file-preview').length > 0 ) || outlet_const == 'tumblr')
 		{
 			post_copy_error.hide();
 			if(slate_date !='' && !moment(slate_date, 'YYYY-MM-DD', true).isValid()){
 				hm_error.empty();
 				hm_error.hide();
 				date_error.empty();
 				date_error.hide();

 				if( slate_hour != '' && slate_minute != '' && slate_hour > 0 && slate_hour < 13 && slate_minute < 60 && slate_minute >= 0 && slate_ampm !='' && (slate_ampm.toLowerCase() =='am' || slate_ampm.toLowerCase() =='pm')){
 					hm_error.hide();
 					disable_btn = false;
 					var slate_date = slate_date+' '+slate_hour+':'+slate_minute+' '+slate_ampm;
 					slate_date = convertDateFormat(slate_date);
 					var today = convertDateFormat('');
 					
 					if(moment(slate_date).isAfter(today, compare_array)){
 						if($(".first-phase li .pull-sm-left .check-box.circle-border").hasClass('selected')){
 							if( phase1_date !='' && phase1_hour !='' && phase1_minute !='' ){
 								phase1_error.hide();
 								var ed_date = phase1_date+' '+phase1_hour+':'+phase1_minute+' '+phase1_ampm;
 								ed_date = convertDateFormat(ed_date);
 								console.log([today,ed_date,slate_date]);
 								if (moment(ed_date).isBetween(today, slate_date, compare_array)){
 									if(outlet_validation(outlet_const)){
 										// outlet_validation(outlet_const);
 										disable_btn = false;
 									}
 									else{
 										disable_btn = true;
 									}
 								}else{
 									disable_btn = true;
 									phase1_error.text( language_message.phase_one_date_error);
 									phase1_error.show();
 								}
 							}
 							else {
 								var msg ='';
 								if(phase1_date == ''){
 									msg = language_message.valid_date;
 								}else{
 									msg = language_message.enter_hour_minutes;
 								}
 								phase1_error.show();
 								phase1_error.text(msg);
 								disable_btn = true;
								//date_error.show();
							}
						}else{
							if(outlet_validation(outlet_const)){
								if(phaseValidation()){
									disable_btn = false;
								}else{
									disable_btn = true;
								}
							}else{
								disable_btn = true;
							}							
						}
					}else{
						console.log(slate_date);
						disable_btn = true;
						hm_error.text(language_message.valid_hour_minutes);	
						hm_error.show();					
					}						
				}else{
					if($('.hour-select').val() == '' && $('.minute-select').val() == ''){
						hm_error.text(language_message.enter_hour_minutes);
						hm_error.show();
					}else{
						hm_error.text(language_message.valid_hour_minutes);
						hm_error.show();
					}
				}
			}else{
				hm_error.text(language_message.valid_date);
				hm_error.show();
			}
		}else{
			var error_disp = false;
			if($('#postCopy').val()==''){
				post_copy_error.text(language_message.enter_post_content);
				post_copy_error.show();
				error_disp = true;
			}
			if(!error_disp){
				img_error.text(language_message.select_image_video);
				img_error.show();
			}
		}			
	}

	if(disable_btn){
		return false;
	}
	else{
		return true;
	}
}

window.phaseValidation 	= function phaseValidation() {
	var disable_save_phase_btn 	= true,
	 	img_error 		= $('#img_error'),
	 	slate_date 		= $('input[name="post-date"]').val(),
	 	slate_hour 		= $('input[name="post-hour"]').val(),
	 	slate_minute 	= $('input[name="post-minute"]').val(),
	 	slate_ampm 		= $('input[name="post-ampm"]').val(),
	 	date_error 		= $('#date_error'),
	 	hm_error 		= $('#hm_error'),

	 	phase1_date 	= $('#ph_one_date').val(),
	 	phase1_hour 	= $('#ph_one_hour').val(),
	 	phase1_minute 	= $('#ph_one_minute').val(),
	 	phase1_ampm 	= $('#ph_one_ampm').val(),
	 	phase1_error 	= $('.phase-one-error-all'),

		phase2_date 	= $('#ph_two_date').val(),
	 	phase2_hour 	= $('#ph_two_hour').val(),
	 	phase2_minute 	= $('#ph_two_minute').val(),
	 	phase2_ampm 	= $('#ph_two_ampm').val(),
	 	phase2_error 	= $('.phase-two-error'),

	 	phase3_date 	= $('#ph_three_date').val(),
	 	phase3_hour 	= $('#ph_three_hour').val(),
	 	phase3_minute 	= $('#ph_three_minute').val(),
	 	phase3_ampm 	= $('#ph_three_ampm').val(),
	 	phase3_error 	= $('.phase-three-error');

	 	var phs1_date_time,phs2_date_time,phs3_date_time;
	 	var today = convertDateFormat('');
	 	var slate_date = slate_date+' '+slate_hour+':'+slate_minute+' '+slate_ampm;
		slate_date = convertDateFormat(slate_date);
		if(slate_date ==''|| slate_hour==''|| slate_minute ==''|| slate_ampm ==''){
			phase1_error.text(language_message.select_sdate);
			phase1_error.show();
			phase2_error.text(language_message.select_sdate);
			phase2_error.show();
			phase3_error.text(language_message.select_sdate);
			phase3_error.show();
			return false;
		}else{
			phase1_error.empty();
			phase1_error.hide();
			phase2_error.empty();
			phase2_error.hide();
			phase3_error.empty();
			phase3_error.hide();
		}

		if($("#approvalPhase1 ul li div").hasClass('user-img') || $("#approvalPhase2 ul li div").hasClass('user-img') || $("#approvalPhase2 ul li div").hasClass('user-img')){

			if($("#approvalPhase1 ul li div").hasClass('user-img')){
				if( phase1_date !='' && phase1_hour !='' && phase1_minute !='' ){
					phase1_error.hide();
					var phs_date = phase1_date+' '+phase1_hour+':'+phase1_minute+' '+phase1_ampm;
					phs1_date_time = convertDateFormat(phs_date);
					console.log([today,phs1_date_time,slate_date]);
					if (moment(phs1_date_time).isBetween(today, slate_date, compare_array)){
						disable_save_phase_btn = false;
					}else{
						disable_save_phase_btn = true;
						phase1_error.text( language_message.phase_one_date_error);
						phase1_error.show();
					}
				}
				else {
					var msg ='';
					if(phase1_date == ''){
						msg = language_message.valid_date;
					}else{
						msg = language_message.enter_hour_minutes;
					}
					phase1_error.show();
					phase1_error.text(msg);
					disable_save_phase_btn = true;
				}
			}

			if($("#approvalPhase2 ul li div").hasClass('user-img')){

				if( phase2_date !='' && phase2_hour !='' && phase2_minute !='' ){
					phase2_error.hide();
					var phs_date = phase2_date+' '+phase2_hour+':'+phase2_minute+' '+phase2_ampm;
					phs2_date_time = convertDateFormat(phs_date);
					console.log([phs1_date_time,phs2_date_time,slate_date]);
					if (moment(phs2_date_time).isBetween(phs1_date_time, slate_date, compare_array)){
						disable_save_phase_btn = false;
					}else{
						disable_save_phase_btn = true;
						phase2_error.text( language_message.phase_two_date_error);
						phase2_error.show();
					}
				}
				else {
					var msg ='';
					if(phase2_date == ''){
						msg = language_message.valid_date;
					}else{
						msg = language_message.enter_hour_minutes;
					}
					phase2_error.show();
					phase2_error.text(msg);
					disable_save_phase_btn = true;
				}
			}

			if($("#approvalPhase3 ul li div").hasClass('user-img')){
				if( phase3_date !='' && phase3_hour !='' && phase3_minute !='' ){
					phase1_error.hide();
					var phs_date = phase3_date+' '+phase3_hour+':'+phase3_minute+' '+phase3_ampm;
					phs3_date_time = convertDateFormat(phs_date);
					console.log([phs2_date_time,phs3_date_time,slate_date]);
					if (moment(phs3_date_time).isBetween(phs2_date_time, slate_date, compare_array)){
						disable_save_phase_btn = false;
					}else{
						disable_save_phase_btn = true;
						phase3_error.text( language_message.phase_three_date_error);
						phase3_error.show();
					}
				}
				else {
					var msg ='';
					if(phase1_date == ''){
						msg = language_message.valid_date;
					}else{
						msg = language_message.enter_hour_minutes;
					}
					phase3_error.show();
					phase3_error.text(msg);
					disable_save_phase_btn = true;
				}
			}
		}else{
			disable_save_phase_btn 	= false;
		}

		
		if(disable_save_phase_btn){
			return false;
		}else{
			return true;
		}
}

window.outlet_validation = function outlet_validation(outlet_const){
	var is_valid_all_fields = false;

	if(outlet_const =='tumblr'){
		return tumblr_validation();
	}

	if(outlet_const =='pinterest'){
		return pinterest_validation();
	}

	if(outlet_const =='youtube'){
		return youtube_validation();
	}

	if(outlet_const =='linkedin'){
		return linkedin_validation();
	}

	if(outlet_const =='instagram'){
		return instagram_validation();
	}

	if(outlet_const =='twitter'){
		return twitter_validation();
	}

	if(outlet_const =='facebook'){
		return facebook_validation();
	}
	return is_valid_all_fields;
}

window.reset_outlet_validation = function youtube_validation(){

	$('.tumblr_error').empty();
	$('.tumblr_error').hide();

	$('.youtube_error').empty();
	$('.youtube_error').hide();

	$('.instagram_error').empty();
	$('.instagram_error').hide();

	$('.twitter_error').empty();
	$('.twitter_error').hide();

	$('.linkedin_error').empty();
	$('.linkedin_error').hide();

	$('.pinterest_error').empty();
	$('.pinterest_error').hide();

	$('.facebook_error').empty();
	$('.facebook_error').hide();

	$('#img_error').empty();
	$('#img_error').hide();

	$('#post_copy_error').empty();
	$('#post_copy_error').hide();
}

window.tumblr_validation = function tumblr_validation(){
	var selected_type = $('#tumblrContent').val();
	selected_type = selected_type.toLowerCase();

	if(selected_type == "text"){
		var tb_text_title 	= $('#tb_text_title').val(),
			tumblrPostCopy 	= $('#tumblrPostCopy').val(),
			tbUrl 			= $('#tbUrl').val(),
			tb_text_error	= $('#tb_text_error'),
			tb_text_tags 	= $('#tb_text_tags').val();
		// required fields body
			if(tumblrPostCopy == ''  ){
				tb_text_error.text(language_message.enter_body);
				tb_text_error.show();
			}else{
				return true;
			}
	}
	else if(selected_type == "photo"){
		var	tbCaption 		= $('#tbCaption').val(),
			tb_photo_tags 	= $('#tb_photo_tags').val(),
			tb_photo_error	= $('#tb_photo_error'),
			tbPhotoSource 	= $('#tbPhotoSource').val();
		// required fields either source or data or data64
		if(tbPhotoSource == '' && $('.form__preview-wrapper img').length < 1){
			tb_photo_error.text(language_message.enter_url_embed_data_image);
			tb_photo_error.show();
			$('#img_error').show();
			$('#img_error').text(language_message.enter_url_embed_data_image);
		}
		else{
			return true;			
		}
	}
	else if(selected_type == "quote"){
		var	tumblrQuoteCopy = $('#tumblrQuoteCopy').val(),
			tbSource 		= $('#tbSource').val(),
			tb_quote_error	= $('#tb_quote_error'),
			tb_quote_url 	= $('#tb_quote_url').val();
		// required fields quote
		if(tumblrQuoteCopy == '' ){
			tb_quote_error.text(language_message.enter_quote);
			tb_quote_error.show();
		}
		else{
			return true;
		}
	}
	else if(selected_type == "link"){
		var	tbLink 			= $('#tbLink').val(),
			tbLinkDesc 		= $('#tbLinkDesc').val(),
			tb_link_error	= $('#tb_link_error'),
			tb_link_url 	= $('#tb_link_url').val();
		//required field url
		if(tbLink == ''){
			tb_link_error.text(language_message.enter_link);
			tb_link_error.show();
		}
		else{
			return true;
		}
	}
	else if(selected_type == "chat"){
		var tb_chat_title 	= $('#tb_chat_title').val(),
			tumblrChatCopy 	= $('#tumblrChatCopy').val(),
			tb_chat_tags 	= $('#tb_chat_tags').val(),
			tb_chat_error	= $('#tb_chat_error'),
			tb_chat_url 	= $('#tb_chat_url').val();
			//required fields conversation
		if(tumblrChatCopy == ''){
			tb_chat_error.text(language_message.enter_chat_copy);
			tb_chat_error.show();
		}
		else{
			return true;
		}
	}
	else if(selected_type == "audio"){
		var tbAudioDescr 	= $('#tbAudioDescr').val(),
			tb_audio_tags 	= $('#tb_audio_tags').val(),
			tb_audio_error	= $('#tb_audio_error'),
			tb_audio_url 	= $('#tb_audio_url').val();
		//required fields  either external_url or data
		if(tb_audio_url == '' && $('.form__preview-wrapper audio').length < 1){
			tb_audio_error.text(language_message.enter_audio_url);
			tb_audio_error.show();
			$('#img_error').show();
			$('#img_error').text(language_message.enter_audio_url);
		}
		else{
			return true;
		}
	}
	else if(selected_type == "video"){
		var tbVideoDescr 	= $('#tbVideoDescr').val(),
			tb_video_tags 	= $('#tb_video_tags').val(),
			tb_video_error	= $('#tb_video_error'),
			tbVideoSource 	= $('#tbVideoSource').val();
		//required fields either a URI, embed, or data
		if(tbVideoSource == '' && $('.form__preview-wrapper video').length < 1){
			tb_video_error.text(language_message.enter_url_embed_data_video);
			tb_video_error.show();
			$('#img_error').show();
			$('#img_error').text(language_message.enter_url_embed_data_video);
		}
		else{
			return true;
		}
	}
	return false;
}

window.youtube_validation = function youtube_validation(){
	var postCopy = $('#postCopy').val(),
		video_Title = $('#ytVideoTitle').val();
		if(video_Title =='' || !($('.form__preview-wrapper video').length)){
			if($('.form__preview-wrapper video').length < 1){
				$('#img_error').show();
				$('#img_error').text(language_message.youtube_video_error);
			}

			if(video_Title == ''){
				$('#youtube_title_error').show();
				$('#youtube_title_error').text(language_message.enter_post_content);
			}
			return false;
		}
		return true;
}

window.pinterest_validation = function pinterest_validation(){
	var postCopy 	= $('#postCopy').val(),
		pinSource 	= $('#pinSource').val(),
		bord_id 	= $('#pinterestBoard').val();

		if(postCopy =='' || bord_id =='' || $('.form__preview-wrapper img').length < 1){
			if($('.form__preview-wrapper img').length < 1){
				$('#img_error').show();
				$('#img_error').text(language_message.pinterest_upload_error);
			}
			if(bord_id == ''){
				$('#pinterest_bord_error').show();
				$('#pinterest_bord_error').text(language_message.pinterest_bord_error);
			}
			if(postCopy == ''){
				$('#post_copy_error').show();
				$('#post_copy_error').text(language_message.enter_post_content);
			}
			return false;
		}
		return true;
}

window.linkedin_validation = function linkedin_validation(){
	return true;
}

window.instagram_validation = function instagram_validation(){
	return true;
}

window.twitter_validation = function twitter_validation(){	
	return true;
}

window.facebook_validation = function facebook_validation(){
	return true;
}

window.convertDateFormat = function convertDateFormat(userDate) {
	var result;
	if(userDate){
		result = moment(new Date (userDate)).format('YYYY-MM-DD H:mm');
	}else{
		result = moment(new Date ()).format('YYYY-MM-DD H:mm');
	}
	return result;
};

window.isValidNumber = function(events, limit, current_txt_box ) {
	if(events.which === 13 || events.which === 8 || events.which === 0 ) {
		return true;
	}
	var currentVal = parseInt(current_txt_box.val(), 10);
	if(!isNaN(currentVal)){
		if(currentVal <= limit) {
		 	return true;
		}
	}
	return false;
};
