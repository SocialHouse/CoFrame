jQuery(function($) {
	var compare_array = ['year', 'month', 'week', 'day', 'hour', 'minute', 'second'];

	//update single date calendar on input blur
	// This function enable and disable the phase button 
	$('body').on('blur', '.single-date-select', function() {

		var inputVal = $(this).val();
		if(inputVal !== "") {
			startDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
			endDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');

			/* 	$activePhase find the current active phaes 
			*	approval-phase is the  class of that phase Id like approvalPhase1 ,approvalPhase2,approvalPhase3
			* 	active is the current active Phase
			*/

			$activePhase = $(this).closest('.approval-phase.active');

			if($activePhase){

				setTimeout(function() {
					var phase_num = $activePhase.data('id') + 1;
					// $('.date-preview'+phase_num).html(startDate.format('M/DD/YYYY'))

					/*	
					*	it is used to find Approvals user is selected or not from drop doan list
					*	pull-sm-left id the class of div into ul > li
					*/
					
					if($activePhase.find('.approver-selected li .pull-sm-left').length > 2)
					{
						if($activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
						{
							var btn_num = 0;
							if($activePhase.find('[data-new-phase]').length > 1)
								btn_num = 1;
							toggleBtnClass($activePhase.find('[data-new-phase]:eq('+btn_num+')'),false)

							if($activePhase.data('id') == 0)
							{
								toggleBtnClass($('.save-phases'),false);
							}
						}
					}
					else
					{

						if($activePhase.find('[data-new-phase]').length > 1){
							btn_num = 1;
						}

						toggleBtnClass($activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);	
						
						if($activePhase.data('id') == 0)
						{
							toggleBtnClass($('.save-phases'), true );
						}
					}
				},100);
			}
		}
	});

	$(document).on('click', '.check-box.circle-border', function(){
		if($('ul.timeframe-list.user-list.first-phase li div i.selected').length > 0){
			$('#submit-approval').text('Submit for Approval');
		}else{
			$('#submit-approval').text('Slate post');
		}
	});

	$(document).on( 'change','input[type="file"]', function(e){
		e.preventDefault();
		if( $(this).attr('id') != 'fileInput'){
			create_post_validation($(this),'');
		}
	});

	$(document).on('click blur change keyup',"#postCopy, .single-date-select, .hour-select, .minute-select, .time-input, .check-box.circle-border,.slate-post .incrementer i", function () {
		create_post_validation($(this),'');
	})

	$(document).on( 'click blur change keyup', '#only_ph_one_date, #only_ph_one_hour, #only_ph_one_minute, #only_ph_one_ampm, .default_approver_time .incrementer i',
		function( e )
		{
			var $div 		= $(this).closest('div.form-group'),
				date_error 	= $('.phase-one-error'),
				phase_no 	= 0 ,
				old_date 	= $('input[name="post-date"]').val(),
				old_hour 	= $('input[name="post-hour"]').val(),
				old_minute 	= $('input[name="post-minute"]').val(),
				old_ampm 	= $('input[name="post-ampm"]').val(),
				new_date 	= $('#only_ph_one_date').val(),
				new_hour 	= $('#only_ph_one_hour').val(),
				new_minute 	= $('#only_ph_one_minute').val(),
				new_ampm 	= $('#only_ph_one_ampm').val(),
				is_error  	= true;
			
			if(old_date != ''){
				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){
						is_error = false;
					}else{
						is_error = true;
						date_error.text(language_message.enter_hour_minutes);
						date_error.show();
					}
				}else{
					date_error.text(language_message.enter_hour_minutes_slate_date);
					date_error.show();
					// $('#hm_error').text('Please enter hour and minutes');
					// $('#hm_error').show();
				}
			}else{
				date_error.text(language_message.enter_slate_date);
				date_error.show();
				// $('#hm_error').text('Please enter Slate date');
				// $('#hm_error').show();
			}

			create_post_validation($(this),is_error);
			// create post validation ();
		}
	);

	$(document).on( 'click blur change keyup', '#ph_one_date, #ph_one_hour, #ph_one_minute, #ph_one_ampm, .1-phase-time-input .incrementer i',
		function( e )
		{
			var $div 		= $(this).closest('div.form-group'),
				date_error =  $('.phase-one-error-all'),
				phase_no 	= 0 ,
				old_date 	= $('input[name="post-date"]').val(),
				old_hour 	= $('input[name="post-hour"]').val(),
				old_minute 	= $('input[name="post-minute"]').val(),
				old_ampm 	= $('input[name="post-ampm"]').val(),
				new_date 	= $('#ph_one_date').val(),
				new_hour 	= $('#ph_one_hour').val(),
				new_minute 	= $('#ph_one_minute').val(),
				new_ampm 	= $('#ph_one_ampm').val(),
				is_error  	= true;
				
			if(old_date != ''){

				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){
						
						var slate_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var current_ph_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;
						console.log([convertDateFormat(current_ph_date) ,convertDateFormat(slate_date)]);
						is_error = comparePhases(current_ph_date ,slate_date, date_error,phase_no);

					}else{
						is_error = true;
						date_error.text(language_message.enter_hour_minutes);
						date_error.show();
					}
				}else{
					date_error.text(language_message.enter_hour_minutes);
					date_error.show();
				}
			}else{
				date_error.text(language_message.enter_slate_date);
				date_error.show();
			}

			// create post validation ();
			create_post_validation($(this),is_error);
		}
	);

	$(document).on( 'click blur change keyup', 'input[name="phase[1][approve_date]"], input[name="phase[1][approve_hour]"], input[name="phase[1][approve_minute]"], input[name="phase[1][approve_ampm]"], .2-phase-time-input .incrementer i',
		function( e )
		{
			var date_error 	= $('.phase-two-error'),
				phase_no 	= 1 ,
				new_date 	= $('input[name="phase[1][approve_date]"]').val(),
				new_hour 	= $('input[name="phase[1][approve_hour]"]').val(),
				new_minute 	= $('input[name="phase[1][approve_minute]"]').val(),
				new_ampm 	= $('input[name="phase[1][approve_ampm]"]').val(),
				old_date 	= $('#ph_one_date').val(),
				old_hour 	= $('#ph_one_hour').val(),
				old_minute 	= $('#ph_one_minute').val(),
				old_ampm 	= $('#ph_one_ampm').val(),
				is_error  	= true;

			if(old_date != ''){
				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){

						var previous_ph_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var current_ph_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;

						is_error = comparePhases(current_ph_date ,previous_ph_date, date_error,phase_no);
						
					}else{
						is_error = true;
						date_error.text(language_message.enter_hour_minutes);
						date_error.show();
					}
				}else{
					$('#hm_error').text(language_message.enter_hour_minutes);
					$('#hm_error').show();
				}
			}else{
				date_error.text(language_message.enter_slate_date);
				date_error.show();
			}

			// create post validation ();
			create_post_validation($(this),is_error);
		}
	);

	$(document).on( 'click blur change keyup', 'input[name="phase[2][approve_date]"], input[name="phase[2][approve_hour]"], input[name="phase[2][approve_minute]"], input[name="phase[2][approve_ampm]"], .3-phase-time-input .incrementer i',
		function( e )
		{
			var date_error 	= $('.phase-three-error'),
				phase_no 	= 2 ,
				new_date 	= $('input[name="phase[2][approve_date]"]').val(),
				new_hour 	= $('input[name="phase[2][approve_hour]"]').val(),
				new_minute 	= $('input[name="phase[2][approve_minute]"]').val(),
				new_ampm 	= $('input[name="phase[2][approve_ampm]"]').val(),
				old_date 	= $('input[name="phase[1][approve_date]"]').val(),
				old_hour 	= $('input[name="phase[1][approve_hour]"]').val(),
				old_minute 	= $('input[name="phase[1][approve_minute]"]').val(),
				old_ampm 	= $('input[name="phase[1][approve_ampm]"]').val(),
				is_error  	= true;

			if(old_date != ''){
				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){

						var previous_ph_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var current_ph_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;

						is_error = comparePhases(current_ph_date ,previous_ph_date, date_error,phase_no);

					}else{
						is_error = true;
						date_error.text(language_message.enter_hour_minutes);
						date_error.show();
					}
				}else{
					$('#hm_error').text(language_message.enter_hour_minutes);
					$('#hm_error').show();
				}
			}else{
				$('#hm_error').text(language_message.enter_hour_minutes);
				$('#hm_error').show();
			}

			// create post validation ();
			create_post_validation($(this),is_error);
		}
	);

	/*
	*	This function compare the phase date time 
	*	startDate 	=  current phase date time
	*	endDate 	=  previous phase date time
	*	error_div 	=  Error div to display error
	*	phase_no 	=  Current phase number
	*/ 
	comparePhases = function(startDate, endDate, error_div, phase_no){
		var sdate 			= $('input[name="post-date"]').val(),
			sdate_hour 		= $('input[name="post-hour"]').val(),
			sdate_minute 	= $('input[name="post-minute"]').val(), 
			sdate_ampm 		= $('input[name="post-ampm"]').val(),
			$display_error 	= true,
			message 		='',
			is_error  		= true;

		startDate = convertDateFormat(startDate);

		endDate =convertDateFormat(endDate);

		error_div.empty();
		error_div.hide();

		if(sdate ==''  && sdate_hour == '' && sdate_minute == '' && sdate_ampm == '' ){
			if(sdate ==''){
				message =language_message.enter_slate_date;
			}else{
				if(sdate_hour == '' && sdate_minute == '' && sdate_ampm == ''){
					message = language_message.enter_hour_minutes_slate_date;
				}				
			}
		}else{
			var slate_date = sdate+' '+sdate_hour+':'+sdate_minute+' '+sdate_ampm;
			slate_date = convertDateFormat(slate_date);
			if( startDate == '' ){
				if(phase_no == 0 ){
					message = language_message.select_sdate;
				}
				if(phase_no == 1 ){
					message = language_message.select_date+phase_no;
				}
				if(phase_no == 2 ){
					message = language_message.select_date+phase_no;
				}
			}else{
					// compaire phase two with sdate and phase one(sdate is greter than phase two/three and sdate is less than phase one/two )
					// moment().isBetween(moment-like, moment-like, String);
					// where moment-like is Moment|String|Number|Date|Array
					// moment('2010-10-20').isBetween('2010-10-19', '2010-10-25'); // true
					// '2010-10-19' < '2010-10-20' > '2010-10-25'

					if(phase_no == 0){
						endDate =convertDateFormat('');
					}
					console.log([endDate,startDate,slate_date]);
					if (moment(startDate).isBetween(endDate, slate_date, compare_array)){
						$display_error = false;
						console.log('isBetween true');
					}else{
						console.log('isBetween false');
						if(phase_no == 0 ){
							message = language_message.phase_one_date_error;
						}
						if(phase_no == 1 ){
							message =language_message.phase_two_date_error;
						}
						if(phase_no == 2 ){
							message =language_message.phase_three_date_error;
						}
					}
			}
			error_div.text(message);
			error_div.show();
		}
		if(!$display_error){
			error_div.empty();
			error_div.hide();
			message ='';
			is_error = false;
		}
		return is_error;
	};

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

	convertDateFormat = function(userDate){
		var result;
		if(userDate){
			result = moment(new Date (userDate)).format('YYYY-MM-DD H:mm');
		}else{
			result = moment(new Date ()).format('YYYY-MM-DD H:mm');
		}
		return result;
	}

	create_post_validation = function(field ,checked_data){
		
		var $ = jQuery;
		var disable_btn 		= true;
		var is_outlet_selected 	= false;
		var post_copy_error 	= $('#post_copy_error'),
			outlet_error		=$('#outlet_error'),
			img_error 			= $('#img_error'),
			date_error 			= $('#date_error');
			hm_error 			= $('#hm_error'),
			approve_date 		= $('#only_ph_one_date').val(),
			approve_hour 		= $('#only_ph_one_hour').val(),
			approve_minute 		= $('#only_ph_one_minute').val(),
			approve_ampm 		= $('#only_ph_one_ampm').val(),
			old_date 			= $('input[name="post-date"]').val(),
			old_hour 			= $('input[name="post-hour"]').val(),
			old_minute 			= $('input[name="post-minute"]').val(),
			old_ampm 			= $('input[name="post-ampm"]').val() ;

		
		if($(field).hasClass('single-date-select') && $(field).val() === "") {
			date_error.text(language_message.select_re_date);
			date_error.show();
		}

		if($(field).hasClass('single-date-select')) {
			var startDate = new Date();
			startDate = moment(new Date (startDate)).format('YYYY-MM-DD');
			old_date = moment(new Date (old_date)).format('YYYY-MM-DD');
			console.log( [startDate ,old_date]);
			if(!moment(new Date (old_date)).isAfter(startDate, ['year', 'month', 'week', 'day'])){
				console.log('is_true');
				date_error.text(language_message.date_greater_than_today );
				date_error.show();
				disable_btn = true;
			}else{
				console.log('is_false');
				date_error.empty();
				date_error.hide();
			}
		}

		if($(field).hasClass('hour-select') && $(field).val() === "" || $(field).hasClass('minute-select') && $(field).val() === "") {
			hm_error.text(language_message.enter_hour_minutes);
			hm_error.show();
			disable_btn = true;
		}

		if($(field).hasClass('hour-select') && $(field).val() > 12 || $(field).hasClass('minute-select') && $(field).val() > 60) {
			hm_error.text(language_message.enter_hour_minutes);
			hm_error.show();
			disable_btn = true;
		}

		$('#post-details .outlet-list li').each(function(i, elm) {
			if(!$(elm).hasClass('disabled')){
				is_outlet_selected = true;
			}
		});

		if(!is_outlet_selected){
			outlet_error.show();
			outlet_error.text('please select outlet');
		}else{
			outlet_error.hide();
			outlet_error.empty();
			if(($('#postCopy').val()!='' || $('.form__file-preview').length > 0 ) ){
				post_copy_error.hide();
				if($('.single-date-select').val() !='' && !moment($('.single-date-select').val(), 'YYYY-MM-DD', true).isValid()){
					hm_error.empty();
					hm_error.hide();
					date_error.empty();
					date_error.hide();
					
					if( $('.hour-select').val() != '' && $('.minute-select').val() != '' && $('.hour-select').val() > 0 && $('.hour-select').val() < 13 && $('.minute-select').val() < 60 && $('.minute-select').val() >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm')){
						hm_error.hide();
						disable_btn = false;
						var slate_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						slate_date = convertDateFormat(slate_date);
						var today = convertDateFormat('');
						if(moment(slate_date).isAfter(today, compare_array)){
							if($(".check-box.circle-border").hasClass('selected')){							
								if( approve_date !='' && approve_hour !='' && approve_minute !='' ){
									$('.phase-one-error').hide();
									var ed_date = approve_date+' '+approve_hour+':'+approve_minute+' '+approve_ampm;
									ed_date = convertDateFormat(ed_date);
									console.log([today,ed_date,slate_date]);
									if (moment(ed_date).isBetween(today, slate_date, compare_array)){
										disable_btn = false;
									}else{
										disable_btn = true;
										$('.phase-one-error').text( language_message.phase_one_date_error);
										$('.phase-one-error').show();
										
									}
								}
								else {
									var msg ='';
									if(approve_date == ''){
										msg = language_message.valid_date;
									}else{
										msg = language_message.enter_hour_minutes;
									}
									$('.phase-one-error').show();
									$('.phase-one-error').text(msg);
									disable_btn = true;
									//date_error.show();
								}
							}
						}else{
							disable_btn = true;
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
		equalColumns();
		//console.log('disable_btn: '+disable_btn);
		/*
		* 	if checked_data is true means there is an error 
		*	if checked_data is false means there is no error 
		*	if disable_btn is  true  means there is an error 
		*	if disable_btn is  false means there is no error 
		*/
		if(checked_data != ''){
			if( checked_data && disable_btn)
				toggleBtnClass("#submit-approval", true);
			else
				toggleBtnClass("#submit-approval", false);
		}else{
			toggleBtnClass("#submit-approval", disable_btn);
		}		
		//toggleBtnClass("#draft", disable_btn);
	}
});