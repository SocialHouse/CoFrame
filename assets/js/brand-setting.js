jQuery(function($) {
    $(document).on('click', '.edit-brands-info', function() {
        var step_no = $(this).data('step-no');
        var brand_slug = $('#brand_slug').val();
        if (brand_slug) {
            $.ajax({
                'type': 'POST',
                dataType: 'html',
                url: base_url + 'settings/edit_step',
                data: {
                    'step_no': step_no,
                    'brand_slug': brand_slug,
                    reload: 'false'
                },
                success: function(response) {
                    if (response != 'false') {
                        toggleBtnClass($('.edit-brands-info'), true);
                        $('#brandStep' + step_no).empty();
                        $('#brandStep' + step_no).addClass('active');
                        $('#brandStep' + step_no).html(response);
                        document.getElementById('brandStep' + step_no).addEventListener('load', function(event){
                            var elm = event.target;
                            if( elm.nodeName.toLowerCase() === 'img' && !$(elm).hasClass('loaded')){
                                $(elm).addClass('loaded');
                                if($('#brandStep' + step_no + ' img.loaded').length === $('#brandStep' + step_no + ' img').length) {          
                                    // All images loaded
                                    equalColumns();
                                }
                            }
                        },
                        true
                        );
                    }
                }
            });
        }
    });

    $(document).on('submit', '#step_2_edit', function(e) {
        e.preventDefault();
        var form = $(this);
        if ($('#selectedOutlets').find('li').length <= plan_data.outlets || plan_data.outlets == 'unlimited') {
            $.ajax({
                'type': 'POST',
                'dataType': 'json',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(result) {
                    if (result.response == 'success') {
                        window.location.reload();
                    }
                }
            });
        } else {
            alert(language_message.tag_limit.replace('%tag_number%', plan_data.tags));
        }
    });

    $(document).on('submit', '#step_3_edit', function(e) {
        e.preventDefault();
        window.location.reload();
        // var form = $(this);
        // var step_no = '3';
        // var brand_slug = $('#brand_slug').val();
        // if(brand_slug){
        //    	$.ajax({
        //    		'type':'POST',
        //    		dataType: 'html',
        //    		url: base_url+'settings/edit_step',
        //    		data:{'step_no':step_no,'brand_slug':brand_slug,reload:'true'},
        //            success: function(response){
        //            	if(response != 'false'){
        //            		toggleBtnClass($('.edit-brands-info'),false);
        //            		$('#brandStep'+step_no).empty();
        //            		$('#brandStep'+step_no).removeClass('active');
        //            		$('#brandStep'+step_no).html(response);
        //            	}
        //            }
        //    	});
        //   	}
    });

    $(document).on('submit', '#step_4_edit', function(e) {
        e.preventDefault();
        var form = $(this);
        var brand_id = $('#brand_id').val();
        var slug = $('#slug').val();
        var selected_labels = $('.labels');

        var tag_ids = []
        $('.tg-ids').each(function(i) {
            tag_ids[i] = this.value;
        });

        var tags = [];
        $('input[name="selected_tags[]"]').each(function(i) {
            var attr = $(this).attr('name');
            if (typeof attr !== typeof undefined && attr !== false) {
                tags[i] = this.value;
            }

        });

        var labels = []

        $.each(selected_labels, function(i, value) {
            labels[i] = $(value).val();
        });

        if ($('#selectedTags').find('li').length <= plan_data.tags || plan_data.tags == 'unlimited') {
            $.ajax({
                url: form.attr('action'),
                data: {
                    'brand_id': brand_id,
                    'tags': tags,
                    'labels': labels,
                    'slug': slug,
                    'tag_ids': tag_ids
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.response == 'success') {
                        window.location.reload();
                    }
                }
            });
        } else {
            alert(language_message.tag_limit.replace('%tag_number%', plan_data.tags));
        }
    });

    $(document).on("click", ".close_brand_step", function(event) {
        toggleBtnClass($(this), true);
        event.preventDefault();
        var step_no = $(this).data('step-no');
        var brand_slug = $('#brand_slug').val();
        if (brand_slug && step_no != 3) {
            $.ajax({
                'type': 'POST',
                dataType: 'html',
                url: base_url + 'settings/edit_step',
                data: {
                    'step_no': step_no,
                    'brand_slug': brand_slug,
                    reload: 'true'
                },
                success: function(response) {
                    if (response != 'false') {
                        toggleBtnClass($('.edit-brands-info'), false);
                        $('#brandStep' + step_no).empty();
                        $('#brandStep' + step_no).removeClass('active');
                        $('#brandStep' + step_no).html(response);
                        toggleBtnClass($(this), false);
                    } 
                }
            });
        } else {
            window.location.reload();
        }
    });
});