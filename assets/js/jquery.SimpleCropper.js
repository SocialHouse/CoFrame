/* 
    Author     : Tomaz Dragar
    Mail       : <tomaz@dragar.net>
    Homepage   : http://www.dragar.net
*/


(function ($) {
    $.fn.simpleCropper = function (onComplete) {


        var $form               = $('form.file-upload'),
            $label              = $form.find( '.file-upload-label' ),
            $errorMsg           = $form.find( '.form__error span' ),
            brand_logo          = [],
            image_dimension_x   = 600,
            image_dimension_x   = 600,
            image_dimension_y   = 600,
            scaled_width        = 0,
            scaled_height       = 0,
            x1                  = 0
            y1                  = 0,
            x2                  = 0,
            y2                  = 0,
            current_image       = null,
            image_filename      = null,
            aspX                = 1,
            aspY                = 1,
            file_display_area   = null,
            ias                 = null,
            original_data       = null;
        
        var jcrop_api,dataUrl;
        var bottom_html = "<canvas id='myCanvas' style='display:none;'></canvas><div id='modal'></div><div id='preview'><div class='buttons'><div class='cancel'></div><div class='ok'></div></div></div>";
        $('.brand-image').append(bottom_html);

        //add click to element
        this.click(function (e) {
            e.preventDefault();

            aspX = $(this).width();
            aspY = $(this).height();
            file_display_area = $(this);
            if(e.target.id == 'new_user_pic'){
                $('#userfileInput').click();    
            }else{
                $('#fileInput').click();
            }
            
        });

        $(document).ready(function () {
            var userfile_obj = $("#new_user_pic");
            var add_brand_obj = $("#add_brand_img");
            var obj;
            add_brand_obj.on('dragenter', function (e) {
                //console.log(e);
                e.stopPropagation();
                e.preventDefault();
                $(this).css('border', '2px solid #0B85A1');
            });
            
            add_brand_obj.on('dragover', function (e) {
                //console.log(e);
                e.stopPropagation();
                e.preventDefault();
            });

            add_brand_obj.on('drop', function (e) {
                obj = 'add_brand_obj';
                $(this).css('border', '2px dotted #0B85A1');
                e.preventDefault();
                var files = e.originalEvent.dataTransfer.files[0];
                file_display_area = $(this);
                aspX = $(this).width();
                aspY = $(this).height();
                file_display_area = $(this);
                $('#fileInput').click();
                //We need to send dropped files to Server
                imageUpload($('#preview').get(0),files); 
            });

            //capture selected filename
            $('#fileInput').change(function (click) {
                click.preventDefault();
                obj = 'add_brand_obj';
                imageUpload($('#preview').get(0),$("#fileInput").get(0).files[0]); //$("#fileInput").get(0).files[0]
                // Reset input value
                $(this).val("");
            });

            userfile_obj.on('dragenter', function (e) {
                
                e.stopPropagation();
                e.preventDefault();
                $(this).css('border', '2px solid #0B85A1');
            });
            
            userfile_obj.on('dragover', function (e) {
                e.stopPropagation();
                e.preventDefault();
            });

            userfile_obj.on('drop', function (e) {
                e.preventDefault();
                obj = 'userfile_obj';
                $(this).css('border', '2px dotted #0B85A1');
                var files = e.originalEvent.dataTransfer.files[0];
                file_display_area = $(this);
                aspX = $(this).width();
                aspY = $(this).height();
                file_display_area = $(this);
                $('#userfileInput').click();
                //We need to send dropped files to Server
                imageUpload($('#preview').get(0),files); 
            });

            //capture selected filename
            $('#userfileInput').change(function (click) {
                click.preventDefault();
                obj = 'userfile_obj';
                //console.log(obj);
                imageUpload($('#preview').get(0),$("#userfileInput").get(0).files[0]); //$("#fileInput").get(0).files[0]
                // Reset input value
                $(this).val("");
            });


            //ok listener
            $('.ok').click(function () {
                preview(obj);
                $('#preview').delay(100).hide();
                $('#modal').hide();
                jcrop_api.destroy();
               // console.log(obj);
                if(obj== 'userfile_obj'){
                    $('.remove-user-img').removeClass('hide');
                    $('.remove-user-img').show();
                    
                }else{
                    $('.remove-brand-img').removeClass('hide');
                    //console.log($('.remove-user-img').attr('class'));
                }
                reset();
            });

            //cancel listener
            $('.cancel').click(function (event) {
                $('#preview').delay(100).hide();
                $('#modal').hide();
                jcrop_api.destroy();
                reset();
            });

            $('.remove-brand-img .remove-upload').click(function(){
                //console.log($(this));
                $('.brand-image').removeClass('has-files');
                $('#add_brand_img').children('img').remove();
                $('#is_brand_image').val('no');
                $('#base64').val('');
                brand_logo = [];            
                $('.remove-brand-img ').addClass('hide');
            });

            $('.remove-user-img .remove-upload').click(function(){
                $('.new-user-pic').removeClass('has-files');
                $('#new_user_pic').children('img').remove();
                $('#user_pic_base64').val('');
                $('.user-img-preview').attr('src','');
                $('.remove-user-img').addClass('hide');
            });

        });

        function reset() {
            scaled_width = 0;
            scaled_height = 0;
            x1 = 0;
            y1 = 0;
            x2 = 0;
            y2 = 0;
            current_image = null;
            image_filename = null;
            original_data = null;
            aspX = 1;
            aspY = 1;
            file_display_area = null;
        }

        function imageUpload(dropbox, file) {
            var imageType = /image.*/;
            brand_logo = [];
            if(file.size > 2000000){
                alert("File size should be lass than 2 MB ");
                return false;
            }
            brand_logo.push(file);
            if (file.type.match(imageType)) {
                var reader = new FileReader();
                image_filename = file.name;

                reader.onload = function (e) {
                    // Clear the current image.
                    $('#photo').remove();

                    original_data = reader.result;

                    // Create a new image with image crop functionality
                    current_image = new Image();
                    current_image.src = reader.result;
                    current_image.id = "photo";
                    current_image.style['maxWidth'] = image_dimension_x + 'px';
                    current_image.style['maxHeight'] = image_dimension_y + 'px';
                    current_image.onload = function () {
                        // Calculate scaled image dimensions
                        if (current_image.width > image_dimension_x || current_image.height > image_dimension_y) {
                            if (current_image.width > current_image.height) {
                                scaled_width = image_dimension_x;
                                scaled_height = image_dimension_x * current_image.height / current_image.width;
                            }
                            if (current_image.width < current_image.height) {
                                scaled_height = image_dimension_y;
                                scaled_width = image_dimension_y * current_image.width / current_image.height;
                            }
                            if (current_image.width == current_image.height) {
                                scaled_width = image_dimension_x;
                                scaled_height = image_dimension_y;
                            }
                        }
                        else {
                            scaled_width = current_image.width;
                            scaled_height = current_image.height;
                        }

                        // set the image size to the scaled proportions which is required for at least IE11
                        current_image.style['width'] = scaled_width + 'px';
                        current_image.style['height'] = scaled_height + 'px';

                        // Position the modal div to the center of the screen
                        $('#modal').css('display', 'block');
                        var window_width = $(window).width() / 2 - scaled_width / 2 + "px";
                        var window_height = $(window).height() / 2 - scaled_height / 2 + "px";

                        // Show image in modal view
                        $("#preview").css("top", window_height);
                        $("#preview").css("left", window_width);
                        $('#preview').show(500);


                        // Calculate selection rect
                        var selection_width = 0;
                        var selection_height = 0;

                        var max_x = Math.floor(scaled_height * aspX / aspY);
                        var max_y = Math.floor(scaled_width * aspY / aspX);


                        if (max_x > scaled_width) {
                            selection_width = scaled_width;
                            selection_height = max_y;
                        }
                        else {
                            selection_width = max_x;
                            selection_height = scaled_height;
                        }

                        ias = $(this).Jcrop({
                            onSelect: showCoords,
                            onChange: showCoords,
                            bgColor: '#747474',
                            bgOpacity: .4,
                            aspectRatio: aspX / aspY,
                            setSelect: [0, 0, selection_width, selection_height]
                        }, function () {
                            jcrop_api = this;
                        });
                    }

                    // Add image to dropbox element
                    dropbox.appendChild(current_image);
                    
                }

                reader.readAsDataURL(file);
            } else {
                alert("File not supported!");
            }
        }

        function showCoords(c) {
            x1 = c.x;
            y1 = c.y;
            x2 = c.x2;
            y2 = c.y2;
        }

        function preview(obj) {
            // Set canvas
            var canvas = document.getElementById('myCanvas');
            var context = canvas.getContext('2d');

            // Delete previous image on canvas
            context.clearRect(0, 0, canvas.width, canvas.height);

            // Set selection width and height
            var sw = x2 - x1;
            var sh = y2 - y1;


            // Set image original width and height
            var imgWidth = current_image.naturalWidth;
            var imgHeight = current_image.naturalHeight;

            // Set selection koeficient
            var kw = imgWidth / $("#preview").width();
            var kh = imgHeight / $("#preview").height();

            // Set canvas width and height and draw selection on it
            canvas.width = aspX;
            canvas.height = aspY;
            context.drawImage(current_image, (x1 * kw), (y1 * kh), (sw * kw), (sh * kh), 0, 0, aspX, aspY);

            // Convert canvas image to normal img
            dataUrl = canvas.toDataURL();
            if(obj == 'userfile_obj'){
                //$('#user_pic_base64').val(dataUrl);
                $('#user_pic_base64').attr('value',dataUrl);
                $('.user-img-preview').attr('src',dataUrl);
            }else{
                 $('#base64').val(dataUrl);
                $('#is_brand_image').val('yes');   
            }
           
            var imageFoo = document.createElement('img');
            imageFoo.src = dataUrl;
            
            // Append it to the body element
            $('#preview').delay(100).hide();
            $('#modal').hide();
            file_display_area.html('');
            file_display_area.append(imageFoo);

            if (onComplete) onComplete(
                {                    
                    "original": { "filename": image_filename, "base64": original_data, "width": current_image.width, "height": current_image.height },
                    "crop": { "x": (x1 * kw), "y": (y1 * kh), "width": (sw * kw), "height": (sh * kh) }
                }
               );
        }

        $(window).resize(function () {
            // Position the modal div to the center of the screen
            var window_width = $(window).width() / 2 - scaled_width / 2 + "px";
            var window_height = $(window).height() / 2 - scaled_height / 2 + "px";

            // Show image in modal view
            $("#preview").css("top", window_height);
            $("#preview").css("left", window_width);
        });

        $(document).on( 'click','.save_brand', function(event){
            
            event.preventDefault();
            var control = this;
            // preventing the duplicate submissions if the current one is in progress
            if( $form.hasClass( 'is-uploading' ) ) return false;

                $form.addClass( 'is-uploading' ).removeClass( 'is-error' );

                // ajax file upload for modern browsers
                // gathering the form data
                var ajaxData = new FormData( $form.get( 0 ) );
                ajaxData.append('base64_image',dataUrl); 
              
                //ajax request
                $.ajax({
                    url:            $form.attr( 'action' ),
                    type:           $form.attr( 'method' ),
                    data:           ajaxData,
                    dataType:       'json',
                    cache:          false,
                    contentType:    false,
                    processData:    false,
                    complete: function(){
                        $form.removeClass( 'is-uploading' );
                    },
                    success: function( data ){
                        if(data.response == 'success')
                        {
                            $('#brand_id').val(data.brand_id);
                            $('#slug').val(data.slug);
                            brand_logo = [];
                            $(control).parents().children('.btn-next-step').trigger('click');
                        }
                    },
                    error: function(){
                        alert( 'There was a problem with your upload.  Please try again.' );
                    }
                });
        });

        $(document).on('submit','#step_1_edit',function(e){
            e.preventDefault();
            var form = $(this);            
            // preventing the duplicate submissions if the current one is in progress
            if( form.hasClass( 'is-uploading' ) ) return false;

                form.addClass( 'is-uploading' ).removeClass( 'is-error' );

                // ajax file upload for modern browsers
                // gathering the form data
                var ajaxData = new FormData(form[0]);
                ajaxData.append('base64_image',$('#base64').val());
                
                
                
                //ajax request
                $.ajax({
                    url:            form.attr( 'action' ),
                    type:           form.attr( 'method' ),
                    data:           ajaxData,
                    dataType:       'json',
                    cache:          false,
                    contentType:    false,
                    processData:    false,
                    complete: function(){
                        form.removeClass( 'is-uploading' );
                    },
                    success: function( result ){
                         if(result.response == 'success'){
                            window.location.reload();
                        }
                    },
                    error: function(){
                        alert( 'There was a problem with your upload.  Please try again.' );
                    }
                });
        });
    }
}(jQuery));

   
