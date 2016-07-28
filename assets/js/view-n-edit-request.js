jQuery(function($) {
//to save edit request
    $(document).on('click','.save-edit-req',function(){
        if($(this).hasClass('btn-secondary'))
        {
            toggleBtnClass($(this),true);
            var $div_suggest_edit = $(this).closest('.suggest-edit');
            console.log( $(this).closest('.suggest-edit'));
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
                        $div_suggest_edit.next().prepend(response.html);
                        var new_height = $div_suggest_edit.next().find('li:first').height();
                        var col_8_height = $div_suggest_edit.parent('div').height();
                        $div_suggest_edit.parent('div').height( parseInt(col_8_height) + parseInt(new_height) );
                        textarea.val('');
                        input_files.remove();
                        var attachment_html = '<input type="file" name="attachment" class="hidden" id="attachment">';
                        $div_suggest_edit.find(".attachment.pull-sm-left").prepend(attachment_html);
                        img.attr('src','');
                        img.addClass('hide');
                        toggleBtnClass($(this).parent().children('.save-edit-req'),true);
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
            var $div_suggest_edit =$(this).closest('.suggest-edit')
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

    $(document).on('click', '.show-hide-replay', function(e) {
        e.preventDefault();
        var $trigger = $(this);
        var show =  $(this).data('show');
        var replay_id =  show.substring(1);
        var html_body = $('#commentReplyStatic').html();
        $comment = $trigger.parent().parent();

        if($trigger.hasClass('active')){
            $(show).slideUp(function() {
                $(show).remove();
            });
        }else{
            $comment.prepend(html_body);
            $comment.find('.emptyCommentReply').attr('id',replay_id);
            $comment.find('.reply-comment-submit').attr('data-parent-id',replay_id.split("_")[1]);
            $(show).removeClass('emptyCommentReply');
        }

        $.each($trigger.parentsUntil('.approval-phase'), function(i, cntrl){
            if($(cntrl).hasClass('equal-section') && $(cntrl).hasClass('col-md-8') ){
                if($trigger.hasClass('active')){
                    $trigger.removeClass('active');
                    setTimeout(function() {
                        $(cntrl).height("-=240");
                    },300);
                }else{
                    $trigger.addClass('active');
                    $(cntrl).height("+=240").slideDown();
                }
            }
        });

        $(show).slideToggle(function(){
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

    $(document).on('keyup blur','#replay_comment_copy',function(){
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
        $('.finish_yes').attr('data-phase-id', phase_id);
        $('.finish_yes').attr('data-phase-number',phase_number );
    });

    $(document).on('click','.finish_yes',function(){
        var phase_id = $(this).data('phase-id');
        var phase_number = $(this).data('phase-number');
        var next_phase = phase_number+1;

        $btn_current =  $('#approvalPhase'+phase_number).find('h2 button');

        $.ajax({
            type:'GET',
            dataType: 'json',
            url: base_url+'posts/finish_phase/'+phase_id,
            success: function(response)
            {
                if(response.response  == 'success')
                {
                    window.location.reload();
                        if($('#approvalPhase'+next_phase).length){
                            $btn_next = $('#approvalPhase'+next_phase).find('h2 button');
                            $('#approvalPhase'+next_phase).removeClass('inactive');
                            $('#approvalPhase'+next_phase).addClass('active');
                            $('#approvalPhase'+phase_number).removeClass('active');
                            $('#approvalPhase'+phase_number).addClass('inactive');
                            $btn_current.text('Finished');
                            $btn_current.removeClass('color-success');
                            $btn_current.addClass('btn-disabled');
                            $btn_next.text('Current');
                            $btn_next.addClass('color-success');
                            $btn_next.removeClass('btn-disabled');
                        }else{
                            $btn_current.text('Finished');
                            $btn_current.removeClass('color-success');
                        }
                        
                        $('.modal-hide').click();
                    }
                    else
                    {
                        alert(language_message.try_again);
                    }
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
                alert('Invalid file extention');
                return false;
            };
            $(control).next().next().attr('src',event.target.result);
            $(control).next().next().removeClass('hide');

        }
    });

    $(document).on('click','.reset-request',function(){
        $('#comment_copy').val('');
        $('#attachment').remove();
        var attachment_html = '<input type="file" name="attachment" class="hidden attachment_image">';
        $('.attachment').prepend(attachment_html);
        $('#attached_img').attr('src','');
        $('#attached_img').addClass('hide');
        toggleBtnClass($(this).parent().children('.save-edit-req'),true);
    });

    $(document).on('click','.reset-edit-request',function(){
        var $div_suggest_edit = $(this).parents('.suggest-edit');
        var textarea = $div_suggest_edit.find("textarea");
        var img = $div_suggest_edit.find("img");
        var input_file = $div_suggest_edit.find("input[type='file']");
        textarea.val('');
        input_file.remove();
        img.attr('src','');
        img.addClass('hide');

        var attachment_html = '<input type="file" name="attachment" class="hidden attachment_image">';
        $div_suggest_edit.find(".attachment.pull-sm-left").prepend(attachment_html);

        toggleBtnClass($(this).parent().children('.save-edit-req'),true);
    });

    $(document).on('click','.add-attachment',function(event) {
        console.log('add-attachment');
        event.preventDefault();
        console.log( $(this).closest('.attachment'));
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
                    alert('Invalid file extention');
                    return false;
                };
                $(control).next().next().attr('src',event.target.result);
                $(control).next().next().removeClass('hide');
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

    $(document).on('click','.reset-comment',function(){
        var parent_id = $(this).data('comment-id');
        var parent_div = $("input[name='attachment"+parent_id+"']" ).parent();
        $(parent_div).children('img').attr('src','');
        $(parent_div).children('img').addClass('hide');
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
        if(confirm(language_message.delete_phase_confirmation)){
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
                //          $(value).children('#phase_number:first').val(i);
                            // $(value).children('.phase_num_div:first').children('label:first').html('Phase '+(i++));                          
                        });
                    }
                }
            }); 
        }        
    });

    $(document).on('click','#add_next_approval_phase',function(){
        var number_of_phases = ($('.phase_container').length) - 2;      
        var next_phase = $('.phase_container:eq('+number_of_phases+')').children('#phase_number').val();
        ++next_phase;
        var phase_html = $('.hide:first').clone();      
        var html_div = phase_html.html();
        
        html_div = html_div.replace('Phase 1','Phase '+(next_phase));       
        html_div = html_div.replace('<input id="phase_number" value="a" type="hidden">','<input type="hidden" id="phase_number" value="'+next_phase+'">');
        // console.log(html_div);
        html_div = html_div.split('users[a]').join('phase[users]['+next_phase+']');
        html_div = html_div.replace('approve_year[a]','phase[approve_year]['+next_phase+'][]');
        html_div = html_div.replace('approve_month[a]','phase[approve_month]['+next_phase+'][]');
        html_div = html_div.replace('approve_day[a]','phase[approve_day]['+next_phase+'][]');
        html_div = html_div.replace('approve_time[a]','phase[approve_time]['+next_phase+'][]');     
        html_div = html_div.replace('note[a]','phase[note]['+next_phase+'][]');         
        // html_div = html_div.replace('<input class="phases_to_add" name="phases_to_add" value="'+phase_to_add+'" type="text"><input class="phase_number" name="phase_number" value="1" type="text">','');

        var next_phase_button = '';
        // if(phase_to_add > phase_added)
        // {
        //  next_phase_button = '<div class="col-md-12 add_phase_btn_div"><button style="margin-top:10px" type="button" class="btn btn-primary add_phases_btn pull-right" id="add_phases">Next</button></div>';
        // }
        html_div = '<div class="col-md-12 well phase_container"><a href="javascript:void(0)"  id="'+next_phase+'" class="pull-right remove-phase-edit">&times;</a>'+html_div+next_phase_button+'</div>';        
        $(html_div).appendTo('.all_phases');

        $('.approve_time').timepicker({
            minuteStep: 5,
            showInputs: false,
            disableFocus: true
        });
    });

});