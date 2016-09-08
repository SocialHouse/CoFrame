jQuery(function($) {

	// content type change
	$(document).on('click','.content-list li', function() {
		var previousContentObj, call_show_hide, previousContentType, str_show, str_hide;
		var newContentType = $(this).data('selected-content');
		$('#live-post-preview').removeAttr('class');
		$.each($('.content-list li'), function(i, element){
			if(!$(element).hasClass('disabled')){
				previousContentObj = $(element);
				previousContentType = $(previousContentObj).data('selected-content');
				str_show = $(previousContentObj).children('i').data('show');
				str_hide = $(previousContentObj).children('i').data('hide');
			}
		});

		if(previousContentType === newContentType )	{
			return;
		}

		if(newContentType === 'Photo' ){
			$('#live-post-preview').addClass('photo-post');
			if($('.form__preview-wrapper video ').length > 0 || $('.form__preview-wrapper audio ').length > 0 ){
				getConfirm(language_message.tumblr_change_audio_video_error.replace("%Content_type%", newContentType) ,'','alert',function(confResponse) {});
				call_show_hide = true;
			}else{
				$(this).toggleClass('disabled');
				$(this).siblings().addClass('disabled');
				$('#tumblrContent').val(newContentType);
			}
		}
		else if(newContentType === 'Audio'){
				if($('.form__preview-wrapper img').length > 0 || $('.form__preview-wrapper audio ').length > 0 ){
					getConfirm(language_message.tumblr_change_img_audio_error.replace("%Content_type%", newContentType),'','alert',function(confResponse) {});
					call_show_hide = true;
				}else{
					$(this).toggleClass('disabled');
					$(this).siblings().addClass('disabled');
					$('#tumblrContent').val(newContentType);
				}
			
		}else if(newContentType === 'Video'){
			$('#live-post-preview').addClass('video-post');
				if($('.form__preview-wrapper img').length > 0 || $('.form__preview-wrapper video ').length > 0 ){
					getConfirm(language_message.tumblr_change_img_video_error.replace("%Content_type%", newContentType),'','alert',function(confResponse) {});
					call_show_hide = true;
				}else{
					$(this).toggleClass('disabled');
					$(this).siblings().addClass('disabled');
					$('#tumblrContent').val(newContentType);
				}
			
		}else{
			if(newContentType === 'Chat' ){
				$('#live-post-preview').addClass('chat-post');
			}
			if(newContentType === 'Text' ){
				$('#live-post-preview').addClass('text-post');
			}
			if($('.form__preview-wrapper video').length > 0){
				getConfirm(language_message.tumblr_change_audio_error.replace("%Content_type%", newContentType),'','alert',function(confResponse) {});
				call_show_hide = true;
			}
			else if($('.form__preview-wrapper img').length > 0){
				getConfirm(language_message.tumblr_change_img_error.replace("%Content_type%", newContentType),'','alert',function(confResponse) {});
				call_show_hide = true;
			}else if($('.form__preview-wrapper audio').length > 0){
				getConfirm(language_message.tumblr_change_audio_error.replace("%Content_type%", newContentType),'','alert',function(confResponse) {});
				call_show_hide = true;
			}
			else{
				$(this).toggleClass('disabled');
				$(this).siblings().addClass('disabled');
				$('#tumblrContent').val(newContentType);
				call_show_hide = false;
			}
		}
		if(call_show_hide){
			setTimeout(function() {
				var sdf = $(previousContentObj).children('i');
				$(sdf).click();
			}, 1000);
		}
		else{
			// Clear all the text box of previous selected Content Type
			$.each($(str_show).find('input,textarea'), function(i,element){
				$(element).val('');
				$(element).keypress();
			});
			$('#live-post-preview .post-title').removeClass('quote');
		}
	});


	// $(document).on('keypress', '.tb_tags',function(e){
	// 	console.log(e.which);
	// 	if (e.which == 13) {
	// 		console.log($(this).val());
	// 		$(this).val('#'+$(this).val());
	// 	}
	// });

	$(document).on('keypress blur keyup','#tumblrPostCopy, #tumblrChatCopy', function() {
		$('#postCopy').val($(this).val());
		$('#postCopy').keyup();
	});

	$(document).on('keypress blur keyup','#tb_text_title, #tb_chat_title, #tumblrQuoteCopy, #tbCaption,#tbVideoDescr,#tbAudioDescr', function() {
		if($(this).attr('id') == 'tumblrQuoteCopy'){
			if(!$('#live-post-preview .post-title').hasClass('quote')){
				$('#live-post-preview .post-title').addClass('quote');
			}
		}else{
			$('#live-post-preview .post-title').removeClass('quote');
		}
		$('#live-post-preview .post-title').text($(this).val());
	});

	$(document).on('keypress blur keyup','#tbSource', function() {
		if($(this).val() !== ''){
			$('#live-post-preview .source').text('— '+$(this).val());
		}else{
			$('#live-post-preview .source').text('');
		}
	});

	$(document).on('keypress blur keyup','#tb_text_tags, #tb_photo_tags, #tb_quote_tags, #tb_chat_tags, #tb_audio_tags, #tb_video_tags', function() {
		$('#live-post-preview .tags').text($(this).val());
	});

	$(document).on('keypress blur keyup','#tbLink', function() {
		if($(this).val() !== ''){
			if(!$('#live-post-preview .link').hasClass('link-url')){
				$('#live-post-preview .link').addClass('link-url');
			}
		}else{
			$('#live-post-preview .link').removeClass('link-url');
		}
		$('#live-post-preview .link a').text($(this).val());	
		
	});

});