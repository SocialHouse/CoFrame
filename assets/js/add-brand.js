jQuery(function($) {

	$(document).ready(function() {
		$('#brandOutlets.outlet-list li').on('click', function() {
			if(!$(this).hasClass('saved')) {
				$(this).toggleClass('disabled selected');
				$(this).siblings().each(function() {
					if(!$(this).hasClass('saved')) {
						$(this).addClass('disabled').removeClass('selected');
					}
				});
				if(!$(this).hasClass('disabled')) {				

					$('#addOutlet').removeClass('btn-disabled').prop("disabled", false);
				}
				else {
					$('#addOutlet').addClass('btn-disabled').prop("disabled", true);
				}
			}
		});
		$('#addNewUser.outlet-list li').on('click', function() {
			var savedOutlets = $('#userOutlet').val();
			var newOutlets = [];
			var thisOutlet = $(this).data('selectedOutlet');
			$(this).toggleClass('disabled selected');
			if($(this).hasClass('selected')) {
				if(savedOutlets !== '') {
					newOutlets.push(savedOutlets);
				}
				newOutlets.push(thisOutlet);
			}
			else {
				savedOutlets = savedOutlets.split(',');
				var index = savedOutlets.indexOf(thisOutlet);
				savedOutlets.splice(index, 1);
				newOutlets.push(savedOutlets);
			}
			$('#userOutlet').val(newOutlets);
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
					$('#save_outlet').prop('disabled',false);
					if(!$('#save_outlet').hasClass('btn-secondary'))
    					$('#save_outlet').addClass('btn-secondary');

    				$('#save_outlet').removeClass('btn-disabled');    	
				}
				else
				{
					if(!$('#save_outlet').hasClass('btn-disabled'))
		    			$('#save_outlet').addClass('btn-disabled');
		    		$('#save_outlet').removeClass('btn-secondary');
		    		$('#save_outlet').prop('disabled',true); 
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
				$('#save_outlet').prop('disabled',false);
				if(!$('#save_outlet').hasClass('btn-secondary'))
					$('#save_outlet').addClass('btn-secondary');

				$('#save_outlet').removeClass('btn-disabled');
			}
			else
			{
				if(!$('#save_outlet').hasClass('btn-disabled'))
	    			$('#save_outlet').addClass('btn-disabled');
	    		$('#save_outlet').removeClass('btn-secondary');
	    		$('#save_outlet').prop('disabled',true); 
			}
		});

		$('#selectedOutlets').on('contentSlidDown', function() {
			hideNoLength($(this));
		});		

		$('#userRoleSelect').on('change', function() {
			var selectedRole = $(this).val();
			if(selectedRole)
	    	{
	    		if(!$('.addUserToBrand').hasClass('btn-secondary'))
	    			$('.addUserToBrand').addClass('btn-secondary');
	    		$('.addUserToBrand').removeClass('btn-disabled');

	    		$('.addUserToBrand').prop('disabled',false);
	    	}
	    	else
	    	{
	    		if(!$('.addUserToBrand').hasClass('btn-disabled'))
	    			$('.addUserToBrand').addClass('btn-disabled');
	    		$('.addUserToBrand').removeClass('btn-secondary');
	    		$('.addUserToBrand').prop('disabled',true);
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
			var $sectionList = $('#' + section).find('.permissions-list');
			$(this).toggleClass('btn-disabled');
			$sectionList.toggleClass('view');
			if($(this).hasClass('btn-disabled')) {
				$sectionList.find('li').css('display', 'block');
			}
			else {
				$sectionList.find('li.hidden').css('display', 'none');
			}
		});
		$('.permissions-list .check-box').on('click', function() {
			var $parent = $(this).parent('li');
			$parent.toggleClass('hidden');
		});

		/*Tag Functions*/
		//assign tags to brand
		$('body').on('click', '#selectBrandTags .tag', function() {
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
					toggleBtnClass('btn-disabled','btn-secondary','#addTag',false);
				}
				else {

					$('#otherTagLabel').show(function(){
						$(this).find('input').focus();
					});

					if(!$('#newLabel').val())
					{
						toggleBtnClass('btn-secondary','btn-disabled','#addTag',true);
					}
					else
					{
						toggleBtnClass('btn-disabled','btn-secondary','#addTag',false);						
					}
				}
			}
			else
			{
				$('#addTag').prop('disabled',true);
			}
		});

		$(document).on('keyup blur','#newLabel',function(){
			if($(this).val())
			{
				toggleBtnClass('btn-disabled','btn-secondary','#addTag',false);
			}
			else
			{
				toggleBtnClass('btn-secondary','btn-disabled','#addTag',true);
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
				toggleBtnClass('btn-disabled','btn-secondary','.submit_tag',false);
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
				toggleBtnClass('btn-disabled','btn-secondary','.submit_tag',false);
			}
			else
			{
				toggleBtnClass('btn-secondary','btn-disabled','.submit_tag',true);
			}
			$(this).parents('li').remove();
		});

		$('#selectedTags').on('contentSlidDown', function() {
			hideNoLength($(this));
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
    		if(!$('.save_brand').hasClass('btn-secondary'))
    			$('.save_brand').addClass('btn-secondary');
    		$('.save_brand').removeClass('btn-disabled');    		
    		$('.save_brand').prop('disabled',false);
    	}
    	else
    	{
    		if(!$('.save_brand').hasClass('btn-disabled'))
    			$('.save_brand').addClass('btn-disabled');

    		$('.save_brand').removeClass('btn-secondary');
    		$('.save_brand').prop('disabled',true); 
    	}
    	
    });

    $('#timezone').change(function(){
    	if($(this).val() && $('#brandName').val())
    	{
    		if(!$('.save_brand').hasClass('btn-secondary'))
    			$('.save_brand').addClass('btn-secondary');
    		$('.save_brand').removeClass('btn-disabled');    		
    		$('.save_brand').prop('disabled',false);
    	}
    	else
    	{
    		if(!$('.save_brand').hasClass('btn-disabled'))
    			$('.save_brand').addClass('btn-disabled');

    		$('.save_brand').removeClass('btn-secondary');
    		$('.save_brand').prop('disabled',true); 
    	}
    });

     $(document).on('keyup blur','#firstName',function(){
    	if($('#lastName').val() && $('#userEmail').val() && validateEmail($('#userEmail').val()) && $(this).val())
    	{
    		// $('#emailValid').hide();
    		if(!$('#addRole').hasClass('btn-secondary'))
    			$('#addRole').addClass('btn-secondary');
    		$('#addRole').removeClass('btn-disabled');    		
    		$('#addRole').prop('disabled',false);
    	}
    	else
    	{
    		// if($('#userEmail').val() && !validateEmail($('#userEmail').val()))
    		// 	$('#emailValid').show();
    		if(!$('#addRole').hasClass('btn-disabled'))
    			$('#addRole').addClass('btn-disabled');

    		$('#addRole').removeClass('btn-secondary');
    		$('#addRole').prop('disabled',true); 
    	}
    	
    });

    $(document).on('keyup blur','#lastName',function(){
    	if($('#firstName').val() && $('#userEmail').val() && validateEmail($(this).val()) && $(this).val())
    	{
    		// $('#emailValid').hide()

    		if(!$('#addRole').hasClass('btn-secondary'))
    			$('#addRole').addClass('btn-secondary');
    		$('#addRole').removeClass('btn-disabled');    		
    		$('#addRole').prop('disabled',false);
    	}
    	else
    	{
    		// if($('#userEmail').val() && !validateEmail($('#userEmail').val()))
    		// 	$('#emailValid').show();

    		if(!$('#addRole').hasClass('btn-disabled'))
    			$('#addRole').addClass('btn-disabled');

    		$('#addRole').removeClass('btn-secondary');
    		$('#addRole').prop('disabled',true); 
    	}
    	
    });

    $(document).on('keyup blur','#userEmail',function(){    	
    	if($('#firstName').val() && $('#lastName').val() && $(this).val() && validateEmail($(this).val()))
    	{
    		// $('#emailValid').hide()

    		if(!$('#addRole').hasClass('btn-secondary'))
    			$('#addRole').addClass('btn-secondary');
    		$('#addRole').removeClass('btn-disabled');    		
    		$('#addRole').prop('disabled',false);
    	}
    	else
    	{
    		// if($(this).val() && !validateEmail($(this).val()))
    		// {
    		// 	$('#emailValid').show();
    		// }
    		// else
    		// {
    		// 	$('#emailValid').hide();
    		// }

    		if(!$('#addRole').hasClass('btn-disabled'))
    			$('#addRole').addClass('btn-disabled');

    		$('#addRole').removeClass('btn-secondary');
    		$('#addRole').prop('disabled',true); 
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
    $(document).on('click','#save_outlet',function(){
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

    $('#firstName').keyup(function(){
    	$('.user-name-role').html($(this).val()+' '+$('#lastName').val());
    });

    $('#lastName').keyup(function(){
    	$('.user-name-role').html($('#firstName').val().toUpperCase()+' '+$(this).val().toUpperCase());
    });

    if($('#userPermissionsList').children('.table'))
    {
    	toggleBtnClass('btn-secondary','btn-disabled','#add_user_next',true);
    }
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

	toggleBtnClass = function(oldClass,newClass,btnClass,btnState){
		$(btnClass).attr('disabled',btnState);
		if(!$(btnClass).hasClass(newClass))
		{
			$(btnClass).addClass(newClass);
		}
		$(btnClass).removeClass(oldClass);
	}
});