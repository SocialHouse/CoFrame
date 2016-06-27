// JavaScript Document
	'use strict';

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
				allFiles = [],
				total_images = '',
				outlet = $form.find('#postOutlet').val(),
				showFiles	 = function( files , control){

					$(control).parents('.file-upload-label').text( files.length > 1 ? ( $(control).parents('input[type="file"]').attr( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name );
				};

			$('#post-details .outlet-list li').on('click', function() {
				var previous_outlet = $('#postOutlet').val();
				var outlet = $(this).data('selectedOutlet');
				if(previous_outlet != outlet)
				{
					allFiles = [];
				}
			});

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
			$(document).on( 'change','input[type="file"]', function( e ){

				if( $(this).attr('id') != 'fileInput' && $(this).attr('id') != 'userfileInput')
				{
					var $fileDiv = $(this).parents('.form__input');
					$fileDiv.parent().find('.upload-error').addClass('hide');
					var fileInput = this;
					var error = 'false';



					showFiles( e.target.files,this);
						droppedFiles = e.target.files; // the files that were dropped				
						var reader = new FileReader();
						$.each(droppedFiles, function (index, file) {
							
							var file_type = file.type.split('/');
							if($.inArray(file_type[1] ,supported_files) == -1){
								alert('Invalid file extention');
								return false;
							};
							if( file_type[0]== 'image'){
								if( file.size > 2000000){
									alert('Image size should be less than 2 MB');
									return false;
								}
								if($fileDiv.find('video').length > 0){
									alert('Invalid file extention');
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
								allFiles.push(file)

								var img = document.createElement('img');
								//for live review fb
								var preview_img = document.createElement('img');
								img.onload = function () {
									window.URL.revokeObjectURL(this.src);
								};
								img.className = 'form__file-preview';

								img.src = window.URL.createObjectURL(file);
								var imgDiv = document.createElement('div');
								imgDiv.className = 'form__preview-wrapper';
								$(imgDiv).html('<i class="tf-icon-circle remove-upload">x</i>');
								$(imgDiv).append(img);
								
								$fileDiv.prepend(imgDiv).addClass('has-files');

								// set  data (data-preview-number) to image tag for deleting image 
								total_images = $('img.form__file-preview').length;
								$(img).attr('data-preview-number',total_images);

								reader.readAsDataURL(file);
								reader.onload = function (e) {
									img.src = e.target.result;
				                }

								//to sho user uploded img on add role page
								if($('.user-img-preview').length)
								{
									$('.user-img-preview').attr('src',window.URL.createObjectURL(file));
								}

								//for show preview
								changePreview(file,'image');
							}else if(file_type[0]== 'video' && !$fileDiv.hasClass('user_upload_img_div') && !$fileDiv.hasClass('brand-image')){
								if( file.size > 209715200){
									alert('Video size should be less than 2 MB');
									return false;
								}
								if($('.form__file-preview').length >= 1){
									
									if(file_type[0] =='video'){
										alert('You can\'t add more than 1 video');
									}else{
										alert('Invalid file extention');
									}
									return false;
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
									allFiles.push(file);
									var video = document.createElement('video');
									//for live review fb
									video.onload = function () {
										window.URL.revokeObjectURL(this.src);
									};

									video.className = 'form__file-preview';
									video.src = window.URL.createObjectURL(file);
									
									$fileDiv.prepend(video).addClass('has-files');

									total_images = $('video.form__file-preview').length;
									$(video).attr('data-preview-number',total_images);

									//to show user uploded img on add role page
									if($('.user-img-preview').length)
									{
										$('.user-img-preview').attr('src',window.URL.createObjectURL(file));
									}
									//for show preview								
									changePreview(file,'video');								
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
						$.each(droppedFiles, function (index, file) {
							var file_type = file.type.split('/');
							if($.inArray(file_type[1] ,supported_files) == -1){
								alert('Invalid file extention');
								return false;
							};
							if( file_type[0]== 'image'){
								if( file.size > 2000000){
									alert('Image size should be less than 200 MB');
									return false;
								}
								if($('.form__file-preview').src=='video'){
									alert('Invalid file extention');
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
								allFiles.push(file);
								var img = document.createElement('img');
								img.onload = function () {
									window.URL.revokeObjectURL(this.src);
								};

								img.className = 'form__file-preview';
								img.src = window.URL.createObjectURL(file);
								var imgDiv = document.createElement('div');
								imgDiv.className = 'form__preview-wrapper';
								$(imgDiv).html('<i class="tf-icon-circle remove-upload">x</i>');
								$(imgDiv).append(img);
								$(target_file_input).prepend(imgDiv).addClass('has-files');

								// set  data (data-preview-number) to image tag for deleting image 
								total_images = $('img.form__file-preview').length;
								$(img).attr('data-preview-number',total_images);

								var reader = new FileReader();
			                    reader.onload = function (e) {
			                       $(img).attr("src", e.target.result);
			                    }
								//for show preview
								changePreview(file,'image');
							}else if( file_type[0]== 'video' && !$fileDiv.hasClass('user_upload_img_div') && !$fileDiv.hasClass('brand-image')){

								if( file.size > 209715200){
									alert('video size should be less than 200 Mb');
									return false;
								}

								if($('.form__file-preview').length >= 1){
									
									if($('.form__file-preview').src =='video'){
										alert('You can\'t add more than 1 video');	
									}else{
										alert('Invalid file extention');
									}
									return false;
								}else{

									var video = document.createElement('video');
									video.onload = function () {
										window.URL.revokeObjectURL(this.src);
									};
									video.className = 'form__file-preview';
									video.src = window.URL.createObjectURL(file);
									$(target_file_input).prepend(video).addClass('has-files');
									//for show preview

									// set  data (data-preview-number) to video element for deleting video 
									total_images = $('video.form__file-preview').length;
									$(video).attr('data-preview-number',total_images);

									changePreview(file,'video');
								}							
							}else{
								$fileDiv.parent().find('.upload-error').removeClass('hide');
							}
						});
					}
					//$form.trigger( 'submit' ); // automatically submit the form on file drop
				});
			}

			// if the form was submitted
			$(document).on( 'click','.submit-btn', function( e ){	
				var btn = this;	
					
				if($(this).attr('id') == 'draft')
				{
					$('#save_as').val('draft');
				}
				else
					$('#save_as').val('');
				// preventing the duplicate submissions if the current one is in progress
				if( $form.hasClass( 'is-uploading' ) ) return false;

				$form.addClass( 'is-uploading' ).removeClass( 'is-error' );

				// ajax file upload for modern browsers
				if( isAdvancedUpload ) {
					e.preventDefault();

					// gathering the form data
					var ajaxData = new FormData( $form.get( 0 ) );
					if( allFiles ){
						$.each( allFiles, function( i, file ){							
							ajaxData.append( 'file['+i+']', file,file.name);
						});					
					}
					// return false;
					var other_data = $('form').serializeArray();
					$.each(other_data,function(key,input){
						if(input.name == 'brand_id' || input.id== 'post_user_id' || input.name == 'save_as')
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
							alert( 'There was a problem with your upload.  Please try again.' );
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




			//add user to brand
			$(document).on( 'click','.addUserToBrand', function( e ){
				var control = this;
				// preventing the duplicate submissions if the current one is in progress
				// if( $form.hasClass( 'is-uploading' ) ) return false;

				// $form.addClass( 'is-uploading' ).removeClass( 'is-error' );
				$('.user-upload-img').show();
				$('.user-img-preview').hide();
				// ajax file upload for modern browsers
				if( isAdvancedUpload ) {
					e.preventDefault();


					// gathering the form data
					var ajaxData = new FormData();
					// $.each( allFiles, function( i, file ){
					// 	ajaxData.append( 'file['+i+']', file,file.name);
					// });
					
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
			    	var selectedPermissions = [];
			    	var image_name = '';
			    	var user_pic = '';
			    	console.log($('#user_pic_base64').val());
			    	if($('#user_pic_base64').val() != ''){
			    		user_pic = $('#user_pic_base64').attr('value');
			    	}
			    	
			    	$('input[name="'+userRoleSelect+'-permissions[]"]:checked').each(function(i) {
					   selectedPermissions[i] = this.value;
					});
			    	$.ajax({
			    		url: base_url+'brands/add_user',    		
			    		data:{'brand_id': brand_id,'first_name':fname,'last_name':lname,'title':title,'email':email,'outlets':selectedOutlets,'role':userRoleSelect,'permissions':selectedPermissions,'image_name': image_name,'file':user_pic,' user_id': user_id },
			    		type: 'POST',
			    		dataType: 'json',
			    		contentType: "application/x-www-form-urlencoded;charset=UTF-8",
			    		success: function(data)
			    		{
			    			if(data.response == "success")
			    			{
			    				$('#userPermissionsList').append(data.html);
			    				$('.go-to-userlist').trigger('click');
			    				$('#firstName').val('');
						    	$('#lastName').val('');
						    	$('#userTitle').val('');
						    	$('#userEmail').val('');
						    	$('#userOutlet').val('');
						    	$('#userRoleSelect').val('');
						    	$('#userRoleSelect').trigger('change');

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
								alert('Unable to add user.');
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
				var imgSrc = $(this).next('img').attr('src');
				console.log(imgSrc);
				$(this).parent('.form__preview-wrapper').fadeOut(function() {
					$(this).remove();
					removeFromPreview(imgSrc);
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
		}

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

		var selected,selected_outlet ='' ;
		var preview_img = '<img class="post-img" src="'+window.URL.createObjectURL(file)+'" >';
		// preview_img.src = window.URL.createObjectURL(file);
		var no_of_img = jQuery('#live-post-preview .img-div img').length;
		var outlet_id = jQuery('#postOutlet').val();
		selected = jQuery('#postOutlet').attr('data-outlet-const');		
		selected_outlet = 'outlet_'+ selected;
		if(selected_outlet == 'outlet_facebook')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .img-div').prepend(video);
				jQuery("#live-post-preview .img-div video").css("width", "100%");
			}else{
				if(no_of_img == 0)
				{
					jQuery('#live-post-preview .img-div').append(preview_img);
				}
				if(no_of_img == 1) 
				{
					jQuery('#live-post-preview .img-div img:first').addClass('width_50');
					jQuery('#live-post-preview .img-div img:first').removeClass('post-img');
					var preview_img = '<img class="width_50" src="'+window.URL.createObjectURL(file)+'" >';
					jQuery('#live-post-preview .img-div').append(preview_img);
					jQuery('.no-of-photos').html('added <span class="photos_count">2 new photos</span>');
				}
				if(no_of_img == 2) 
				{
					jQuery('#live-post-preview .img-div').addClass('clearfix');
					jQuery('#live-post-preview .img-div').append('<div class="pull-left section1"></div>');
					jQuery('#live-post-preview .img-div').append('<div class="pull-left width_50 section2"></div>');
					var img_1 = jQuery('#live-post-preview .img-div img:eq(1)');
					var img_2 = jQuery('#live-post-preview .img-div img:eq(0)');
					jQuery('#live-post-preview .img-div .section1').append(img_1);
					img_1.removeClass('width_50');
					jQuery('#live-post-preview .img-div .section2').append(img_2);
					var preview_img = '<img class="section_2_img img-radious-right-bottom" src="'+window.URL.createObjectURL(file)+'" >';
					jQuery('#live-post-preview .img-div .section2').append(preview_img);
					jQuery('.no-of-photos').html('added <span class="photos_count">4 new photos</span>');
				}

				if(no_of_img == 3)
				{
					jQuery('#live-post-preview .img-div .section2 img').removeClass('width_50');
					jQuery('#live-post-preview .img-div .section2').addClass('width_33');
					jQuery('#live-post-preview .img-div img:eq(1)').removeClass('width_50');
					jQuery('#live-post-preview .img-div img:eq(2)').addClass('width_33');
					jQuery('#live-post-preview .img-div img:eq(2)').removeClass('width_50');
					var preview_img = '<img class="width_33" src="'+window.URL.createObjectURL(file)+'" >';
					jQuery('#live-post-preview .img-div').append(preview_img);
					jQuery('.no-of-photos').html('added <span class="photos_count">4 new photos</span>');
				}

				if(no_of_img == 4)
				{
					jQuery('#live-post-preview .img-div img:eq(0)').addClass('width_50');
					jQuery('#live-post-preview .img-div img:eq(0)').removeClass('post-img');

					jQuery('#live-post-preview .img-div img:eq(1)').addClass('width_50');
					jQuery('#live-post-preview .img-div img:eq(1)').removeClass('width_33');
					var preview_img = '<img class="width_33" src="'+window.URL.createObjectURL(file)+'" >';
					jQuery('#live-post-preview .img-div').append(preview_img);
					jQuery('.no-of-photos').html('added <span class="photos_count">5 new photos</span>');
				}

				if(no_of_img >= 5)
				{
					if(jQuery('.more-images').length >= 1)
					{
						var more_count = jQuery('.more-images').attr('id');
						more_count++;
						jQuery('.more-images').attr('id',more_count);
						jQuery('.more-images').html('+'+more_count);
						jQuery('.no-of-photos').html('added <span class="photos_count">'+more_count+' new photos</span>');
					}
					else
					{
						var preview_img = '<div class="more-images" id="1"> +1</div>';
						jQuery('#live-post-preview .img-div').append(preview_img);
						jQuery('.no-of-photos').html('added <span class="photos_count">6 new photos</span>');
					}
				}
			}
		}
		//for twitter
		if(selected_outlet == 'outlet_twitter')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .twitter-img-div').prepend(video);
				jQuery("#live-post-preview .twitter-img-div video").css("width", "100%");
			}else{
				if(no_of_img == 0)
				{
					var preview_img = '<div class="pull-left"><img class="img-radious" src="'+window.URL.createObjectURL(file)+'" ></div>';
					jQuery('.twitter-img-div').empty();
					jQuery('#live-post-preview .twitter-img-div').append(preview_img);
				}

				if(no_of_img == 1) 
				{
					jQuery('#live-post-preview .twitter-img-div .pull-left:first').addClass('width_50');
					jQuery('#live-post-preview .twitter-img-div .pull-left:first img:first').addClass('height_135');
					jQuery('#live-post-preview .twitter-img-div .pull-left:first img:first').addClass('img-radious-left');
					jQuery('#live-post-preview .twitter-img-div .pull-left:first img:first').removeClass('img-radious');

					var preview_img = '<div class="pull-left width_50"><img class="img-radious-right height_135" src="'+window.URL.createObjectURL(file)+'" ></div>';
					jQuery('#live-post-preview .twitter-img-div').append(preview_img);
				}

				if(no_of_img == 2) 
				{
					jQuery('#live-post-preview .twitter-img-div .pull-left:first').removeClass('width_50');
					jQuery('#live-post-preview .twitter-img-div .pull-left:first').addClass('section1');

					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1)').addClass('section2');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').addClass('img-radious-right-top');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').addClass('width_30');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').addClass('section_2_img');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').addClass('padding_bottom');	
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').removeClass('height_135');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').removeClass('img-radious-right');

					var preview_img = '<img class="width_30 section_2_img img-radious-right-bottom" src="'+window.URL.createObjectURL(file)+'" >';
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1)').append(preview_img);
				}

				if(no_of_img == 3) 
				{
					jQuery('#live-post-preview .twitter-img-div .pull-left:first').css('width','75%');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1)').css('width','25%');

					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').removeClass('section_2_img');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:first').addClass('section_3_img');

					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:eq(1)').removeClass('section_2_img');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:eq(1)').addClass('section_3_img');
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:eq(1)').removeClass('img-radious-right-bottom');				
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1) img:eq(1)').addClass('padding_bottom');

					var preview_img = '<img class="width_30 section_3_img img-radious-right-bottom" src="'+window.URL.createObjectURL(file)+'" >';
					jQuery('#live-post-preview .twitter-img-div .pull-left:eq(1)').append(preview_img);
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
				var preview_img = '<img src="'+window.URL.createObjectURL(file)+'" >';
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
				jQuery('#live-post-preview .tumblr-img-div').prepend(video);
				jQuery("#live-post-preview .tumblr-img-div video").css("width", "100%");
			}else{
				var preview_img = '<img width="100%" src="'+window.URL.createObjectURL(file)+'" >';
				jQuery('#live-post-preview .tumblr-img-div').append(preview_img);
			}
		}

		//for vine
		if(selected_outlet == 'outlet_vine')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .content').prepend(video);
				jQuery("#live-post-preview .content video").css("width", "100%");
			}else{
				var preview_img = '<img width="100%" src="'+window.URL.createObjectURL(file)+'" >';
	            jQuery('.vine-img-div').empty();
	            jQuery('#live-post-preview .content').append(preview_img);	
            }	
		}
		if(selected_outlet == 'outlet_youtube')
		{
			if(file_type == 'video'){
				jQuery('#live-post-preview .content').prepend(video);
				jQuery("#live-post-preview .content video").css("width", "100%");
			}else{
				var preview_img = '<img width="100%" src="'+window.URL.createObjectURL(file)+'" >';
	            jQuery('.vine-img-div').empty();
	            jQuery('#live-post-preview .content').append(preview_img);	
            }	
		}
		if(selected_outlet == 'outlet_pinterest')
		{
			if(file_type == 'images'){
	            var preview_img = '<img src="'+window.URL.createObjectURL(file)+'" >';
	            jQuery('.pinterest-img-div').empty();
	            jQuery('#live-post-preview .pinterest-img-div').append(preview_img);
	        }
		}
	}

	function removeFromPreview(file) {
		var $ = jQuery, imgTag;
		imgTag = $('#live-post-preview').find('img');
		$.each(imgTag, function(i, img){
			if($(this).attr('src') == file ){
				console.log('img removed');
			}
		})
	}

	