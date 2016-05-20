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
				droppedFiles = false,
				allFiles = [],
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

			// letting the server side to know we are going to make an Ajax request
			$form.append( '<input type="hidden" name="ajax" value="1" />' );

			// automatically submit the form on file select
			$(document).on( 'change','input[type="file"]', function( e ){		
				console.log(this);
				showFiles( e.target.files,this);
					droppedFiles = e.target.files; // the files that were dropped
					var $fileDiv = $(this).parents('.form__input');
					$.each(droppedFiles, function (index, file) {
						allFiles.push(file)
						var img = document.createElement('img');
						//for live review fb
						var preview_img = document.createElement('img');
						img.onload = function () {
							window.URL.revokeObjectURL(this.src);
						};
						img.className = 'form__file-preview';
						img.src = window.URL.createObjectURL(file);
						$fileDiv.prepend(img).addClass('has-files');
						//for show preview
						changePreview(file);
					});
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
					droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
					var $fileDiv = $('.form__input');

					$.each(droppedFiles, function (index, file) {
						allFiles.push(file)
						var img = document.createElement('img');
						img.onload = function () {
							window.URL.revokeObjectURL(this.src);
						};
						img.className = 'form__file-preview';
						img.src = window.URL.createObjectURL(file);
						$fileDiv.prepend(img).addClass('has-files');

						//for show preview
						changePreview(file);
					});
					
					//$form.trigger( 'submit' ); // automatically submit the form on file drop
				});
			}

			// if the form was submitted
			$('#submit-btn').on( 'click', function( e ){
				// preventing the duplicate submissions if the current one is in progress
				if( $form.hasClass( 'is-uploading' ) ) return false;

				$form.addClass( 'is-uploading' ).removeClass( 'is-error' );

				// ajax file upload for modern browsers
				if( isAdvancedUpload ) {
					e.preventDefault();

					// gathering the form data
					var ajaxData = new FormData( $form.get( 0 ) );
					if( droppedFiles ){
						$.each( droppedFiles, function( i, file ){
							ajaxData.append( 'file['+i+']', file,file.name);
						});					
					}

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
								$('#uploaded_files').val(JSON.stringify(data));
								$form.submit();
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

			//save brand image
			// if the form was submitted
			$('.save_brand').on( 'click', function( e ){
				var control = this;
				// preventing the duplicate submissions if the current one is in progress
				if( $form.hasClass( 'is-uploading' ) ) return false;

				$form.addClass( 'is-uploading' ).removeClass( 'is-error' );

				// ajax file upload for modern browsers
				if( isAdvancedUpload ) {
					e.preventDefault();

					// gathering the form data
					var ajaxData = new FormData( $form.get( 0 ) );
				
					$.each( allFiles, function( i, file ){
						ajaxData.append( 'file['+i+']', file,file.name);
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
							if(data.response == 'success')
							{
								$('#brand_id').val(data.brand_id);
								$(control).parents().children('.btn-next-step').trigger('click');
							}
							else
							{

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

	function changePreview(file)
	{
		var preview_img = '<img class="post-img" src="'+window.URL.createObjectURL(file)+'" >';
		// preview_img.src = window.URL.createObjectURL(file);
		var no_of_img = jQuery('#live-post-preview .img-div img').length;
		var outlet_id = jQuery('#postOutlet').val();
		if(outlet_id == 1)
		{
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
				jQuery('#live-post-preview .img-div img:first').addClass('post-img');
				jQuery('#live-post-preview .img-div img:first').removeClass('width_50');
				var preview_img = '<img class="width_50" src="'+window.URL.createObjectURL(file)+'" >';
				jQuery('#live-post-preview .img-div').append(preview_img);
				jQuery('.no-of-photos').html('added <span class="photos_count">3 new photos</span>');
			}

			if(no_of_img == 3)
			{
				jQuery('#live-post-preview .img-div img:eq(1)').addClass('width_33');
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
		//for twitter
		if(outlet_id == 2)
		{
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
		//for insta
		if(outlet_id == 3)
		{
			var preview_img = '<img src="'+window.URL.createObjectURL(file)+'" >';
			jQuery('.insta-img-div').empty();
			jQuery('#live-post-preview .insta-img-div').append(preview_img);
		}
	}