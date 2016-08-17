jQuery(function($) {
//to save edit request
    $(document).on('click','.save-edit-req',function(){
        if($(this).hasClass('btn-secondary'))
        {
            toggleBtnClass($(this),true);
            var $div_suggest_edit = $(this).closest('.suggest-edit');
            var input_files = $div_suggest_edit.find("input[type='file']");
            var textarea = $div_suggest_edit.find("textarea");
            var attachment = input_files[0].files[0];
            var img = $div_suggest_edit.find("img");

            var data = new FormData();

            jQuery.each(input_files[0].files, function(i, file) {
                data.append( 'attachment', file,file.name);
            });
            data.append('comment', textarea.val());
            data.append('phase_id', $(this).data('phase-id'));

            jQuery.each($('input'), function(i, control) {
                if(control.name == 'brand_owner' || control.name == 'user_id' || control.name == 'post_id' || control.name == 'brand_id')
                {
                    if(control.value)
                        data.append(control.name, control.value);
                }
            });

            $.ajax({
                type:'POST',
                url: base_url+'approvals/save_edit_request',
                cache: false,
                contentType: false,
                processData: false,
                data:data,
                dataType: 'json',
                success:function(response)
                {
                    if(response.response  == 'success')
                    {
                        $div_suggest_edit.next('.comment-list').prepend(response.html);
                        textarea.val('');
                        input_files.remove();
                        var attachment_html = '<input type="file" name="attachment" class="hidden" id="attachment">';
                        $div_suggest_edit.find(".attachment.pull-sm-left").prepend(attachment_html);
                        img.attr('src','').addClass('hide');
                        toggleBtnClass($(this).parent().children('.save-edit-req'),true);
						equalColumns();
                    }
                    else
                    {
                        alert(language_message.edit_req_not_save);
                    }
                }
            });
        }
    });

    $(document).on('click','.reply-comment-submit',function(){
        if($(this).hasClass('btn-secondary'))
        {
            toggleBtnClass($(this),true);
            console.log($(this));
            var $div_suggest_edit =$(this).closest('li')
            var input_files = $div_suggest_edit.find("input[type='file']");
            var textarea = $div_suggest_edit.find("textarea");
            var attachment = input_files[0].files[0];
            console.log(input_files);
            var img = $div_suggest_edit.find("img");

            var data = new FormData();

            jQuery.each(input_files[0].files, function(i, file) {
                data.append( 'attachment', file,file.name);
            });
            data.append('comment', textarea.val());
            data.append('phase_id', $(this).data('phase-id'));
            data.append('parent_id', $(this).data('parent-id'));

            jQuery.each($('input'), function(i, control) {
                if(control.name == 'brand_owner' || control.name == 'user_id' || control.name == 'post_id' || control.name == 'brand_id')
                {
                    if(control.value)
                        data.append(control.name, control.value);
                }
            });
            $.ajax({
                type:'POST',
                url: base_url+'approvals/save_edit_request',
                cache: false,
                contentType: false,
                processData: false,
                data:data,
                dataType: 'json',
                success:function(response)
                {
                    if(response.response  == 'success')
                    {
                        $div_suggest_edit.closest('.commentReply').slideUp(function() {
                            $div_suggest_edit.closest('.commentReply').remove();
                        });
                        $div_suggest_edit.closest('.comment').append(response.html);
                        var new_height = $div_suggest_edit.closest('.comment').find('li:first').height();
                        var col_8_height = $div_suggest_edit.parent('div').height();
                        $div_suggest_edit.parent('div').height( parseInt(col_8_height) + parseInt(new_height) );
                    }
                    else
                    {
                        alert(language_message.edit_req_not_save);
                    }
                }
            });
        }
    });

    $(document).on('click', '.show-hide-reply', function(e) {
        e.preventDefault();
        var $trigger = $(this);
        var show =  $(this).data('show');
        var reply_id =  show.substring(1);
        var html_body = $('#commentReplyStatic').html();
        var $comment = $trigger.closest('.comment');

        if($trigger.hasClass('active')){
            $(show).slideUp(function() {
                $(show).remove();
				equalColumns();
				$trigger.removeClass('active');
				//if there are reply, don't remove reply class
				if(!$comment.find('.commentReply').length) {
					$comment.removeClass('has-reply');
				}
            });
        }else{
            $comment.append(html_body);
            $comment.find('.emptyCommentReply').attr('id',reply_id);
            $comment.find('.reply-comment-submit').attr('data-parent-id',reply_id.split("_")[1]);
            $(show).removeClass('emptyCommentReply');
			$comment.addClass('has-reply');
			$trigger.addClass('active');
        }

        $(show).slideToggle(function(){
			equalColumns();
            $(show).trigger('contentSlidDown', [$trigger]);
        });         
    });

    $(document).on('keyup blur','#comment_copy',function(){
        $suggest_edit =  $(this).parent().parent();
        if($.trim($(this).val()))
        {
            toggleBtnClass($suggest_edit.find('button.save-edit-req'),false);
        }
        else
        {
            toggleBtnClass($suggest_edit.find('button.save-edit-req'),true);
        }
    });

    $(document).on('keyup blur','#reply_comment_copy',function(){
        $suggest_edit =  $(this).parent().parent();
        if($.trim($(this).val()))
        {
            toggleBtnClass($suggest_edit.find('button.reply-comment-submit'),false);
        }
        else
        {
            toggleBtnClass($suggest_edit.find('button.reply-comment-submit'),true);
        }
    })

    $(document).on('click','.finish_phase',function(){
         var phase_id = $(this).data('phase-id');
        var phase_number = $(this).data('phase-number');
        var next_phase = phase_number+1;
        getConfirm(language_message.finish_Phase,'',function(confResponse) {
            if (confResponse) {
               

                $btn_current =  $('#approvalPhase'+phase_number).find('h2 button');

                $.ajax({
                    type:'GET',
                    dataType: 'json',
                    url: base_url+'posts/finish_phase/'+phase_id,
                    success: function(response)
                    {
                        if(response.response  == 'success')
                        {
                            //window.location.reload();
                            if($('#approvalPhase'+next_phase).length){
                                $btn_next = $('#approvalPhase'+next_phase).find('h2 button');
                                $('#approvalPhase'+next_phase).removeClass('inactive').addClass('active');
                                $('#approvalPhase'+phase_number).removeClass('active').addClass('inactive');
                                $btn_current.text('Finished');
                                $btn_current.removeClass('color-success').addClass('btn-disabled');
                                $btn_next.text('Current').addClass('color-success').removeClass('btn-disabled');
                            }else{
                                $btn_current.text('Finished').removeClass('color-success');
                            }
                            $('.modal-hide').click();
                        }
                        else
                        {
                            alert(language_message.try_again);
                        }
                    }
                });     
            }
        });    
    });

    $(document).on('change','.attachment_image',function(){
        var control = this;
        console.log($(control).next().next());
       
        var supported_files = ['gif','png','jpg','jpeg'];
        var reader = new FileReader();
        var file = $(this)[0].files[0];
        reader.readAsDataURL(file);
        reader.onload = function (event) {
            var file_type = file.type.split('/');
            if($.inArray(file_type[1] ,supported_files) == -1){
                alert(language_message.invalid_extention);
                return false;
            };
            $(control).next().next().attr('src',event.target.result);
            $(control).next().next().removeClass('hide');
            $(control).parent('.attachment ').find('.remove-attached-img').show();
        }
    });

    $(document).on('click','.reset-request',function(){
        $('#comment_copy').val('');
        $('#attachment').remove();
        var attachment_html = '<input type="file" name="attachment" class="hidden attachment_image">';
        $('.attachment').prepend(attachment_html);
        $('#attached_img').attr('src','').addClass('hide');
        toggleBtnClass($(this).parent().children('.save-edit-req'),true);
    });

    $(document).on('click','.reset-edit-request',function(){
        var $comment_section = $(this).closest('.comment-section');
        console.log($comment_section);
        var textarea = $comment_section.find("textarea");
        var img = $comment_section.find("img.base-64-img");
        var input_file = $comment_section.find("input[type='file']");
        $comment_section.find(".remove-attached-img").hide();
        textarea.val('');
        input_file.remove();
        img.attr('src','').addClass('hide');

        var attachment_html = '<input type="file" name="attachment" class="hidden attachment_image">';
        $comment_section.find(".attachment.pull-sm-left").prepend(attachment_html);

        toggleBtnClass($(this).parent().children('.save-edit-req'),true);
    });

    $(document).on('click','.add-attachment',function(event) {
        event.preventDefault();
        $(this).closest('.attachment').find('input[type="file"]').click();
    });

    $('.commentReply').on('contentSlidDown', function(event, element) {
        if($(this).is(':visible')) {
            element.addClass('active');
            $(this).closest('.comment').addClass('will-reply');
        }
        else {
            element.removeClass('active');
            $(this).closest('.comment').removeClass('will-reply');
        }
    });

    // console.log($('input[name="attachment"]'));
    $(document).on('change','.reply-attach',function(){
        if($(this).attr('id') != 'attachment')
        {
            var control = this;
            var supported_files = ['gif','png','jpg','jpeg'];
            var reader = new FileReader();
            var file = $(this)[0].files[0];
            reader.readAsDataURL(file);
            reader.onload = function (event) {
                var file_type = file.type.split('/');
                if($.inArray(file_type[1] ,supported_files) == -1){
                    alert(language_message.invalid_extention);
                    return false;
                };
                $(control).next().next().attr('src',event.target.result);
                $(control).next().next().removeClass('hide');
                $(control).parent('.attachment ').find('.remove-attached-img').show();
            }
        }
    })

    $(document).on('keyup blur','.reply-comment',function(){
        var btn = $(this).parent().parent().children('div:last').children('div:last').find('.save-reply');
        if($(this).val())
        {
            toggleBtnClass(btn,false);
        }
        else
        {
            toggleBtnClass(btn,true);
        }
    });

    $(document).on('click','.remove-attached-img',function(){
        $(this).hide();
        $cmt_box = $(this).closest('div.attachment');
        $cmt_box.find('.attachment_image').remove();
        var attachment_html = '<input type="file" name="attachment" class="hidden attachment_image">';
        $cmt_box.prepend(attachment_html);
        $cmt_box.find('img').attr('src','').addClass('hide');
    });

    $(document).on('click','.reset-comment',function(){
        var parent_id = $(this).data('comment-id');
        var parent_div = $("input[name='attachment"+parent_id+"']" ).parent();
        $(parent_div).children('img').attr('src','');
        $(parent_div).children('img').addClass('hide');
        $('.remove-attached-img').hide();
        $("input[name='attachment"+parent_id+"']" ).remove();
        
        var attachment_html = '<input type="file" name="attachment" class="hidden" id="attachment">';                       
        $(parent_div).prepend(attachment_html);
        $("textarea[name='comment"+parent_id+"']").val('');     
        toggleBtnClass($(this).parent().children('.save-reply'),true);
    });

    $(document).on('click','.save-reply',function(){
        var parent_id = $(this).data('comment-id');
        var status = $(this).data('status');
        
        var reply_div = $(this).parent().parent().parent().parent();
        var data = new FormData();
        jQuery.each($("input[name='attachment"+parent_id+"']" )[0].files, function(i, file) {
            data.append( 'attachment', file,file.name);
        });

        jQuery.each($("textarea[name='comment"+parent_id+"']"), function(i, control) {
            data.append('comment', control.value);
        });

        jQuery.each($("input[name='phase_id"+parent_id+"']"), function(i, control) {
            data.append('phase_id', control.value);
        });

        jQuery.each($('input'), function(i, control) {
            if(control.name == 'brand_owner' || control.name == 'user_id' || control.name == 'post_id' || control.name == 'brand_id')
                data.append(control.name, control.value);
        });
        
        data.append('parent_id',parent_id);

        $.ajax({
            type:'POST',
            url: base_url+'approvals/save_edit_request',
            cache: false,
            contentType: false,
            processData: false,
            data:data,
            dataType: 'json',
            success:function(response)
            {
                if(response.response  == 'success')
                {
                    $('.remove-attached-img').hide();
                    $(reply_div).empty();
                    $(reply_div).prepend(response.html);
                    $("input[name='comment"+parent_id+"']" ).val('');
                    $("input[name='attachment"+parent_id+"']" ).remove();
                    var attachment_html = '<input type="file" name="attachment" class="hidden" id="attachment">';
                    $("input[name='attachment"+parent_id+"']" ).prepend(attachment_html);
                }
                else
                {
                    alert(language_message.unable_to_save_reply);
                }
            }
        });
    });

    $(document).on('click','.post-remove-phase',function(){
        getConfirm(language_message.delete_phase_confirmation,'',function(confResponse) {
            if(confResponse){
                var div_to_delete = $(this).parents().parents('div:first');
                var phase_id = $(this).attr('id');
                $.ajax({
                    'type':'POST',
                    'data':{'phase_id':phase_id},
                    url: base_url+'api/delete_phase',                 
                    success: function(response)
                    {
                        var json = $.parseJSON(response);
                        if(json.status == 'success')
                        {
                            $(div_to_delete).remove();
                            
                            var all_phases_count = ($('.phase_container').length) - 1;
                            var all_phases = $('.phase_container');
                            var i =1;
                            $.each(all_phases, function( index, value ) 
                            {
                                if(i <=all_phases_count);
                                {
                                    $(value).children('#phase_number:first').val(i);
                                    $(value).children('.phase_num_div:first').children('label:first').html('Phase '+(i++));
                                }
                            });
                        }
                    }
                }); 
            }
        });     
    });

    $(document).on('click','#add_next_approval_phase',function(){
        var number_of_phases = ($('.phase_container').length) - 2;      
        var next_phase = $('.phase_container:eq('+number_of_phases+')').children('#phase_number').val();
        ++next_phase;
        var phase_html = $('.hide:first').clone();      
        var html_div = phase_html.html();
        
        html_div = html_div.replace('Phase 1','Phase '+(next_phase));       
        html_div = html_div.replace('<input id="phase_number" value="a" type="hidden">','<input type="hidden" id="phase_number" value="'+next_phase+'">');
        html_div = html_div.split('users[a]').join('phase[users]['+next_phase+']');
        html_div = html_div.replace('approve_year[a]','phase[approve_year]['+next_phase+'][]');
        html_div = html_div.replace('approve_month[a]','phase[approve_month]['+next_phase+'][]');
        html_div = html_div.replace('approve_day[a]','phase[approve_day]['+next_phase+'][]');
        html_div = html_div.replace('approve_time[a]','phase[approve_time]['+next_phase+'][]');     
        html_div = html_div.replace('note[a]','phase[note]['+next_phase+'][]');         

        var next_phase_button = '';
        html_div = '<div class="col-md-12 well phase_container"><a href="javascript:void(0)"  id="'+next_phase+'" class="pull-right remove-phase-edit">&times;</a>'+html_div+next_phase_button+'</div>';        
        $(html_div).appendTo('.all_phases');

        $('.approve_time').timepicker({
            minuteStep: 5,
            showInputs: false,
            disableFocus: true
        });
    });

});