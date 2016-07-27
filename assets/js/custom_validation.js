jQuery(function($) {

	//update single date calendar on input blur
	// This function enable and disable the phase button 
	$('body').on('blur', '.single-date-select', function() {

		var inputVal = $(this).val();
		if(inputVal !== "") {
			startDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
			endDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');

			/* 	$activePhase  find the current active phaes 
			*	approval-phase is the  class of that phase Id like approvalPhase1 ,approvalPhase2,approvalPhase3
			* 	active is the current active Phase
			*/

			$activePhase = $(this).closest('.approval-phase.active');

			if($activePhase){

				setTimeout(function() {
					var phase_num = $activePhase.data('id') + 1;
					$('.date-preview'+phase_num).html(startDate.format('M/DD/YYYY'))

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

	$(document).on('keypress, blur, change', '#postCopy, .single-date-select, .hour-select, .minute-select, .time-input, .check-box.circle-border,.incrementer i', function() {
		create_post_validation($(this));
	});
	$(document).on('click', '.check-box.circle-border, .incrementer i', function() {
		create_post_validation($(this));
	});

	$(document).on('click', '#only_ph_one_date, #only_ph_one_hour, #only_ph_one_minute', function() {
		create_post_validation($(this));
	});

	$(document).on('click', '.check-box.circle-border', function(){
		if($('ul.timeframe-list.user-list.first-phase li div i.selected').length > 0){
			$('#submit-approval').text('Submit for Approval');
		}else{
			$('#submit-approval').text('Slate post');
		}
	});

	$(document).on( 'change','input[type="file"]', function( e ){
		e.preventDefault();
		if( $(this).attr('id') != 'fileInput'){
			create_post_validation($(this));
		}
	});

	$(document).on( 'click, blur, change', 'input[name="post-date"]',
		function( e )
		{
			var $div 		= $(this).closest('div.form-group'),
				date_error 	= $('#date_error'),
				phase_no 	= 0 ,
				new_date 	= $('#only_ph_one_date').val(),
				new_hour 	= $('#only_ph_one_hour').val(),
				new_minute 	= $('#only_ph_one_minute').val(),
				new_ampm 	= $('#only_ph_one_ampm').val();
				old_date 	= $('input[name="post-date"]').val(),
				old_hour 	= $('input[name="post-hour"]').val(),
				old_minute 	= $('input[name="post-minute"]').val(), 
				old_ampm 	= $('input[name="post-ampm"]').val() ;

			if(new_date !== ''){
				if(!compareDate(old_date,new_date)){
					date_error.text(language_message.enter_valid_datetime_slate_greater_than_date_than_approval);
					date_error.show();
				}
			}else{
				date_error.empty();
				date_error.show();
			}
		}
	);


	$(document).on( 'click, blur, change', '#ph_one_date, #ph_one_hour, #ph_one_minute, #ph_one_ampm',
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
				new_ampm 	= $('#ph_one_ampm').val();
				
			
			if(old_date != ''){

				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){
						
						var slate_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var current_ph_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;

						comparePhases(current_ph_date ,slate_date, date_error,phase_no);
						
					}else{
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
		}
	);


	$(document).on( 'click, blur, change', '#only_ph_one_date, #only_ph_one_hour, #only_ph_one_minute, #only_ph_one_ampm',
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
				new_ampm 	= $('#only_ph_one_ampm').val();
			
			if(old_date != ''){
				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){

						var slate_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var current_ph_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;

						comparePhases(current_ph_date ,slate_date, date_error,phase_no);
						
					}else{
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
		}
	);


	$(document).on( 'click, blur, change', 'input[name="phase[1][approve_date]"], input[name="phase[1][approve_hour]"], input[name="phase[1][approve_minute]"], input[name="phase[1][approve_ampm]"]',
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
				old_ampm 	= $('#ph_one_ampm').val();

			if(old_date != ''){
				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){

						var previous_ph_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var current_ph_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;

						comparePhases(current_ph_date ,previous_ph_date, date_error,phase_no);
						
					}else{
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
		}
	);

	$(document).on( 'click, blur, change', 'input[name="phase[2][approve_date]"], input[name="phase[2][approve_hour]"], input[name="phase[2][approve_minute]"], input[name="phase[2][approve_ampm]"]',
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
				old_ampm 	= $('input[name="phase[1][approve_ampm]"]').val();

			if(old_date != ''){
				if(old_hour != '' && old_minute !=''  && old_hour > 0 && old_hour < 13 && old_minute < 60 && old_minute >= 0 && old_ampm !='' && (old_ampm.toLowerCase() =='am' || old_ampm.toLowerCase() =='pm') ){
					if( new_minute != '' &&  new_hour !=''  && new_hour > 0 && new_hour < 13 && new_minute < 60 && new_minute >= 0 && new_ampm !='' && (new_ampm.toLowerCase() =='am' || new_ampm.toLowerCase() =='pm')){

						var previous_ph_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var current_ph_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;

						comparePhases(current_ph_date ,previous_ph_date, date_error,phase_no);

					}else{
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
		}
	);


	create_post_validation = function(field){
		
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
			if(startDate <= old_date){
				date_error.text(language_message.date_greater_than_today );
				date_error.show();
				disable_btn = true;
			}else{
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
						if($(".check-box.circle-border").hasClass('selected')){
							
							if( approve_date !='' && !compareDate(approve_date, old_date)){
								$('.phase-one-error').hide();
								if( approve_hour !='' && approve_minute !=''){
									var st_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
									var ed_date = approve_date+' '+approve_hour+':'+approve_minute+' '+approve_ampm;
									//console.log([approve_date, old_date]);
									if(compareDateTime(ed_date,st_date)){
										console.log([approve_date, old_date]);
										disable_btn = false;
									}
								}else{
									disable_btn = true;
									$('.phase-one-error').show();
									$('.phase-one-error').text(language_message.enter_hour_minutes);
								}
							}
							else {
								disable_btn = true;
								$('.phase-one-error').show();
								$('.phase-one-error').text(language_message.valid_date);
								//date_error.show();
							}
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
		toggleBtnClass("#submit-approval", disable_btn);
		//toggleBtnClass("#draft", disable_btn);
	}

	compareDate = function(startDate, endDate){
		startDate = moment(new Date (startDate)).format('YYYY-MM-DD');
		endDate = moment(new Date (endDate)).format('YYYY-MM-DD');
		if (startDate >= endDate) {
			return true;
		}else {
			return false;
		}
	};



	compareDateTime = function(startDate, endDate){
		var $isValid = false;
		st_date = moment(new Date (startDate)).format('YYYY-MM-DD H:mm');
		st_hr = parseInt(moment(new Date (startDate)).format('H'));
		st_mm = parseInt(moment(new Date (startDate)).format('mm'));

		end_date = moment(new Date (endDate)).format('YYYY-MM-DD H:mm');
		end_hr =parseInt(moment(new Date (endDate)).format('H'));
		end_mm = parseInt(moment(new Date (endDate)).format('mm'));
		console.log(moment(startDate).isBefore(endDate));
		if(moment(startDate).isBefore(endDate)){
			$isValid = true;
		}
		//console.log(moment(startDate).isBefore(endDate));
		// if (st_date >= end_date ) {
		// 	if (st_hr >= end_hr ) {
		// 		if (st_mm >= end_mm ) {
		// 			$isValid = true ;
		// 		}
		// 	}
		// }
		if($isValid){
			return $isValid;
		}else{
			return $isValid;
		}

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

/*
*	this function compare the phase date time 
*	startDate 	=  current phase date time
*	endDate 	=  previous phase date time
*	error_div 	=  Error dic to display error
*	phase_no 	=  Current phase number
*/ 
	comparePhases = function(startDate, endDate, error_div, phase_no){
		var sdate 			= $('input[name="post-date"]').val(),
			sdate_hour 		= $('input[name="post-hour"]').val(),
			sdate_minute 	= $('input[name="post-minute"]').val(), 
			sdate_ampm 		= $('input[name="post-ampm"]').val(),
			$display_error 	= true,
			message 		='';

		startDate = moment(new Date (startDate)).format('YYYY-MM-DD H:mm');

		endDate = moment(new Date (endDate)).format('YYYY-MM-DD H:mm');

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
				console.log(slate_date);
				slate_date = moment(new Date(slate_date)).format('YYYY-MM-DD H:mm');
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
							endDate = moment(new Date()).format('YYYY-MM-DD H:mm');
						}
						if (moment(startDate).isBetween(endDate, slate_date)){
							$display_error = false;
						}else{
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
					// is middel between  start date  and  previous phase 
				}
			
			error_div.text(message);
			error_div.show();
		}
		if(!$display_error){
			error_div.empty();
			error_div.hide();
			message ='';
		}
	};

	resetAllMessage = function(){
		$('.phase-one-error').empty();
		$('.phase-one-error').hide();
		$('#date_error').empty();
		$('#date_error').hide();
		$('.phase-one-error-all').empty();
		$('.phase-one-error-all').hide();
		$('.phase-two-error').empty();
		$('.phase-two-error').hide();
		$('.phase-three-error').empty();
		$('.phase-three-error').hide();
		$('#hm_error').empty();
		$('#hm_error').hide();
		$('#img_error').empty();
		$('#img_error').hide();
		$('#post_copy_error').empty();
		$('#post_copy_error').hide();
	}

});