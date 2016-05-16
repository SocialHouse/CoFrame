// JavaScript Document
	'use strict';

	;( function( $, window, document, undefined ){

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
				showFiles	 = function( files ){
					$label.text( files.length > 1 ? ( $input.attr( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name );

				};

			// letting the server side to know we are going to make an Ajax request
			$form.append( '<input type="hidden" name="ajax" value="1" />' );

			// automatically submit the form on file select
			$input.on( 'change', function( e ){
				showFiles( e.target.files );
					droppedFiles = e.target.files; // the files that were dropped
					var $fileDiv = $('.form__input');

					$.each(droppedFiles, function (index, file) {
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

						var preview_img = '<img class="post-img" src="'+window.URL.createObjectURL(file)+'" >';
						// preview_img.src = window.URL.createObjectURL(file);
						var no_of_img = $('#live-post-preview .img-div img').length;
						var outlet_id = $('#postOutlet').val();
						if(outlet_id == 1)
						{
							if(no_of_img == 0)
							{
								$('#live-post-preview .img-div').append(preview_img);							
							}
							if(no_of_img == 1) 
							{
								$('#live-post-preview .img-div img:first').addClass('width_50');
								$('#live-post-preview .img-div img:first').removeClass('post-img');
								var preview_img = '<img class="width_50" src="'+window.URL.createObjectURL(file)+'" >';
								$('#live-post-preview .img-div').append(preview_img);
								$('.no-of-photos').html('added <span class="photos_count">2 new photos</span>');
							}
							if(no_of_img == 2) 
							{
								$('#live-post-preview .img-div img:first').addClass('post-img');
								$('#live-post-preview .img-div img:first').removeClass('width_50');
								var preview_img = '<img class="width_50" src="'+window.URL.createObjectURL(file)+'" >';
								$('#live-post-preview .img-div').append(preview_img);
								$('.no-of-photos').html('added <span class="photos_count">3 new photos</span>');
							}

							if(no_of_img == 3)
							{
								$('#live-post-preview .img-div img:eq(1)').addClass('width_33');
								$('#live-post-preview .img-div img:eq(1)').removeClass('width_50');
								$('#live-post-preview .img-div img:eq(2)').addClass('width_33');
								$('#live-post-preview .img-div img:eq(2)').removeClass('width_50');							
								var preview_img = '<img class="width_33" src="'+window.URL.createObjectURL(file)+'" >';
								$('#live-post-preview .img-div').append(preview_img);
								$('.no-of-photos').html('added <span class="photos_count">4 new photos</span>');
							}

							if(no_of_img == 4)
							{
								$('#live-post-preview .img-div img:eq(0)').addClass('width_50');
								$('#live-post-preview .img-div img:eq(0)').removeClass('post-img');

								$('#live-post-preview .img-div img:eq(1)').addClass('width_50');
								$('#live-post-preview .img-div img:eq(1)').removeClass('width_33');						
								var preview_img = '<img class="width_33" src="'+window.URL.createObjectURL(file)+'" >';
								$('#live-post-preview .img-div').append(preview_img);
								$('.no-of-photos').html('added <span class="photos_count">5 new photos</span>');
							}

							if(no_of_img >= 5)
							{
								if($('.more-images').length >= 1)
								{
									var more_count = $('.more-images').attr('id');
									more_count++;
									$('.more-images').attr('id',more_count);
									$('.more-images').html('+'+more_count);
									$('.no-of-photos').html('added <span class="photos_count">'+more_count+' new photos</span>');
								}
								else
								{
									var preview_img = '<div class="more-images" id="1"> +1</div>';
									$('#live-post-preview .img-div').append(preview_img);
									$('.no-of-photos').html('added <span class="photos_count">6 new photos</span>');
								}							
							}
						}

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
						var img = document.createElement('img');
						img.onload = function () {
							window.URL.revokeObjectURL(this.src);
						};
						img.className = 'form__file-preview';
						img.src = window.URL.createObjectURL(file);
						$fileDiv.prepend(img).addClass('has-files');
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
						// console.log(droppedFiles);
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
							// console.log(data.);
							// return false;
							if(data.success)
							{
								console.log(JSON.stringify(data));
								// return;
								$('#uploaded_files').val(JSON.stringify(data));
								$form.submit();
							}
							// alert('done');
							// console.log($form);
							// $form.submit();
							// $form.addClass( data.success == true ? 'is-success' : 'is-error' );
							// if( !data.success ) $errorMsg.text( data.error );

							// $form.submit();
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

	})( jQuery, window, document );