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


	$(document).on('click, blur, change','input[name="phase[0][approve_hour]"]', function( e ){
		
		var $div 		= $(this).parents().parents('div.form-group'),
			date_error 	= $('.phase-one-error'),
			start_date 	= $('input[name="post-date"]').val(),
			end_date 	= $(this).val();

		if($div.hasClass('phase-date-time-div')){
			// if user click on (Add Approval Phase(s)) button
			date_error =  $('.phase-one-error-all');
		}

		if($('input[name="phase[0][approve_date]"]').val() === '' ){
			date_error.text('please select date');
			date_error.show();
			e.preventDefault();
			return false;
		}else{
			date_error.empty();
			date_error.hide();
		}
	});


	$(document).on('click, blur','input[name="phase[0][approve_date]"]', function(){
		var $div 		= $(this).parents().parents('div.form-group'),
			date_error 	= $('.phase-one-error'),
			start_date 	= $('input[name="post-date"]').val(),
			end_date 	= $(this).val(),
			phase_no 	= 0 ;

		if($div.hasClass('phase-date-time-div')){
			// if user click on (Add Approval Phase(s)) button
			date_error =  $('.phase-one-error-all');
		}

		if($('input[name="phase[0][approve_hour]"]').val() === '' && $('input[name="phase[0][approve_minute]"]').val() === '' ){
			date_error.text('Please enter hour and minutes');
			date_error.show();
		}

		if($('input[name="post-hour"]').val() === '' && $('input[name="post-minute"]').val() ==='' ){
			console.log('post-hour and post-minute');
			$('#hm_error').text('Please enter hour and minutes');
			$('#hm_error').show();
		}

		//comparePhases(start_date, end_date, date_error,phase_no);		
	});


	$(document).on('click, blur','input[name="phase[1][approve_date]"]', function(){
		
		var date_error 		= $('.phase-two-error'),
			start_date 		= $('input[name="phase[0][approve_date]"]').val(),
			end_date 		= $(this).val(),
			phase_no 		= 1 ;


		comparePhases(start_date, end_date, date_error,phase_no);
	});



	$(document).on('click, blur','input[name="phase[2][approve_date]"]', function(){
		
		var date_error 		= $('.phase-three-error'),
			start_date 		= $('input[name="phase[1][approve_date]"]').val(),
			end_date 		= $(this).val(),
			phase_no 		= 2 ;

		comparePhases(start_date, end_date, date_error,phase_no);
	});


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
			hm_error = $('#hm_error');

		if($(field).hasClass('single-date-select') && $(field).val() === "") {
			date_error.text('Please select date');
			date_error.show();
		}

		if($(field).hasClass('single-date-select')) {
			var sdate = $(field).val();
			var currentDate = new Date();
			if(!compareDate(currentDate,sdate)){
				date_error.text('Please select valid date');
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
						if($('input[name="phase[0][approve_date]').val()!=''){
							if($('input[name="phase[0][approve_hour]"]').val()!='' && $('input[name="phase[0][approve_minute]"]').val()!=''){
								disable_btn = false;
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
		toggleBtnClass("#submit-approval", disable_btn);
		//toggleBtnClass("#draft", disable_btn);
	}

	compareDate = function(startDate, endDate){
		startDate = moment(new Date (startDate)).format('YYYY-MM-DD');	
		endDate = moment(new Date (endDate)).format('YYYY-MM-DD');
		if (startDate <= endDate) {
			return true;
		}else {
			return false;
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
					$message = 'Date must be grether than Sdate';
				}
				else{
					$message = 'Date must be grether than Phase '+ phase_no;
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

});