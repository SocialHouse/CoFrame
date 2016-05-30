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
				setTimeout(function(){
					var $selectedList = $('#selectedTags ul');
					var $clone = $selectedItem.clone();

					var $listItem = $clone.remove('input').removeClass('selected');
					$listItem.children('.color').attr('name','selected_tags[]');

					var tagTitle = $selectedItem.data('value');
					var editTag = '<a href="#" class="pull-sm-right edit-tag btn-icon btn-gray" data-edit-tag="' + tagTitle + '"><i class="fa fa-pencil"></i></a>';
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
					toggleBtnClass('btn-disabled','btn-secondary','.submit_tag',false)
				}, 100);
				$('.submit_tag').prop('disabled',false);
			}
			else {
				return;
			}
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