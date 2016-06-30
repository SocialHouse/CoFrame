jQuery(function($) {

	$(document).on('keypress blur', '#postCopy, .single-date-select, .hour-select, .minute-select, .check-box.circle-border,.incrementer i', function() {
		create_post_validation($(this));
	});
	$(document).on('click', '.check-box.circle-border, .incrementer i', function() {
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


	$(document).on('click, blur','input[name="phase[0][approve_date]"]', function(){
		var $display_error = true;
		var $div = $(this).parents().parents('div.form-group');
		var date_error = $('.phase-one-error');
		var start_date = $('input[name="post-date"]').val();
		var end_date = $(this).val();
		if(start_date !== "") {
			$('.single-date-select').fullCalendar('removeEvents');
			var eventData = {
				allDay: true,
				start: $.fullCalendar.moment(start_date),
				rendering: 'background',
				color: '#f4d3d5'
			};
			$('.single-date-select').fullCalendar('renderEvent', eventData, true);
		}
		if($div.hasClass('phase-date-time-div')){
			// if user click on (Add Approval Phase(s)) button
			date_error =  $('.phase-one-error-all');
		}
		if( $('input[name="post-date"]').val() == '' ){

			date_error.text('Plaese select Sdate first');
			date_error.show();
		}else{			
			if(compareDate(start_date, end_date)){
				$display_error = false;
			}else{
				date_error.text('Date must be grether than Sdate');
				date_error.show();
			}
		}
		if(!$display_error){
			date_error.empty();
			date_error.hide();			
		}
	});


	$(document).on('blure','input[name="phase[1][approve_date]"]', function(){
		// if($('input[name="post-date"]').val() == '' ){
			
		// }else{

		// }
	});

	function create_post_validation(field){
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

	compareTime = function(startTime, endTime){
		startDate = moment(new Date (startDate)).format('YYYY-MM-DD');	
		endDate = moment(new Date (endDate)).format('YYYY-MM-DD');
		if (startDate <= endDate) {
			return true;
		}else {
			return false;
		}
	};

});