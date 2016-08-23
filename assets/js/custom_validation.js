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
})


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
 	phase1_error 		= $('.phase-one-error'),

 	$('#post-details .outlet-list li').each(function(i, elm) {
 		if(!$(elm).hasClass('disabled')){
 			is_outlet_selected = true;
 		}
 	});

 	if(!is_outlet_selected){
 		outlet_error.show();
 		outlet_error.text('Please select outlet');
 	}else{
 		outlet_error.hide();
 		outlet_error.empty();
 		if(($('#postCopy').val()!='' || $('.form__file-preview').length > 0 ) ){
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
 									disable_btn = false;
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
							if(phaseValidation()){
								disable_btn = false;
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

window.phaseValidation = function phaseValidation() {
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
		if(disable_save_phase_btn){
			return false;
		}else{
			return true;
		}
}


window.convertDateFormat = function convertDateFormat(userDate) {
	var result;
	if(userDate){
		result = moment(new Date (userDate)).format('YYYY-MM-DD H:mm');
	}else{
		result = moment(new Date ()).format('YYYY-MM-DD H:mm');
	}
	return result;
}

isValidNumber = function(events, limit, current_txt_box ) {
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
