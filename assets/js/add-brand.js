jQuery(function($) {
	var validName = false;
	var validEmail = false;
	$(document).ready(function() {
		if($("#add-brand-details").length || $("#step_1_edit").length  || $("#step_3_edit").length)
		{
			$('.cropme').simpleCropper();
		}

		
		$('#brandOutlets.outlet-list li').on('click', function() {
			if(!$(this).hasClass('saved')) {
				$(this).toggleClass('disabled selected');
				$(this).siblings().each(function() {
					if(!$(this).hasClass('saved')) {
						$(this).addClass('disabled').removeClass('selected');
					}
				});
				if(!$(this).hasClass('disabled')) {
 					toggleBtnClass('#addOutlet',false);
				}
				else {
 					toggleBtnClass('#addOutlet',true);
				}
			}
		});

		
		//add brand outlet to list
		$('#addOutlet').on('click', function() {
			var $selectedItem = $('#brandOutlets .selected');
			var numberSelected =  $selectedItem.length;
			var savedOutlets = [];
			var outletsVal = $('#brandOutlet').val();
			if(numberSelected > 0) {
				var $selectedList = $('#selectedOutlets ul');
				var $listItem = $(document.createElement('li'));
				if(outletsVal !== '') {
					savedOutlets.push(outletsVal);
				}
				savedOutlets.push($selectedItem.data('selectedOutlet'));	
				var outletTitle = $selectedItem.data('selected-outlet');
				var outletId = $selectedItem.data('selected-outlet-id');
				var outletConst = $selectedItem.data('outlet-const');				

				var outletHtml = $selectedItem.html()+'<input type="hidden" class="outlets" name="outlets[]" value="'+outletId+'" >' ;				
				var removeOutlet = '<a href="#" class="pull-sm-right remove-outlet" data-remove-outlet="' + outletTitle + '"><i class="tf-icon circle-border">x</i></a>';
				$listItem.append(outletHtml + outletTitle + removeOutlet).attr('data-outlet', outletTitle);
				
				$selectedItem.addClass('saved').removeClass('selected');
				//set input field value
				$('#brandOutlet').val(savedOutlets);				
				$selectedList.append($listItem);
				
				if($('#selectedOutlets').children('ul').children('li'))
				{
 					toggleBtnClass('#save_outlet',false);
				}
				else
				{
 					toggleBtnClass('#save_outlet',true);
				}
			}
			else {
				return;
			}
		});
		//remove brand outlet from list
		$('body').on('click', '.remove-outlet', function() {
			var savedOutlets = $('#brandOutlet').val().split(',');
			var removeOutlet = $(this).data('remove-outlet');			
			$('#selectedOutlets li[data-outlet="' + removeOutlet + '"]').slideUp(function() {
				$(this).remove();
				hideNoLength($('#selectedOutlets'));

				var index = savedOutlets.indexOf(removeOutlet);
				savedOutlets.splice(index, 1);
				$('#brandOutlet').val(savedOutlets);
			});
			$('#brandOutlets li[data-selected-outlet="' + removeOutlet + '"]').removeClass('saved').addClass('disabled');
			
			if(savedOutlets.length > 1)
			{
 				toggleBtnClass('#save_outlet',false);
			}
			else
			{
 				toggleBtnClass('#save_outlet',true);
			}
		});

		$('#selectedOutlets').on('contentSlidDown', function() {
			hideNoLength($(this));
		});		

		var brandStepH;
		$('#addNewUser').on('contentSlidDown', function(event, element) {
			var parentInlineH = $(this).parents('.brand-step').prop('style')['height'];
			var parentH = $(this).parents('.brand-step').height();
			var contentH = $(this).parents('.container-brand-step').outerHeight();
			if(parentInlineH !== 'auto' && contentH > parentH) {
				brandStepH = parentInlineH;
				$(this).parents('.brand-step').css({'height': 'auto'});
			}
		});
		$('#addNewUser').on('contentSlidUp', function(event, element) {
			$(this).parents('.brand-step').css({'height': brandStepH});
			$('#userSelect, #addUserInfo').removeAttr('style');
			// $('#userSelect select').val('');
			toggleBtnClass('#addRole', true);
		});

       // Remove selected class from social icons when adding a second.
        $('#addUserLink').on('click', function() {
            $('.brand-step .outlet-list li').removeClass('selected');
            $('.brand-step .outlet-list li').addClass('disabled');
            $('#nameValid').addClass('hide');
            $('#emailValid').addClass('hide');
            $('#emailUniqueValid').addClass('hide');
        })

        // Clear tag field when adding a second tag.
        $('#addTagLink').on('click', function() {
            $('#newLabel').val("");
            $('#tagLabel').val("");
        })

		$('#userRoleSelect').on('change', function() {
			var selectedRole = $(this).val();
			if(selectedRole)
	    	{
	    		if(selectedRole == 'billing')
	    		{
	    			$('.edit-permissions').hide();	
	    		}
	    		else
	    		{
	    			$('.edit-permissions').show();
	    		}
	    		
 				toggleBtnClass('.addUserToBrand',false);
	    	}
	    	else
	    	{
 				toggleBtnClass('.addUserToBrand',true);
	    	}

			var $actPermissions = $('.permission-details:visible');			
			if($actPermissions.length) {
				$actPermissions.fadeOut(function() {
					$('#' + selectedRole + 'Permissions').slideDown();
				});
			}
			else {
				$('#' + selectedRole + 'Permissions').slideDown();
			}
		});

		$('.edit-permissions').on('click', function() {
			var section = $(this).data('section');
			var $sectionLabel = $('#' + section).find('.permissions-label');
			var $sectionList = $('#' + section).find('.permissions-list');
			$(this).toggleClass('btn-disabled');
			$sectionList.toggleClass('view');
			if($(this).hasClass('btn-disabled')) {
				$sectionList.find('li').css('display', 'block');
				$sectionLabel.text('Modify Permissions');
			}
			else {
				$sectionList.find('li.hidden').css('display', 'none');
				$sectionLabel.text('Default Permissions');
			}
		});
		$('.permissions-list .check-box').on('click', function() {
			var $parent = $(this).parent('li');
			$parent.toggleClass('hidden');
		});

		/*Tag Functions*/
		//assign tags to brand
		$('body').on('click', '#selectBrandTags .tag', function() {
			//alert('test');
			if($(this).hasClass('saved')) {
				return;
			}
			var checked = false;
			var label = $('#tagLabel').val();
			var $checkbox = $(this).find('input');
			if(label === 'other') {
				label = $('#otherTagLabel input').val();
			}
			$(this).toggleClass('selected');
			if($(this).hasClass('selected')) {
				checked = true;
				var $siblings = $(this).siblings(':not(.saved)');
				var $sibCheckbox = $siblings.find('input');
				if(label !== "") {
					$(this).attr('data-value', label);
				}
				$siblings.removeClass('selected').attr('data-value', '');
				$sibCheckbox.prop('checked', false);
			}
			else {
				checked = false;
			}
			//set the input value
			$checkbox.prop('checked', checked);
		});

		var customTag = false;

		$('#chooseTagColor').colorpicker({format: 'hex'}).on('changeColor', function(e) {			
			var customColor = e.color.toHex();			
			var $custom = $('#selectBrandTags .custom-tag');			
			var $icon = $custom.find('.fa');
			$icon.css({'color': customColor, 'border-color': customColor});
			$custom.attr('data-color',customColor);
			$custom.show();
			$custom.children().attr('value',customColor);
			customTag = true;
		});

		$('#tagLabel').on('change', function() {
			var $tag = $('#selectBrandTags .selected');
			var label = $(this).val();
			if(label)
			{
				if(label !== 'other') 
				{
					$('#otherTagLabel').hide();
					$tag.attr('data-value', label);
					// toggleBtnClass('#addTag',false);
					var selected_tag = $('#selectedTags').children('ul').children('li');
					//console.log(selected_tag);
					var add_flag = 1;
					var control = this;
					$.each(selected_tag,function(a,b){
						//console.log($(control).val());
						//console.log($(b).data('value'));
						if($(b).data('value') == $(control).val())
						{
							add_flag = 0;
							$('#labelSelectValid').removeClass('hide');
						}
					});

					if(add_flag == 1)
					{
						$('#labelSelectValid').addClass('hide');
						if($(this).val())
						{
							toggleBtnClass('#addTag',false);
						}				
					}
					else
					{
						toggleBtnClass('#addTag',true);
					}
				}
				else {
					$('#labelSelectValid').addClass('hide');
					$('#otherTagLabel').show(function(){
						$(this).find('input').focus();
					});

					if(!$('#newLabel').val())
					{
						toggleBtnClass('#addTag',true);
					}
					else
					{
						toggleBtnClass('#addTag',false);						
					}
				}
			}
			else
			{
				$('#addTag').prop('disabled',true);
			}
		});

		$(document).on('keyup blur','#newLabel',function(){
			var selected_tag = $('#selectedTags').children('ul').children('li');
			var add_flag = 1;
			var control = this;
			$.each(selected_tag,function(a,b){
				//console.log($(control).val());
				//console.log($(b).data('value'));
				if($(b).data('value') == $(control).val())
				{
					add_flag = 0;
					$('#labelValid').removeClass('hide');
				}
			});

			if(add_flag == 1)
			{
				$('#labelValid').addClass('hide');
				if($(this).val())
				{
					toggleBtnClass('#addTag',false);
				}				
			}
			else
			{
				toggleBtnClass('#addTag',true);
			}
		});	

		$('#otherTagLabel input').on('keyup blur', function() {			
			var $tag = $('#selectBrandTags .selected');
			var label = $(this).val();
			$tag.attr('data-value', label);
			
			if($(this).val().length > 0)
			{
				$('#addTag').prop('disabled',false);
			}
			else
			{
				$('#addTag').prop('disabled',true);	
			}
		});

		//add tag to list
		$('#addTag').on('click', function() {
			var $selectedItem = $('#selectBrandTags .selected');
			var numberSelected =  $selectedItem.length;
			if(numberSelected > 0) {
				var $selectedList = $('#selectedTags ul');
				var $clone = $selectedItem.clone();

				var $listItem = $clone.remove('input').removeClass('selected');
				$listItem.children('.color').attr('name','selected_tags[]');
				$('.submit_tag').prop('disabled',true);
				setTimeout(function(){										
					var tagTitle = $selectedItem.attr('data-value');
					var editTag = '<a class="pull-sm-right remove-tag" data-remove-outlet="twitter" href="#"><i class="tf-icon circle-border">x</i></a>';
					//reset custom tags so that another can be added
					if(customTag === true) {
						var $custom = $('#selectBrandTags .custom-tag');					
						var $newCustom = $custom.clone();
						$newCustom.insertAfter($custom).removeClass('selected').hide();
						$custom.removeClass('custom-tag');
						customTag = false;
					}
					
					$listItem.append('<input type="hidden" name="labels[]" class="labels" value="'+tagTitle+'" >'+tagTitle + editTag).attr('data-tag', tagTitle);
					$selectedItem.addClass('saved').removeClass('selected');
					$selectedList.append($listItem);					
				}, 200);
				toggleBtnClass('.submit_tag',false);
				$('.submit_tag').prop('disabled',false);
			}
			else {
				return;
			}
		});

		$(document).on('click','.remove-tag',function(){	
			control = this;
			var li = $(".tags-to-add").children('li');
			var selected = 0;
			$.each(li,function(a,b){			
				if($(b).data('color') == $(control).parents('li').data('color') && $(b).data('value') == $(control).parents('li').data('value'))
				{			
					$(b).removeClass('saved');
				}
				if($(b).hasClass('saved'))
				{
					selected++;
				}

			});
			if(selected > 0)
			{
				toggleBtnClass('.submit_tag',false);
			}
			else
			{
				toggleBtnClass('.submit_tag',true);
			}
			$(this).parents('li').remove();
		});

		$('#selectedTags').on('contentSlidDown', function() {
			hideNoLength($(this));
		});

		var selected_tag = $('#selectedTags').find('li');
		$.each(selected_tag,function(a,b){
			$.each($('.tag-list').children('.tags-to-add').find('li'),function(c,d){
				if($(d).data('color') == $(b).find('input').val())
				{
					$(d).addClass('saved');
				}
			});
		});

		$('#add-brand-details').on('submit', function(){
			$(this).addClass('success');
			//show dashboard button and tooltip
			$('#addBrandSuccess').show();
			successTip();
			$('.modal-contain').removeClass('in').hide();
			$('.brand-step').removeClass('active');
		});

		$('body').on('click', '.btn-next-step', function() {
			var next = $(this).data('nextStep');
			nextStep(next);
		});

		$('body').on('change', '#userSelect select', function() {
			if($(this).val() === "Add New") {
				toggleBtnClass('#addRole', true);
				$('#userSelect').slideUp(function() {
					$('#addUserInfo').slideDown(function() {
						equalColumns();
					});
				});
			}
			else if($(this).val() !== "") {
				toggleBtnClass('#addRole', false);
			}
		});

		$(document).on('blur keyup','#firstName,#lastName',function()
		{			
			if($('#lastName').val() && $('#userEmail').val() && validateEmail($('#userEmail').val()) && $('#firstName').val() && validEmail)
	    	{
				toggleBtnClass('#addRole',false);
	    	}
	    	else
	    	{
				toggleBtnClass('#addRole',true);
	    	}
		});
	});

	window.successTip = function successTip() {
		$('#addBrandSuccess .btn').qtip({
			content: {
				attr: 'data-content'
			},
			position: {
				my: 'bottom center',
				at: 'top center',
				adjust: {
					y: -11
				},
				container: $('.page-main')
			},
			show: {
				effect: function() {
					$(this).fadeIn();
				},
				ready: true
			},
			hide: {
				effect: function() {
					$(this).fadeOut();
				},
				event: 'unfocus'
			},
			style: {
				classes: 'qtip-shadow text-xs-center',
				tip: {
					width: 20,
					height: 10
				},
				width: 320
			}
		});

	$('#brandName').keyup(function(){
    	if($('#timezone').val() && $(this).val())
    	{
			toggleBtnClass('.save_brand',false);
    	}
    	else
    	{
 			toggleBtnClass('.save_brand',true);
   		}
    	
    });

    $('#timezone').change(function(){
    	if($(this).val() && $('#brandName').val())
    	{
			toggleBtnClass('.save_brand',false);
    	}
    	else
    	{
			toggleBtnClass('.save_brand',true);
    	}
    });

   	 $(document).on('keyup blur','#userEmail',function(){
    	if($('#firstName').val() && $('#lastName').val() && $(this).val() && validateEmail($(this).val()))
    	{
 			toggleBtnClass('#addRole',false);
    	}
    	else
    	{
   			toggleBtnClass('#addRole',true);
	   	}

    	if(!validateEmail($(this).val()))
		{
			if($(this).val().length > 2)
			{
				$('#emailValid').html('This is not a valid email.');
				$('#emailValid').removeClass('hide');
				$('#emailUniqueValid').addClass('hide');
			}

			if(!$(this).val())
			{				
				$('#emailValid').addClass('hide');
				$('#emailUniqueValid').addClass('hide');
			}
		}
		else
		{
			$('#emailValid').addClass('hide');
			$.ajax({
				url: base_url+'tour/check_email_exist',
				type:'POST',
				data: {'email':$('#userEmail').val()},
				success:function(data){
					if(data == 'true')
					{
						validEmail = false;
						$('#emailUniqueValid').removeClass('hide');						
					}
					else
					{
						validEmail = true;
						$('#emailUniqueValid').addClass('hide');
					}
					if($('#lastName').val() && $('#userEmail').val() && $('#firstName').val() && validEmail)
			    	{
						toggleBtnClass('#addRole',false);
			    	}
			    	else
			    	{
						toggleBtnClass('#addRole',true);
			    	}
				}
			});
		}
    	
    });

    $('.skip_step').click(function(){
    	var slug = $('#slug').val();
    	if(brand_id)
    	{
    		window.location.href = base_url+'brands/success/'+slug;
    	}
    });

    //save outlet to brand
    $(document).on('click','#add-brand-details #save_outlet',function(){
    	var control = this;
    	var brand_id = $('#brand_id').val();
    	var elements = $('.outlets');

    	var outlet_ids = [];
    	var social_media_keys = {};
    	var i =0;
    	$.each(elements,function(i,value){
    		outlet_ids.push($(value).val());
    		if($(value).val())
    		{
    			social_media_keys[$(value).val()] = $('#'+$(value).val()).val();
    		}
    	}); 	

    	var data = {'brand_id': brand_id,'outlets': outlet_ids};
    	var post_data = {}
    	$.extend(post_data, data, social_media_keys);

    	$.ajax({
    		url: base_url+'brands/save_outlet',
    		data: post_data,
    		type:'POST',
    		dataType: 'json',
    		success: function( data ){
    			
    			if(data.response == 'success')
    			{
    				$(control).parents().children('.btn-next-step').trigger('click');
    				if(data.html)
    				{
    					$('#user-selected-outlet').html(data.html);
    				}
    			}
    		}
    	});
    });  

    //save tags
     $(document).on('click','.submit_tag',function(){     
    	var control = this;
    	var brand_id = $('#brand_id').val();
    	var slug = $('#slug').val();
    	var selected_labels = $('.labels');

    	var tags = [];
    	$('input[name="selected_tags[]"]:checked').each(function(i) {
		   tags[i] = this.value;
		});

    	var labels = []
    	$.each(selected_labels,function(i,value){    		
    		labels[i] = $(value).val();
    	});
    	

    	$.ajax({
    		url: base_url+'brands/save_tags',
    		data: {'brand_id': brand_id,'tags': tags,'labels':labels},
    		type:'POST',
    		dataType: 'json',
    		success: function( data ){
    			
    			if(data.response == 'success')
    			{    				
    				window.location.href = base_url+'brands/success/'+slug;
    			}
    		}
    	});
    });

    //step3 cancel btn
  	$(document).on('click','.btn-cancel',function(){
  		$('#emailValid').addClass('hide');
  		$('#nameValid').addClass('hide');
    	$('#firstName').val('');
		$('#lastName').val('');
		$('#userTitle').val('');
		$('#userEmail').val('');
		$('#userOutlet').val('');
		$('#userRoleSelect').val('');
		$('#userSelect select').val('');
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
		
		if($('#userPermissionsList').children('.table').length)
	    {    	
	    	toggleBtnClass('#add_user_next',false);
	    }
	    else
	    {
	    	toggleBtnClass('#add_user_next',true);
	    }
    });

    $('#firstName').keyup(function(){
    	$('.user-name-role').html($(this).val()+' '+$('#lastName').val());
    });

    $('#lastName').keyup(function(){
    	$('.user-name-role').html($('#firstName').val().toUpperCase()+' '+$(this).val().toUpperCase());
    });

    if($('#userPermissionsList').children('.table').length)
    {    	
    	toggleBtnClass('#add_user_next',false);
    }
    else
    {
    	toggleBtnClass('#add_user_next',true);
    }

    $('[data-id="connect"]').click(function(){    	
    	var outlet = $(this).data('outlet-const');
    	var brand_id = $('#brand_id').val();
    	if(brand_id)
    	{
	    	var path = base_url+outlet.toLowerCase()+'_connect/'+outlet.toLowerCase()+'/'+brand_id+'/'+$(this).data('selected-outlet-id');
	    	if(!$(this).hasClass('selected'))
	    	{
		        $.oauthpopup({
		            path: path,
		            callback: function(){            
		            }
		        });
		    }
		}
    });

     $('body').on('click', '#userPermissionsList .remove-user', function(event){
     	event.preventDefault();
     	// if(!($('#userPermissionsList .table').length > 1)){
     	// 	return false;
     	// }
    	if(confirm("Are you sure, you want to delete this user?"))
        {

			var aauth_user_id = $(this).data('user-id');
			$.ajax({
				url: base_url+'brands/delete_user',
				type:'POST',
				data: {'aauth_user_id':aauth_user_id},
				success:function(data){
					if(data=='success'){
						$('#table_id_'+aauth_user_id).fadeOut(function() {
							$('#table_id_'+aauth_user_id).remove();
						});
					}else{

					}
				}
			});
		}
		
    });
}

	function validateEmail(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
	}

	function nextStep(i) {	
		if(i == 1)
		{
			if($('.brand-image').children('.default-img').length)
			{
				$('.brand-image').children('.default-img').remove();
				$('.brand-image').removeClass('has-files');
			}
		}

		$('.brand-step').removeClass('active').addClass('inactive');
		$('#brandStep' + i).removeClass('inactive').addClass('active');
	}

	function hideNoLength(obj) {
		var numSelected = $(obj).find('li').length;
		if(numSelected < 1) {
			$(obj).hide();
		}
	}

});