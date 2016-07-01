jQuery(function($) {

	$(document).on('keypress blur', '#postCopy, .single-date-select, .hour-select, .minute-select, .check-box.circle-border,.incrementer i', function() {
		create_post_validation($(this));
	});
	$(document).on('click', '.check-box.circle-border, .incrementer i', function() {
		create_post_validation($(this));
	});

	$(document).on('keypress', '.minute-select', function ( e ) {
		return isValidNumber(e, 59,$(this));
	});

	$(document).on('keypress', '.hour-select', function ( e ) {
		return isValidNumber(e, 12,$(this));
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
			var $div 		= $(this).parents().parents('div.form-group'),
				date_error 	= $('#date_error'),
				phase_no 	= 0 ,
				new_date 	= $('input[name="phase[0][approve_date]"]').val(),
				new_hour 	= $('input[name="phase[0][approve_hour]"]').val(),
				new_minute 	= $('input[name="phase[0][approve_minute]"]').val(),
				new_ampm 	= $('input[name="phase[0][approve_ampm]"]').val(),
				old_date 	= $('input[name="post-date"]').val(),
				old_hour 	= $('input[name="post-hour"]').val(),
				old_minute 	= $('input[name="post-minute"]').val(), 
				old_ampm 	= $('input[name="post-ampm"]').val() ;

			if(new_date !== ''){
				if(!compareDate(old_date,new_date)){
					date_error.text('Please enter valid date and time or Slate date must be greater than date than Approval phase 1 ');
					date_error.show();
				}
			}else{
				date_error.empty();
				date_error.show();
			}
		}
	);


	$(document).on( 'click, blur, change', 'input[name="phase[0][approve_date]"], input[name="phase[0][approve_hour]"], input[name="phase[0][approve_minute]"], input[name="phase[0][approve_ampm]"]',
		function( e )
		{
			var $div 		= $(this).parents().parents('div.form-group'),
				date_error 	= $('.phase-one-error'),
				phase_no 	= 0 ,
				new_date 	= $('input[name="phase[0][approve_date]"]').val(),
				new_hour 	= $('input[name="phase[0][approve_hour]"]').val(),
				new_minute 	= $('input[name="phase[0][approve_minute]"]').val(),
				new_ampm 	= $('input[name="phase[0][approve_ampm]"]').val(),
				old_date 	= $('input[name="post-date"]').val(),
				old_hour 	= $('input[name="post-hour"]').val(),
				old_minute 	= $('input[name="post-minute"]').val(),
				old_ampm 	= $('input[name="post-ampm"]').val() ;

			if($div.hasClass('phase-date-time-div')){
				// if user click on (Add Approval Phase(s)) button
				date_error =  $('.phase-one-error-all');
			}
			if(old_date != ''){
				console.log('old_date');
				if(old_hour != '' && old_minute !='' ){
					console.log([new_minute ,new_hour]);
					if( new_minute != '' &&  new_hour !='' ){
						console.log('dsfdsfds');
						comparePhases(old_date, new_date, date_error,phase_no);

						var st_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var ed_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;
						if(compareDateTime(ed_date, st_date)){
							date_error.text('Please enter valid date and time or Approval date must be less than Slate date');
							date_error.show();
						}else{
							date_error.text();
							date_error.hide();
						}
					}else{
						date_error.text('Please enter hour and minutes');
						date_error.show();
					}
				}else{
					$('#hm_error').text('Please enter hour and minutes');
					$('#hm_error').show();
				}
			}else{
				$('#hm_error').text('Please enter Slate date');
				$('#hm_error').show();
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
				old_date 	= $('input[name="phase[0][approve_date]"]').val(),
				old_hour 	= $('input[name="phase[0][approve_hour]"]').val(),
				old_minute 	= $('input[name="phase[0][approve_minute]"]').val(),
				old_ampm 	= $('input[name="phase[0][approve_ampm]"]').val();

			if(old_date != ''){
				if(old_hour != '' && old_minute !='' ){
					if( new_minute != '' &&  new_hour !='' ){

						comparePhases(old_date, new_date, date_error,phase_no);

						var st_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var ed_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;
						if(compareDateTime(ed_date, st_date)){
							date_error.text('Please enter valid date and time or date must be less than phase 1');
							date_error.show();
						}else{
							date_error.text();
							date_error.hide();
						}
					}else{
						date_error.text('Please enter hour and minutes');
						date_error.show();
					}
				}else{
					$('#hm_error').text('Please enter hour and minutes');
					$('#hm_error').show();
				}
			}else{
				$('#hm_error').text('Please enter hour and minutes');
				$('#hm_error').show();
			}
		}
	);

	$(document).on( 'click, blur, change', 'input[name="phase[2][approve_date]"], input[name="phase[2][approve_hour]"], input[name="phase[2][approve_minute]"], input[name="phase[2][approve_ampm]"]',
		function( e )
		{
			var date_error 	= $('.phase-three-error'),
				phase_no 	= 1 ,
				new_date 	= $('input[name="phase[2][approve_date]"]').val(),
				new_hour 	= $('input[name="phase[2][approve_hour]"]').val(),
				new_minute 	= $('input[name="phase[2][approve_minute]"]').val(),
				new_ampm 	= $('input[name="phase[2][approve_ampm]"]').val(),			
				old_date 	= $('input[name="phase[1][approve_date]"]').val(),
				old_hour 	= $('input[name="phase[1][approve_hour]"]').val(),
				old_minute 	= $('input[name="phase[1][approve_minute]"]').val(),
				old_ampm 	= $('input[name="phase[1][approve_ampm]"]').val();

			if(old_date != ''){
				if(old_hour != '' && old_minute !='' ){
					if( new_minute != '' &&  new_hour !='' ){

						comparePhases(old_date, new_date, date_error,phase_no);

						var st_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
						var ed_date = new_date+' '+new_hour+':'+new_minute+' '+new_ampm;
						if(compareDateTime(ed_date, st_date)){
							date_error.text('Please enter valid date and time or date must be less than phase 2');
							date_error.show();
						}else{
							date_error.text();
							date_error.hide();
						}
					}else{
						date_error.text('Please enter hour and minutes');
						date_error.show();
					}
				}else{
					$('#hm_error').text('Please enter hour and minutes');
					$('#hm_error').show();
				}
			}else{
				$('#hm_error').text('Please enter hour and minutes');
				$('#hm_error').show();
			}
		}
	);



	$(document).on('click','#submit-approval', function(){
		// if(){

		// }
	});


	create_post_validation = function(field){
		var $ = jQuery;
		var disable_btn = true;
		var post_copy_error = $('#post_copy_error'),
			img_error = $('#img_error'),
			date_error = $('#date_error');
			hm_error = $('#hm_error'),
			approve_date = $('input[name="phase[0][approve_date]').val(),
			approve_hour = $('input[name="phase[0][approve_hour]"]').val(),
			approve_minute = $('input[name="phase[0][approve_minute]"]').val();
			approve_ampm = $('input[name="phase[0][approve_ampm]"]').val();
			old_date 	= $('input[name="post-date"]').val(),
			old_hour 	= $('input[name="post-hour"]').val(),
			old_minute 	= $('input[name="post-minute"]').val(),
			old_ampm 	= $('input[name="post-ampm"]').val() ;

		if($(field).hasClass('single-date-select') && $(field).val() === "") {
			date_error.text('Please select date');
			date_error.show();
		}

		if($(field).hasClass('single-date-select')) {
			var startDate = new Date();
			startDate = moment(new Date (startDate)).format('YYYY-MM-DD');
			old_date = moment(new Date (old_date)).format('YYYY-MM-DD');
			if(startDate >= old_date){
				date_error.text('Please select valid date Date must be grether than today\'s date' );
				date_error.show();
				disable_btn = true;
			}else{
				date_error.text('');
				date_error.hide();				
			}
		}


		if($(field).hasClass('hour-select') && $(field).val() === "" || $(field).hasClass('minute-select') && $(field).val() === "") {
			hm_error.text('Please enter hour and minutes');
			hm_error.show();
		}
		if($(field).hasClass('hour-select') && $(field).val() > 12 || $(field).hasClass('minute-select') && $(field).val() > 60) {
			hm_error.text('Please enter valid hour and minutes');
			hm_error.show();
		}
		if(($('#postCopy').val()!='' || $('.form__file-preview').length > 0 ) ){
			post_copy_error.hide();			
			if($('.single-date-select').val() !=''){
				date_error.hide();
				if( $('.hour-select').val() != '' && $('.minute-select').val() != '' ){
					hm_error.hide();
					disable_btn = false;
					if($(".check-box.circle-border").hasClass('selected')){
						
						if( approve_date !='' && !compareDate(approve_date, old_date)){

							if( approve_hour !='' && approve_minute !=''){
								var st_date = old_date+' '+old_hour+':'+old_minute+' '+old_ampm;
								var ed_date = approve_date+' '+approve_hour+':'+approve_minute+' '+approve_ampm;
								//console.log([approve_date, old_date]);
								if(compareDateTime(ed_date,st_date)){
									console.log([approve_date, old_date]);
									disable_btn = false;
								}
							}
						}
						else {
							disable_btn = true;
						}
					}
				}
			}
		}else{
			var error_disp = false;
			if($('#postCopy').val()==''){
				post_copy_error.text('Please enter post content');
				post_copy_error.show();
				error_disp = true;
			}
			if(!error_disp){
				img_error.text('Please select images or video');
				img_error.show();
			}
		}
		equalColumns();
		console.log('disable_btn: '+disable_btn);
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
		//console.log(moment(startDate).isBefore(endDate));
		if (st_date >= end_date ) {
			if (st_hr >= end_hr ) {
				if (st_mm >= end_mm ) {
					$isValid = true ;
				}
			}
		}
		if($isValid){
			return $isValid;
		}else{
			return $isValid;
		}

	};


	isValidNumber = function(events ,limit, current_txt_box ) {
		if(events.which === 13 || events.which === 8 || events.which === 0 ) {
	    	return true
	    };
	    var currentChar = parseInt(String.fromCharCode(events.which), 10);
	    if(!isNaN(currentChar)){
	        var nextValue = current_txt_box.val() + currentChar; //It's a string concatenation, not an addition
	        if(parseInt(nextValue, 10) <= limit) {
	        	return true
	        };
	    }
	    return false;
	}

	comparePhases = function(startDate, endDate, error_div, phase_no){
		var $display_error 	= true,
			$message 		='';

		error_div.empty();
		error_div.hide();
		// start_date = moment(new Date (startDate)).format('YYYY-MM-DD');	
		// end_date = moment(new Date (endDate)).format('YYYY-MM-DD');
		
		if( startDate == '' ){
			if(phase_no == 0 ){
				$message = 'Plaese select Sdate first';
				console.log($message);
			}
			if(phase_no == 1 ){
				$message = 'Plaese select date in Phase 1';
			}
			if(phase_no == 2 ){
				$message = 'Plaese select date in Phase 2';
			}
			error_div.text($message);
			error_div.show();
		}else{
			if(compareDate(startDate, endDate)){
				$display_error = false;
			}else{
				if(phase_no == 0 ){
					$message = 'Date must be less than Sdate';
				}
				else{
					$message = 'Date must be less than Phase '+ phase_no;
				}
				error_div.text($message);
				error_div.show();
			}
		}
		if(!$display_error){
			error_div.empty();
			error_div.hide();
		}
	};

	resetAllMessage = function(){
		$('.phase-one-error').empty();
		$('.phase-one-error').hide();
		$('#date_error').empty();
		$('#date_error').hide();
		$('.phase-one-error').empty();
		$('.phase-one-error').hide();
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
		$('#date_error').empty();
		$('#date_error').hide();
		$('#post_copy_error').empty();
		$('#post_copy_error').hide();
	}

});