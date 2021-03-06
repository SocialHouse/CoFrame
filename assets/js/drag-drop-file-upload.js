// JavaScript Document
	'use strict';
	var allFiles = [],
		removeFromPreview;

	;( function( $, window, document, undefined ){
		
		window.fileDragNDrop = function fileDragNDrop() {
		// feature detection for drag&drop upload
		var isAdvancedUpload = function(){
			var div = document.createElement( 'div' );
			return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
		}();
		
		// applying the effect for every form
		
		$( 'form.file-upload' ).each( function(){

			var $form		 = $( this ),
				$input		 = $form.find( 'input[type="file"]' ),
				$label		 = $form.find( '.file-upload-label' ),
				$errorMsg	 = $form.find( '.form__error span' ),
				$restart	 = $form.find( '.form__restart' ),
				supported_files = ['gif','png','jpg','jpeg','mp4'],
				droppedFiles = false,
				total_images = '',
				outlet = $form.find('#postOutlet').val(),
				showFiles	 = function( files , control){
					$(control).parents('.file-upload-label').text( files.length > 1 ? ( $(control).parents('input[type="file"]').attr( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name );
				};

			$('body').on('click', '.btn-next-step', function() {
				var next = $(this).data('nextStep');
				if(next == 1)
				{
					allFiles = [];
				}
			});

			$('#save_outlet').click(function(){
				allFiles = [];
			});

			// letting the server side to know we are going to make an Ajax request
			$form.append( '<input type="hidden" name="ajax" value="1" />' );

			// automatically submit the form on file select
			$('input[type="file"]').on( 'change',function( e ){

				if( $(this).attr('id') != 'fileInput' && $(this).attr('id') != 'userfileInput')
				{
					var $fileDiv = $(this).parents('.form__input');
					$fileDiv.parent().find('.upload-error').addClass('hide');
					var fileInput = this;
					var error = 'false';

					showFiles( e.target.files,this);
					droppedFiles = e.target.files; // the files that were dropped

					$.each(droppedFiles, function (index, file) {
						console.log(allFiles.length);
						var file_type = file.type.split('/');
						if($.inArray(file_type[1] ,supported_files) == -1){
							getConfirm(language_message.invalid_extention,'','alert',function(confResponse) {});
							return false;
							// alert(language_message.invalid_extention);
							
						};
						
						
						var outlet_const = jQuery('#postOutlet').attr('data-outlet-const');
						
						if( file_type[0]== 'image'){
							if( file.size > upload_limit[outlet_const].image_size){
								getConfirm(language_message.image_size_limit.replace('%size%', upload_limit[outlet_const].image_size/1000000)+' MB' ,'','alert',function(confResponse) {});
								return false;
							}

							if(upload_limit[outlet_const].height !="" || upload_limit[outlet_const].width !=""){
								var img_obj = new Image();
								img_obj.onload = function() {
									if(upload_limit[outlet_const].height < img_obj.height){
										console.log("In valid Height: " + img_obj.height );
										//is_valid_image = false;
									}

									if(upload_limit[outlet_const].width < img_obj.width){
										console.log("In valid Width: " + img_obj.width );
									}
									
								}
								img_obj.src = window.URL.createObjectURL(file);
							}


							if($fileDiv.find('video').length > 0){
								getConfirm(language_message.invalid_extention,'','alert',function(confResponse) {});
								return false;
							}
							if($(fileInput).parents('.brand-image').length)
							{
								$(fileInput).parents('.brand-image').children('.form__file-preview').remove();
								allFiles = [];
							}
							if($(fileInput).parents('.user_upload_img_div').length)
							{
								$(fileInput).parents('.brand-image').children('.form__file-preview').remove();
								$('.remove-user-img').show();
								allFiles =[];
							}

							var reader = new FileReader();
							reader.readAsDataURL(file);
							reader.onload = function (e) {								
								if(outlet_const == 'tumblr')
								{
									if($('.content-list li:not(".disabled")').data('selected-content') == 'Video' && file_type != 'video')
									{
										getConfirm(language_message.tumblr_upload_photo_error,'','alert',function(confResponse) {});
										return false;
									}	
								}

								if(allFiles.length == 1 && outlet_const == 'twitter' && (allFiles[0].type == 'image/gif' || file.type == 'image/gif'))
								{
									getConfirm(language_message.twitter_gif_error,'','alert',function(confResponse) {});
									return false;
								}

								if(allFiles.length == 4 && outlet_const == 'twitter')
								{
									getConfirm(language_message.twitter_img_allowed,'','alert',function(confResponse) {});
									return false;
								}
								else if((outlet_const == 'youtube' || outlet_const == 'vine') && file_type[0]== 'image')
								{
									
									if(outlet_const == 'youtube')
									{
										getConfirm(language_message.youtube_outlet_change_error,'','alert',function(confResponse) {});
										return false;
									}else{
										getConfirm(language_message.vine_outlet_change_error,'','alert',function(confResponse) {});
										return false;
									}
									
								}

								if(outlet_const == 'instagram' && file.type == 'image/gif')
								{
									getConfirm(language_message.insta_video_not_allowed,'','alert',function(confResponse) {});
									return false;
								}

								if(allFiles.length == 1 && (outlet_const == 'instagram' || outlet_const == 'linkedin' || outlet_const == 'pinterest'))
								{
									var message = language_message.insta_img_allowed;
									if(outlet_const == 'linkedin')
									{
										message = language_message.linkedin_img_allowed;
									}
									else if(outlet_const == 'pinterest')
									{
										message = language_message.pinterest_img_allowed;
									}
									getConfirm(message,'','alert',function(confResponse) {});
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
									allFiles.push(file);
									changePreview(file,'image');
								}								
			                };	                

							//to sho user uploded img on add role page
							if($('.user-img-preview').length)
							{
								$('.user-img-preview').attr('src',window.URL.createObjectURL(file));
							}

						//for show preview
						}else if(file_type[0]== 'video' && !$fileDiv.hasClass('user_upload_img_div') && !$fileDiv.hasClass('brand-image')){
							// if(outlet_const == 'instagram' ){
							// 	getConfirm(language_message.insta_video_not_allowed,'','alert',function(confResponse) {});
							// 	return false;
							// }

							if(outlet_const == 'tumblr')
							{
								if($('.content-list li:not(".disabled")').data('selected-content') == 'Photo' && file_type != 'image')
								{
									getConfirm(language_message.tumblr_upload_video_error,'','alert',function(confResponse) {});
									return false;
								}
							}

							if(outlet_const == 'linkedin')
							{
								getConfirm(language_message.linkedin_video_error,'','alert',function(confResponse) {});
								return false;
							}

							if(outlet_const == 'pinterest')
							{
								getConfirm(language_message.pinterest_video_error,'','alert',function(confResponse) {});
								return false;
							}

							if( file.size > upload_limit[outlet_const].video){
								getConfirm(language_message.video_size_limit.replace('%size%',(upload_limit[outlet_const].video)/1000000)+' MB','','alert',function(confResponse) {});
								return false;
							}



							if($('.form__file-preview').length >= 1){

								if(file_type[0] =='video'){
									getConfirm(language_message.video_upload_error,'','alert',function(confResponse) {});
									return false;
									// alert(language_message.video_upload_error);
								}else{
									getConfirm(language_message.invalid_extention,'','alert',function(confResponse) {});
									return false;
									// alert(language_message.invalid_extention);
								}
							}else{
								if($(fileInput).parents('.brand-image').length)
								{
									$(fileInput).parents('.brand-image').children('.form__file-preview').remove();
									allFiles = [];
								}
								if($(fileInput).parents('.user_upload_img_div').length)
								{
									$(fileInput).parents('.brand-image').children('.form__file-preview').remove();
									$('.remove-user-img').show();
									allFiles =[];
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
									allFiles.push(file);
									//for show preview								
									changePreview(file,'video');								
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
				}
			});

			// drag&drop files if the feature is available
			if( isAdvancedUpload ){
				//set all files array on initial load - for post edit screens
				if(allFiles.length === 0 && $('img.form__file-preview').length > 0) {
					$('img.form__file-preview').each(function(i, el) {
						var file = {img_src:$(el).attr('src')};
						allFiles.push(file);
					});
				}
				$form
				.addClass( 'has-advanced-upload' ) // letting the CSS part to know drag&drop is supported by the browser
				.on( 'drag dragstart dragend dragover dragenter dragleave drop', function( e ){
					// preventing the unwanted behaviours
					e.preventDefault();
					e.stopPropagation();
				})
				.on( 'dragover dragenter', function() {
					$form.addClass( 'is-dragover' );
				})
				.on( 'dragleave dragend drop', function(){
					$form.removeClass( 'is-dragover' );
				})
				.on( 'drop', function( e ){	
				
					var target_file_input = $(e.target).closest('.form__input');					
					if(target_file_input.length > 0)
					{
						droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
						var $fileDiv = $('.form__input');
						$fileDiv.parent().find('.upload-error').addClass('hide');
						var error ='false';						
						var outlet_const = jQuery('#postOutlet').attr('data-outlet-const');	
						$.each(droppedFiles, function (index, file) {
							var file_type = file.type.split('/');
							if($.inArray(file_type[1] ,supported_files) == -1){
								getConfirm(language_message.invalid_extention,'','alert',function(confResponse) {});
								return false;
								// alert(language_message.invalid_extention);
								// return false;
							}
							
							var outlet_const = jQuery('#postOutlet').attr('data-outlet-const');
							if((outlet_const == 'youtube' || outlet_const == 'vine') && file_type[0]== 'image')
							{
								var message_obj = 'vine_img_not_allwed';
								if(outlet_const == 'youtube')
								{
									message_obj = 'youtube_img_not_allwed';
								}
								getConfirm(language_message.message_obj,'','alert',function(confResponse) {});
								return false;
							}

							if(outlet_const == 'instagram' && file.type == 'image/gif')
								{
									getConfirm(language_message.insta_video_not_allowed,'','alert',function(confResponse) {});
									return false;
								}

							// if(outlet_const == 'instagram' && file_type[0]== 'video')
							// {
							// 	getConfirm(language_message.insta_video_not_allowed,'','alert',function(confResponse) {});
							// 	return false;
							// }

							if( file_type[0]== 'image'){
								if( file.size > upload_limit[outlet_const].image_size){
									getConfirm(language_message.image_size_limit.replace('%size%',(upload_limit[outlet_const].image_size)/1000000)+' MB','','alert',function(confResponse) {});
									return false;
								}
								if($('.form__file-preview').src=='video'){
									getConfirm(language_message.invalid_extention,'','alert',function(confResponse) {});
									return false;
								}
								if($(target_file_input).hasClass('brand-image'))
								{
									allFiles = [];
									$(target_file_input).children('.form__file-preview').remove();							
									
								}
								if($(target_file_input).hasClass('user_upload_img_div'))
								{
									allFiles = [];
									$(target_file_input).children('.form__file-preview').remove();
									$('.remove-user-img').show();
								}								

								var reader = new FileReader();
								reader.readAsDataURL(file);
			                    reader.onload = function (e) {
			                    	if(allFiles.length == 1 && jQuery('#postOutlet').attr('data-outlet-const') == 'twitter' && (allFiles[0].type == 'image/gif' || file.type == 'image/gif'))
									{
										getConfirm(language_message.twitter_gif_error,'','alert',function(confResponse) {});
										return false;
									}
			                    	if(allFiles.length == 4 && jQuery('#postOutlet').attr('data-outlet-const') == 'twitter')
									{
										getConfirm(language_message.twitter_img_allowed,'','alert',function(confResponse) {});
										return false;
									}
									else if(allFiles.length == 1 && (outlet_const == 'instagram' || outlet_const == 'linkedin' || outlet_const == 'pinterest'))
									{
										var message = language_message.insta_img_allowed;
										if(outlet_const == 'linkedin')
										{
											message = language_message.linkedin_img_allowed;
										}
										else if(outlet_const == 'pinterest')
										{
											message = language_message.pinterest_img_allowed;
										}
										getConfirm(message,'','alert',function(confResponse) {});
										return false;
									}
									else
									{
										var img = document.createElement('img');							

										img.className = 'form__file-preview';
										// img.src = window.URL.createObjectURL(file);
										var imgDiv = document.createElement('div');
										imgDiv.className = 'form__preview-wrapper';
										$(imgDiv).html('<i class="tf-icon-circle remove-upload">x</i>');
										$(imgDiv).append(img);
										$(target_file_input).prepend(imgDiv).addClass('has-files');

										// set  data (data-preview-number) to image tag for deleting image 
										total_images = $('img.form__file-preview').length;
										$(img).attr('data-preview-number',total_images);
										img.src = e.target.result;
										file.img_src = e.target.result;
					                	allFiles.push(file);
										//for show preview
										changePreview(file,'image');
									}
				                }
							}else if( file_type[0]== 'video' && !$fileDiv.hasClass('user_upload_img_div') && !$fileDiv.hasClass('brand-image')){

								// if(outlet_const == 'instagram' ){
								// 	getConfirm(language_message.insta_video_not_allowed,'','alert',function(confResponse) {});
								// 	return false;
								// }							

								if( file.size > upload_limit[outlet_const].video){
									getConfirm(language_message.video_size_limit.replace('%size%',(upload_limit[outlet_const].video)/1000000)+' MB','','alert',function(confResponse) {});
									return false;
								}

								if($('.form__file-preview').length >= 1){
									if($('.form__file-preview').src =='video'){
										getConfirm(language_message.video_upload_error,'','alert',function(confResponse) {});
										return false;
									}else{
										getConfirm(language_message.invalid_extention,'','alert',function(confResponse) {});
										return false;
									}
								}else{
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
										allFiles.push(file);
										//for show preview
										changePreview(file,'video');
					                }

									// set  data (data-preview-number) to video element for deleting video 
									total_images = $('video.form__file-preview').length;
									$(video).attr('data-preview-number',total_images);
								}							
							}else{
								$fileDiv.parent().find('.upload-error').removeClass('hide');
							}
						});
					}
				});
			}

			// if the form was submitted
			$(document).on( 'click','.submit-btn', function( e ){	
				var btn = this;	
				if($('#post-details').length && $(btn).attr('id') != 'draft' || $('#edit-post-details').length && $(btn).attr('id') != 'draft'){
			    	if(!create_post_validation()){
			    		return false;
			    	}
			    }

				if($(btn).attr('name') == 'resubmit')
				{
					$('#resubmit').val('resubmit');
				}
				else
				{
					$('#resubmit').val('');	
				}
					
				if($(btn).attr('id') == 'draft')
				{
					$('#save_as').val('draft');
				}
				else{
					$('#save_as').val('');
				}
				// preventing the duplicate submissions if the current one is in progress
				if( $form.hasClass( 'is-uploading' ) ) return false;

				$form.addClass( 'is-uploading' ).removeClass( 'is-error' );

				// ajax file upload for modern browsers
				if( isAdvancedUpload ) {
					e.preventDefault();

					// gathering the form data
					var ajaxData = new FormData( $form.get( 0 ) );

					if( allFiles ){
						var file_count = 0;
						$.each( allFiles, function( i, file ){
							if(typeof(file) == 'object' && file.name){
								ajaxData.append( 'file['+file_count+']',file,file.name);
								file_count++;
							}
							
						});
					}
					// return false;
					var other_data = $('form').serializeArray();
					$.each(other_data,function(key,input){
						if(input.name == 'brand_id' || input.id== 'post_user_id' || input.name == 'post_copy')
				        	ajaxData.append(input.name,input.value);
				    });
				   

					// ajax request
					$.ajax({
						url: 			$form.attr( 'upload' ),
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
							if(data.success)
							{
								if($(btn).hasClass('clear-phase'))
								{
									$.each($('[data-clear-phase]'),function(a,b){
										b.remove();
									});

								}
								// return;
								if(data.success != 'no_files')
									$('#uploaded_files').val(JSON.stringify(data));

								setTimeout(function(){
									$form.submit();
								},100);
								
							}
						},
						error: function(){
							getConfirm(language_message.upload_error,'','alert',function(confResponse) {});
						}
					});
				}

				// fallback Ajax solution upload for older browsers
				else {
					var iframeName	= 'uploadiframe' + new Date().getTime(),
						$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

					$( 'body' ).append( $iframe );
					$form.attr( 'target', iframeName );

					$iframe.one( 'load', function(){
						var data = $.parseJSON( $iframe.contents().find( 'body' ).text() );
						$form.removeClass( 'is-uploading' ).addClass( data.success == true ? 'is-success' : 'is-error' ).removeAttr( 'target' );
						if( !data.success ) $errorMsg.text( data.error );
						$iframe.remove();
					});
				}				
			});

			$(document).on( 'click','.schedule-cocreate', function( e ){		
				var btn = this;				
		    	if(!cocreate_validation()){
		    		return false;
		    	}

			    var newModal = $('#emptyModal').clone();
				newModal.attr('id', '');
				newModal.addClass('alert-modal modal-reschedule-post');
				newModal.find('.modal-dialog').addClass('form-inline').css('width', 380);
				$.get(base_url+'co_create/schedule/'+$('#brand_id').val(),function(data) {
					newModal.find('.modal-body').html('<h2 class="text-xs-center">Schedule Post</h2>' + data);
					newModal.find('[name="post_id"]').val($('#post_id').val());
					newModal.find('[type="submit"]').attr('type','button').addClass('schedule_cocreate');
					newModal.modal({
						show: true,
						backdrop: 'static'
					});
					newModal.on('shown.bs.modal', function () {
						addIncrements();
					});
				});
			    // $('.co-create-form').attr('action',base_url+"")
			    // $('.co-create-form').submit();

				// if($(btn).attr('name') == 'resubmit')
				// {
				// 	$('#resubmit').val('resubmit');
				// }
				// else
				// {
				// 	$('#resubmit').val('');	
				// }
					
				// if($(btn).attr('id') == 'draft')
				// {
				// 	$('#save_as').val('draft');
				// }
				// else{
				// 	$('#save_as').val('');
				// }
				// // preventing the duplicate submissions if the current one is in progress
				// if( $form.hasClass( 'is-uploading' ) ) return false;

				// $form.addClass( 'is-uploading' ).removeClass( 'is-error' );

				// // ajax file upload for modern browsers
				// if( isAdvancedUpload ) {
				// 	e.preventDefault();

				// 	// gathering the form data
				// 	var ajaxData = new FormData( $form.get( 0 ) );

				// 	if( allFiles ){
				// 		var file_count = 0;
				// 		$.each( allFiles, function( i, file ){
				// 			if(typeof(file) == 'object' && file.name){
				// 				ajaxData.append( 'file['+file_count+']',file,file.name);
				// 				file_count++;
				// 			}
							
				// 		});
				// 	}
				// 	// return false;
				// 	var other_data = $('form').serializeArray();
				// 	$.each(other_data,function(key,input){
				// 		if(input.name == 'brand_id' || input.id== 'post_user_id' || input.name == 'save_as')
				//         	ajaxData.append(input.name,input.value);
				//     });
				   

				// 	// ajax request
				// 	$.ajax({
				// 		url: 			$form.attr( 'upload' ),
				// 		type:			$form.attr( 'method' ),
				// 		data: 			ajaxData,
				// 		dataType:		'json',
				// 		cache:			false,
				// 		contentType:	false,
				// 		processData:	false,
				// 		complete: function(){
				// 			$form.removeClass( 'is-uploading' );
				// 		},
				// 		success: function( data ){
				// 			if(data.success)
				// 			{
				// 				if($(btn).hasClass('clear-phase'))
				// 				{
				// 					$.each($('[data-clear-phase]'),function(a,b){
				// 						b.remove();
				// 					});

				// 				}
				// 				// return;
				// 				if(data.success != 'no_files')
				// 					$('#uploaded_files').val(JSON.stringify(data));

				// 				setTimeout(function(){
				// 					$form.submit();
				// 				},100);
								
				// 			}
				// 		},
				// 		error: function(){
				// 			getConfirm(language_message.upload_error,'','alert',function(confResponse) {});
				// 		}
				// 	});
				// }

				// // fallback Ajax solution upload for older browsers
				// else {
				// 	var iframeName	= 'uploadiframe' + new Date().getTime(),
				// 		$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

				// 	$( 'body' ).append( $iframe );
				// 	$form.attr( 'target', iframeName );

				// 	$iframe.one( 'load', function(){
				// 		var data = $.parseJSON( $iframe.contents().find( 'body' ).text() );
				// 		$form.removeClass( 'is-uploading' ).addClass( data.success == true ? 'is-success' : 'is-error' ).removeAttr( 'target' );
				// 		if( !data.success ) $errorMsg.text( data.error );
				// 		$iframe.remove();
				// 	});
				// }				
			});

			save_cocreate_data();
			

			function save_cocreate_data()
			{
				if($('#page').length > 0 && $('#page').val() == 'co_create')
				{
					setTimeout(function(){
						if(typeof is_sender !== 'undefined' && is_sender)
					    {
							// preventing the duplicate submissions if the current one is in progress
							if( $form.hasClass( 'is-uploading' ) ) return false;

							// $form.addClass( 'is-uploading' ).removeClass( 'is-error' );

							// ajax file upload for modern browsers
							if( isAdvancedUpload ) {
								// gathering the form data
								var ajaxData = new FormData( $form.get( 0 ) );

								if( allFiles ){
									var file_count = 0;
									$.each( allFiles, function( i, file ){
										if(typeof(file) == 'object' && file.name){
											ajaxData.append( 'file['+file_count+']',file,file.name);
											file_count++;
										}
										
									});
								}
								// return false;
								var other_data = $('form').serializeArray();
								$.each(other_data,function(key,input){
									if(input.name == 'brand_id' || input.id== 'post_user_id' || input.name == 'save_as')
							        	ajaxData.append(input.name,input.value);
							    });
							   
								$('#uploaded_files').val(' ');
								// ajax request
								$.ajax({
									url: 			$form.attr( 'upload' ),
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
										if(data.success)
										{	
											if(data.success != 'no_files')
												$('#uploaded_files').val(JSON.stringify(data));

											setTimeout(function(){
												var ajaxData = new FormData( $form.get( 0 ) );			
												$.ajax({
										    		url:base_url+'co_create/save_cocreate_info',
										    		data:ajaxData,
										    		type:"POST",
										    		processData: false,
	    											contentType: false,
	    											dataType: 'json',
	    											success:function(response){
	    												if(response.response == 'success')
	    												{
	    													$('#cocreate_info_id').val(response.inserted_id);
	    													$('#post_id').val(response.post_id);
	    													$('.approval-list').html(response.approver_html);
	    													$('.participant-list').html(response.participant_html);
															//set height of chat list
														    var discussionH = $('.container-cocreate-discussion').height();
															var videoHeight = $('#videos').height();
															var participantH = $('.cocreate-participants').height();
															var approveH = $('.cocreate-approve').height();
															var chatH = discussionH - videoHeight - participantH - approveH;
															$('.discussion-list').css('height', chatH);
	    												}
	    											}
										    	});
											},100);

											save_cocreate_data();										
										}
									},
									error: function(){
										getConfirm(language_message.upload_error,'','alert',function(confResponse) {});
									}
								});
							}

							// fallback Ajax solution upload for older browsers
							else {
								var iframeName	= 'uploadiframe' + new Date().getTime(),
									$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

								$( 'body' ).append( $iframe );
								$form.attr( 'target', iframeName );

								$iframe.one( 'load', function(){
									var data = $.parseJSON( $iframe.contents().find( 'body' ).text() );
									$form.removeClass( 'is-uploading' ).addClass( data.success == true ? 'is-success' : 'is-error' ).removeAttr( 'target' );
									if( !data.success ) $errorMsg.text( data.error );
									$iframe.remove();
								});
							}	
					    }
					    else
					    {
					    	$.ajax({
					    		url: base_url+'co_create/update_preview',
					    		data:{'req_id': $('#co_create_req_id').val()},
					    		dataType: 'json',
					    		type:'POST',
					    		success:function(response){
					    			if(response.response == 'success')
					    			{
					    				if(response.html)
					    					$('#live-cocreate-preview').html(response.html);
					    				
					    				if(response.approver_status)
					    				{
					    					var btn = '.approve-cocreate';
						    				if(response.approver_status == 'approved')
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

										if(response.approver_html)
										{
											$('.approval-list').html(response.approver_html);
	    									$('.participant-list').html(response.participant_html);
										}
					    			}
									//set height of chat list
								    var discussionH = $('.container-cocreate-discussion').height();
									var videoHeight = $('#videos').height();
									var participantH = $('.cocreate-participants').height();
									var approveH = $('.cocreate-approve').height();
									var chatH = discussionH - videoHeight - participantH - approveH;
									$('.discussion-list').css('height', chatH);

					    			save_cocreate_data();
					    		}
					    	});
					    }
					},5000);
				}
			}


			//add user to brand
			$(document).on( 'click','.addUserToBrand', function( e ){
				if(plan_data.users > $('#all_users').val() || $('#user-select').val() != 'Add New')
				{
					var control = this;				
					$('.user-upload-img').show();
					$('.user-img-preview').hide();
					// ajax file upload for modern browsers
					if( isAdvancedUpload ) {
						e.preventDefault();
						// gathering the form data
						var ajaxData = new FormData();
						var other_data = $('form').serializeArray();
						$.each(other_data,function(key,input){
							if(input.name == 'brand_id' || input.name== 'user_id')
							{
								if(input.value)
									ajaxData.append(input.name,input.value);
							}
					    });

						// ajax request
						
						var brand_id = $('#brand_id').val();
				    	var fname = $('#firstName').val();
				    	var lname = $('#lastName').val();
				    	var title = $('#userTitle').val();
				    	var email = $('#userEmail').val();
				    	var selectedOutlets = $('#userOutlet').val();
				    	var userRoleSelect = $('#userRoleSelect :selected').val();
				    	var user_id = $('#post_user_id :selected').val();
				    	var selected_user = $('#user-select').val();
				    	if(selected_user != 'Add New')
				    	{
				    		fname = $('#user-select option:selected').attr('data-fname');
				    		lname = $('#user-select option:selected').attr('data-lname');
				    	}

				    	var selectedPermissions = [];
				    	var image_name = '';
				    	var user_pic = '';
				    	if($('#user_pic_base64').val() != ''){
				    		user_pic = $('#user_pic_base64').attr('value');
				    	}

				    	$('input[name="'+userRoleSelect+'-permissions[]"]:checked').each(function(i) {
						   selectedPermissions[i] = this.value;
						});

						$(control).addClass('btn-disabled');
				    	$.ajax({
				    		url: base_url+'brands/add_user',    		
				    		data:{'brand_id': brand_id,'first_name':fname,'last_name':lname,'title':title,'email':email,'outlets':selectedOutlets,'role':userRoleSelect,'permissions':selectedPermissions,'image_name': image_name,'file':user_pic,' user_id': user_id,'selected_user':selected_user},
				    		type: 'POST',
				    		dataType: 'json',
				    		contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				    		success: function(data)
				    		{
				    			
				    			$(control).removeClass('btn-disabled');
				    			if(data.response == "success")
				    			{
				    				$('#user_pic_base64').val('');
				    				$('#new_user_pic img').remove();
				    				$('#new_user_pic').removeClass('hasUpload');
				    				$('#userPermissionsList').append(data.html);
				    				$('.go-to-userlist').trigger('click');
				    				$('#firstName').val('');
							    	$('#lastName').val('');
							    	$('#userTitle').val('');
							    	$('#userEmail').val('');
							    	$('#userOutlet').val('');
							    	$('#userRoleSelect').val('');
							    	$('#userRoleSelect').trigger('change');
							    	$('#userSelect select').val('');
							    	$('#all_users').val(data.all_user_count);

							    	$('.user-img-preview').attr('src',base_url+'assets/images/default_profile.jpg');
							    	$('.user_upload_img_div').html('');
							    	$('.user_upload_img_div').removeClass('has-files');
							    	var html = '<input id="userFile" class="form__file" type="file" data-multiple-caption="{count} files selected" name="files[]">';
									html += '<label id="userFileLabel" class="file-upload-label" for="userFile">Upload photo</label>';
									html += '<button class="form__button btn btn-sm btn-default" type="submit">Upload</button>';
									$('.user_upload_img_div').html('');
							    	$('.user_upload_img_div').html(html);
							    	$('.remove-user-img').hide();
							    	allFiles = [];
							    	$('.user-upload-img').hide();
							    	$('.user-img-preview').show();
							    	
							    	$("#user-select option[value='"+data.inserted_id+"']").remove();
							    	if($('#add_user_next').hasClass('btn-disabled'))
							    	{
							    		$('#add_user_next').removeClass('btn-disabled');
							    	}
							    	$('#add_user_next').addClass('btn-secondary');
							    	$('#add_user_next').prop('disabled',false);
				    			}
				    			else
				    			{
				    				$('.user-upload-img').hide();
									$('.user-img-preview').show();
									if(!$('#add_user_next').hasClass('btn-disabled'))
							    	{
							    		$('#add_user_next').addClass('btn-disabled');
							    	}
							    	$('#add_user_next').removeClass('btn-secondary');
							    	$('#add_user_next').prop('disabled',true);
							    	getConfirm(language_message.unable_to_add_user,'','alert',function(confResponse) {});
									// alert(language_message.unable_to_add_user);
				    			}
				    		}
				    	});					   
					}

					// fallback Ajax solution upload for older browsers
					else {
						var iframeName	= 'uploadiframe' + new Date().getTime(),
							$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

						$( 'body' ).append( $iframe );
						$form.attr( 'target', iframeName );

						$iframe.one( 'load', function(){
							var data = $.parseJSON( $iframe.contents().find( 'body' ).text() );
							$form.removeClass( 'is-uploading' ).addClass( data.success == true ? 'is-success' : 'is-error' ).removeAttr( 'target' );
							if( !data.success ) $errorMsg.text( data.error );
							$iframe.remove();
						});
					}
				}
			    else
			    {
			    	getConfirm(language_message.user_limit.replace('%user_number%',plan_data.users),'','alert',function(confResponse) {});
			    }
			});

		    $('.remove-user-img').click(function(){
		    	$('.user_upload_img_div').removeClass('has-files');
		    	$('.user_upload_img_div').children('.form__file-preview').remove();
		    	var html = '<input id="userFile" class="form__file" type="file" data-multiple-caption="{count} files selected" name="files[]">';
				html += '<label id="userFileLabel" class="file-upload-label" for="userFile">Upload photo</label>';
				html += '<button class="form__button btn btn-sm btn-default" type="submit">Upload</button>';
				$('.user_upload_img_div').html('');
		    	$('.user_upload_img_div').html(html);
		    	allFiles = [];
		    	$(this).hide();
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
					$.each(allFiles,function(a,img){
						if(img.img_src === $(control).attr('src'))
						{
							imgIndex = a;							
							return;
						}
					});
					allFiles.splice(imgIndex, 1);

					$(this).remove();
					removeFromPreview();					
					var $uploads = $uploader.find('.form__preview-wrapper');
					if(!$uploads.length) {
						$uploader.removeClass('has-files');
					}
				});
		    });


			// restart the form if has a state of error/success
			$restart.on( 'click', function( e ){
				e.preventDefault();
				$form.removeClass( 'is-error is-success' );
				$input.trigger( 'click' );
			});

			// Firefox focus bug fix for file input
			$input
			.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
			.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
		});
		};

	})( jQuery, window, document );

	
	function changePreview(file,file_type)
	{
		if(file_type == 'video'){
			var video = document.createElement('video');
			video.onload = function () {
				window.URL.revokeObjectURL(this.src);
			};
			video.controls= true;
			video.src = window.URL.createObjectURL(file);
		}

		var selected,selected_outlet ='';
		var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
		var no_of_img = allFiles.length;
		var photoText = (no_of_img === 1) ? 'photo' :'photos';
		var outlet_id = jQuery('#postOutlet').val();
		selected = jQuery('#postOutlet').attr('data-outlet-const');
		selected_outlet = 'outlet_'+ selected;
		if(selected_outlet == 'outlet_facebook')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .img-div').prepend(video);
				jQuery("#live-post-preview .img-div video").css("width", "100%");
			}else{
				if(no_of_img == 1)
				{
					jQuery('#live-post-preview .img-div').append(preview_img);
				}
				if(no_of_img == 2) 
				{
					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('#live-post-preview .img-div').append(preview_img);
					jQuery('#live-post-preview .img-div img').wrap('<div class="width_50 img-item"></div>');
					preview_img.load(function() {
						getImgSizes('.img-div');
					});
				}
				if(no_of_img == 3) 
				{
					jQuery('#live-post-preview .img-div').css('height', 'auto').append('<div class="section1 img-wrapper"></div><div class="section2 img-wrapper"></div>');
					var img_1 = jQuery('#live-post-preview .img-div .img-item:eq(0) img');
					var img_2 = jQuery('#live-post-preview .img-div .img-item:eq(1)');
					img_1.unwrap();
					jQuery('#live-post-preview .img-div .section1').append(img_1);
					jQuery('#live-post-preview .img-div .section2').append(img_2);
					
					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('#live-post-preview .img-div .section2').append(preview_img);
					preview_img.wrap('<div class="width_50 img-item"></div>');
					preview_img.load(function() {
						getImgSizes('.section2');
					});
				}
				if(no_of_img == 4)
				{
					jQuery('#live-post-preview .img-div').css('height', 'auto');
					jQuery('#live-post-preview .img-div .section2 img').unwrap();
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="width_33 img-item"></div>');
					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('#live-post-preview .img-div .section2').append(preview_img);
					preview_img.wrap('<div class="width_33 img-item"></div>');
					preview_img.load(function() {
						getImgSizes('.section2');
					});
				}
	
				if(no_of_img == 5)
				{
					jQuery('#live-post-preview .img-div').css('height', 'auto');
					jQuery('#live-post-preview .img-div .section1 img').wrap('<div class="width_50 img-item"></div>');
					var img_2 = jQuery('#live-post-preview .img-div .section2 .img-item:eq(0)');
					img_2.removeClass('width_33').addClass('width_50').appendTo('#live-post-preview .section1');
					jQuery('#live-post-preview .img-div .section1 img').load(function() {
						getImgSizes('.section1');
					});
					jQuery('#live-post-preview .img-div .section2').css('height', '');
					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('#live-post-preview .img-div .section2').append(preview_img);
					preview_img.wrap('<div class="width_33 img-item"></div>');
					preview_img.load(function() {
						getImgSizes('.section2');
					});
				}
				if(no_of_img >= 6)
				{
					if(jQuery('.more-images').length >= 1)
					{
						var more_count = jQuery('.more-images').attr('id');
						more_count++;
						jQuery('.more-images').attr('id',more_count);
						jQuery('.more-images .vertical-center').html('+'+more_count);
					}
					else
					{
						var preview_img = '<div class="more-images" id="1"><span class="vertical-center">+1</span></div>';
						jQuery('#live-post-preview .section2 .img-item:last-child').append(preview_img);
					}
				}
				jQuery('.no-of-photos').html(' added <span class="photos_count">' + no_of_img + ' new ' + photoText + '</span>');
			}
		}
		//for twitter
		if(selected_outlet == 'outlet_twitter')
		{
			text_char_limit($('#postCopy').val(),140);
			if(file_type == 'video'){
				jQuery('#live-post-preview .twitter-img-div').prepend(video);
				jQuery("#live-post-preview .twitter-img-div video").css("width", "100%");
			}else{
				if(no_of_img == 1)
				{
					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('.twitter-img-div').empty();
					jQuery('#live-post-preview .twitter-img-div').append(preview_img);
				}
	
				if(no_of_img == 2)
				{
					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('#live-post-preview .twitter-img-div').append(preview_img);
					jQuery('#live-post-preview .img-div img').wrap('<div class="width_50 img-item"></div>');
					preview_img.load(function() {
						getImgSizes('.img-div');
					});
				}
	
				if(no_of_img == 3) 
				{
					jQuery('#live-post-preview .img-div img').unwrap();
					var img_1 = jQuery('#live-post-preview .img-div img:eq(0)');
					var img_2 = jQuery('#live-post-preview .img-div img:eq(1)');
					jQuery('#live-post-preview .img-div').css('height', 'auto').append('<div class="section1 pull-left width_twothirds"></div><div class="section2 pull-left img-wrapper width_33"></div>');
					jQuery('#live-post-preview .img-div .section1').append(img_1);
					jQuery('#live-post-preview .img-div .section2').append(img_2);
					var imgH = img_1.height();
					jQuery('#live-post-preview .img-div').css('height', imgH);
					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('#live-post-preview .img-div .section2').append(preview_img);
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="img-wrapper height_50"></div>');
				}
	
				if(no_of_img == 4)
				{
					jQuery('#live-post-preview .img-div .section2 img').unwrap();

					var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
					jQuery('#live-post-preview .img-div .section2').append(preview_img);
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="img-wrapper height_33"></div>');
				}
			}
		}
		//for insta
		if( selected_outlet == 'outlet_instagram')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .insta-img-div').prepend(video);
				jQuery("#live-post-preview .insta-img-div video").css("width", "100%");
			}else{
				var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
				jQuery('.insta-img-div').empty();
				jQuery('#live-post-preview .insta-img-div').append(preview_img);
			}
		}
			
		//for linkedin
		if(selected_outlet == 'outlet_linkedin')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .likedin-img-div').prepend(video);
				jQuery("#live-post-preview .likedin-img-div video").css("width", "100%");
			}else{
				var preview_img = '<img src="'+window.URL.createObjectURL(file)+'" >';
				jQuery('.likedin-img-div').empty();
				jQuery('#live-post-preview .likedin-img-div').append(preview_img);
			}
		}
	
		//for tumblr
		if(selected_outlet == 'outlet_tumblr')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .img-div').prepend(video);
				jQuery("#live-post-preview .img-div video").css("width", "100%");
			}else{
				var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
				jQuery('#live-post-preview .img-div').append(preview_img);
			}
			preview_img.load(function() {
				equalColumns();
			});
		}
	
		//for vine
		if(selected_outlet == 'outlet_vine')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .video-div').prepend(video);
				jQuery("#live-post-preview video").css("width", "100%");
			}
		}
		if(selected_outlet == 'outlet_youtube')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .video-div').prepend(video);
				jQuery("#live-post-preview video").css("width", "100%");
			}
		}
		if(selected_outlet == 'outlet_pinterest')
		{
			if(file_type == 'image'){
				var preview_img = jQuery('<img/>', {src: window.URL.createObjectURL(file)});
				jQuery('.pinterest-img-div').empty();
				jQuery('#live-post-preview .pinterest-img-div').append(preview_img);
			}
		}
		equalColumns();
	}
	
	function getImgSizes(div) {
		var imgHs=[];
		jQuery('#live-post-preview ' + div + ' img').each(function() {
			imgHs.push(jQuery(this).height());
		});
		var smallestImg = Math.min.apply(null, imgHs);
		jQuery('#live-post-preview ' + div).height(smallestImg);
	}

	function removePreview(){
		var $ = jQuery;
		$('#live-post-preview').empty();
		$('.no-of-photos').html('');
		var outlet_id = $('#postOutlet').attr('data-outlet-const');
    	var post_copy;
		if($('#postCopy').val()) {
    		post_copy = $('#postCopy').val().replace(/\r?\n/g,'<br/>')
			post_copy = convertToLink(post_copy);
			post_copy = hashtagToLink(post_copy);
			post_copy = atToLink(post_copy);
			$('#outlet_'+outlet_id+' .post_copy_text').html(post_copy.replace(/\r?\n/g, '<br/>'));
		}
		$('#live-post-preview').append($('#outlet_'+outlet_id).html());
    }

	removeFromPreview = function removeFromPreview() {
		var $ = jQuery, imgTag;
		var imgTags = $('.form__preview-wrapper').find('img');
		var videoTags = $('.form__preview-wrapper').find('video');
		
		removePreview();

		if(videoTags.length)
		{
			$.each(videoTags,function(a,videoTag){
				var video = document.createElement('video');
				video.onload = function () {
					window.URL.revokeObjectURL(this.src);
				};
				video.className = 'form__file-preview';
				video.src = $(videoTag).attr('src');

				jQuery('#live-post-preview .twitter-img-div').prepend(video);
				jQuery("#live-post-preview .twitter-img-div video").css("width", "100%");
				jQuery("#live-post-preview .twitter-img-div video").removeAttr('class');

				jQuery('#live-post-preview .insta-img-div').prepend(video);
				jQuery("#live-post-preview .insta-img-div video").css("width", "100%");
				jQuery("#live-post-preview .insta-img-div video").removeAttr('class');

				jQuery('#live-post-preview .video-div').prepend(video);
				jQuery("#live-post-preview video").css("width", "100%");
				jQuery("#live-post-preview video").removeAttr('class');

				jQuery('#live-post-preview .img-div').prepend(video);
				jQuery("#live-post-preview .img-div video").css("width", "100%");
				jQuery("#live-post-preview .img-div video").removeAttr('class');

				jQuery('#live-post-preview .twitter-img-div').prepend(video);
				jQuery("#live-post-preview .twitter-img-div video").css("width", "100%");
				jQuery("#live-post-preview .twitter-img-div video").removeAttr('class');

				jQuery('#live-post-preview .video-div').prepend(video);
				jQuery("#live-post-preview .video-div video").css("width", "100%");
				jQuery("#live-post-preview .video-div video").removeAttr('class');
			});
		}
		else
		{
			var selected,selected_outlet ='';
			var no_of_img = allFiles.length;
			var photoText = (no_of_img === 1) ? 'photo' :'photos';
			var outlet_id = jQuery('#postOutlet').val();
			selected = jQuery('#postOutlet').attr('data-outlet-const');
			selected_outlet = 'outlet_'+ selected;
			if(selected_outlet == 'outlet_facebook')
			{
				if(no_of_img == 1)
				{
					var preview_img = jQuery('<img/>', {src: allFiles[0].img_src});
					jQuery('#live-post-preview .img-div').append(preview_img);
				}
				if(no_of_img == 2)
				{
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						jQuery('#live-post-preview .img-div').append(preview_img);
						preview_img.load(function() {
							getImgSizes('.img-div');
						});
					});
					jQuery('#live-post-preview .img-div img').wrap('<div class="width_50 img-item"></div>');
				}
				if(no_of_img == 3)
				{
					jQuery('#live-post-preview .img-div').append('<div class="section1 img-wrapper"></div><div class="section2 img-wrapper"></div>');
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						if(a === 0) {
							jQuery('#live-post-preview .img-div .section1').append(preview_img);
						}
						else {
							jQuery('#live-post-preview .img-div .section2').append(preview_img);
						}
						preview_img.load(function() {
							getImgSizes('.section2');
						});
					});
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="width_50 img-item"></div>');
				}

				if(no_of_img == 4)
				{
					jQuery('#live-post-preview .img-div').append('<div class="section1 img-wrapper"></div><div class="section2 img-wrapper"></div>');
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						if(a === 0) {
							jQuery('#live-post-preview .img-div .section1').append(preview_img);
						}
						else {
							jQuery('#live-post-preview .img-div .section2').append(preview_img);
							preview_img.load(function() {
								getImgSizes('.section2');
							});
						}
					});
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="width_33 img-item"></div>');
				}

				if(no_of_img == 5)
				{
					jQuery('#live-post-preview .img-div').append('<div class="section1 img-wrapper"></div><div class="section2 img-wrapper"></div>');
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						if(a === 0 || a === 1) {
							jQuery('#live-post-preview .img-div .section1').append(preview_img);
							preview_img.load(function() {
								getImgSizes('.section1');
							});
						}
						else {
							jQuery('#live-post-preview .img-div .section2').append(preview_img);
							preview_img.load(function() {
								getImgSizes('.section2');
							});
						}
					});
					jQuery('#live-post-preview .img-div .section1 img').wrap('<div class="width_50 img-item"></div>');
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="width_33 img-item"></div>');
				}

				if(no_of_img >= 6)
				{
					jQuery('#live-post-preview .img-div').append('<div class="section1 img-wrapper"></div><div class="section2 img-wrapper"></div>');
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						if(a === 0 || a === 1) {
							jQuery('#live-post-preview .img-div .section1').append(preview_img);
							preview_img.load(function() {
								getImgSizes('.section1');
							});
						}
						else if(a <=4) {
							jQuery('#live-post-preview .img-div .section2').append(preview_img);
							preview_img.load(function() {
								getImgSizes('.section2');
							});
						}
					});
					var more_num = no_of_img - 5;
					jQuery('#live-post-preview .img-div .section1 img').wrap('<div class="width_50 img-item"></div>');
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="width_33 img-item"></div>');
					var more_img = '<div class="more-images" id="' + more_num + '"><span class="vertical-center">+' + more_num + '</span></div>';
					jQuery('#live-post-preview .section2 .img-item:last-child').append(more_img);
				}
				if(no_of_img > 0) {
					jQuery('.no-of-photos').html(' added <span class="photos_count">' + no_of_img + ' new ' + photoText + '</span>');
				}
				else {
					jQuery('.no-of-photos').html('');
				}
			}
			//for twitter
			if(selected_outlet == 'outlet_twitter')
			{
				if(no_of_img == 1)
				{
					var preview_img = jQuery('<img/>', {src: allFiles[0].img_src});
					jQuery('#live-post-preview .img-div').append(preview_img);
				}

				if(no_of_img == 2)
				{
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						jQuery('#live-post-preview .img-div').append(preview_img);
						preview_img.load(function() {
							getImgSizes('.img-div');
						});
					});
					jQuery('#live-post-preview .img-div img').wrap('<div class="width_50 img-item"></div>');
				}

				if(no_of_img == 3)
				{
					jQuery('#live-post-preview .img-div').append('<div class="section1 pull-left width_twothirds"></div><div class="section2 pull-left img-wrapper width_33"></div>');
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						jQuery('#live-post-preview .img-div').append(preview_img);
						if(a === 1) {
							jQuery('#live-post-preview .img-div .section1').append(preview_img);
						}
						else {
							jQuery('#live-post-preview .img-div .section2').append(preview_img);
						}
					});
					jQuery('#live-post-preview .img-div .section1 img').load(function() {
						var imgH = jQuery(this).height();
						jQuery('#live-post-preview .img-div').css('height', imgH);
					});
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="img-wrapper height_50"></div>');
				}

				if(no_of_img == 4)
				{
					jQuery('#live-post-preview .img-div').append('<div class="section1 pull-left width_twothirds"></div><div class="section2 pull-left img-wrapper width_33"></div>');
					$.each(allFiles,function(a,img){
						var preview_img = jQuery('<img/>', {src: img.img_src});
						jQuery('#live-post-preview .img-div').append(preview_img);
						if(a === 1) {
							jQuery('#live-post-preview .img-div .section1').append(preview_img);
						}
						else {
							jQuery('#live-post-preview .img-div .section2').append(preview_img);
						}
					});
					jQuery('#live-post-preview .img-div .section1 img').load(function() {
						var imgH = jQuery(this).height();
						jQuery('#live-post-preview .img-div').css('height', imgH);
					});
					jQuery('#live-post-preview .img-div .section2 img').wrap('<div class="img-wrapper height_33"></div>');
				}
				
				text_char_limit($('#postCopy').val(),140);
			}

			//for insta
			if( selected_outlet == 'outlet_instagram')
			{
				$.each(allFiles,function(a,img){
					var preview_img = jQuery('<img/>', {src: img.img_src});
					jQuery('.img-div').empty();
					jQuery('#live-post-preview .img-div').append(preview_img);
				});
			}

			//for linkedin
			if(selected_outlet == 'outlet_linkedin')
			{
				$.each(allFiles,function(a,img){
					var preview_img = jQuery('<img/>', {src: img.img_src});
					jQuery('.likedin-img-div').empty();
					jQuery('#live-post-preview .img-div').append(preview_img);
				});
			}

			//for tumblr
			if(selected_outlet == 'outlet_tumblr')
			{
				$.each(allFiles,function(a,img){
					var preview_img = jQuery('<img/>', {src: img.img_src});
					jQuery('#live-post-preview .img-div').append(preview_img);
				});
			}

			//for vine
			if(selected_outlet == 'outlet_vine')
			{
				jQuery('.video-div').empty();
			}
			if(selected_outlet == 'outlet_youtube')
			{
				jQuery('.video-div').empty();
			}
			if(selected_outlet == 'outlet_pinterest')
			{
				$.each(allFiles,function(a,img){
					var preview_img = jQuery('<img/>', {src: img.img_src});
					jQuery('.pinterest-img-div').empty();
					jQuery('#live-post-preview .pinterest-img-div').append(preview_img);
				});
			}
			equalColumns();
		}		
	};



	