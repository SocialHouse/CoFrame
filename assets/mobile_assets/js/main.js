jQuery(function($) {

	var wh = $(window).height();
	var ww = $(window).width();

	// if($('#brand-manage').length) {
		setUserTime();
	// }

	$(window).on("orientationchange resize", function () {
		wh = $(window).height();
		ww = $(window).width();
	});

	$(document).ready(function() {
		
		$('.navbar-main').on('show.bs.collapse', function () {
			$('html').addClass('nav-expand');
		});
		$('.navbar-main').on('hide.bs.collapse', function () {
			$('html').removeClass('nav-expand');
		});
		
		$('.to-do-list ol, .to-do-list ul, .pricing-details ul').on('show.bs.collapse', function () {
			var arrow = $(this).parent().find('.expand-collapse:first');
			arrow.addClass('fa-angle-down').removeClass('fa-angle-right');
		});
		$('.to-do-list ol, .to-do-list ul, .pricing-details ul').on('hide.bs.collapse', function () {
			var arrow = $(this).parent().find('.expand-collapse');
			arrow.removeClass('fa-angle-down').addClass('fa-angle-right');
		});


		$('body').on('click', '.show-hide', function(e) {
			e.preventDefault();
			var $trigger = $(this);
			var show = $trigger.data('show');
			var hide = $trigger.data('hide');
			if(hide) { 
				$(hide).slideUp(function() {
					//call custom function on completion
					$(hide).trigger('contentSlidUp', [$trigger]);
					$(show).slideDown(function(){
						$(show).trigger('contentSlidDown', [$trigger]);
					});
				});
			}
			else {
				$(show).slideToggle(function(){
					$(show).trigger('contentSlidDown', [$trigger]);
				});
			}
		});

	});

	$('body').on('click', '.target-hidden', function(e) {
		e.preventDefault();
		var target = $(this).attr('href');
		$(target).click();
	});
	
	$('body').on('click', '.outlet-list li:not(.filter)', function(e) {
		var outlet_const = $(this).data('selected-outlet');
		var video_count = $('.form__preview-wrapper video').length;
		var all_images = $('.form__preview-wrapper img').length;
		
		if(outlet_const === 'twitter')
		{
			should_change = 1;
			if(all_images > 4)
			{
				alert(language_message.twitter_img_allowed);
				should_change = 0;
			}
			if(all_images >= 1)
			{
				$('.form__preview-wrapper img').each(function(){
					if($(this).attr('src').indexOf('gif') >= 0)
					{
						should_change = 0;
						alert(language_message.twitter_gif_error);
					}
				});
			}

			if(should_change == 0)
			{
				return false;
			}
		}

		if (outlet_const === 'vine' || outlet_const === 'youtube') {
			if ($('.form__preview-wrapper img').length) {
				if (outlet_const === 'youtube') {
					alert(language_message.youtube_outlet_change_error);
					return false;
				} else {
					alert(language_message.vine_outlet_change_error);
					return false;
				}
				
			}				
		}

		if (outlet_const == 'instagram') {
			// if ($('.form__preview-wrapper video').length) {
			// 	alert(language_message.insta_outlet_change_error);
			// 	return false;
			// }

			if ($('.form__preview-wrapper img').length > 1) {
				alert(language_message.insta_outlet_change_img_error);
				return false;
			}
			else
			{
				if ($('.form__preview-wrapper img').length)
				{
					if($('.form__preview-wrapper img').attr('src').indexOf('gif') >= 0)
					{
						getConfirm(language_message.insta_video_not_allowed,'','alert',function(confResponse) {});
						return false;
					}
				}
			}
		}

		if (outlet_const == 'linkedin') {			
			if ($('.form__preview-wrapper img').length > 1) {
				alert(language_message.linkedin_outlet_change_error);
				return false;
			}
		}

		if (outlet_const == 'pinterest') {			
			if ($('.form__preview-wrapper img').length > 1) {
				alert(language_message.pinterest_outlet_change_error);
				return false;
			}
		}

		$(this).toggleClass('disabled');
		$(this).siblings().addClass('disabled');
		$('#postOutlet').val($(this).data('outlet-id'));
	});
	
	$('.content-editable').each(function() {
		var id = $(this).attr('id');
		document.getElementById(id).addEventListener("input", function() {
			var input = $(this).data('input');
			var content = $(this).html();
			$(input).val(content);
		});
	});

	//assign tags to post
	$('body').on('click', '.tag:not(.filter)', function() {
		var tagVal = $(this).data('value');
		var tagGroup = $(this).data('group');
		if(tagVal !== 'check-all') {
			$(this).toggleClass('selected');
			var checked = false;
			if ($(this).hasClass('selected')) {
				checked = true;
			} else {
				checked = false;
			}
			//set the input value
			var $input = $(this).find('input');
			$input.prop('checked', checked);
		}
		else {
			$('.tag[data-group="' + tagGroup + '"]').each(function() {
				if(!$(this).hasClass('selected')) {
					$(this).addClass('selected');
					checked = true;
					//set the input value
					var $input = $(this).find('input');
					$input.prop('checked', checked);
				}
			});
		}
	});

	//Time selector functions
	$('body').on('click', '.incrementer', function(e) {
		var $target = $(e.target);
		var incDec = ($target.hasClass('increase')) ? 'increase' : 'decrease';
		var inputName = $(this).data('for');
		var relatedInput = $('input[name="' + inputName + '"]');
		if(relatedInput.hasClass('hour-select')) {
			setHrs(relatedInput, incDec);
		}
		if(relatedInput.hasClass('minute-select')) {
			setMins(relatedInput, incDec);
		}
		if(relatedInput.hasClass('amselect')) {
			setAmPm(relatedInput);
		}
	});

	$('body').on('keydown', '.time-input', function(e) {
		var incDec;
		//up arrow pressed
		if(e.which === 38) {
			incDec = 'increase';
		}
		//down arrow pressed
		else if(e.which === 40) {
			incDec = 'decrease';
		}
		else {
			return;
		}
		var input = $(this);
		if(input.hasClass('hour-select')) {
			setHrs(input, incDec);
		}
		if(input.hasClass('minute-select')) {
			setMins(input, incDec);
		}
		if(input.hasClass('amselect')) {
			setAmPm(input);
		}
	});

	var supported_files = ['gif','png','jpg','jpeg','mp4'];
	var all_images = [];
	$(document).on('change','#postFile',function(event){
		var $fileDiv = $(this).parents('.form__input');
		var file = event.target.files[0];
		var current_outlet = $('#current_outlet').val()
		img_count = $('img.form__file-preview').length + 1;
		var file_type = file.type.split('/');
		var fileInput = this;		

		if($.inArray(file_type[1] ,supported_files) == -1){		
			alert(language_message.invalid_extention);
			return false;
		}

		if(img_count >= 2 && current_outlet == 'twitter')
		{
			var should_change = 1;

			if(file.type == 'image/gif')
			{
				should_change = 0;				
			}
			else
			{
				$('img.form__file-preview').each(function(a,b){				
					if($(this).attr('src').indexOf('gif') >= 0)
					{					
						should_change = 0;
						return false;
					}			
				});
			}

			if(should_change == 0)
			{
				alert(language_message.twitter_gif_error);
				return false;
			}
		}

		if(current_outlet == 'twitter' && img_count == 5)
		{			
			alert(language_message.twitter_img_allowed);
			return false;
		}

		if(current_outlet == 'instagram' && img_count == 1 && file.type == 'image/gif')
		{			
			alert(language_message.twitter_gif_error);
			return false;
		}

		if(file_type[0] == 'image')
		{
			if( file.size > upload_limit[current_outlet].image_size){
				alert(language_message.image_size_limit.replace('%size%', upload_limit[outlet_const].image_size/1000000)+' MB');		
				return false;
			}

			if(upload_limit[current_outlet].height !="" || upload_limit[current_outlet].width !=""){
				var img_obj = new Image();
				img_obj.onload = function() {
					if(upload_limit[current_outlet].height < img_obj.height){
						console.log("In valid Height: " + img_obj.height );
						//is_valid_image = false;
					}

					if(upload_limit[current_outlet].width < img_obj.width){
						console.log("In valid Width: " + img_obj.width );
					}
					
				}
				img_obj.src = window.URL.createObjectURL(file);
			}


			if($fileDiv.find('video').length > 0){
				alert(language_message.img_vid_error);
				return false;
			}

			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function (e) {
				if(img_count == 5 && current_outlet == 'twitter')
				{
					alert(language_message.twitter_img_allowed);
					return false;
				}
				else if((current_outlet == 'youtube' || current_outlet == 'vine') && file_type[0]== 'image')
				{					
					if(current_outlet == 'youtube')
					{
						alert(language_message.youtube_outlet_change_error);						
					}else{
						alert(language_message.vine_outlet_change_error);						
					}
					return false;
					
				}

				// if(current_outlet == 'instagram' && file_type[0]== 'video')
				// {
				// 	alert(language_message.insta_video_not_allowed);
				// 	return false;
				// }

				if(img_count == 2 && (current_outlet == 'instagram' || current_outlet == 'linkedin' || current_outlet == 'pinterest'))
				{
					var message = language_message.insta_img_allowed;
					if(current_outlet == 'linkedin')
					{
						message = language_message.linkedin_img_allowed;
					}
					else if(current_outlet == 'pinterest')
					{
						message = language_message.pinterest_img_allowed;
					}
					alert(message);
					return false;
				}
				else
				{
					var img = document.createElement('img');
					var preview_img = document.createElement('img');					
					img.className = 'form__file-preview';

					var imgDiv = document.createElement('div');
					imgDiv.className = 'form__preview-wrapper';
					$(imgDiv).html('<i class="tf-icon-circle remove-upload">x</i>');
					$(imgDiv).append(img);
						
					$fileDiv.prepend(imgDiv).addClass('has-files');

					// set  data (data-preview-number) to image tag for deleting image 
					total_images = $('img.form__file-preview').length;
					$(img).attr('data-preview-number',total_images);
					img.src = e.target.result;
					file.img_src = e.target.result;
					all_images.push(file);
				}								
            };	                

			//to sho user uploded img on add role page
			if($('.user-img-preview').length)
			{
				$('.user-img-preview').attr('src',window.URL.createObjectURL(file));
			}
		}
		else if(file_type[0]== 'video' && !$fileDiv.hasClass('user_upload_img_div') && !$fileDiv.hasClass('brand-image'))
		{
			if(current_outlet == 'instagram' ){
				alert(language_message.insta_video_not_allowed);
				return false;
			}

			if( file.size > upload_limit[current_outlet].video){
				alert(language_message.video_size_limit.replace('%size%',(upload_limit[outlet_const].video)/1000000)+' MB');				
				return false;
			}



			if($('.form__file-preview').length >= 1){

				if($('.form__preview-wrapper img').length > 0 && file_type[0] =='video')
				{
					alert(language_message.img_vid_error);					
				}
				if(file_type[0] =='video'){
					alert(language_message.video_upload_error);					
				}else{
					alert(language_message.invalid_extention);					
				}
				return false;
			}else{
				if($(fileInput).parents('.brand-image').length)
				{
					$(fileInput).parents('.brand-image').children('.form__file-preview').remove();
					all_images = [];
				}
				if($(fileInput).parents('.user_upload_img_div').length)
				{
					$(fileInput).parents('.brand-image').children('.form__file-preview').remove();
					$('.remove-user-img').show();
					all_images =[];
				}

				var video = document.createElement('video');
				video.className = 'form__file-preview';									
				var videoDiv = document.createElement('div');
				videoDiv.className = 'form__preview-wrapper';
				$(videoDiv).html('<i class="tf-icon-circle remove-upload">x</i>');
				$(videoDiv).append(video);

				$fileDiv.prepend(videoDiv).addClass('has-files');

				var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = function (e) {
					video.src = e.target.result;
					file.img_src = e.target.result;
					all_images.push(file);
                }

				if($('.user-img-preview').length)
				{
					$('.user-img-preview').attr('src',window.URL.createObjectURL(file));
				}
			}							
		}
		else{
			$fileDiv.parent().find('.upload-error').removeClass('hide');
		}
	});

	//remove post media upload on icon click
    $('body').on('click', '.form__input .remove-upload', function(){		    	
		var $uploader = $(this).closest('.form__input');
		var imgIndex;
		var control = $(this).parent().find('img');
		if($(this).data('deleteId'))
		{
			var deleted = $('#delete_img').val()
			if(deleted)
			{
				$('#delete_img').val(deleted+','+$(this).data('delete-id'));
			}
			else
			{
				$('#delete_img').val($(this).data('deleteId'));
			}
		}

		$(this).parent('.form__preview-wrapper').fadeOut(function() {
			$.each(all_images,function(a,img){
				if(img.img_src === $(control).attr('src'))
				{
					imgIndex = a;							
					return;
				}
			});
			all_images.splice(imgIndex, 1);

			$(this).remove();
			var $uploads = $uploader.find('.form__preview-wrapper');
			// if(!$uploads.length) {
			// 	 $uploader.removeClass('has-files');
			// }
		});
    });

    $(document).on('click','.update-post',function(){
    	var $form = $('.edit-post');
    	var ajaxData = new FormData( $form.get( 0 ) );
    	if( all_images ){
			var file_count = 0;
			$.each( all_images, function( i, file ){
				if(typeof(file) == 'object' && file.name){
					ajaxData.append( 'file['+file_count+']',file,file.name);
					file_count++;
				}
				
			});
		}

		var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
			if(input.name == 'brand_id' || input.id== 'post_user_id' || input.name == 'save_as')
	        	ajaxData.append(input.name,input.value);
	    });

	    // ajax request
		$.ajax({
			url: 			$form.attr( 'action' ),
			type:			$form.attr( 'method' ),
			data: 			ajaxData,
			dataType:		'json',
			cache:			false,
			contentType:	false,
			processData:	false,
			complete: function(){
				$form.removeClass( 'is-uploading' );
			},
			success: function( data ){
				if(data.response == 'fail')
				{
					alert(language_message.edit_post_fail);
				}
				else
				{
					location.reload();
				}
			},
			error: function(){
				alert(language_message.upload_error);
				return false;
			}
		});
    });

	function setHrs(input, incDec) {
		var newVal;
		var minVal = $(input).attr('data-min');
		var maxVal = $(input).attr('data-max');
		var inputVal = parseFloat($(input).val());
		if(!inputVal) {
			inputVal = 0;
		}
		if(incDec === "increase") {
			if(inputVal < maxVal) {
				newVal = inputVal + 1;
			}
			else if(inputVal >= maxVal) {
				newVal = minVal;
			}
		}
		else if(incDec === "decrease") {
			if(inputVal > minVal) {
				newVal = inputVal - 1;
			}
			else if(inputVal <= minVal) {
				newVal = maxVal;
			}
		}
		$(input).val(newVal);
	}
	function setMins(input, incDec) {
		var newVal;
		var minVal = $(input).attr('data-min');
		var maxVal = $(input).attr('data-max');
		var inputVal = parseFloat($(input).val());
		if(!inputVal) {
			inputVal = 0;
		}
		if(incDec === "increase") {
			if(inputVal < maxVal) {
				newVal = inputVal + 1;
			}
			else if(inputVal >= maxVal) {
				newVal = minVal;
			}
		}
		else if(incDec === "decrease") {
			if(inputVal > minVal) {
				newVal = inputVal - 1;
			}
			else if(inputVal <= minVal) {
				newVal = maxVal;
			}
		}
		if(newVal < 10) {
			newVal = '0' + newVal;
		}
		$(input).val(newVal);
	}
	function setAmPm(input) {
		($(input).val() === 'am') ? $(input).val('pm') : $(input).val('am');
	}
	window.addIncrements = function addIncrements() {
		$('body').find('.time-select .time-input').each(function() {
			var inputName = $(this).attr('name');
			var increment = '<div class="incrementer" data-for="' + inputName + '"><i class="fa fa-caret-up increase"></i><i class="fa fa-caret-down decrease"></i></div>';
			$(this).after(increment);
			if($(this).hasClass('minute-select')) {
				$(this).before('<span class="time-separator">:</span>');
			}
		});
	};
	addIncrements();

	toggleBtnClass = function(btnClass, btnState) {
	 	$(btnClass).prop('disabled', btnState);
	 	if (btnState) {
	 		$(btnClass).addClass('btn-disabled');
	 	} else {
	 		$(btnClass).removeClass('btn-disabled');
	 	}
	 };

});

	var today = new Date();

	function setUserTime() {
		if(jQuery('#userTime').length)
		{
			var today = new Date();
			var h = today.getHours();
			var m = today.getMinutes();
			h = checkHours(h);
			m = checkMinutes(m);
			document.getElementById('userTime').innerHTML = h + ":" + m;
			var t = setTimeout(setUserTime, 500);
		}
	}
	function checkMinutes(i) {
		if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		return i;
	}
	function checkHours(i) {
		if (i > 12) {i = i-12}; //12 hour format
		return i;
	}

	function showContent(obj) {
		obj.fadeIn(function() {
			obj.trigger('contentShown');
		});
	}
	function hideContent(obj) {
		obj.fadeOut(function() {
			obj.trigger('contentHidden');
		});
	}